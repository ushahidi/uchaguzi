<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Sodnet Settings Controller
 *
 * PHP version 5
 * LICENSE: This source file is subject to LGPL license 
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/copyleft/lesser.html
 * @author	   Ushahidi Team <team@ushahidi.com> 
 * @package    Ushahidi - http://source.ushahididev.com
 * @module	   Sodnet Settings Controller	
 * @copyright  Ushahidi - http://www.ushahidi.com
 * @license    http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL) 
* 
*/

class Sodnet_Settings_Controller extends Tools_Controller {
	public function index()
	{
		$this->template->this_page = 'addons';
		
		// Standard Settings View
		$this->template->content = new View("admin/addons/plugin_settings");
		$this->template->content->title = "Sodnet Settings";
		$this->template->content->this_page = 'addons';
		
		// Settings Form View
		$this->template->content->settings_form = new View("sodnet/admin/sodnet_settings");
		
		// JS Header Stuff
		//$this->template->js = new View('sodnet/admin/sodnet_settings_js');
		
		// setup and initialize form field names
		$form = array
		(
			'sodnet_username' => '',
			'sodnet_apikey' => ''
		);
		//  Copy the form as errors, so the errors will be stored with keys
		//  corresponding to the form field names
		$errors = $form;
		$form_error = FALSE;
		$form_saved = FALSE;

		// check, has the form been submitted, if so, setup validation
		if ($_POST)
		{
			// Instantiate Validation, use $post, so we don't overwrite $_POST
			// fields with our own things
			$post = new Validation($_POST);

			// Add some filters
			$post->pre_filter('trim', TRUE);

			// Add some rules, the input field, followed by a list of checks, carried out in order

			$post->add_rules('sodnet_username', 'required', 'length[3,50]');
			$post->add_rules('sodnet_apikey', 'required', 'length[3,50]');

			// Test to see if things passed the rule checks
			if ($post->validate())
			{
				// Yes! everything is valid
				Settings_Model::save_setting('sodnet_username', $post->sodnet_username);
				Settings_Model::save_setting('sodnet_apikey', $post->sodnet_apikey);

				// Everything is A-Okay!
				$form_saved = TRUE;

				// repopulate the form fields
				$form = arr::overwrite($form, $post->as_array());

			}

			// No! We have validation errors, we need to show the form again,
			// with the errors
			else
			{
				// repopulate the form fields
				$form = arr::overwrite($form, $post->as_array());

				// populate the error fields, if any
				$errors = arr::overwrite($errors, $post->errors('settings'));
				$form_error = TRUE;
			}
		}
		else
		{
			// Retrieve Current Settings
			$form = array
			(
				'sodnet_username' => Settings_Model::get_setting('sodnet_username'),
				'sodnet_apikey' => Settings_Model::get_setting('sodnet_apikey')
			);
		}
		
		// Pass the $form on to the settings_form variable in the view
		$this->template->content->settings_form->form = $form;
		
		// Other variables
		$this->template->content->errors = $errors;
		$this->template->content->form_error = $form_error;
		$this->template->content->form_saved = $form_saved;
	}
}