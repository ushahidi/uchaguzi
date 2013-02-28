<?php
/**
 * Plugin Settings page
 *
 * PHP version 5
 * LICENSE: This source file is subject to LGPL license
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/copyleft/lesser.html
 * @author     Ushahidi Team <team@ushahidi.com>
 * @package    Ushahidi - http://source.ushahididev.com
 * @module     API Controller
 * @copyright  Ushahidi - http://www.ushahidi.com
 * @license    http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL)
 */
?>

<div id="tools-content">
   	<div class="pageheader">
		<h1 class="pagetitle"><?php echo Kohana::lang('uchaguzi.tools'); ?></h1>
		<ul class="hornav">
			<?php echo admin::tools_nav($this_page);?>
		</ul>
		<nav id="tools-menu">
			<ul class="second-level-menu">
				<li class="active"><a href="<?php echo url::base() . 'admin/addons/plugins'; ?>"><?php echo Kohana::lang('ui_main.plugins'); ?></a></li>
				<li><a href="<?php echo url::base() . 'admin/addons/themes'; ?>"><?php echo Kohana::lang('ui_main.themes'); ?></a></li>
			</ul>
		</nav>
	</div>	
	
	<div class="page-content">
		<?php print form::open(NULL, array('name'=>'plugin_settings')); ?>
		<div class="report-form">
			<?php
			if (isset($form_error) AND $form_error)
			{
			?>
				<!-- red-box -->
				<div class="red-box">
					<h3><?php echo Kohana::lang('ui_main.error');?></h3>
					<ul>
					<?php
					foreach ($errors as $error_item => $error_description)
					{
						print (!$error_description) ? '' : "<li>" . $error_description . "</li>";
					}
					?>
					</ul>
				</div>
			<?php
			}

			if (isset($form_saved) AND $form_saved)
			{
			?>
				<!-- green-box -->
				<div class="green-box">
					<h3><?php echo Kohana::lang('ui_main.configuration_saved');?></h3>
				</div>
			<?php
			}
			?>
			<div class="table-tabs">
				<input type="submit" class="save-rep-btn" value="<?php echo Kohana::lang('ui_admin.save_settings');?>" />
			</div>
			
			<?php echo $settings_form; ?>

			<div class="table-tabs">
				<input type="submit" class="save-rep-btn" value="<?php echo Kohana::lang('ui_admin.save_settings');?>" />
			</div>
		</div>
		<?php print form::close(); ?>
	</div>
</div>