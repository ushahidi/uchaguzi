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
				<li>Visitor summary</li>
				<li><a href="<?php print url::site() ?>admin/stats/hits"><?php echo Kohana::lang('stats.hit_summary');?></a></li>
				<li><a href="<?php print url::site() ?>admin/stats/country"><?php echo Kohana::lang('stats.country_breakdown');?></a></li>
				<li><a href="<?php print url::site() ?>admin/stats/reports"><?php echo Kohana::lang('stats.report_stats');?></a></li>
				<li><a href="<?php print url::site() ?>admin/stats/impact"><?php echo Kohana::lang('stats.category_impact');?></a></li>
			</ul>
		</nav>
	</div>
	
	<div class="page-content">
		<?php
			if($stat_id == 0){ // No stat account created
		?>
				<h1 style="text-align:center"><?php echo Kohana::lang('stats.stats_not_setup');?></h1>
		<?php
			}else{
		?>
		<?php echo Kohana::lang('stats.description');?>.
		<?php
			}
		?>
	</div>
</div>
