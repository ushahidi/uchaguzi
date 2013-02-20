<?php defined('SYSPATH') or die('No direct script access.');
/**
 * This controller is used to manage election tool methods
 *
 * PHP version 5
 * LICENSE: This source file is subject to LGPL license
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/copyleft/lesser.html
 * @author	   Ushahidi Team <team@ushahidi.com>
 * @package	   Ushahidi - http://source.ushahididev.com
 * @module	   Admin Election Controller
 * @copyright  Ushahidi - http://www.ushahidi.com
 * @license	   http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL)
 */

class Election_Controller extends Tools_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->template->this_page = 'election';

	}

	function index()
	{
		$this->template->content = new View('election/monitor');
		$this->template->content->title = 'Manage Monitors';

		$this->template->content->this_page = 'monitor';
		// set up and initialize form fields
		$form = array
		(
			'action'	=> '',
			'monitor_id' => '',
			'location_id' => '',
			'phonenumber' => '',
			'polling_station' => '',
			'boundary_name' => ''
			);
			//copy the form as errors, so the errors will be stored with keys corresponding to the form field names
			$errors = $form;
			$form_error = FALSE;
			$form_saved = FALSE;
			$form_action = "";
			$location_array = array();

			// check, has the form been submitted, if so, setup validation
			if ($_POST)
			{

				$post = Validation::factory($_POST);
					
				//  Add some filters
				$post->pre_filter('trim', TRUE);
					
				if ($post->action == 'a') 				// Add/Edit Action
				{
					// Add some rules, the input field, followed by a list of checks, carried out in order
					$post->add_rules('phonenumber','required','length[3,50]');
					$post->add_rules('location_id','required');
				}
					
				if ($post->validate())
				{

					//$monitor = ORM::factory('monitors',$post->monitor_id);
					$monitor_id = $post->monitor_id;
					$monitor = new Monitor_Model($monitor_id);

					if( $post->action == 'd' )
					{ // Delete Action
						$monitor->delete( $monitor_id );
						$form_saved = TRUE;
						$form_action = 'DELETED';
							
					}
					elseif ($post->action == 'a') 				// Add/Edit Action
					{
						$monitor = ORM::factory('monitor',$post->monitor_id);

						// Existing Monitor??
						if ($monitor->loaded==true)
						{
							$monitor->phonenumber = $post->phonenumber;
							$monitor->location_id = $post->location_id;
							$monitor->polling_station = $post->polling_station;
							$monitor->save();

							$form_saved = TRUE;
							$form_action = "Edited";
						}
						else
						{
							$monitor->phonenumber = $post->phonenumber;
							$monitor->location_id = $post->location_id;
							$monitor->polling_station = $post->polling_station;
							$monitor->save();

							$form_saved = TRUE;
							$form_action = "Added";
						}
					}

				}
				else{
					// repopulate the form fields
					$form = arr::overwrite($form, $post->as_array());

					// populate the error fields, if any
					$errors = arr::overwrite($errors, $post->errors('monitor'));
					$form_error = TRUE;
				}
			}

			// Pagination
			$pagination = new Pagination(array(
                            'query_string' => 'page',
                            'items_per_page' => (int) Kohana::config('settings.items_per_page_admin'),
                            'total_items'    => ORM::factory('monitor')
			->count_all()
			));
			$monitors = ORM::factory('monitor')->orderby('monitor.location_id', 'asc')
			->find_all((int) Kohana::config('settings.items_per_page_admin'),
			$pagination->sql_offset);


			/* Get the list of locations */
			$location_array = ORM::factory('boundary')
			->select_list('id', 'boundary_name');
			
			$this->template->content->form = $form;
			$this->template->content->form_error = $form_error;
			$this->template->content->form_saved = $form_saved;
			$this->template->content->form_action = $form_action;
			$this->template->content->pagination = $pagination;
			$this->template->content->total_items = $pagination->total_items;
			$this->template->content->monitors = $monitors;
			$this->template->content->errors = $errors;
			$this->template->content->location_array = $location_array;

			// Javascript Header
			$this->template->colorpicker_enabled = TRUE;
			$this->template->js = new View('js/monitor_js');
	}


	function boundaries()
	{
		$this->template->content = new View('election/boundary');
		$this->template->content->title = 'Administrative Boundaries';
		$this->template->content->this_page = 'boundaries';

		// setup and initialize form field names
		$form = array
		(
			'action' => '',
			'boundary_id'      => '',
			'boundary_name'      => ''
			);
			 
			// copy the form as errors, so the errors will be stored with keys corresponding to the form field names
			$errors = $form;
			$form_error = FALSE;
			$form_saved = FALSE;
			$form_action = "";
			// check, has the form been submitted, if so, setup validation
			if ($_POST)
			{
				// Instantiate Validation, use $post, so we don't overwrite $_POST fields with our own things
				$post = Validation::factory(array_merge($_POST,$_FILES));
					
				//  Add some filters
				$post->pre_filter('trim', TRUE);

				if ($post->action == 'a')		// Add Action
				{
					// Add some rules, the input field, followed by a list of checks, carried out in order
					$post->add_rules('boundary_name','required', 'length[3,80]');
				}
					
				// Test to see if things passed the rule checks
				if ($post->validate())
				{
					$boundary_id = $post->boundary_id;
					$boundary = new Boundary_Model($boundary_id);

					if( $post->action == 'd' )
					{ // Delete Action
						$boundary->delete( $boundary_id );
						$form_saved = TRUE;
						$form_action = 'DELETED';
							
					}
					else if( $post->action == 'a' )
					{ // Save Action
						$boundary->boundary_name = $post->boundary_name;
						$boundary->save();
							
						$form_saved = TRUE;
						$form_action = 'ADDED/EDITED!';
					}
				}
				// No! We have validation errors, we need to show the form again, with the errors
				else
				{
					// repopulate the form fields
					$form = arr::overwrite($form, $post->as_array());

					// populate the error fields, if any
					$errors = arr::overwrite($errors, $post->errors('categorization'));
					$form_error = TRUE;
				}
			}

			// Pagination
			$pagination = new Pagination(array(
                            'query_string' => 'page',
                            'items_per_page' => (int) Kohana::config('settings.items_per_page_admin'),
                            'total_items'    => ORM::factory('boundary')
			->count_all()
			));

			$boundaries = ORM::factory('boundary')
			->orderby('id', 'ASC')
			->find_all((int) Kohana::config('settings.items_per_page_admin'),
			$pagination->sql_offset);

			$this->template->content->errors = $errors;
			$this->template->content->form_error = $form_error;
			$this->template->content->form_saved = $form_saved;
			$this->template->content->form_action = $form_action;
			$this->template->content->pagination = $pagination;
			$this->template->content->total_items = $pagination->total_items;
			$this->template->content->boundaries = $boundaries;

			// Locale (Language) Array
			$this->template->content->locale_array = Kohana::config('locale.all_languages');

			// Javascript Header
			$this->template->colorpicker_enabled = TRUE;
			$this->template->js = new View('js/boundary_js');



	}

    function codes(){

		$this->template->content = new View('election/code');
		$this->template->content->title = 'Form Codes';
		$this->template->content->this_page = 'codes';
		
		// setup and initialize form field names
		$form = array
	    (
			'action' => '',
			'code_id'      => '',
			'code_code_id'  => '',
			'code_description'      => ''
	    );
	    
		// copy the form as errors, so the errors will be stored with keys corresponding to the form field names
	    $errors = $form;
		$form_error = FALSE;
		$form_saved = FALSE;
		$form_action = "";
		// check, has the form been submitted, if so, setup validation
	    if ($_POST)
	    {
	        // Instantiate Validation, use $post, so we don't overwrite $_POST fields with our own things
			$post = Validation::factory(array_merge($_POST,$_FILES));
			
	         //  Add some filters
	        $post->pre_filter('trim', TRUE);
	
			if ($post->action == 'a')		// Add Action
			{
				// Add some rules, the input field, followed by a list of checks, carried out in order
				$post->add_rules('code_code_id','required');
				$post->add_rules('code_description','required', 'length[3,80]');
			}
			
			// Test to see if things passed the rule checks
	        if ($post->validate())
	        {
				$code_id = $post->code_id;
				$code = new Code_Model($code_id);
				
				if( $post->action == 'd' )
				{ // Delete Action
					$code->delete($code_id );
					$form_saved = TRUE;
					$form_action = 'DELETED';
			
				}
				else if( $post->action == 'a' )
				{ // Save Action				
					$code->code_description = $post->code_description;
					$code->code_id = $post->code_code_id;
					$code->save();
					
					$form_saved = TRUE;
					$form_action = 'ADDED/EDITED!';
				}
	        }
            // No! We have validation errors, we need to show the form again, with the errors
	        else
			{
	            // repopulate the form fields
	            $form = arr::overwrite($form, $post->as_array());

               // populate the error fields, if any
                $errors = arr::overwrite($errors, $post->errors('categorization'));
                $form_error = TRUE;
            }
        }

        // Pagination
        $pagination = new Pagination(array(
                            'query_string' => 'page',
                            'items_per_page' => (int) Kohana::config('settings.items_per_page_admin'),
                            'total_items'    => ORM::factory('code')
			     ->count_all()
                        ));

        $codes = ORM::factory('code')
                        ->orderby('code_id', 'asc')
                        ->find_all((int) Kohana::config('settings.items_per_page_admin'), 
                            $pagination->sql_offset);
		
		$this->template->content->errors = $errors;
        $this->template->content->form_error = $form_error;
        $this->template->content->form_saved = $form_saved;
		$this->template->content->form_action = $form_action;
		$this->template->content->form = $form;
        $this->template->content->pagination = $pagination;
        $this->template->content->total_items = $pagination->total_items;
        $this->template->content->codes = $codes;
		
		// Locale (Language) Array
		$this->template->content->locale_array = Kohana::config('locale.all_languages');

        // Javascript Header
        $this->template->colorpicker_enabled = TRUE;
        $this->template->js = new View('js/code_js');


	}


	function admin_sections(){

		$this->template->content = new View('election/adminsection');
		$this->template->content->this_page = 'admin_sections';

		// setup and initialize form field names
		$form = array
	    (
	    	'action' => '',
	    	'adminsection_id' => '',
			'adminsection_title' => '',
			'reportsection_id' =>'',
			'reportsection_name' => ''
	    );
        //  Copy the form as errors, so the errors will be stored with keys
        //  corresponding to the form field names
        $errors = $form;
		$form_error = FALSE;
		$form_saved = FALSE;
		$form_action = "";
		$reportsection_array = array();
		// check, has the form been submitted, if so, setup validation
	    if ($_POST)
	    {
	    	// Instantiate Validation, use $post, so we don't overwrite $_POST
            // fields with our own things
            $post = new Validation($_POST);

            // Add some filters
	        $post->pre_filter('trim', TRUE);

	        if($post->action == 'a' ) {
	        	$post->add_rules('adminsection_title','required','length[3,60]');
				$post->add_rules('reportsection_id','required');
	        }
	        
			// passed validation test.
			if($post->validate()) {
				$adminsection_id = $post->adminsection_id;
				
				$adminsection = new Adminsection_Model($adminsection_id);
				//Delete action
				if( $post->action == 'd'){
					
					$adminsection->delete( $adminsection_id );
					$form_saved = TRUE;
					$form_action = strtoupper(Kohana::lang('ui_admin.deleted'));
				}
				
				else if($post->action == 'v') {
				// Show/Hide Action
	            	if ($adminsection->loaded==true)
					{
						if ($adminsection->adminsection_active == 1) {
							$adminsection->adminsection_active = 0;
							
						}
						else {
							$adminsection->adminsection_active = 1;
						}
						$adminsection->save();
						$form_saved = TRUE;
						$form_action = strtoupper(Kohana::lang('ui_admin.modified'));
					}
				}
				
				else if( $post->action == 'a' ) 		
				{ // Save Action
					$adminsection->adminsection_title = $post->adminsection_title;
					$adminsection->reportsection_id = $post->reportsection_id;
					$adminsection->save();
					$form_saved = TRUE;
					$form_action = strtoupper(Kohana::lang('ui_admin.added_edited'));
				}
				
			} 
			
			else 
			{
				// repopulate the form fields
	            $form = arr::overwrite($form, $post->as_array());

	            // populate the error fields, if any
	            $errors = arr::overwrite($errors, $post->errors('adminsection'));
				$form_error = TRUE;	
			}
	    
	    }

	   // Pagination
        $pagination = new Pagination(array(
                            'query_string' => 'page',
                            'items_per_page' => (int) Kohana::config('settings.items_per_page_admin'),
                            'total_items'    =>
 							ORM::factory('adminsection')->count_all()
                     	));

        $adminsections = ORM::factory('adminsection')
                        ->orderby('adminsection_title', 'asc')
                        ->find_all((int) Kohana::config('settings.items_per_page_admin'), 
                            $pagination->sql_offset);

		/* Get the list of reportsections */
		$reportsection_array = ORM::factory('reportsection')
		->select_list('id', 'reportsection_name');


        $this->template->content->form = $form;
		$this->template->content->form_error = $form_error;
        $this->template->content->form_saved = $form_saved;
		$this->template->content->form_action = $form_action;
        $this->template->content->pagination = $pagination;
        $this->template->content->total_items = $pagination->total_items;
        $this->template->content->adminsections = $adminsections;
		$this->template->content->errors = $errors;
		$this->template->content->reportsection_array = $reportsection_array;

        // Javascript Header
        $this->template->colorpicker_enabled = TRUE;
        $this->template->js = new View('js/adminsection_js');


	}

	function report_sections()
	{
		$this->template->content = new View('election/reportsection');
		$this->template->content->title = 'Reports Sections';
		$this->template->content->this_page = 'report_sections';
		

		// setup and initialize form field names
		$form = array
		(
			'action' => '',
			'reportsection_id'  => '',
			'reportsection_name' => ''
			);
			 
			// copy the form as errors, so the errors will be stored with keys corresponding to the form field names
			$errors = $form;
			$form_error = FALSE;
			$form_saved = FALSE;
			$form_action = "";
			// check, has the form been submitted, if so, setup validation
			if ($_POST)
			{
				// Instantiate Validation, use $post, so we don't overwrite $_POST fields with our own things
				$post = Validation::factory(array_merge($_POST,$_FILES));
					
				//  Add some filters
				$post->pre_filter('trim', TRUE);

				if ($post->action == 'a')		// Add Action
				{
					// Add some rules, the input field, followed by a list of checks, carried out in order
					$post->add_rules('reportsection_name','required', 'length[3,80]');
				}
					
				// Test to see if things passed the rule checks
				if ($post->validate())
				{
					$reportsection_id = $post->reportsection_id;
					$reportsection = new Reportsection_Model($reportsection_id);

					if( $post->action == 'd' )
					{ 

				        // We don't want to delete the first and second
				        // reportsections
		
						if($post->reportsection_id_action != 1 && $post->reportsection_id_action !=2)
						{   
							// Delete the reportsection
							$reportsection->delete( $reportsection_id );
							
						}	   
						// Delete Action
						$form_saved = TRUE;
						$form_action = 'DELETED';
							
					}
					else if( $post->action == 'a' )
					{ // Save Action
						$reportsection->reportsection_name = $post->reportsection_name;
						$reportsection->save();
							
						$form_saved = TRUE;
						$form_action = 'ADDED/EDITED!';
					}
				}
				// No! We have validation errors, we need to show the form again, with the errors
				else
				{
					// repopulate the form fields
					$form = arr::overwrite($form, $post->as_array());

					// populate the error fields, if any
					$errors = arr::overwrite($errors, $post->errors('election'));
					$form_error = TRUE;
				}
			}

			// Pagination
			$pagination = new Pagination(array(
                            'query_string' => 'page',
                            'items_per_page' => (int) Kohana::config('settings.items_per_page_admin'),
                            'total_items'    => ORM::factory('reportsection')
			->count_all()
			));

			$reportsections = ORM::factory('reportsection')
			->orderby('id', 'ASC')
			->find_all((int) Kohana::config('settings.items_per_page_admin'),
			$pagination->sql_offset);

			$this->template->content->errors = $errors;
			$this->template->content->form_error = $form_error;
			$this->template->content->form_saved = $form_saved;
			$this->template->content->form_action = $form_action;
			$this->template->content->pagination = $pagination;
			$this->template->content->total_items = $pagination->total_items;
			$this->template->content->reportsections = $reportsections;

			// Locale (Language) Array
			$this->template->content->locale_array = Kohana::config('locale.all_languages');

			// Javascript Header
			$this->template->colorpicker_enabled = TRUE;
			$this->template->js = new View('js/reportsection_js');



	}


}
