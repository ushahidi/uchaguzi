<?php defined('SYSPATH') or die('No direct script access.');

/**
* Model for Reporters
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

class Reporter_Model extends ORM
{
	protected $belongs_to = array('service','level','location');
	protected $has_many = array('incident','message');
	
	// Database table name
	protected $table_name = 'reporter';
	
	// Create a Reporter if they do not already exist
	public function add($reporter_attrs)
	{
		if (count($this->where('service_id', $reporter_attrs['service_id'])->
		                 where('service_account', $reporter_attrs['service_account'])->
		                 find_all()) == 0)
		{
			$this->db->insert('reporter', $reporter_attrs);
		}
	}
	
	/**
	 * Finds and returns a report record using the service name and service account
	 *
	 * @param  string service_name
	 * @param  string service_account
	 * @return Reporter_Model
	 */
	public static function find_by_service_account($service_name, $service_account)
	{
		$reporter_orm = ORM::factory('reporter')
			->join('service', 'service.id', 'reporter.service_id', 'INNER')
			->where('service.service_name', $service_name)
			->where('reporter.service_account', $service_account)
			->find();
		
		return $reporter_orm->loaded ? $reporter_orm : NULL;
	}
}
