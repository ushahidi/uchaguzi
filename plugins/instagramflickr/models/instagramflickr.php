<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Model for instagramflickr
 */
class Instagramflickr_Model extends ORM {

	protected $belongs_to = array('incident','reporter');
	protected $has_many = array('media');
	
	// Table name
	protected $table_name = 'instagramflickr';
}