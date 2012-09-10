<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Info Controller
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

class Info_Controller extends Main_Controller {
	function __construct()
	{
		parent::__construct();
	}

	public function index()
	{

		$this->template->header->this_page = 'info';
		$this->template->content = new View('info');

		$this->template->header->page_title .= Kohana::lang('uchaguzi.info') . Kohana::config('settings.title_delimiter');
		
		$electoral = TRUE;
		$voting = TRUE;
		
		$this->template->content->electoral = $electoral;
		$this->template->content->voting = $voting;
		
	}

}
