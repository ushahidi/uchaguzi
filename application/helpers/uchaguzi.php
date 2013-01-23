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
	
	public function gallery_tabs($this_page = FALSE)
	{
		//media_tpes: 0=>All, 1=>Images, 2=>Videos, 3=>Audio, 4=>News, 5=>Podcasts
		//$media_type = array("0", "1", "2", "3", "4", "5");
		$menu = "";

		//All
		$menu .= "<li class=\"active\"><a href='#' id='filter_link_media_0'>".Kohana::lang('uchaguzi.all')."</a></li>";

		//Images
		$menu .= "<li><a href='#' id='filter_link_media_1'>".Kohana::lang('uchaguzi.image')."</a></li>";
		
		//Videos
		$menu .= "<li><a href='#' id='filter_link_media_2'>".Kohana::lang('uchaguzi.video')."</a></li>";

		//News
		$menu .= "<li><a href='#' id='filter_link_media_4'>".Kohana::lang('uchaguzi.news')."</a></li>";

		echo $menu;
	}

	public function gallery_reports_menu($this_page = FALSE)
	{
		$menu = "";

		//All
		$menu .= "<li><a href=\"".url::site()."gallery\" ";
		$menu .= ($this_page == 'home') ? " class=\"active\"" : "";
		$menu .= ">".Kohana::lang('uchaguzi.all_reports')."</a></li>";

		//Recent
		$menu .= "<li><a href=\"".url::site()."gallery\" ";
		$menu .= ($this_page == 'home') ? " class=\"active\"" : "";
		$menu .= ">".Kohana::lang('uchaguzi.recent_reports')."</a></li>";
		
		//Popular
		$menu .= "<li><a href=\"".url::site()."gallery\" ";
		$menu .= ($this_page == 'home') ? " class=\"active\"" : "";
		$menu .= ">".Kohana::lang('uchaguzi.popular_reports')."</a></li>";

		//Amplified
		$menu .= "<li><a href=\"".url::site()."gallery\" ";
		$menu .= ($this_page == 'home') ? " class=\"active\"" : "";
		$menu .= ">".Kohana::lang('uchaguzi.amplified_reports')."</a></li>";

		//Fagged
		$menu .= "<li><a href=\"".url::site()."gallery\" ";
		$menu .= ($this_page == 'home') ? " class=\"active\"" : "";
		$menu .= ">".Kohana::lang('uchaguzi.flagged_reports')."</a></li>";

		echo $menu;
	}

	/**
	 * Get news URL page title for the 
	 * gallery display
	 *
	 * @return string
	 */
	public static function page_title($url) {

		// Only process valid URL
		if ( valid::url($url)) 
		{ 
			// get content of the URL and supress warnings
			$file = @file_get_contents($url);
		
			if (preg_match("/<title>(.+)<\/title>/i",$file,$result))
			{
				return $result[1];
			}
		}
	}
}
