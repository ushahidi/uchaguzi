<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Admin controller for instagram
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
class Instagramflickr_Controller extends Tools_Controller {
	
	public function __construct() 
	{
		parent::__construct();

		$this->template->this_page = 'settings';
		
	}
	
	public function index() 
	{
		$this->template->content = new View('admin/instagramflickr_form');
		// setup and initialize form field names
		$form = array
	    (
			'flickr_tag' => '',
			'flickr_id' => '',
			'num_of_photos' => '',
			'image_width' =>  '',
			'image_height' => '',
			'block_position' => '',
			'enable_cache' => '',
			'block_no_photos' => ''
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
	        
	        $post->add_rules('flickr_tag','required','length[0,500]');
			$post->add_rules('flickr_id','length[0,20]');
			$post->add_rules('num_of_photos','numeric');
			$post->add_rules('image_width','length[2,600]','numeric');
			$post->add_rules('image_height','required','length[2,600]','numeric');
			$post->add_rules('block_position','length[1,6]','numeric');
			$post->add_rules('enable_cache','between[0,1]','numeric');
			$post->add_rules('block_no_photos','between[4,10]','numeric');
	        
			// passed validation test.
			if($post->validate()) {
				$settings = new Instagramflickr_Settings_Model(1);

				$settings->flickr_tag = $post->flickr_tag;
				$settings->flickr_id = $post->flickr_id;
				$settings->num_of_photos = $post->num_of_photos;
				$settings->image_height = $post->image_height;
				$settings->image_width = $post->image_width;
				$settings->block_position = $post->block_position;
				$settings->enable_cache = $post->enable_cache;
				$settings->block_no_photos = $post->block_no_photos;
				
				$settings->save();
				
				// Delete Settings Cache
				// $this->cache->delete('settings');
				// $this->cache->delete_tag('settings');

				// Everything is A-Okay!
				$form_saved = TRUE;
					
				// repopulate the form fields
	            $form = arr::overwrite($form, $post->as_array());
				
			} 
			
			else 
			{
				// repopulate the form fields
	            $form = arr::overwrite($form, $post->as_array());

	            // populate the error fields, if any
	            $errors = arr::overwrite($errors, $post->errors('instagramflickr'));
				$form_error = TRUE;	
			}
	    
	    }

	    // Retrieve current settings.
	    else 
	    {
	    	$settings = ORM::factory('instagramflickr_settings',1);
	    	
	    	$form = array
	    	(
	    		'flickr_tag' => $settings->flickr_tag,
				'flickr_id' => $settings->flickr_id,
				'num_of_photos' => $settings->num_of_photos,
				'image_width' => $settings->image_width,
				'image_height' => $settings->image_height,
				'block_position' => $settings->block_position,
				'enable_cache' => $settings->enable_cache,
				'block_no_photos' => $settings->block_no_photos
	    	);
	    }
	    
	    $this->template->content->form = $form;
	    $this->template->content->errors = $errors;
		$this->template->content->form_error = $form_error;
		$this->template->content->form_saved = $form_saved;
		$this->template->content->this_page = 'settings/site';
	}
	
}