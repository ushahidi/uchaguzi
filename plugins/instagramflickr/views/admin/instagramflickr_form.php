<?php 
/**
 * Clean URLs view page.
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
				<?php admin::settings_subtabs("instagramflickr"); ?>
			</ul>
		</nav>
	</div><!--pageheader-->

	<div class="page-content cf">  
		<?php print form::open(NULL, array('id' => 'instagramflickrForm', 
		'name' => 'instagramflickrForm','action'=> url::site().'admin/instagramflickr')); ?>
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
				<input type="submit" value="<?php echo Kohana::lang('ui_admin.save_settings'); ?>" class="save-rep-btn" />
			</div>
			<div class="col_8">
				<!-- flickwijit starts -->
				<div class="row">
					
					<div class="row">
						<h4><a href="#" class="tooltip" title="" ><?php echo Kohana::lang('instagramflickr.form_flickr_tags');?></a></h4>
						<?php print form::input('flickr_tag', $form['flickr_tag'], ' class="text"'); ?>
					</div>
					<span><?php echo Kohana::lang('instagramflickr.form_flickr_tags');?> </span>
					<div class="row" style="padding-top: 5px;">
						<h4><a href="#" class="tooltip" title=""><?php echo Kohana::lang('instagramflickr.form_flickr_id');?></a></h4>
						<?php print form::input('flickr_id', $form['flickr_id'], ' class="text"'); ?>
					</div>
					<span><?php echo Kohana::lang('instagramflickr.form_flickr_id');?></span>
					<div class="row" style="padding-top: 5px;">
						<h4><a href="#" class="tooltip" title=""><?php echo Kohana::lang('instagramflickr.form_num_of_photos');?></a></h4>
						<?php print form::input('num_of_photos', $form['num_of_photos'], ' class="text"'); ?>
					</div>
					<span><?php echo Kohana::lang('instagramflickr.form_num_of_photos_blub');?></span>
					<div class="row" style="padding-top: 5px;">
						<h4><a href="#" class="tooltip" title""><?php echo Kohana::lang('instagramflickr.form_image_width');?></a></h4>
						<?php print form::input('image_width', $form['image_width'], ' class="text"'); ?>
					</div>
					<span><?php echo Kohana::lang('instagramflickr.form_image_width_blub');?></span>
					<div class="row" style="padding-top: 5px;">
						<h4><a href="#" class="tooltip" title=""><?php echo Kohana::lang('instagramflickr.form_image_height');?></a></h4>
						<?php print form::input('image_height', $form['image_height'], ' class="text"'); ?>
					</div>
					<span><?php echo Kohana::lang('instagramflickr.form_image_height_blub');?></span>
					<div class="row" style="padding-top: 5px;">
						<h4><a href="#" class="tooltip" title=""><?php echo Kohana::lang('instagramflickr.flickrwijit_enable_main_menu');?></a></h4>
						<?php print form::dropdown('block_position',array('0'=>'No','1'=>'Yes'),$form['block_position']); ?>
					</div>
					<span><?php echo Kohana::lang('instagramflickr.flickrwijit_top_menu_blub');?></span>
					<div class="row" style="padding-top: 5px;">
						<h4><a href="#" class="tooltip" title=""><?php echo Kohana::lang('instagramflickr.flickrwijit_enable_cache');?></a></h4>
						<?php print form::dropdown('enable_cache',array('0'=>'No','1'=>'Yes'),$form['enable_cache']); ?>
					</div>
					<span><?php echo Kohana::lang('instagramflickr.flickrwijit_enable_cache_blub');?></span>
					
					<div class="row" style="padding-top: 5px;">
						<h4><a href="#" class="tooltip" title=""><?php echo Kohana::lang('instagramflickr.flickrwijit_block_no_of_photos');?></a></h4>
						<?php print form::dropdown('block_no_photos',array('4'=>'4','6'=>'6','8'=>'8','10'=>'10'),$form['block_no_photos']); ?>
					</div>
					<span><?php echo Kohana::lang('instagramflickr.flickrwijit_block_no_of_photos_blub');?></span>	
				</div>
				<!-- flickwijit ends -->
				<div class="table-tabs">
					<input type="submit" value="<?php echo Kohana::lang('ui_admin.save_settings'); ?>" class="save-rep-btn" />
				</div>
			</div>	
			
			
			<?php print form::close(); ?>
		</div>
	</div>
</div> 
