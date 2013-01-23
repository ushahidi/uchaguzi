<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Admin helper class.
 *
 * @package	   Admin
 * @author	   Ushahidi Team
 * @copyright  (c) 2008 Ushahidi Team
 * @license	   http://www.ushahidi.com/license.html
 */
class admin_Core {

	/**
	 * Generate Main Tab Menus
	 */
	public static function main_tabs()
	{
		// Change tabs for MHI
		if (Kohana::config('config.enable_mhi') == TRUE AND Kohana::config('settings.subdomain') == '')
		{
			// Start from scratch on admin tabs since most are irrelevant

			return array(
				'mhi' => Kohana::lang('ui_admin.mhi'),
				'stats' => Kohana::lang('ui_admin.stats'),
				'manage/pages' => Kohana::lang('ui_main.pages')
			);
		}
		else
		{
			$tabs = array();
			$tabs['dashboard'] = Kohana::lang('ui_admin.dashboard');
			$tabs['reports'] = Kohana::lang('ui_admin.reports');

			if(Kohana::config('settings.checkins'))
			{
				$tabs['checkins'] = Kohana::lang('ui_admin.checkins');
			}

			$tabs['messages'] = Kohana::lang('ui_admin.messages');
			$tabs['stats'] = Kohana::lang('ui_admin.stats');
			$tabs['addons'] = Kohana::lang('ui_admin.addons');
			Event::run('ushahidi_action.nav_admin_main_top', $tabs);
			return $tabs;
		}
	}


	/**
	 * Generate Main Tab Menus (RIGHT SIDE)
	 */
	public static function main_right_tabs($user = FALSE)
	{
		$main_right_tabs = array();

		// Change tabs for MHI
		if (Kohana::config('config.enable_mhi') == TRUE AND Kohana::config('settings.subdomain') == '')
		{
			$main_right_tabs = array(
				'users' => Kohana::lang('ui_admin.users'),
				'mhi/settings' => Kohana::lang('ui_admin.settings')
			);
		}
		else
		{
			// Build the tabs array depending on the role permissions for each section
			if ($user)
			{
				// Check permissions for settings panel
				$main_right_tabs = (Auth::instance()->has_permission('settings', $user))
					? arr::merge($main_right_tabs, array('settings/site' => Kohana::lang('ui_admin.settings')))
					: $main_right_tabs;

				// Check permissions for the manage panel
				$main_right_tabs = (Auth::instance()->has_permission('manage', $user))
					? arr::merge($main_right_tabs, array('manage' => Kohana::lang('ui_admin.manage')))
					: $main_right_tabs;

				// Check permissions for users panel
				$main_right_tabs = (Auth::instance()->has_permission('users', $user))
					? arr::merge($main_right_tabs, array('users' => Kohana::lang('ui_admin.users')))
					: $main_right_tabs;
			}
		}

		return $main_right_tabs;
	}

	/**
	 * Generate MHI Sub Tab Menus
	 * @param string $this_sub_page
	 * @return string $menu
	 */
	public static function mhi_subtabs($this_sub_page = FALSE)
	{
		$menu = "";

		$menu .= ($this_sub_page == "deployments") ? "Deployments" : "<a href=\"".url::base()."admin/mhi/\">Deployments</a>";

		$menu .= ($this_sub_page == "activity") ? "Activity Stream" : "<a href=\"".url::base()."admin/mhi/activity\">Activity Stream</a>";

		$menu .= ($this_sub_page == "updatelist") ? "Update List" : "<a href=\"".url::base()."admin/mhi/updatelist\">Update List</a>";

		echo $menu;
	}

	/**
	 * Generate Report Sub Tab Menus
	 * @param string $this_sub_page
	 * @return string $menu
	 */
	public static function reports_subtabs($this_sub_page = FALSE)
	{
		$menu = "";

		$menu .= ($this_sub_page == "view") ? "<li class=\"active\"><a>".Kohana::lang('ui_main.view_reports')."</a></li>" : "<li><a href=\"".url::base()."admin/reports\">".Kohana::lang('ui_main.view_reports')."</a></li>";

		$menu .= ($this_sub_page == "edit") ? "<li class=\"active\"><a>".Kohana::lang('ui_main.create_report')."</a></li>" : "<li><a href=\"".url::base()."admin/reports/edit\">".Kohana::lang('ui_main.create_report')."</a></li>";

		$menu .= ($this_sub_page == "comments") ? "<li class=\"active\"><a>".Kohana::lang('ui_main.comments')."</a></li>" : "<li><a href=\"".url::base()."admin/comments\">".Kohana::lang('ui_main.comments')."</a></li>";

		$menu .= ($this_sub_page == "download") ? "<li class=\"active\"><a>".Kohana::lang('ui_main.download_reports')."</a></li>" : "<li><a href=\"".url::base()."admin/reports/download\">".Kohana::lang('ui_main.download_reports')."</a></li>";

		$menu .= ($this_sub_page == "upload") ? "<li class=\"active\"><a>".Kohana::lang('ui_main.upload_reports')."</a></li>" : "<li><a href=\"".url::base()."admin/reports/upload\">".Kohana::lang('ui_main.upload_reports')."</a></li>";

		echo $menu;

		// Action::nav_admin_reports - Add items to the admin reports navigation tabs
		Event::run('ushahidi_action.nav_admin_reports', $this_sub_page);
	}


	/**
	 * Generate Messages Sub Tab Menus
	 * @param int $service_id
	 * @return string $menu
	 */
	public static function messages_subtabs($service_id = FALSE)
	{
		$menu = "";
		foreach (ORM::factory('service')->find_all() as $service)
		{
			if ($service->id == $service_id)
			{
				$menu .= "<li class=\"active\"><a>".$service->service_name."</a></li>";
			}
			else
			{
				$menu .= "<li><a href=\"" . url::site() . "admin/messages/index/".$service->id."\">".$service->service_name."</a></li>";
			}
		}

		echo $menu;

		// Action::nav_admin_messages - Add items to the admin messages navigation tabs
		Event::run('ushahidi_action.nav_admin_messages', $service_id);
	}


	/**
	 * Generate Settings Sub Tab Menus
	 * @param string $this_sub_page
	 * @return string $menu
	 */
	public static function settings_subtabs($this_sub_page = FALSE)
	{
		$menu = "";

		$menu .= ($this_sub_page == "site") ? "<li class=\"active\"><a>".Kohana::lang('ui_main.site')."</a></li>" : "<li><a href=\"".url::site()."admin/settings/site\">".Kohana::lang('ui_main.site')."</a></li>";

		$menu .= ($this_sub_page == "map") ? "<li class=\"active\"><a>".Kohana::lang('ui_main.map')."</a></li>" : "<li><a href=\"".url::site()."admin/settings\">".Kohana::lang('ui_main.map')."</a>";

		$menu .= ($this_sub_page == "sms") ? "<li class=\"active\"><a>".Kohana::lang('ui_main.sms')."</a></li>" : "<li><a href=\"".url::site()."admin/settings/sms\">".Kohana::lang('ui_main.sms')."</a>";

		$menu .= ($this_sub_page == "email") ? "<li class=\"active\"><a>".Kohana::lang('ui_main.email')."</a></li>" : "<li><a href=\"".url::site()."admin/settings/email\">".Kohana::lang('ui_main.email')."</a>";

		// We cannot allow cleanurl settings to be changed if MHI is enabled since it modifies a file in the config folder
		if (Kohana::config('config.enable_mhi') == FALSE)
		{
			$menu .= ($this_sub_page == "cleanurl") ? Kohana::lang('ui_main.cleanurl'):	 "<a href=\"".url::site() ."admin/settings/cleanurl\">".Kohana::lang('ui_main.cleanurl')."</a>";

			// SSL subtab
			$menu .= ($this_sub_page == "https") ? Kohana::lang('ui_main.https'):  "<a href=\"".url::site() ."admin/settings/https\">".Kohana::lang('ui_main.https')."</a>";
		}

		$menu .= ($this_sub_page == "api") ? Kohana::lang('ui_main.api') : "<a href=\"".url::site()."admin/settings/api\">".Kohana::lang('ui_main.api')."</a>";

		$menu .= ($this_sub_page == "facebook") ? "Facebook" : "<a href=\"".url::site()."admin/settings/facebook\">Facebook</a>";

		$menu .= ($this_sub_page == "externalapps") ? Kohana::lang('ui_main.external_apps') : "<a href=\"".url::site()."admin/settings/externalapps\">".Kohana::lang('ui_main.external_apps')."</a>";

		echo $menu;

		// Action::nav_admin_settings - Add items to the admin settings navigation tabs
		Event::run('ushahidi_action.nav_admin_settings', $this_sub_page);
	}


	/**
	 * Generate SMS Sub Tab Menus
	 * @param string $this_sub_page
	 * @return string $menu
	 */
	public static function settings_sms_subtabs($this_sub_page = FALSE)
	{
		$menu = "";
		$menu .= ($this_sub_page == "sms") ? Kohana::lang('ui_main.sms') : "<a href=\"".url::base()."admin/settings/sms\">".Kohana::lang('settings.sms.option_1')."</a>";
		$menu .= ($this_sub_page == "smsglobal") ? Kohana::lang('ui_main.sms') : "<a href=\"".url::base()."admin/settings/smsglobal\">".Kohana::lang('settings.sms.option_2')."</a>";

		echo $menu;

		// Action::nav_admin_settings_sms - Add items to the settings sms  navigation tabs
		Event::run('ushahidi_action.sub_nav_admin_settings_sms', $this_sub_page);
	}




	/**
	 * Generate Manage Sub Tab Menus
	 * @param string $this_sub_page
	 * @return string $menu
	 */
	public static function manage_subtabs($this_sub_page = FALSE)
	{
		$menu = "";

		$menu .= ($this_sub_page == "categories") ? "<li class=\"active\"><a>".Kohana::lang('ui_main.categories')."</a></li>" : "<li><a href=\"".url::site()."admin/manage\">".Kohana::lang('ui_main.categories')."</a></li>";

		$menu .= ($this_sub_page == "blocks") ? "<li class=\"active\"><a>".Kohana::lang('ui_admin.blocks')."</a></li>" : "<li><a href=\"".url::site()."admin/manage/blocks\">".Kohana::lang('ui_admin.blocks')."</a></li>";

		$menu .= ($this_sub_page == "forms") ? "<li class=\"active\"><a>".Kohana::lang('ui_main.forms')."</a></li>" : "<li><a href=\"".url::site()."admin/manage/forms\">".Kohana::lang('ui_main.forms')."</a></li>";

		$menu .= ($this_sub_page == "pages") ? "<li class=\"active\"><a>".Kohana::lang('ui_main.pages')."</a></li>" : "<li><a href=\"".url::site()."admin/manage/pages\">".Kohana::lang('ui_main.pages')."</a></li>";

		$menu .= ($this_sub_page == "feeds") ? "<li class=\"active\"><a>".Kohana::lang('ui_main.news_feeds')."</a></li>" : "<li><a href=\"".url::site()."admin/manage/feeds\">".Kohana::lang('ui_main.news_feeds')."</a></li>";

		$menu .= ($this_sub_page == "layers") ? "<li class=\"active\"><a>".Kohana::lang('ui_main.layers')."</a></li>" : "<li><a href=\"".url::site()."admin/manage/layers\">".Kohana::lang('ui_main.layers')."</a></li>";

		$menu .= ($this_sub_page == "scheduler") ? "<li class=\"active\"><a>".Kohana::lang('ui_main.scheduler')."</a></li>" : "<li><a href=\"".url::site()."admin/manage/scheduler\">".Kohana::lang('ui_main.scheduler')."</a></li>";

		$menu .= ($this_sub_page == "publiclisting") ? "<li class=\"active\"><a>".Kohana::lang('ui_admin.public_listing')."</a></li>" : "<li><a href=\"".url::site()."admin/manage/publiclisting\">".Kohana::lang('ui_admin.public_listing')."</a></li>";

		$menu .= ($this_sub_page == "actions") ? "<li class=\"active\"><a>".Kohana::lang('ui_admin.actions')."</a></li>" : "<li><a href=\"".url::site()."admin/manage/actions\">".Kohana::lang('ui_admin.actions')."</a></li>";

		$menu .= ($this_sub_page == "badges") ? "<li class=\"active\"><a>".Kohana::lang('ui_main.badges')."</a></li>" : "<li><a href=\"".url::site()."admin/manage/badges\">".Kohana::lang('ui_main.badges')."</a></li>";

		$menu .= ($this_sub_page == "alerts") ? "<li class=\"active\"><a>".Kohana::lang('ui_admin.alerts')."</a></li>" : "<li><a href=\"".url::site()."admin/manage/alerts\">".Kohana::lang('ui_admin.alerts')."</a></li>";

		echo $menu;

		// Action::nav_admin_manage - Add items to the admin manage navigation tabs
		Event::run('ushahidi_action.nav_admin_manage', $this_sub_page);
	}


	/**
	 * Generate User Sub Tab Menus
	 * @param string $this_sub_page
	 * @param boolean $display_roles
	 * @return string $menu
	 */
	public static function user_subtabs($this_sub_page = FALSE, $display_roles = FALSE)
	{
		$menu = "";

		$menu .= ($this_sub_page == "users") ? "<li class=\"active\"><a>".Kohana::lang('ui_admin.manage_users')."</a></li>" : "<li><a href=\"".url::site()."admin/users/\">".Kohana::lang('ui_admin.manage_users')."</a></li>";

		$menu .= ($this_sub_page == "users_edit") ? "<li class=\"active\"><a>".Kohana::lang('ui_admin.manage_users_edit')."</a></li>" : "<li><a href=\"".url::site()."admin/users/edit/\">".Kohana::lang('ui_admin.manage_users_edit')."</a></li>";

		// Only display the link for roles where $display_roles = TRUE
		if ($display_roles)
		{
			$menu .= ($this_sub_page == "roles") ? "<li class=\"active\"><a>".Kohana::lang('ui_admin.manage_roles')."</a></li>" : "<li><a
			href=\"".url::site()."admin/users/roles/\">".Kohana::lang('ui_admin.manage_roles')."</a></li>";
		}

		echo $menu;

		// Action::nav_admin_users - Add items to the admin manage navigation tabs
		Event::run('ushahidi_action.nav_admin_users', $this_sub_page);
	}
	
	/**
	 * Legacy permissions check
	 * @deprecated Use Auth::has_permission() instead.
	 */
	public function permissions($user = FALSE, $permission = FALSE)
	{
		Kohana::log('alert', 'admin::permissions() in deprecated and replaced by Auth::has_permission()');
		return Auth::instance()->has_permission($permission, $user);
	}
	
	/**
	 * Legacy admin access check
	 * @deprecated Use Auth::admin_access() instead.
	 */
	public function admin_access($user = FALSE)
	{
		Kohana::log('alert', 'admin::admin_access() in deprecated and replaced by Auth::admin_access()');
		return Auth::instance()->admin_access($user);
	}

	public static function tools_nav($this_page)
	{


		$main_tabs = self::main_tabs();

		// Get logged in user
		$user= Auth::instance()->get_user();
		$main_right_tabs = self:: main_right_tabs($user);
		
		foreach ($main_tabs as $page => $tab_name):  
		?>
		<li><a href="<?php echo url::site(); ?>admin/<?php echo $page; ?>" <?php if($this_page == $page) echo 'class="active"' ;?>><?php echo $tab_name; ?></a></li>
		<?php endforeach; ?>
		<?php foreach ($main_right_tabs as $page => $tab_name): ?>
		<li><a href="<?php echo url::site(); ?>admin/<?php echo $page; ?>" <?php if($this_page == $page) echo 'class="active"' ;?>><?php echo $tab_name; ?></a></li>
		<?php endforeach;
	}
}
