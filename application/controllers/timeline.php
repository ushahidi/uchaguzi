<?php defined('SYSPATH') or die('No direct script access.');
/**
 * This controller handles requests for SMS/ Email alerts
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

class Timeline_Controller extends Main_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		// Cacheable Controller
		$this->is_cachable = TRUE;

		$this->template->header->this_page = 'timeline';
		$this->template->content = new View('timeline');

		// Fetch all incidents
		$incidents = reports::fetch_incidents(TRUE);

		//Set the template content
		$this->template->content->incidents = $incidents;

		// Pagination
		$pagination = reports::$pagination;

		// Set the next and previous page numbers
		$this->template->content->next_page = $pagination->next_page;
		$this->template->content->previous_page = $pagination->previous_page;


		$this->template->content->pagination = $pagination;
		$this->template->header->header_block = $this->themes->header_block();
		$this->template->footer->footer_block = $this->themes->footer_block();

	}	
	
}




?>
