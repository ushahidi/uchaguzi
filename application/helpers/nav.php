<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Front-End Nav helper class.
 *
 * @package    Nav
 * @author     Ushahidi Team
 * @copyright  (c) 2008 Ushahidi Team
 * @license    http://www.ushahidi.com/license.html
 */
class nav_Core {
	
	/**
	 * Generate Main Tabs
     * @param string $this_page
     * @param array $dontshow
	 * @return string $menu
     */
	public static function main_tabs($this_page = FALSE, $dontshow = FALSE)
	{
		$menu = "";
		
		if( ! is_array($dontshow))
		{
			// Set $dontshow as an array to prevent errors
			$dontshow = array();
		}
		
		// Home
		/*
		if( ! in_array('home',$dontshow))
		{
			$menu .= "<li><a href=\"".url::site()."main\" ";
			$menu .= ($this_page == 'home') ? " class=\"active\"" : "";
		 	$menu .= "><i class=\"icon-main\"></i>".Kohana::lang('ui_main.home')."</a></li>";
		 }
		 */
		 

		// Reports Submit
		if( ! in_array('reports_submit',$dontshow))
		{
			if (Kohana::config('settings.allow_reports'))
			{
				$menu .= "<li class=\"submit\"><a href=\"".url::site()."reports/submit\" ";
				$menu .= ($this_page == 'reports_submit') ? " class=\"active\"":"";
			 	$menu .= "><i class=\"icon-pencil\"></i><span class=\"label\">".Kohana::lang('ui_main.submit')."</span></a></li>";
			}
		}		 

		// Reports List
		if( ! in_array('reports',$dontshow))
		{
			$menu .= "<li><a href=\"".url::site()."reports\" ";
			$menu .= ($this_page == 'reports') ? " class=\"active\"" : "";
		 	$menu .= "><i class=\"icon-pictures\"></i><span class=\"label\">".Kohana::lang('ui_main.reports')."</span></a></li>";
		 }

		// Timeline
		/*
		if( ! in_array('timeline',$dontshow))
		{
			$menu .= "<li><a href=\"".url::site()."timeline\" ";
			$menu .= ($this_page == 'timeline') ? " class=\"active\"" : "";
		 	$menu .= ">".Kohana::lang('uchaguzi.timeline')."</a></li>";
		 }
		
		
		// Alerts
		if(! in_array('alerts',$dontshow))
		{
			if(Kohana::config('settings.allow_alerts'))
			{
				$menu .= "<li><a href=\"".url::site()."alerts\" ";
				$menu .= ($this_page == 'alerts') ? " class=\"active\"" : "";
				$menu .= ">".Kohana::lang('ui_main.alerts')."</a></li>";
			}
		}
		
		// Contacts
		if( ! in_array('contact',$dontshow))
		{
			if (Kohana::config('settings.site_contact_page') AND Kohana::config('settings.site_email') != "")
			{
				$menu .= "<li><a href=\"".url::site()."contact\" ";
				$menu .= ($this_page == 'contact') ? " class=\"active\"" : "";
			 	$menu .= ">".Kohana::lang('ui_main.contact')."</a></li>";	
			}
		}
		*/
		
		// Media
		if( ! in_array('gallery',$dontshow))
		{
				$menu .= "<li><a href=\"".url::site()."gallery\" ";
				$menu .= ($this_page == 'gallery') ? " class=\"active\"" : "";
			 	$menu .= "><i class=\"icon-video\"></i><span class=\"label\">".Kohana::lang('uchaguzi.gallery')."</span></a></li>";	
		}		
		
		// Info
		if( ! in_array('info',$dontshow))
		{
				$menu .= "<li><a href=\"".url::site()."info\" ";
				$menu .= ($this_page == 'info') ? " class=\"active\"" : "";
			 	$menu .= "><i class=\"icon-info\"></i><span class=\"label\">".Kohana::lang('uchaguzi.info')."</span></a></li>";	
		}
		
		echo $menu;
		
		// Action::nav_admin_reports - Add items to the admin reports navigation tabs
		Event::run('ushahidi_action.nav_main_top', $this_page);
	}


	/*
	 * Generate header tabs
	 * @param string $this_page
	 * @param array $dontshow
	 * @return string $menu
	*/

	
	public function header_tabs($this_page, $user = FALSE)
	{
		$menu = "";
		
		// Main
			$menu .= "<li><a href=\"".url::site()."main\" ";
			//$menu .= ($this_page == 'home') ? " class=\"active\"" : "";
		 	$menu .= ">".Kohana::lang('ui_main.home')."</a></li>";

		// Citizen Reports
			$menu .= "<li><a href=\"".url::site()."reports\" ";
			//$menu .= ($this_page == 'reports') ? " class=\"active\"" : "";
		 	$menu .= ">".Kohana::lang('uchaguzi.citizen_reports')."</a></li>";
		
		//IEBC
			$menu .= "<li><a href=\"".url::site()."timeline\" ";
			//$menu .= ($this_page == 'timeline') ? " class=\"active\"" : "";
		 	$menu .= ">".Kohana::lang('uchaguzi.iebc')."</a></li>";

		//ELOG
			$menu .= "<li><a href=\"".url::site()."analysis\" ";
			//$menu .= ($this_page == 'analysis') ? " class=\"active\"" : "";
		 	$menu .= ">".Kohana::lang('uchaguzi.elog')."</a></li>";
	
		//TOOLS
			if(Auth::instance()->has_permission('tools', $user))
			{
				$menu .="<li><a href=\"".url::site()."tools\" ";
				//$menu .= ($this_page == 'tools') ? " class=\"active\"" : "";
				$menu .= ">".Kohana::lang('uchaguzi.tools')."</a></li>";
			}
			else
			{
				//hide the tools tab
			}

		echo $menu;

		// Action::nav_main_top - Add items to main nav bar
		Event::run('ushahidi_action.nav_main_top', $this_page);
	}
	
	
}
