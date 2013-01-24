<?php 
/**
 * Feedback view page.
 *
 * PHP version 5
 * LICENSE: This source file is subject to LGPL license 
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/copyleft/lesser.html
 * @author     Ushahidi Team <team@ushahidi.com> 
 * @package	   Ushahidi - http://source.ushahididev.com
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
				<?php admin::stats_subtabs('country'); ?>
			</ul>
		</nav>
	</div>
	
	<div class="page-content">		
		<div id="time-period-selector">
			<?php echo form::open('admin/stats/country/', array('method' => 'get', 'style' => "display: inline;")); ?>
			<h3><?php echo Kohana::lang('stats.choose_date_range');?></h3>
			<div class="range-select">
				<a href="<?php print url::site() ?>admin/stats/country/?range=30"><?php echo Kohana::lang('stats.time_range_1');?></a> 
				<a href="<?php print url::site() ?>admin/stats/country/?range=90"><?php echo Kohana::lang('stats.time_range_2');?></a> 
				<a href="<?php print url::site() ?>admin/stats/country/?range=180"><?php echo Kohana::lang('stats.time_range_3');?></a>  
				<a href="<?php print url::site() ?>admin/stats/country/"><?php echo Kohana::lang('stats.time_range_all');?></a>
			</div>
			<div class="range-input">	
				<input type="text" class="dp" name="dp1" id="dp1" value="<?php echo $dp1; ?>" />
				<span class="transition">to</span> 
				<input type="text" class="dp" name="dp2" id="dp2" value="<?php echo $dp2; ?>" /> 
				<input type="hidden" name="range" value="<?php echo $range; ?>" />
				<input type="submit" value="Go &rarr;" class="button" />
			</div>
			<?php echo form::close(); ?>
		</div>

		<div class="chart-holder">
		<img src="<?php echo $visitor_map; ?>" />
		<?php if($failure != ''){ ?>
			<div class="red-box">
				<h3><?php echo Kohana::lang('stats.error');?></h3>
				<ul><li><?php echo $failure; ?></li></ul>
			</div>
		<?php } ?>
		</div>

		<div class="stats-wrapper cf">
			<div class="statistic first">
				<h4><?php echo Kohana::lang('stats.countries');?></h4>
				<p><?php echo $num_countries; ?></p>
			</div>
			<div class="statistic">
				<h4><?php echo Kohana::lang('stats.unique_visitors');?></h4>
				<p><?php echo $uniques; ?></p>
			</div>
			<div class="statistic">
				<h4><?php echo Kohana::lang('stats.visits');?></h4>
				<p><?php echo $visits; ?></p>
			</div>
			<div class="statistic">
				<h4><?php echo Kohana::lang('stats.pageviews');?></h4>
				<p><?php echo $pageviews; ?></p>
			</div>
		</div>

		<div class="tabs">
			<!-- tabset -->
			<ul class="tabset">
				<li><a class="active"><?php echo Kohana::lang('stats.unique_visitors');?></a></li>
			</ul>
			<div class="tab-boxes">

				<div class="tab-box active-tab" id="unique-visitors">
					<table class="table-graph generic-data">
						<tr>
							<th class="gdItem"><?php echo Kohana::lang('stats.country');?></th>
							<th class="gdDesc"><?php echo Kohana::lang('stats.unique_visitors');?></th>
						</tr>
						<?php
						foreach($countries as $name => $data){
							?>
							<tr>
							<td class="gdItem"><img class="flag" src="<?php echo $data['icon']; ?>"/> <?php echo $name; ?></td>
							<td class="gdDesc"><?php echo $data['count']; ?></td>
							</tr>
							<?php
						}
						?>
					</table>
				</div>

			</div>
		</div>
	</div>
</div>
