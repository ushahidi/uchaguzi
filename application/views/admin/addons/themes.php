<?php 
/**
 * Themes view page.
 *
 * PHP version 5
 * LICENSE: This source file is subject to LGPL license 
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/copyleft/lesser.html
 * @author     Ushahidi Team <team@ushahidi.com> 
 * @package    Ushahidi - http://source.ushahididev.com
 * @module     Themes View
 * @copyright  Ushahidi - http://www.ushahidi.com
 * @license    http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL) 
 */
?>

<div id="tools-content">
   	<div class="pageheader">
		<h1 class="pagetitle"><?php echo Kohana::lang('uchaguzi.tools'); ?></h1>

		<nav id="tools-menu">
			<ul class="second-level-menu">
				<li><a href="<?php echo url::base() . 'admin/addons' . '">' . Kohana::lang('ui_main.plugins') . '</a>' ?></li>
				<li class="active"><a><?php echo Kohana::lang('ui_main.themes'); ?></a></li>
			</ul>
		</nav>
	</div>
	
	<div class="page-content">
		<?php print form::open(); ?>
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
			
			<div class="sms_holder">
				<!-- Default Theme -->
				<article class="theme_holder">
					<div class="theme_screenshot"><?php
						echo "<img src=\"".url::file_loc('img')."media/img/default_theme.png\" />";
					?></div>
					<h1><?php echo Kohana::lang('ui_main.theme_default');?></h1>
					<p><?php echo Kohana::lang('ui_main.theme_default');?></p>
					<ul>
						<li><strong><?php echo Kohana::lang('ui_main.version');?></strong>: 1.0</li>
						<li><strong><?php echo Kohana::lang('ui_main.demo');?></strong>: http://www.ushahidi.com</li>
						<li><strong><?php echo Kohana::lang('ui_main.contact');?></strong>: team@ushahidi.com</li>
						<li><strong><?php echo Kohana::lang('ui_main.location');?></strong>: </li>
					</ul>
					<div class="theme_select">
						<input type="radio" name="site_style" value="" <?php
						if ($form['site_style'] == "")
						{
							echo "checked = \"checked\"";
						}
						?> /><?php echo Kohana::lang('ui_main.select_theme');?>
					</div>												
				</article>
				<!-- / Default Theme -->				
				<?php
				$i = 2; // Start at 2 because the default theme isn't in this array
				foreach ($themes as $theme)
				{
					?>
					<article class="theme_holder">
						<div class="theme_screenshot"><?php
							if (!empty($theme['Screenshot']))
							{
								echo "<img src=\"".url::base()."themes/".$theme['Template_Dir']."/".
								$theme['Screenshot']."\" width=240 height=150 border=0>";
							}
						?></div>
						<h1><?php echo $theme['Title']." $i by ".$theme['Author']; ?></h1>
						<p><?php echo $theme['Description'] ?></p>
						<ul>
							<li><strong><?php echo Kohana::lang('ui_main.version');?></strong>: <?php echo $theme['Version'] ?></li>
							<li><strong><?php echo Kohana::lang('ui_main.demo');?></strong>: <?php echo $theme['Demo'] ?></li>
							<li><strong><?php echo Kohana::lang('ui_main.contact');?></strong>: <?php echo $theme['Author_Email'] ?></li>
							<li><strong><?php echo Kohana::lang('ui_main.location');?></strong>: <em>/themes/<?php echo $theme['Template_Dir'] ?>/</em></li>
						</ul>
						<div class="theme_select">
							<input type="radio" name="site_style" value="<?php echo $theme['Template_Dir'] ?>" <?php
							if ($theme['Template_Dir'] == $form['site_style'])
							{
								echo "checked = \"checked\"";
							}
							?> />
							<?php echo Kohana::lang('ui_main.select_theme');?>
						</div>
					</article>
					<?php
					// Make sure the themes don't get bunched up
					if($i % 3 == 0) {
						?><div style="clear:both;"></div><?php
					}
					$i++;
				}						
				?>
			</div>

			<div class="table-tabs">
				<input type="submit" class="save-rep-btn" value="<?php echo Kohana::lang('ui_admin.save_settings');?>" />
			</div>

		<?php print form::close(); ?>
	</div>
</div>
