<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Helper library for the Sodnet API
 *
 * @package     Sodnet SMS 
 * @category    Plugins
 * @author      Ushahidi Team
 * @copyright   (c) 2008-2013 Ushahidi Team
 * @license     http://www.gnu.org/copyleft/lesser.html GNU Less Public General License (LGPL)
 */
class Sodnet_Sms_Provider implements Sms_Provider_Core {
	
	/**
	 * Sends a text message (SMS) using the Sodnet API
	 *
	 * @param string $to
	 * @param string $from
	 * @param string $to
	 */
	public function send($to = NULL, $from = NULL, $message = NULL)
	{
		// Get Current Sodnet Settings
		$sodnet_username = Settings_Model::get_setting('sodnet_username');
		$sodnet_apikey = Settings_Model::get_setting('sodnet_apikey');
		
		$key = md5($sodnet_apikey.date('ymd'));
		$from = ($from) ? $from : '3002';
		$message = urlencode($message);

		$url = "http://41.215.5.182/remote/?user=".$sodnet_username."&pass=".$key."&MESSAGE=".$message."&MSISDN=".$to."&messageID=0&source=".$from;

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, '3');
		$data = curl_exec($ch);
		curl_close($ch);

		$json = json_decode($data, true);

		if ($json AND isset($json['content']))
		{
			$sent = strrpos($json['content'], 'SMS SENT');
			if ($sent === FALSE)
			{
				Kohana::log('error', 'SODNET: Generic Error: could not send message. Please write mail to techkenya@mtechcomm.com -- '.serialize($json));
				return "Generic Error: could not send message. Please write mail to techkenya@mtechcomm.com";
				//return $json['content'];
			}
			else
			{
				return TRUE;
			}
		}
		else
		{
			Kohana::log('error', 'SODNET: Invalid Response From SODNET! -- '.serialize($json));
			return "Invalid Response From SODNET!";
			//return $url;
		}
	}
	
}