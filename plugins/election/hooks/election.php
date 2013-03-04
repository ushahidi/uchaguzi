<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Election Tool Hook - Load All Events
 *
 * PHP version 5
 * LICENSE: This source file is subject to LGPL license
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/copyleft/lesser.html
 *
 * @author     Ushahidi Team <team@ushahidi.com>
 * @package    Uchaguzi - https://github.com/ushahidi/uchaguzi
 * @copyright  Ushahidi - http://www.ushahidi.com
 * @license    http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL)
 */

class election {

	/**
	 * Phone number of the election monitor
	 * @var string
	 */
	private $monitor_phone_number;
	
	/**
	 * Monitor who submitted the report
	 * @var Monitor_Model
	 */
	private $monitor;
	
	/**
	 * Location of the monitor
	 * @var string
	 */
	protected $monitor_location;

	protected $user;

	public function __construct()
	{
		$this->db = Database::instance();

		// Load session
		$this->session = new Session;
		
		$this->session = Session::instance();
		
		// Input should always be available
		$this->input = Input::instance();

		//Get session information

		$auth = new Auth();
		if (isset($_SESSION['auth_user']))
		{
			$this->user = new User_Model($_SESSION['auth_user']->id);
		}

		// Hook into routing
		Event::add('system.pre_controller', array($this, 'add'));
	}

	/**
	 * Adds all the events to the main Ushahidi application
	 */
	public function add()
	{
		// Add a Sub-Nav Link
		//Event::add('ushahidi_action.nav_main_right_tabs', array($this,'_election_link'));
		Event::add('ushahidi_action.nav_admin_main_top', array($this,'_election_link'));

		// Verify that the sender is an election monitor
		Event::add('ushahidi_filter.message_sms_from', array($this, 'verify_reporter_is_monitor'));

		// Modify the message description from sms
		Event::add('ushahidi_filter.message_sms', array($this, 'modify_sms_message'));
		
		// Auto-geolocate SMSs coming from registered election monitors
		Event::add('ushahidi_action.message_sms_add', array($this, 'create_trusted_monitor_report'));

		// Only add the events if we are on that controller
		if (Router::$controller == 'admin')
		{
			plugin::add_stylesheet('election/views/css/main');
		
		}
		elseif (strripos(Router::$current_uri, "admin/users") !== FALSE) 
		{
			// Hook into users report form
			//Event::add('ushahidi_action.users_form_admin',array($this,'_users_form'));
			
			//Hook into users submit form
			//Event::add('ushahidi_action.users_add_admin', array($this,'_users_form_submit_admin'));
			
			//Hook into users edit action
			//Event::add('ushahidi_action.user_edit',array($this,'_update_users_admin_section'));

			//Event::add('ushahidi_action.users_listing_header',array($this,'_show_adminsection_header_title'));

			//Event::add('ushahidi_action.users_listing_item',array($this,'_show_adminsection_item'));

			//Hook into users delete
			//Event::add('ushahidi_action.users_delete_admin',array($this,'_users_delete_admin')); 
		}
		elseif (strripos(Router::$current_uri, "admin/reports/edit") !== FALSE)
		{
			Event::add('ushahidi_action.location_from',array($this, 'verify_reporter_is_monitor'));	
			Event::add('ushahidi_filter.location_name',array($this, '_append_location'));
			
			// Commented out by E.K.
			// Event::add('ushahidi_filter.location_find',array($this,'_append_location_find'));

			Event::add('ushahidi_action.report_form_admin', array($this,'_report_form_admin'));
			Event::add('ushahidi_action.report_form_admin', array($this,'_update_report_mode'));
			Event::add('ushahidi_action.report_edit', array($this,'_report_submit_admin'));
			Event::add('ushahidi_action.report_edit', array($this,'_delete_report_mode'));
			Event::add('ushahidi_action.report_delete',array($this,'_monitor_report_delete_admin'));
			Event::add('ushahidi_action.report_delete',array($this,'_crowd_report_delete_admin'));
		}
		elseif (strripos(Router::$current_uri, "admin/reports") !== FALSE) 
		{   
			//Filter incident
			Event::add('ushahidi_filter.pagination',array($this, '_pagination'));
			Event::add('ushahidi_filter.filter_incidents', array($this,'_manipulate_incident'));
		}
	}

	public function _election_link()
	{
		if (admin::permissions($this->user,'settings') != FALSE)
		{
			$main_right_tabs = Event::$data;
			Event::$data = arr::merge($main_right_tabs,array('election'=>'Election Tool'));
		}
	}

	/**
	 * Verifies whether the sender of the SMS is an election monitor
	 */
	public function verify_reporter_is_monitor()
	{
		$from = Event::$data;
		if ($this->is_monitor($from))
		{
			// Se the monitor's phone number
			$this->monitor_phone_number = $from;
			
			// Set the monitor's location
			$this->monitor_location = $this->get_monitor_location($from);
		}
	}


	/**
	 * Modify the message description that comes via the sms provider available
	 */	
	public function modify_sms_message()
	{
		$message_description = Event::$data;

		if (is_numeric($message_description ) AND ! empty($this->monitor_phone_number)) 
		{
			// Get the message that corresponds to the submitted form response code
			$message = $this->_get_description((int)$message_description);

			if (empty($message))
			{
				$message = Kohana::lang('election.missing_matching_code');
			}

			$message_description = $message;
		}
		Event::$data = $message_description;
	}


	/**
	 * Callback method to create a report from a SMS that has been sent
	 * in by a registered monitor
	 */
	public function create_trusted_monitor_report()
	{
		$sms = Event::$data;
		if ($this->monitor_phone_number == $sms->message_from)
		{
			$reporter_orm = Reporter_Model::find_by_service_account('SMS', $this->monitor_phone_number);
			if ( ! isset($reporter_orm->location_id) OR $reporter_orm->location_id != $this->monitor_location->id)
			{
				$reporter_orm->location_id = $this->monitor_location->id;
				$reporter_orm->save();
			}
			
			// Create incident/report that is approved, verified and trusted from the SMS
			$incident_orm = Incident_Model::create_incident_from_sms($sms, $reporter_orm, TRUE, TRUE, TRUE);
			
			// Associate the report with the monitor
			Monitor_Report_Model::create_from_incident($this->monitor, $incident_orm);
		}
	}

	/**
	 * hook into users report form.
	 */
	public function _users_form()
	{
		// Load the View
		$form = View::factory('admin/adminsection_users_form');
	        
		$id = Event::$data;

		// incase we are editing a user
		if ($id)
		{
			// Do We have an Existing Actionable Item for this Report?
			$adminsections = ORM::factory('adminsection')
				->where('user_id', $id)
				->select_list('id','adminsection_title');
			
		}
		else
		{
			$adminsections = ORM::factory('adminsection')
				->where('adminsection_active', '1')
				->select_list('id','adminsection_title');
		}

		$form->adminsections = $adminsections;
		$form->render(TRUE);
	}

	/**
	 *  Add users to an admin section
	 */
	public function _users_form_submit_admin()
	{
		$post = Event::$data;
		
		$sql = "SELECT id FROM ".Kohana::config('database.default.table_prefix')."users WHERE username ='".$post->username."'";
		$user_id = $this->db->query($sql);
		if ($post)
		{
			// Pull user id from users table for insertion in adminsection.
			//Prevent duplicate entries.
			if ($this->_get_user_id('adminsection_users',$user_id[0]->id) != $user_id[0]->id)
			{
				$adminsection = ORM::factory('adminsection_user');
				$adminsection->user_id = $user_id[0]->id;
				$adminsection->adminsection_id = $post->adminsection_title;
				$adminsection->save();
			}
		}
	}


	/**
	 * Update a users admin section
	 */
	public function _update_users_admin_section() 
	{
		$user_data = Event::$data;
		$user_id = $user_data[0];
		$post = $user_data[1];
		if ($post) 
		{
			// Add new
			$userid = $this->_get_user_id('adminsection_users',$user_id);
			if (empty($userid))
			{
				$this->db->insert('adminsection_users' ,array(
					'user_id'=>$user_id,
					'adminsection_id'=>$post->adminsection_title
				));
			}
			else
			{
				//update
				$this->db->update('adminsection_users',
					array("adminsection_id" => $post->adminsection_title),
					array('user_id' => $user_id));
			}
	    }
	}

	/**
	 * Delete from adminsection table
	 */
	public function _users_delete_admin() 
	{
		$users = Event::$data;
		$this->db->delete('adminsection_users', array('user_id' => $users->id));
	}
	
	/**
	 * Show the header title for the admisection at the users list page.
	 */
	public function _show_adminsection_header_title()
	{
		$template = View::factory('admin/adminsection_header_title');
		$template->header_title = "Adminsection";
		$template->render(TRUE);
	}
	
	/**
	 * Show the adminsection the user is in at the users
	 * listing page.
	 */
	public function _show_adminsection_item() 
	{
		$user_id = Event::$data;
		if ($user_id)
		{    
			$adminsection_title = $this->_get_admin_section($user_id);
		}

		//Load the view
		$template = View::factory('admin/adminsection_item');
		if ( ! empty($adminsection_title))
		{
			$template->adminsection_title = $adminsection_title;
		}
		else
		{
			$template->adminsection_title = "None";
		}

		$template->render(TRUE);
	}

	/**
	 * Get admin section id.
	 */
	public function _get_admin_section_id($user_id)
	{
		$admin_section = ORM::factory('adminsection_user')
			->where('user_id',$user_id)->orderby('adminsection_id')
			->join('adminsection','adminsection_users.adminsection_id','adminsection.id','INNER')
			->find();
	
		return $admin_section->adminsection->id;
	}


	/**
	* Get report section id.
	*/
	public function _get_report_section_id($admin_section_id)
	{
		$report_section = ORM::factory('adminsection')	
			->where('id',$admin_section_id)->orderby('id')
			->find();

		return $report_section->reportsection_id;
	}



	/**
	 * Get admin section title.
	 */
	public function _get_admin_section($user_id)
	{
		$admin_section = ORM::factory('adminsection_user')
			->where('user_id',$user_id)->orderby('adminsection_id')
			->join('adminsection','adminsection_users.adminsection_id','adminsection.id','INNER')
			->find();

		return $admin_section->adminsection->adminsection_title;
	}
	
	/** 
	 * Append phone numbers to respective locations for reports that comes from monitors
	 */
	public function _append_location()
	{
		$location_name = Event::$data;
		
		if ( ! empty($this->monitor_location))
		{
			$location_name = $this->monitor_location->location_name;
			Event::$data = $location_name;
		}
	}   

	/**
	 * Append phone numbers that comes from monitors to their location.
	 * TODO rework this wack solution
	 */
	public function _append_location_find()
	{
		$location_find = Event::$data;
		
		if (isset($_SESSION['from_location']))
		{
			$location_find = $_SESSION['from_location'];

			$this->from_monitors = "m";
			if (empty($location_find))
			{
				$location_find = "";
				$this->from_monitors = "";
			}
		}
		unset($_SESSION['from_location']);
		Event::$data = $location_find;
	}
	
	/** 
	 * Detect reports from monitors
	 */
	public function _report_form_admin()
	{
		//Load the view
		$auth = new Auth(); 
		$admin_section = $this->_get_admin_section($_SESSION['auth_user']->id);
	 
		//If user is a moderator, manipulate report query
		if ($auth->has_permission("reports_view"))
		{ 
			if (strcasecmp($admin_section, "peacenet") == 0)
			{
				$this->from_monitors = "p";
			}
		}

		$form = View::factory('election/monitors_form');
		$form->from_monitors = $this->from_monitors;
		$form->monitors = $this->monitors;
		$form->render(TRUE);
	}   


	/**
	 * Insert the mode of a report
	 */
	public function _update_report_mode() 
	{
		$incident_id = Event::$data;
		
		// If no entry in report_more - create one for the current user & incident
		if ($this->_get_incident_id('report_mode', $incident_id) != $incident_id) 
		{
			$report_mode = ORM::factory('report_mode');
			$report_mode->incident_id = $incident_id;
			$report_mode->user_id = $_SESSION['auth_user']->id;		
			$report_mode->save();
		}
	}

	/**
	 * Submit a report.
	 */
	public function _report_submit_admin() 
	{
		$incident = Event::$data;

		// Get the message associated is with the incident
		$message_orm = Message_Model::find_by_incident_id($incident->id);
		
		// Is there a messaeg associated with the incident?
		if ($message_orm->loaded)
		{
			$is_monitor = $this->is_monitor($message_orm->message_from);
	    
			if ($_POST) 
			{
				if ($is_monitor) 
				{
					if ( $this->_get_incident_id('monitor_report', $incident->id) != $incident->id ) 
					{
						$adminsection = ORM::factory('monitor_report');
						$adminsection->incident_id = $incident->id;
						$adminsection->save();
					}
				}
				else 
				{
					if ($this->_get_incident_id('crowd_report', $incident->id) !== $incident->id)
					{
						$adminsection = ORM::factory('crowd_report');
						$adminsection->incident_id = $incident->id;
						$adminsection->save();
					}
				}
			}
		}
	}



	/**
	 * Get the monitor number using message_id
	 */
	public function _monitor_number()
	{
		if (isset($_GET['mid']))
		{
			$message_id = $_GET['mid'];
			$monitor_number = ORM::factory('message')
				->where('id', $message_id)
				->find();

			return $monitor_number->message_from;
		}
		return 0;
	}

	/**
	 * Delete the mode of a report
	 *
	 * @param unknown_type incident_id
	 */
	public function _delete_report_mode() 
	{
		$incident = Event::$data;
		$this->db->delete('report_mode', array('incident_id' => $incident));
	}

	/**
	 * Delete report id from monitor_report
	 */
	public function _monitor_report_delete_admin() 
	{
		$incident = Event::$data;
		$this->db->delete('monitor_report', array('incident_id' => $incident));
	}

	/**
	 * Delete report id from crowd_report
	 */
	public function _crowd_report_delete_admin() 
	{
		$incident = Event::$data;
		$this->db->delete('crowd_report', array('incident_id' => $incident));
	}

	/**
	 * Manipulate view 
	 */
	public function _manipulate_incident() 
	{
		$incidents = Event::$data;
		$filter = $this->_filter();
		$auth = new Auth();

		$admin_section_id = $this->_get_admin_section_id($_SESSION['auth_user']->id);
		$reportsection_id = $this->_get_report_section_id($admin_section_id);

		$pagination = $this->_pagination();		
		//If user is a moderator, manipulate report query
		if (admin::permissions($this->user, "reports_view"))
		{
			//1 is monitor
			if ($reportsection_id == 1)
			{
				if (strcasecmp($filter, "1=1"))
				{
					$filter = "incident.id = monitor_report.incident_id ";
				}
				else
				{
					$filter .= " AND
					(".Kohana::config('database.default.table_prefix')."incident.id
					=monitor_report.incident_id )";
				}

				$incidents = ORM::factory('incident')
					->join('monitor_report','incident.id','monitor_report.incident_id','INNER')	
					->join('location', 'incident.location_id', 'location.id','INNER')
					->where($filter)
					->orderby('incident_dateadd', 'desc')
					->find_all((int) Kohana::config('settings.items_per_page_admin'), $pagination->sql_offset);

				Event::$data = $incidents;
				$admin_section = "";
				
			}
			//2 is crowd
			elseif ($reportsection_id == 2)
			{
				//echo $admin_section;exit;
				if (strcasecmp($filter, "1=1"))
				{
					$filter = "incident.id = crowd_report.incident_id ";
				}
				else
				{
					$filter .= " AND
					(".Kohana::config('database.default.table_prefix')."incident.id
					=crowd_report.incident_id )";
				}

				$incidents = ORM::factory('incident')
					->join('crowd_report','incident.id','crowd_report.incident_id','INNER')	
					->join('location', 'incident.location_id', 'location.id','INNER')
					->where($filter)
					->orderby('incident_dateadd', 'desc')
					->find_all((int) Kohana::config('settings.items_per_page_admin'), $pagination->sql_offset);

				Event::$data = $incidents;
				$admin_section = "";
			}
			else 
			{
				Event::$data = $incidents;
			}
		} 
	}

	public function _pagination()
	{
		$pagination = Event::$data;
		
		$filter =$this->_filter(); 

		$pagination = new Pagination(array(
			'query_string'	 => 'page',
			'items_per_page' => (int) Kohana::config('settings.items_per_page_admin'),
			'total_items'	 => ORM::factory('incident')
				->join('location', 'incident.location_id', 'location.id','INNER')
				->where($filter)
				->count_all()
		));
		
		Event::$data = $pagination;
		return $pagination;	
	}

	public function _filter()
	{
		if (!empty($_GET['status']))
		{
			$status = $_GET['status'];

			if (strtolower($status) == 'a')
			{
				$filter = 'incident_active = 0';
			}
			elseif (strtolower($status) == 'v')
			{
				$filter = 'incident_verified = 0';
			}
			else
			{
				$status = "0";
				$filter = '1=1';
			}
		}
		else
		{
			$status = "0";
			$filter = "1=1";
		}

		// Get Search Keywords (If Any)
		if (isset($_GET['k']))
		{
			//	Brute force input sanitization
			
			// Phase 1 - Strip the search string of all non-word characters 
			$keyword_raw = preg_replace('/[^\w+]\w*/', '', $_GET['k']);
			
			// Strip any HTML tags that may have been missed in Phase 1
			$keyword_raw = strip_tags($keyword_raw);
			
			// Phase 3 - Invoke Kohana's XSS cleaning mechanism just incase an outlier wasn't caught
			// in the first 2 steps
			$keyword_raw = $this->input->xss_clean($keyword_raw);
			
			$filter .= " AND (".$this->_get_searchstring($keyword_raw).")";
		}
		else
		{
			$keyword_raw = "";
		}
		
		return $filter;
	}


	/**
	 * Creates a SQL string from search keywords
	 */
	private function _get_searchstring($keyword_raw)
	{
		$or = '';
		$where_string = NULL;


		// Stop words that we won't search for
		// Add words as needed!!
		$stop_words = array('the', 'and', 'a', 'to', 'of', 'in', 'i', 'is', 'that', 'it',
		'on', 'you', 'this', 'for', 'but', 'with', 'are', 'have', 'be',
		'at', 'or', 'as', 'was', 'so', 'if', 'out', 'not');

		$keywords = explode(' ', $keyword_raw);
		
		if (is_array($keywords) && !empty($keywords))
		{
			array_change_key_case($keywords, CASE_LOWER);
			$i = 0;
			
			foreach($keywords as $value)
			{
				if ( ! in_array($value,$stop_words) AND !empty($value))
				{
					$chunk = mysql_real_escape_string($value);
					if ($i > 0)
					{
						$or = ' OR ';
					}
					$where_string .= $or
					    . "incident_title LIKE '%$chunk%' OR incident_description LIKE '%$chunk%'  OR location_name LIKE '%$chunk%'";

					$i++;
				}
			}
		}
		return ! empty($where_string) ?  $where_string : "1 = 1";
	}

    /**
     * Given a monitor's phone number, gets their location
     * 
     * @param  string phone_number
	 * @return 
     */
	public function get_monitor_location($phone_number)
	{
		$reporter_orm = Reporter_Model::find_by_service_account('SMS', $phone_number);
		if ($reporter_orm AND ! empty($repoter_orm->location_id))
		{
			return $reporter_orm->location;
		}

		$boundary_orm = ORM::factory('boundary')
			->join('monitor', 'monitor.boundary_id', 'boundary.id', 'INNER')
			->where('monitor.phonenumber', $phone_number)
			->find();
		
		// Get the constituency using the boundary name
		$result = Database::instance()
			->query('SELECT DISTINCT latitude, longitude FROM constituency WHERE LOWER(constituency_name) = ?', 
				array(strtolower($boundary_orm->boundary_name)))
			->result_array();
		
		$constituency = $result[0];
		$location_orm = NULL;
		
		// Boundary exist as constituency?
		if ($constituency)
		{
			$location_orm = Location_Model::find_by_lat_lon($constituency->latitude, $constituency->longitude);
			if (empty($location_orm))
			{
				$location_data = array(
					'location_name' => $boundary_orm->boundary_name,
					'latitude' => $constituency->latitude,
					'longitude' => $constituency->longitude
				);
				
				$location_orm = Location_Model::create_from_array($location_data);
			}
		}
		else
		{
			// TODO Geocode boundary name
		}
		
		return $location_orm;
	}


	public function _get_admin_sections()
	{
		$adminsections = array();
		foreach (ORM::factory('adminsection')->orderby('adminsection_title')->find_all() as $adminsection)
		{
			$this_adminsection = $adminsection->adminsection_title;
			$adminsections[$adminsection->id] = $this_adminsection;	
		}

		return $adminsections;
	}

	/**
	 * Verifies whether the phone_number belongs to a monitor
	 *
	 * @param  string phone_number
	 * @return bool
	 */
	public function is_monitor($phone_number)
	{
		$monitor_orm = ORM::factory('monitor')
						->where('phonenumber', $phone_number)
						->find();

		$this->monitor = $monitor_orm;
		return $monitor_orm->loaded;
	}

	/**
	 * Match a code to a report description
	 */
	public function _get_description($report_code)
	{
        $report_desc = ORM::factory('code')
			->where('code_id', $report_code)
			->find();

		return $report_desc->code_description;
	}
	
	/**
	 * Get polling station
	 * 
	 * @param - monitor_number - the monitors number
	 */
	public function _get_polling_station($monitor_number)
	{
		$polling_station = ORM::factory('monitor')
			->where('phonenumber',$monitor_number)
			->find();
		return $polling_station->polling_station;
	}


	/**
	 * Check if a report ID already exist in the db.
	 * @param report id
	 * @param table name
	 */
	public function _get_incident_id($table_name, $report_id) 
    {
		$incident_orm = ORM::factory($table_name)
			->where('incident_id',$report_id)
			->find();
		
		return $incident_orm->loaded ? $incident_orm->incident_id : "";
	}
	
	/**
	 * Get reports
	 */
	public function _get_report($table_name) 
	{
		$incident_id = ORM::factory($table_name)->find_all();
		$incident_ids = array();

		foreach ($incident_id as $id)
		{
			$incident_ids[] = $id->incident_id;
		}
		return $incident_ids;
	}

	/**
	 * Get user id
	 */
	public function _get_user_id($table_name, $user_id ) 
	{
		$user = $this->db->from($table_name)
			->select('user_id')
			->where('user_id', $user_id)
			->get();

		if ($user[0])
		{
			return $user[0]->user_id;
		}
		else
		{
			return "";
		}
	}

}
new election;
