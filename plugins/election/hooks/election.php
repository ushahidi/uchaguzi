<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Election Tool Hook - Load All Events
 *
 * PHP version 5
 * LICENSE: This source file is subject to LGPL license
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/copyleft/lesser.html
 * @author	   Ushahidi Team <team@ushahidi.com>
 * @package	   Ushahidi - http://source.ushahididev.com
 * @copyright  Ushahidi - http://www.ushahidi.com
 * @license	   http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL)
 */

class election {

	/**
	 * Registers the main event add method
	 */

    protected $from_number = "";
    protected $monitors_location;
	protected $user;


	public function __construct()
	{
		$this->db = Database::instance();
        $this->monitors = "";
        $this->from_monitors = " ";
        $this->monitors_location = "";

		// Load session
		$this->session = new Session;
		
		$this->session = Session::instance();

		//Get session information

		$auth = new Auth();
		if (isset($_SESSION['auth_user']))
		$this->user = new User_Model($_SESSION['auth_user']->id);


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

		// Only add the events if we are on that controller
		if (Router::$controller == 'admin')
		{
			plugin::add_stylesheet('election/views/css/main');
		
		}
		elseif(strripos(Router::$current_uri, "admin/users") !== false) 
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
        else if ( strripos(Router::$current_uri, "admin/messages") !== false ) 
        {   
    
            Event::add('ushahidi_action.message_from_admin',array($this,'_get_senders_location'));
		}
        else if (strripos(Router::$current_uri, "admin/reports/edit") !== false)
        {
			Event::add('ushahidi_action.location_from',array($this,'_get_senders_location'));	
            Event::add('ushahidi_filter.location_name',array($this,'_append_location'));
            Event::add('ushahidi_filter.location_find',array($this,'_append_location_find'));
            Event::add('ushahidi_action.report_form_admin', array($this,'_report_form_admin'));
			Event::add('ushahidi_action.report_form_admin', array($this,'_report_mode'));
			Event::add('ushahidi_action.report_form_admin', array($this,'_update_report_mode'));
			Event::add('ushahidi_action.report_edit', array($this,'_report_submit_admin'));
			Event::add('ushahidi_action.report_edit', array($this,'_delete_report_mode'));
			Event::add('ushahidi_action.report_delete',array($this,'_monitor_report_delete_admin'));
			Event::add('ushahidi_action.report_delete',array($this,'_crowd_report_delete_admin'));
			

        }
        else if(strripos(Router::$current_uri, "admin/reports") !== false ) 
        {   
            //Filter incident
            Event::add('ushahidi_filter.pagination',array($this,'_pagination'));
            Event::add('ushahidi_filter.filter_incidents', array($this,'_manipulate_incident'));
    
        }   

		
			Event::add('ushahidi_filter.message_sms_from',array($this,'_message_sms_from'));
			
			//Modify the message description from sms
			
			Event::add('ushahidi_filter.message_sms',array($this,'_modify_message_sms'));
			


	}

	public function _election_link()
	{

		if(admin::permissions($this->user,'settings') != FALSE)
		{
			$main_right_tabs = Event::$data;
			Event::$data = arr::merge($main_right_tabs,array('election'=>'Election Tool'));
		}
	}


	/**
	 * hook into users report form.
	 */
	public function _users_form() {
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
			
	    } else {
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
	public function _users_form_submit_admin() {
		$post = Event::$data;
		
		$sql = "SELECT id FROM ".Kohana::config('database.default.table_prefix')."users WHERE username ='".$post->username."'";
		$user_id = $this->db->query($sql);
		if($post) {
			// pull user id from users table for insertion in adminsection.
			//Prevent duplicate entries.
			if($this->_get_user_id('adminsection_users',$user_id[0]->id) != $user_id[0]->id) {
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
            //add new
            $userid = $this->_get_user_id('adminsection_users',$user_id);
            if (empty($userid))
            {
                $this->db->insert('adminsection_users',array('user_id'=>$user_id,'adminsection_id'=>$post->adminsection_title));
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
		
		$this->db->delete('adminsection_users', 
                array('user_id' => $users->id));
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

    /** modify message from */

	public function _message_sms_from()
	{
        $from = Event::$data;
			
        $_SESSION['from_location'] = $from;
		 
        $phonenumber = ORM::factory('monitor')->where('phonenumber',$_SESSION['from_location'])->find();
        //$phonenumber = ORM::factory('monitor')->where('phonenumber',$from)->find();
    
        if(!empty($phonenumber->phonenumber)){
            $this->from_monitors = "m";
        }else{
            $this->from_monitors = ""; 
        }   

	}

	public function _message_sms_from_loc()
	{
        $from = Event::$data;
			
        //$_SESSION['from_location'] = $from;
		
		  $monitor_number =
$this->_get_monitor_number($_SESSION['from_location']);

 
        $phonenumber =
		ORM::factory('monitor')->where('phonenumber',$monitor_number)->find();
        //$phonenumber = ORM::factory('monitor')->where('phonenumber',$from)->find();
		echo $_SESSION['from_location'];	
        if(!empty($phonenumber->phonenumber)){
            $this->from_monitors = "m";
        }else{
            $this->from_monitors = ""; 
        }   

	}


/** Modify the message description that comes via the sms provider available */	

	public function _modify_message_sms()
	{
        $message_description = Event::$data;
        $monitor_number =
$this->_get_monitor_number($_SESSION['from_location']);

        if( is_numeric( $message_description ) && $monitor_number == $_SESSION['from_location']) 
		{

            $message = $this->_get_description((int)$message_description);

            if(!empty($message) ) {

               // if(isset($from) && !empty($from)) {
                if(isset($_SESSION['from_location']) && !empty($_SESSION['from_location'])) {
                    $polling_station = $this->_get_polling_station("0".substr($_SESSION['from_location'],3));
                    //$polling_station = $this->_get_polling_station($from);

                    $message_desc = $message /*. " from $polling_station polling
station"*/;

                }else{
                    $message_desc = $message;
                }

            } else {

                $message_desc = Kohana::lang('election.missing_matching_code');
            }

        } else {
            $message_desc = $message_description;
        }

        Event::$data = $message_desc;

	}


    /** 
     * Append phone numbers to respective locations for reports that comes from monitors
     */
    public function _append_location() {
        $location_n = Event::$data;
		
        if (isset($_SESSION['from_location']))
        {   
            $location_n = $_SESSION['from_location'];
	
        }   
        else
        {   
            $location_n = ""; 
        }   
        Event::$data = $location_n;
    }   



    /**
     * Append phone numbers that comes from monitors to their location.
     * TODO rework this wack solution
     */
    public function _append_location_find() {
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
    public function _report_form_admin() {
    
        //Load the view
        $auth = new Auth(); 
        $admin_section = $this->_get_admin_section($_SESSION['auth_user']->id);
	 
        //If user is a moderator, manipulate report query
        if (admin::permissions($this->user, "reports_view") ) { 
            //if (strcasecmp($admin_section, "peacenet") == 0) {
            if (strcasecmp($admin_section, "peacenet") == 0) {
                $this->from_monitors = "p";
            }   
        }   
        $form = View::factory('election/monitors_form');
        $form->from_monitors = $this->from_monitors;
    
        $form->monitors = $this->monitors;
        $form->render(TRUE);
    }   



	public function _report_mode() 
    {
		$incident_id = Event::$data;
		// get user login section
		
		$auth = new Auth();
		
		$existing_id = $this->_get_incident_id('report_mode', $incident_id );
		
		$user_id = $this->_get_user_id('report_mode',$_SESSION['auth_user']->id);
		
		if( ( $existing_id == $incident_id ) && 
			!empty($incident_id) && 
			$user_id != $_SESSION['auth_user']->id && 
			( !$auth->logged_in('superadmin') || !$auth->logged_in('admin') ))
		{
				url::redirect('admin/reports/');
		}
	}


	/**
	 * insert the mode of a report
	 */
	public function _update_report_mode() 
    {
		
		$incident_id = Event::$data;
		
		if ($this->_get_incident_id('report_mode', $incident_id) != $incident_id) 
        {
			$report_mode = ORM::factory('report_mode');
			$report_mode->incident_id = $incident_id;
			$report_mode->user_id = $_SESSION['auth_user']->id;		
			$report_mode->save();
		}
		
	}
	

	/**
	 * submit a report.
	 */
	public function _report_submit_admin() 
    {
		
		$incident = Event::$data;
	    
		$monitor_number = $this->_monitor_number();
		
		$is_monitor = $this->_get_monitor_number( $monitor_number ) == '' ? '' : TRUE;
			
		if ($_POST) 
        {
			if ($is_monitor) 
            {
				if ( $this->_get_incident_id('monitor_report',$incident->id) != $incident->id ) 
                {
					$adminsection = ORM::factory('monitor_report');
					$adminsection->incident_id = $incident->id;
					$adminsection->save();
				}
				
			}
            else 
            {
				if ($this->_get_incident_id('crowd_report',$incident->id) !== $incident->id)
                {
					$adminsection = ORM::factory('crowd_report');
					$adminsection->incident_id = $incident->id;
					$adminsection->save();
				}
			}
		}
	}



	/**
	* Get the monitor number using message_id
	*/
	public function _monitor_number()
	{
		if(isset($_GET['mid']))
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
		//die(print_r(Kohana::debug($incidents)));
		$filter = $this->_filter();
		$auth = new Auth();
			
		$admin_section_id = $this->_get_admin_section_id($_SESSION['auth_user']->id);
		$reportsection_id = $this->_get_report_section_id($admin_section_id);
		//$sections = $this->_get_admin_sections();
	    $pagination = $this->_pagination();		
		//If user is a moderator, manipulate report query
		if (admin::permissions($this->user, "reports_view"))
        {
			//1 is monitor
			if($reportsection_id == 1 )
            {
				//echo $admin_section;exit;
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
			else if($reportsection_id == 2)
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
		$where_string = '';


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
				if (!in_array($value,$stop_words) && !empty($value))
				{
					$chunk = mysql_real_escape_string($value);
					if ($i > 0) {
						$or = ' OR ';
					}
					$where_string = $where_string.$or."incident_title LIKE '%$chunk%' OR incident_description LIKE '%$chunk%'  OR location_name LIKE '%$chunk%'";
					$i++;
				}
			}
		}

		if ($where_string)
		{
			return $where_string;
		}
		else
		{
			return "1=1";
		}
	}




/* Get location of the sender in this case monitor */

    public function _get_senders_location()
    {   
        $message_from = Event::$data;
        if ($message_from)
        {   
            //$location = $this->_get_location($this->_remove_country_code($message_from));
            $location = $this->_get_location($message_from);
            if( ! empty($location))
            {   
                $_SESSION['from_location'] = $location;
            }   
            else
            {   
                $_SESSION['from_location'] = "";
            }   
        }   
    }   


    /**
     * Get location from a number
     * 
     * @param - loc_number - location number
     * @param - loc_name - location name 
     */
    public function _get_location($loc_number) {

        $loc_ids = ORM::factory('monitor')->where('phonenumber',$loc_number)->find();

        $loc_id = $loc_ids->location_id;

        $loc_names = ORM::factory('boundary')->where('id',$loc_id)->find();

        $loc_name = $loc_names->boundary_name;

        return $loc_name;
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



/*Get monitor number from the database */

	public function _get_monitor_number($monitor_number)
	{
		
		$phone_number = ORM::factory('monitor')
							->where('phonenumber', $monitor_number)
							->find();

		return $phone_number->phonenumber;
	
	}



/* Match a code to a report description */

    public function _get_description($report_code) {

        $report_desc =
ORM::factory('code')->where('code_id',$report_code)->find();

        return $report_desc->code_description;

    }


    /**
     * Get polling station
     * 
     * @param - monitor_number - the monitors number
     */
    public function _get_polling_station($monitor_number) {

        $polling_station =
ORM::factory('monitor')->where('phonenumber',$monitor_number)->find();

        return $polling_station->polling_station;
    }


	/**
	 * Check if a report ID already exist in the db.
	 * @param report id
	 * @param table name
	 */
	public function _get_incident_id($table_name, $report_id) 
    {
		$incident_id = ORM::factory($table_name)->where('incident_id',$report_id)->find();
        if ($incident_id)
        {
		    return $incident_id->incident_id;
        }
        else
        {
            return "";
        }
	}
	
	/**
	 * Get reports
	 */
	public function _get_report($table_name) 
    {
		$incident_id = ORM::factory($table_name)->find_all();
		$incident_ids = array();

		foreach( $incident_id as $id ) {
			$incident_ids[] = $id->incident_id;
		}
        return $incident_ids;
	}



	/**
	 * Get user id
	 */
	public function _get_user_id($table_name, $user_id ) 
    {
		$user = $this->db->from($table_name)->select('user_id')->where('user_id',$user_id)->get();
        
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
