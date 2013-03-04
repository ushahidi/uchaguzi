<?php
class flickr_Core {

	/**
	 * Fetch flickr images
	 */
	public static function fetch_flickr_images() 
	{

		//Load the php flickr library
		include Kohana::find_file('libraries/phpflickr','phpFlickr');
		
		return new phpFlickr(Kohana::config('instagramflickr.flick_api_key'));
	}

	/**
	 * Search photo based on set tags
	 *
	 * @return The found photos
	 */
	public static function photo_search() 
	{
		$flickr = self::fetch_flickr_images();

		// Fetch flickr settings from db
		$settings = ORM::factory('instagramflickr_settings',1);
		
		return $flickr->photos_search( array(
			'tags' => $settings->flickr_tag,
			'per_page' => $settings->block_no_photos
		) );
	}
}