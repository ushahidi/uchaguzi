<?php
/**
 * SODNET SMS API
 *
 * This class is meant to send SMS messages (with unicode support) via 
 * the Sodnet gateway. 
 * This class use the fopen or CURL module to communicate with the gateway via HTTP/S.
 *
 * @package sms_api
 */


class Sodnet_Core {

    /**
    *Api Key
    * @var integer
    */
    public $api_key;
    	
    public function __construct() {
    	$this->api_key = 'Psksd!324'.date('ymd');
    }

    public function send($to=null, $from=null, $text=null){
		
	//$code = '254';
		
	$too = $to;

	$new_to = $too;
	
 	$key = $this->api_key;	

	$sms_url = "http://41.215.5.182/remote/?user=huduma&pass=".md5($key)."&MESSAGE=".urlencode("$text")."&MSISDN=".urlencode($new_to)."&messageID=0&source=3002";
	
	$buffer = fopen($sms_url, "r");


	return $this->_parse_auth($buffer);

    }


    public function _parse_auth ($buffer) {

$dumped = stream_get_contents($buffer);		
$xml_string = <<<XML
$dumped
XML;
	$xml = simplexml_load_string($xml_string);
	$xml->Response->Code;
	if($xml->Response->Code = "201" ) {
			return "OK";
		}else{

			return "";
		}
	}
  
}

