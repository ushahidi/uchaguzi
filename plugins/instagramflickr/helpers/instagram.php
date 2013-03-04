<?php
class instagram_core {

	public static function send_request($url)
	{

		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,15); // Timeout set to 15 seconds. This is somewhat arbitrary and can be changed.
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1); //Set curl to store data in variable instead of print
		curl_setopt($ch,CURLOPT_HTTPGET, true);
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
		$buffer = curl_exec($ch);
		curl_close($ch);

		return json_decode($buffer);
	}

	public static function photo_search() 
	{
		$url = sprintf("https://api.instagram.com/v1/tags/%s/media/recent?client_id=%s",
			Kohana::config('instagramflickr.instagram_tag'), Kohana::config('instagramflickr.instagram_client_id'));
		
		return self::send_request($url);
		
	}
}
?>