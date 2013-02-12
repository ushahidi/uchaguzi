<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Election Tool helper class.
 *
 * @package    Election
 * @author     Ushahidi Team
 * @copyright  (c) 2008 Ushahidi Team
 * @license    http://www.ushahidi.com/license.html
 */


class election_tool_Core {

	/**
	 * Generate Election Tab Menus
	 */

	public static function election_subtabs($this_sub_page = FALSE)
	{
		$menu = "";

		$menu .= ($this_sub_page == "monitors") ?
Kohana::lang('election.monitors') : "<a
href=\"".url::site()."admin/election\">".Kohana::lang('election.monitors')."</a>";

		$menu .= ($this_sub_page == "boundaries") ?
Kohana::lang('election.boundaries') : "<a
href=\"".url::site()."admin/election/boundaries\">".Kohana::lang('election.boundaries')."</a>";

		
		$menu .= ($this_sub_page == "codes") ?
Kohana::lang('election.codes') : "<a
href=\"".url::site()."admin/election/codes\">".Kohana::lang('election.codes')."</a>";

		$menu .= ($this_sub_page == "admin_sections") ?
Kohana::lang('election.admin_sections') : "<a
href=\"".url::site()."admin/election/admin_sections\">".Kohana::lang('election.admin_sections')."</a>";
		$menu .= ($this_sub_page == "report_sections") ?
Kohana::lang('election.report_sections') : "<a
href=\"".url::site()."admin/election/report_sections\">".Kohana::lang('election.report_sections')."</a>";

		echo $menu;
		
	}

}
