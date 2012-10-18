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

		$this->template->header->header_block = $this->themes->header_block();
		$this->template->footer->footer_block = $this->themes->footer_block();

	}	
	
}




?>
