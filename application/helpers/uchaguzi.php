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
	
	public function info_tabs($this_page = FALSE)
	{
		$pages = ORM::factory('page')->where('page_active','1')->find_all();
		$menu = "";
		
		foreach ($pages as $page)
		{
			$page_id = $page->id;
			$page_title = $page->page_title;
			$page_tab = $page->page_tab;
			
			//Page details
			$menu .= "<li><a href=\"".url::site()."info/index/".$page_id."\" ";
			$menu .= ($this_page == $page_title) ? " class=\"active\"" : "";
		 	$menu .= ">".$page_tab."</a></li>";

		}

		echo $menu;

	}
	
	
}
