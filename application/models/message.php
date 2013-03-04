<?php defined('SYSPATH') or die('No direct script access.');

/**
* Model for Messages
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

class Message_Model extends ORM
{
	protected $belongs_to = array('incident','reporter');
	protected $has_many = array('media');
	
	// Database table name
	protected $table_name = 'message';
	
	/**
	 * @return Message_Model
	 */
	public static function find_by_incident_id($incident_id)
	{
		$message_orm = ORM::factory('message')
				->where('incident_id', $incident_id)
				->find();
		
		return $message_orm;
	}

	public function replies()
	{
		$replies = ORM::factory('message')
			->where('reporter_id', $this->reporter_id)
			->orderby('message_date', 'desc')
			->limit(10)
			->find_all();
			
		// Don't return anything if no replies
		if ($replies->count() == 1 AND $replies->current()->id == $this->id) return array();
		
		return $replies;
	}

}