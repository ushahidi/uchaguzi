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
		<ul class="hornav">
			<?php echo admin::tools_nav($this_page);?>
		</ul>
		<nav id="tools-menu">
			<ul class="second-level-menu">
				<?php admin::stats_subtabs('hits'); ?>
			</ul>
		</nav>
	</div>
	
	<div class="page-content">		
		<div id="time-period-selector">
			<?php echo form::open('admin/stats/hits/', array('method' => 'get', 'style' => "display: inline;")); ?>
				<h3><strong><?php echo Kohana::lang('stats.choose_date_range');?></strong></h3>
				<div class="range-select">
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

		<div class="chart-holder">
			<?php echo $traffic_chart; ?>
			<?php if($failure != ''){ ?>
				<div class="red-box">
					<h3><?php echo Kohana::lang('stats.error');?></h3>
					<ul><li><?php echo $failure; ?></li></ul>
				</div>
			<?php } ?>
		</div>

		<div class="stats-wrapper cf">
			<div class="statistic first">
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
				<li><a <?php if($active_tab == 'uniques') echo 'class="active"'; ?> href="<?php print url::site() ?>admin/stats/hits/?range=<?php echo $range; ?>&dp1=<?php echo $dp1; ?>&dp2=<?php echo $dp2; ?>&active_tab=uniques"><?php echo Kohana::lang('stats.unique_visitors');?></a></li>
				<li><a <?php if($active_tab == 'visits') echo 'class="active"'; ?> href="<?php print url::site() ?>admin/stats/hits/?range=<?php echo $range; ?>&dp1=<?php echo $dp1; ?>&dp2=<?php echo $dp2; ?>&active_tab=visits"><?php echo Kohana::lang('stats.visits');?></a></li>
				<li><a <?php if($active_tab == 'pageviews') echo 'class="active"'; ?> href="<?php print url::site() ?>admin/stats/hits/?range=<?php echo $range; ?>&dp1=<?php echo $dp1; ?>&dp2=<?php echo $dp2; ?>&active_tab=pageviews"><?php echo Kohana::lang('stats.pageviews');?></a></li>
			</ul>

			<div class="tab-boxes">
			<?php
			$labels = array();
			foreach($raw_data as $label => $data_array) {
				$activetabcss = '';
				if($label == $active_tab) $activetabcss = 'active-tab';
				?>
				<div class="tab-box <?php echo $activetabcss; ?>" id="<?php echo $label; ?>">
				<table class="table-graph horizontal-bar">
				<?php
				$data_array = array_reverse($data_array,true);
				foreach($data_array as $timestamp => $count) {
					$date = date('M jS, Y',($timestamp/1000));
					$percentage = 0;
					if($$label != 0) $percentage = round((($count / $$label) * 100),1);
					?>
					<tr>
						<td class="hbItem"><?php echo $date; ?></td>
						<td class="hbDesc"><span style="width:<?php echo $percentage; ?>%" class="stat-bar">&nbsp;</span><span class="stat-percentage"><?php echo $percentage; ?>% (<?php echo $count; ?>)</span></td>
					</tr>
					<?php
				}
				?>
				</table>
				</div>
				<?php
			}
			?>
			</div>

		</div>

		<div class="glossary">
			<h4><?php echo Kohana::lang('stats.glossary');?></h4>
			<div class="terms">
				<p><strong><?php echo Kohana::lang('stats.unique_visitors');?>:</strong> <?php echo Kohana::lang('stats.unique_visitors_description');?>.</p>
				<p><strong><?php echo Kohana::lang('stats.visits');?>:</strong> <?php echo Kohana::lang('stats.visits_description');?>.</p>
				<p><strong><?php echo Kohana::lang('stats.pageviews');?>:</strong> <?php echo Kohana::lang('stats.pageviews_description');?>.</p>
			</div>
		</div>
	</div>
</div>
