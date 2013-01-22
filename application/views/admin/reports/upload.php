<?php 
/**
 * Reports upload view page.
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
				<?php admin::reports_subtabs("upload"); ?>
			</ul>
		</nav>
	</div><!--pageheader-->
	
	<div class="page-content">

		<!-- report-form -->
		<div class="report-form col_12">
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
			?>
			<!-- column -->
			<div class="upload_container">
				<p><?php echo Kohana::lang('ui_main.upload_reports_detail_1');?>.</p>

				<h3><?php echo Kohana::lang('ui_main.please_note');?></h3>
				<ul>
					<li><?php echo Kohana::lang('ui_main.upload_reports_detail_2');?>.</li>
					<li><?php echo Kohana::lang('ui_main.upload_reports_detail_3');?>.</li>
					<li><?php echo Kohana::lang('ui_main.upload_reports_detail_4');?></li>
					<li><?php echo Kohana::lang('ui_main.upload_reports_detail_4b');?></li>
				</ul>
				
				<h3><?php echo Kohana::lang('ui_main.upload_reports_detail_5');?></h3>
				<span class="sample">
					<?php echo Kohana::lang('ui_main.upload_reports_detail_6');?><br />
					<?php echo Kohana::lang('ui_main.upload_reports_detail_7');?><br />
				
				</span>
				
				<?php print form::open(NULL, array('id' => 'uploadForm', 'name' => 'uploadForm', 'enctype' => 'multipart/form-data')); ?>
				<h3><?php echo Kohana::lang('ui_main.upload_file');?> <?php echo form::upload(array('name' => 'csvfile'), 'path/to/local/file'); ?></h3>
				<input type="submit" value="Upload" class="btn_submit" />
				<?php print form::close(); ?>
			</div>
		</div>
	</div>
</div>