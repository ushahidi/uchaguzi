<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Instagram Flickr
 */
class Instagramflickr_Controller extends Controller {

	private $flicrk;
	public function __construct()
	{
		parent::__construct();
	}

	public function index() 
	{
		$this->flickr = flickr::fetch_flickr_images();

		// Fetch flickr settings from db
		$settings = ORM::factory('instagramflickr_settings',1);
		
		$photos = $this->flickr->photos_search( array(
			'tags' => $settings->flickr_tag,
			'per_page' => $settings->block_no_photos) );

		$this->_add_flickr($photos);
	}

	/**
	 * Pull instagram photos
	 *  
	 */
	public function instagram()
	{
		$this->_add_instagram(instagram::photo_search());
	}

	/**
	 * Add instagram photos to the database
	 */
	private function _add_instagram($photos) 
	{
		$service = ORM::factory('service')
			->where('service_name', 'Instagram')
			->find();

		if (isset($photos->meta->code) AND $photos->meta->code == 200)
		{
			if (isset($photos->data))
			{	
				
				$foto = array();
				foreach($photos->data AS $photo)
				{

					$foto['name'] = $photo->user->full_name;

					$foto['username'] = $photo->user->username; 

					$foto['title'] = $photo->caption->text;

					$foto['photo_id'] = $photo->id;

					$foto['service_id'] = $service->id; 

					$foto['date'] = $photo->created_time;

					$foto['description'] = $photo->caption->text;

					$foto['link'] = $photo->images->standard_resolution->url;
					
					$foto['medium'] = $photo->images->low_resolution->url;
					
					$foto['thumb'] = $photo->images->thumbnail->url;

					// Location
					if ($photo->location != NULL )
					{
						$foto['latitude'] = $photo->location->latitude;

						$foto['longitude'] = $photo->location->longitude;
					}
					else 
					{
						$foto['latitude'] = "";

						$foto['longitude'] = "";
					}
					
					
					// Add to database
					$this->_add_to_database($foto);
				}
			}
		}
	}

	/**
	 * Add photo details to database
	 * @param [type] $photo [description]
	 */
	private function _add_to_database($photo) 
	{

		$p = ORM::factory('instagramflickr')->where('service_photoid',
			$photo['photo_id'])->find();

		// Avoid duplicates
		if ( ! $p->loaded AND $p->service_photoid != $photo['photo_id'])
		{

			$reporter = ORM::factory('reporter')
				->where('service_id', $photo['service_id'])
				->where('service_account', $photo['username'])
				->find();
			
			if (!$reporter->loaded == true)
			{
				// Add new reporter
				$names = explode(' ', $photo['name'], 2);
				$last_name = '';
				if (count($names) == 2) {
					$last_name = $names[1]; 
				}

				// get default reporter level (Untrusted)
				$level = ORM::factory('level')
					->where('level_weight', 0)
					->find();

				// Add new reporter
				$reporter->service_id		= $photo['service_id'];
				$reporter->level_id			= $level->id;
				$reporter->service_account	= $photo['username']; 
				$reporter->reporter_first	= $names[0];
				$reporter->reporter_last	= $last_name;
				$reporter->reporter_email	= null;
				$reporter->reporter_phone	= null;
				$reporter->reporter_ip		= null;
				$reporter->reporter_date	= date('Y-m-d');
				$reporter->save();
			}

			if ($reporter->level_id > 1 AND 
					count(ORM::factory('instagramflickr')
						->where('service_photoid', $photo['photo_id'])
						->find_all()) == 0 )
			{
				// Save Email as Message
				$instagramflickr = new Instagramflickr_Model();
				$instagramflickr->parent_id = 0;
				$instagramflickr->incident_id = 0;
				$instagramflickr->user_id = 0;
				$instagramflickr->reporter_id = $reporter->id;
				$instagramflickr->photo_from = $photo['name'];
				$instagramflickr->photo_to = null;
				$instagramflickr->photo_title = $photo['title'];
				$instagramflickr->photo_description = $photo['description'];
				$instagramflickr->photo_type = 1; // Inbox
				$instagramflickr->photo_date = $photo['date'];
				$instagramflickr->service_photoid = $photo['photo_id'];
				$instagramflickr->latitude = $photo['latitude'];
				$instagramflickr->longitude = $photo['longitude'];
				$instagramflickr->save();

				//Add media
				$media = new Media_Model();
				$media->location_id = 0;
				$media->incident_id = 0;
				$media->message_id = $instagramflickr->id;
				$media->media_type = 1; // Images
				$media->media_link = $photo['link'];
				$media->media_medium = $photo['medium'];
				$media->media_thumb = $photo['thumb'];
				$media->media_date = date("Y-m-d H:i:s",time());
				$media->save();

				// Auto-Create A Report if Reporter is Trusted
				$reporter_weight = $reporter->level->level_weight;
				$reporter_location = $reporter->location;
				//Auto-Create A Report if there is location
				if ($reporter_weight > 0 AND $reporter_location)
				{
					// Create Incident
					$incident = new Incident_Model();
					$incident->location_id = $reporter_location->id;
					$incident->incident_title = $photo['title'];
					$incident->incident_description = $photo['description'];
					$incident->incident_date = $photo['date'];
					$incident->incident_dateadd = date("Y-m-d H:i:s",time());
					$incident->incident_active = 1;
					if ($reporter_weight == 2)
					{
						$incident->incident_verified = 1;
					}
					if ($reporter->user_id > 0)
					{
						$incident->user_id = $reporter->user_id;
					}
					$incident->save();

					// Update Message with Incident ID
					$email->incident_id = $incident->id;
					$email->save();

					// Save Incident Category
					$trusted_categories = ORM::factory("category")
						->where("category_trusted", 1)
						->find();
					if ($trusted_categories->loaded)
					{
						$incident_category = new Incident_Category_Model();
						$incident_category->incident_id = $incident->id;
						$incident_category->category_id = $trusted_categories->id;
						$incident_category->save();
					}

					// Add media
					$media = ORM::factory("media")
						->where("message_id", $instagramflickr->id)
						->find_all();
					foreach ($media AS $m)
					{
						$m->incident_id = $incident->id;
						$m->save();
					}
				}
			}
		}
	}

	/**
	 * Add flcirk photos to the database
	 * 
	 * @param  array $photos Details of the photos
	 * 
	 */
	private function _add_flickr($photos)
	{
		$service = ORM::factory('service')
			->where('service_name', 'Flickr')
			->find();
		
		if ( ! $service->loaded)
		{
			return;
		}

		if (empty($photos['photo']) OR ! is_array($photos['photo']))
		{
			return;
		}
		
		$foto = array();
		foreach($photos['photo'] as $photo) 
		{
			// Get details of the photo	
			$photo_info = $this->flickr->photos_getInfo($photo['id'], 
				$photo['secret']);
			
			$foto['name'] = $photo_info['owner']['realname'];

			$foto['service_id'] = $service->id; 

			$foto['username'] = $photo_info['owner']['username']; 

			$foto['title'] = $photo_info['title'];

			$foto['photo_id'] = $photo_info['id'];

			$foto['date'] = $photo_info['dates']['posted'];

			$foto['description'] = $photo_info['description'];

			$foto['link'] = $this->flickr->buildPhotoURL($photo, "Large");
			
			$foto['medium'] = $this->flickr->buildPhotoURL($photo);
			
			$foto['thumb'] = $this->flickr->buildPhotoURL($photo,'Square');

			// Location
			if( ( $photo_info['location'] != NULL) AND 
					(is_array($photo_info['location'])))
			{
				$foto['latitude'] = $photo_info['location']['latitude'];

				$foto['longitude'] = $photo_info['location']['longitude'];
			}
			else 
			{
				$foto['latitude'] = "";

				$foto['longitude'] = "";
			}

			// Add to database
			$this->_add_to_database($foto);
		}
	}
} 