<?php defined('SYSPATH') or die('No direct script access.');
/**
 * This controller handles the administrator Navigation bar (tools)
 *
 * PHP version 5
 * LICENSE: This source file is subject to LGPL license
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/copyleft/lesser.html
 * @author     Ushahidi Team <team@ushahidi.com>
 * @package    Ushahidi - http://source.ushahididev.com
 * @subpackage Controllers
 * @copyright  Ushahidi - http://www.ushahidi.com
 * @license    http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL)
*/

class Tools_Controller extends Main_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		// Cacheable Controller
		$this->is_cachable = TRUE;

		$this->template->header->this_page = 'tools';
		$this->template->content = new View('tools');

		// Generate main tab navigation list.
		$this->template->content->main_tabs = admin::main_tabs();

		$this->template->content->this_page = "";

		// Retrieve Dashboard Count...

		// Total Reports
		$this->template->content->reports_total = ORM::factory('incident')->count_all();

		// Total Unapproved Reports
		$this->template->content->reports_unapproved = ORM::factory('incident')->where('incident_active', '0')->count_all();

		// Total verified Reports
		$this->template->content->reports_verified =
		ORM::factory('incident')->where('incident_verified', '1')->count_all();

		// Total unverified Reports
		$this->template->content->reports_unverified =
		ORM::factory('incident')->where('incident_verified', '0')->count_all();


		// Total Messages
		$message_count = ORM::factory('message')
						->join('reporter','message.reporter_id','reporter.id')
						->where('message_type', '1')
						->count_all();

		$this->template->content->message_count = $message_count;


		$this->template->header->header_block = $this->themes->header_block();
		$this->template->footer->footer_block = $this->themes->footer_block();

	}	
	
}




?>
