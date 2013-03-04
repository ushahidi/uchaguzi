<?php defined('SYSPATH') or die('No direct script access.');

/**
* Model for Locations
 *
 * PHP version 5
 * LICENSE: This source file is subject to LGPL license 
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/copyleft/lesser.html
 * @author     Ushahidi Team <team@ushahidi.com> 
 * @package    Ushahidi - http://source.ushahididev.com
 * @subpackage Models
 * @copyright  Ushahidi - http://www.ushahidi.com
 * @license    http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL) 
 */

class Location_Model extends ORM
{
	/**
	 * One-to-many relationship definition
	 * @var array
	 */
	protected $has_many = array('incident', 'media', 'incident_person', 'feed_item', 'reporter', 'checkin');
	
	/**
	 * Many-to-one relationship definition
	 * @var array
	 */
	protected $has_one = array('country');
	
	/**
	 * Database table name
	 * @var string
	 */
	protected $table_name = 'location';
	
	/**
	 * Checks if a location id exists in the database
	 * @param int $location_id Database ID of the the location
	 * @return bool
	 */
	public static function is_valid_location($location_id)
	{
		return (intval($location_id) > 0)
			? ORM::factory('location', intval($location_id))->loaded
			: FALSE;
	}
	
	/**
	 * Get and return a location record using the latitude and longitude
	 *
	 * @param float latitude
	 * @param float longitude
	 * @return Location_Model when found, NULL otherwise
	 */
	public static function find_by_lat_lon($latitude, $longitude)
	{
		$location_orm = ORM::factory('location')
			->where('latitude', $latitude)
			->where('longitude', $longitude)
			->find();
		
		return $location_orm->loaded ? $location_orm : NULL;
	}

	/**
	 * Creates and returns a location entry in the database
	 *
	 * @param  array location_data
	 * @return Location_Model
	 */
	public static function create_from_array($location_data)
	{
		$location_orm = new Location_Model();

		$location_orm->location_name = $location_data['location_name'];
		$location_orm->country_id = Settings_Model::get_setting('default_country');
		$location_orm->latitude = $location_data['latitude'];
		$location_orm->longitude = $location_data['longitude'];
		$location_orm->location_visible = 1;
		$location_orm->location_date = date('Y-m-d H:i:s');
		
		return $location_orm->save();
	}
}
