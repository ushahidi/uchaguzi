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
                <?php admin::stats_subtabs('impact'); ?>
            </ul>
        </nav>
    </div>

    <div class="page-content">
        <div id="time-period-selector">
                <?php echo form::open('admin/stats/impact/', array('method' => 'get', 'style' => "display: inline;")); ?>
                    <h3><?php echo Kohana::lang('stats.choose_date_range');?></h3>
                    <div class="range-select">
                        <a href="<?php print url::site() ?>admin/stats/impact/?range=30"><?php echo Kohana::lang('stats.time_range_1');?></a> 
                        <a href="<?php print url::site() ?>admin/stats/impact/?range=90"><?php echo Kohana::lang('stats.time_range_2');?></a> 
                        <a href="<?php print url::site() ?>admin/stats/impact/?range=180"><?php echo Kohana::lang('stats.time_range_3');?></a> 
                        <a href="<?php print url::site() ?>admin/stats/impact/"><?php echo Kohana::lang('stats.time_range_all');?></a>
                    </div>
                    <div class="range-input">
                        <input type="text" class="dp" name="dp1" id="dp1" value="<?php echo $dp1; ?>" /><span class="transition">to</span> 
                        <input type="text" class="dp" name="dp2" id="dp2" value="<?php echo $dp2; ?>" />
                        <input type="hidden" name="range" value="<?php echo $range; ?>" />
                        <input type="submit" value="Go &rarr;" class="button" />
                    </div>
                <?php echo form::close(); ?>
        </div>
        
        <!-- Left Column -->
        <div class="two-col tc-left reports-charts">
        <p><?php echo Kohana::lang('stats.category_impact_description');?>.</p>
            <div id="impact_info2" class="impact_hidden">
                <div id="impact_legend2">&nbsp;</div>
                <div id="impact_message2"><?php echo Kohana::lang('stats.legend');?></div>
            </div>
            <div id="impact_placeholder"></div>
            <div id="impact_chart"></div>
            
        </div>
        
        <!-- Right Column -->
        <div class="two-col tc-right stats-sidebar">
            <div class="stats-wrapper clearfix">
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
