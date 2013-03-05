<?php defined('SYSPATH') or die('No direct script access.');

class instagramflickr {

	private $service_id;
	/**
	 * Registers the main event add method
	 */
	public function __construct()
	{
		// Hook into routing
		Event::add('system.pre_controller', array($this, 'add'));
	}

	/**
	 * Adds all the events to the main Ushahidi application
	 */
	public function add()
	{
		// Add a Sub-Nav Link to messages links
		//Event::add('ushahidi_action.nav_admin_messages', array($this, '_flickr_link'));

		// Hook into the messages controller
		if (Router::$controller == 'messages' AND Router::$method == 'index')
		{ 
			// Only when we're on the flickr and instagram pages
			// FIXME:: use a better ID to identify flickr and instragm services
			// HERE 4 is Flickr and 5 is Instagram
			if(count(Router::$segments) > 2 ) 
			{ 
				if (Router::$segments[3] == 4 OR Router::$segments[3] == 5 )
				{ 	
					$this->service_id = Router::$segments[3];
					Event::add('ushahidi_action.admin_messages_custom_layout', 
						array($this,'_instagramflickr_view'));
				}
			}
		}

		// Hook into gallery controller
		if(Router::$controller == 'gallery') 
		{
			Event::add('ushahidi_action.gallery_list', array($this,'_display_gallery_images'));
		}

		Event::add('ushahidi_action.nav_admin_settings', array($this,
			'_settings_link'));
	}

	/**
	 * Add a links to messages sub navs
	 */
	public function _flickr_link() 
	{
		//$service_id = Event::$data;
		$this->service_id = $service_id;
		
	}

	/**
	 * Settings sub tab link
	 */
	public function _settings_link()  {
		$this_sub_page = Event::$data;
		echo ($this_sub_page == "instagramflickr") ? 
		"<li class=\"active\"><a>".Kohana::lang('instagramflickr.title')."</a></li>" : 
		"<li><a href=\"".url::site()."admin/instagramflickr\">"
		.Kohana::lang('instagramflickr.title')."</a>";
	}

	public function _instagramflickr_submit_report() 
	{
		$form = Event::$data;


	}

	/**
	 * Display submitted flickr or instagram messages
	 * 
	 * @return [type] [description]
	 */
	public function _instagramflickr_view() 
	{

		$view = View::factory('admin/messages/instagramflickr_view');
		
		$items_per_page = (int) Kohana::config('settings.items_per_page_admin');

		$type = "1";
		$filter = 'instagramflickr.photo_type = 1';

		// Do we have a reporter ID?
		if (isset($_GET['rid']) AND !empty($_GET['rid']))
		{
			$filter .= ' AND instagramflickr.reporter_id=\''.intval($_GET['rid']).'\'';
		}
        
		// ALL / Trusted / Spam
		$level = '0';
		if (isset($_GET['level']) AND !empty($_GET['level']))
		{
			$level = $_GET['level'];
			if ($level == 4)
			{
				$filter .= " AND ( ".$table_prefix."reporter.level_id = '4' OR "
				    . $table_prefix."reporter.level_id = '5' ) "
				    . "AND ( ".$table_prefix."instagramflickr.photo_level != '99' ) ";
			}
			elseif ($level == 2)
			{
				$filter .= " AND ( ".$table_prefix."instagramflickr.instagramflickr_level = '99' ) ";
			}
		}

		// Check, has the form been submitted?
		$form_error = FALSE;
		$form_saved = FALSE;
		$form_action = "";
        
		// Check, has the form been submitted, if so, setup validation
		if ($_POST)
		{
			// Instantiate Validation, use $post, so we don't overwrite $_POST fields with our own things
			$post = Validation::factory($_POST);

			// Add some filters
			$post->pre_filter('trim', TRUE);

			// Add some rules, the input field, followed by a list of checks, carried out in order
			$post->add_rules('action','required', 'alpha', 'length[1,1]');
			$post->add_rules('message_id.*','required','numeric');

			// Test to see if things passed the rule checks
			if ($post->validate())
			{   
				if( $post->action == 'd' )              // Delete Action
				{
					foreach($post->message_id as $item)
					{
						// Delete Message
						$photo = ORM::factory('instagramflickr')->find($item);
						$photo->photo_type = 3; // Tag As Deleted/Trash
						$photo->save();
					}

					$form_saved = TRUE;
					$form_action = utf8::strtoupper(Kohana::lang('ui_admin.deleted'));
				}
			}
			// No! We have validation errors, we need to show the form again, with the errors
			else
			{
				// repopulate the form fields
				$form = arr::overwrite($form, $post->as_array());

				// populate the error fields, if any
				$errors = arr::overwrite($errors, $post->errors('instagramflickr'));
				$form_error = TRUE;
			}
		}

		// Pagination
		$pagination = new Pagination(array(
		'query_string'   => 'page',
		'items_per_page' => $items_per_page,
		'total_items'    => ORM::factory('instagramflickr')
		    ->join('reporter','instagramflickr.reporter_id','reporter.id')
		    ->where($filter)
		    ->where('service_id', $this->service_id)
		    ->count_all()
		));

		$photos = ORM::factory('instagramflickr')
		    ->join('reporter','instagramflickr.reporter_id','reporter.id')
		    ->where('service_id', $this->service_id)
		    ->where($filter)
		    ->orderby('photo_date','desc')
		    ->find_all($items_per_page, $pagination->sql_offset);

		// ALL
		$view->count_all = ORM::factory('instagramflickr')
		    ->join('reporter','instagramflickr.reporter_id','reporter.id')
		    ->where('service_id', $this->service_id)
		    ->where('photo_type', 1)
		    ->count_all();
		       
		$view->pagination = $pagination;
		$view->photos = $photos;
		$view->service_id = $this->service_id;
		$view->services = ORM::factory('service')->find_all();
		$view->form_error = $form_error;
		$view->form_saved = $form_saved;
		$view->form_action = $form_action;
        
		$levels = ORM::factory('level')->orderby('level_weight')->find_all();
		$view->levels = $levels;

		// Total Reports
		$view->total_items = $pagination->total_items;

		// Message Type Tab - Inbox/Outbox
		$view->type = $type;
		$view->level = $level;

		$view->render(TRUE);	
	}

	public function _get_flickr_images() 
	{
		include Kohana::find_file('libraries/phpflickr','phpFlickr');
		
		$f = new phpFlickr(Kohana::config('instagramflickr.flick_api_key'));
		//enable caching
		return $f;
	}

	public function _display_gallery_images()
	{
		$photos = ORM::factory('instagramflickr_gallery')->orderby('photo_date','desc');
		// Load the View
		$view = View::factory('gallery/gallery_list');
		$view->photos = $photos;
		$view->render();
	}
}
new instagramflickr;