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
'<li class="active"><a>'.Kohana::lang('election.monitors').'</a></li>' : "<li><a
href=\"".url::site()."admin/election\">".Kohana::lang('election.monitors')."</a></li>";

		$menu .= ($this_sub_page == "boundaries") ?
'<li class="active"><a>'.Kohana::lang('election.boundaries').'</a></li>' : "<li><a
href=\"".url::site()."admin/election/boundaries\">".Kohana::lang('election.boundaries')."</a></li>";
		
		$menu .= ($this_sub_page == "codes") ?
'<li class="active"><a>'.Kohana::lang('election.codes').'</a></li>' : "<li><a
href=\"".url::site()."admin/election/codes\">".Kohana::lang('election.codes')."</a></li>";

		$menu .= ($this_sub_page == "admin_sections") ?
'<li class="active"><a>'.Kohana::lang('election.admin_sections').'</a></li>' : "<li><a
href=\"".url::site()."admin/election/admin_sections\">".Kohana::lang('election.admin_sections')."</a></li>";

		$menu .= ($this_sub_page == "report_sections") ?
'<li class="active"><a>'.Kohana::lang('election.report_sections').'</a></li>' : "<li><a
href=\"".url::site()."admin/election/report_sections\">".Kohana::lang('election.report_sections')."</a></li>";

		echo $menu;
		
	}

}
