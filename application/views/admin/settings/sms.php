<?php 
/**
 * Sms view page.
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

		<nav id="tools-menu">
			<ul class="second-level-menu">
				<?php admin::settings_subtabs("sms"); ?>
			</ul>
		</nav>
	</div>
	
	<div class="page-content cf">

		<?php print form::open(); ?>
		<div class="report-form">
			<?php
			if ($form_error) {
			?>
				<!-- red-box -->
				<div class="red-box">
					<h3><?php echo Kohana::lang('ui_main.error');?></h3>
					<ul>
					<?php
					foreach ($errors as $error_item => $error_description)
					{
						// print "<li>" . $error_description . "</li>";
						print (!$error_description) ? '' : "<li>" . $error_description . "</li>";
					}
					?>
					</ul>
				</div>
			<?php
			}

			if ($form_saved) {
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

			<div class="table-tabs">
				<div class="row">
					<h4><a href="#" class="tooltip" title="Text Messages Sent From the System Will Use the Selected Provider. ***Provider text messaging rates may apply!">Default Sending Provider</a> <span>Provider text messaging rates may apply</span></h4>
					<span class="sel-holder">
						<?php print form::dropdown('sms_provider', $sms_provider_array, $form['sms_provider']); ?>
					</span>
				</div>

				<div class="row">
					<h4>Enter all the phone numbers that users can use to send text messages into your system below.</h4>
				</div>
				
				<div class="row">
					<h4><?php echo Kohana::lang('ui_main.phone');?> 1: <span><?php echo Kohana::lang('settings.sms.flsms_text_2');?></span></h4>
					<?php print form::input('sms_no1', $form['sms_no1'], ' class="text title_2"'); ?>
				</div>
				
				<div class="row">
					<h4><?php echo Kohana::lang('ui_main.phone');?> 2: <span><?php echo Kohana::lang('settings.sms.flsms_text_2');?></span></h4>
					<?php print form::input('sms_no2', $form['sms_no2'], ' class="text title_2"'); ?>
				</div>
				
				<div class="row">
					<h4><?php echo Kohana::lang('ui_main.phone');?> 3: <span><?php echo Kohana::lang('settings.sms.flsms_text_2');?></span></h4>
					<?php print form::input('sms_no3', $form['sms_no3'], ' class="text title_2"'); ?>
				</div>
			</div>

			<div class="table-tabs">
				<input type="submit" class="save-rep-btn" value="<?php echo Kohana::lang('ui_admin.save_settings');?>" />
			</div>
		</div>
		<?php print form::close(); ?>
	</div>
</div>