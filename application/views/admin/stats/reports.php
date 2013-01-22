<?php 
/**
 * Feedback view page.
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
				<li>Visitor summary</li>
				<li><a href="<?php print url::site() ?>admin/stats/hits"><?php echo Kohana::lang('stats.hit_summary');?></a></li>				
				<li><a href="<?php print url::site() ?>admin/stats/country"><?php echo Kohana::lang('stats.country_breakdown');?></a></li>
				<li><a href="<?php print url::site() ?>admin/stats/reports"><?php echo Kohana::lang('stats.report_stats');?></a></li>
				<li><a href="<?php print url::site() ?>admin/stats/impact"><?php echo Kohana::lang('stats.category_impact');?></a></li>
			</ul>
		</nav>
	</div>
	
	<div class="page-content">		
		<div id="time-period-selector">
			<?php echo form::open('admin/stats/hits/', array('method' => 'get', 'style' => "display: inline;")); ?>
				<div class="range-select">
					<strong><?php echo Kohana::lang('stats.choose_date_range');?></strong>
					<a href="<?php print url::site() ?>admin/stats/hits/?range=30"><?php echo Kohana::lang('stats.time_range_1');?></a> 
					<a href="<?php print url::site() ?>admin/stats/hits/?range=90"><?php echo Kohana::lang('stats.time_range_2');?></a> 
					<a href="<?php print url::site() ?>admin/stats/hits/?range=180"><?php echo Kohana::lang('stats.time_range_3');?></a> 
					<a href="<?php print url::site() ?>admin/stats/hits/"><?php echo Kohana::lang('stats.time_range_all');?></a>
				</div>
				
				<div class="range-input">
					<input type="text" class="dp" name="dp1" id="dp1" value="<?php echo $dp1; ?>" /><span class="transition">to</span>
					<input type="text" class="dp" name="dp2" id="dp2" value="<?php echo $dp2; ?>" /> 
					<input type="hidden" name="range" value="<?php echo $range; ?>" />
					<input type="hidden" name="active_tab" value="<?php echo $active_tab; ?>" /> 
					<input type="submit" value="Go &rarr;" class="button" />
				</div>
			<?php echo form::close(); ?>
		</div>
		
        <div class="reports-charts">
            <h4><?php echo Kohana::lang('stats.reports_categories');?></h4>
            
            <?php echo $reports_chart; ?>

			<table>
				<?php
				foreach($reports_per_cat as $category_id => $count){
					?>
					<tr>
						<td><div id="little-color-box" style="background-color:#<?php echo $category_data[$category_id]['category_color']; ?>">&nbsp;</div></td>
						<td><?php echo $category_data[$category_id]['category_title']; ?></td>
						<td style="padding-left:25px;"><?php echo $count; ?></td>
					</tr>
					<?php
				}
				?>
			</table>

            <h4><?php echo Kohana::lang('stats.reports_status');?></h4>

			<?php echo $report_status_chart_ver; ?>

			<table>
				<tr>
					<td><div id="little-color-box" style="background-color:#0E7800">&nbsp;</div></td>
					<td><?php echo Kohana::lang('stats.verified');?></td>
					<td style="padding-left:25px;"><?php echo $verified; ?></td>
				</tr>
				<tr>
					<td><div id="little-color-box" style="background-color:#FFCF00">&nbsp;</div></td>
					<td><?php echo Kohana::lang('stats.unverified');?></td>
					<td style="padding-left:25px;"><?php echo $unverified; ?></td>
				</tr>
			</table>

			<?php echo $report_status_chart_app; ?>

			<table>
				<tr>
					<td><div id="little-color-box" style="background-color:#0E7800">&nbsp;</div></td>
					<td><?php echo Kohana::lang('stats.approved');?></td>
					<td style="padding-left:25px;"><?php echo $approved; ?></td>
				</tr>
				<tr>
					<td><div id="little-color-box" style="background-color:#FFCF00">&nbsp;</div></td>
					<td><?php echo Kohana::lang('stats.unapproved');?></td>
					<td style="padding-left:25px;"><?php echo $unapproved; ?></td>
				</tr>
			</table>

			<div class="stats-sidebar">
				<div class="stats-wrapper cf">
					<div class="statistic first">
						<h4><?php echo Kohana::lang('stats.reports');?></h4>
						<p><?php echo $num_reports; ?></p>
					</div>
					<div class="statistic">
						<h4><?php echo Kohana::lang('stats.categories');?></h4>
						<p><?php echo $num_categories; ?></p>
					</div>
			
				</div>			
			</div>
		</div>
	</div>
</div>

