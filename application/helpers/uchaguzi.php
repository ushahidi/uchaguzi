<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Front-End Nav helper class for the uchaguzi theme.
 *
 * @package    Nav
 * @author     Ushahidi Team
 * @copyright  (c) 2008 Ushahidi Team
 * @license    http://www.ushahidi.com/license.html
 */
class uchaguzi_Core {
	
	/**
	 * Generate Info Tabs
     * @param string $this_page
     * @param array $dontshow
	 * @return string $menu
     */
	
	public function info_tabs($page_id)
	{
		$menu = "";
		
		// Electoral Process
			$menu .= "<li class='current'><a href=\"".url::site()."info/index/1\" ";
			//$menu .= ($this_page == 'electoral_process') ? " class=\"current\"" : "";
		 	$menu .= ">".Kohana::lang('uchaguzi.electoral_process')."</a></li>";

		// Voting Process
			$menu .= "<li><a href=\"".url::site()."info/index/2\" ";
			//$menu .= ($this_page == 'voting_process') ? " class=\"active\"" : "";
		 	$menu .= ">".Kohana::lang('uchaguzi.voting_process')."</a></li>";
	
		echo $menu;

	}
	
	
}
