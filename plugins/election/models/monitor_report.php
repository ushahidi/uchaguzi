<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Model for Monitor Report
 *
 * PHP version 5
 * LICENSE: This source file is subject to LGPL license
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/copyleft/lesser.html
 * @author     Ushahidi Team <team@ushahidi.com>
 * @package    Ushahidi - http://source.ushahididev.com
 * @module     Monitor Report Model
 * @copyright  Ushahidi - http://www.ushahidi.com
 * @license    http://www.gnu.org/copyleft/lesser.html GNU Lesser General
 * Public License (LGPL)
 */

class Monitor_Report_Model extends ORM
{
	protected $has_one = array('incident');
	
	// Database table name
	protected $table_name = 'monitor_report';
	
	/**
	 * Createa monitor_report record given a monitor and an incident
	 */
	public static function create_from_incident($monitor, $incident)
	{
		$monitor_report = new Monitor_Report_Model();

		$monitor_report->monitor_id = $monitor->id;
		$monitor_report->incident_id = $incident->id;
		$monitor_report->save();
	}
	
}
