<?php 
/**
 * SSL view page.
 *
 * PHP version 5
 * LICENSE: This source file is subject to LGPL license 
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/copyleft/lesser.html
 * @author     Ushahidi Team <team@ushahidi.com> 
 * @package    Ushahidi - http://source.ushahididev.com
 * @module     Settings Controller
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
				<?php admin::settings_subtabs("https"); ?>
			</ul>
		</nav>
	</div>
	
	<div class="page-content cf">	
		<?php print form::open(NULL, array('id' => 'httpsForm', 'name' => 'httpsForm','action'=> url::site().'admin/settings/https')); ?>
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
					<h4><?php echo Kohana::lang('settings.https.enable_https');?>?</h4>
						<?php if ( ! $is_https_capable): ?>
						<?php print form::dropdown(array('name'=>'enable_https','disabled' =>'true'), $yesno_array, '0'); ?>
						<p>
						<?php echo Kohana::lang('settings.https.https_disabled');?>
						</p>
						<?php else: ?>
						<?php print form::dropdown('enable_https', $yesno_array, $form['enable_https']); ?>
						<p>
						<?php echo Kohana::lang('settings.https.https_enabled');?>
						</p>
						<?php endif; ?>
				</div>
			</div>

			<div class="table-tabs">
				<input type="submit" class="save-rep-btn" value="<?php echo Kohana::lang('ui_admin.save_settings');?>" />
			</div>
		</div>
		<?php print form::close(); ?>
	</div>
</div>
