<?php blocks::open("reports");?>
<?php //blocks::title(Kohana::lang('ui_main.reports_listed'));?>
	<ul class="recent_list">
	<?php
	if ($total_items == 0)
	{
		?>
		<li><?php echo Kohana::lang('ui_main.no_reports'); ?></li>
		<?php
	}
	foreach ($incidents as $incident)
	{
		$incident_id = $incident->id;
		$incident_title = text::limit_chars(strip_tags($incident->incident_title), 40, '...', True);
		$incident_date = $incident->incident_date;
		$incident_date = date('M j Y', strtotime($incident->incident_date));
		$incident_location = $incident->location->location_name;
	?>
	
		<li><a href="<?php echo url::site() . 'reports/view/' . $incident_id; ?>"> <?php echo html::specialchars($incident_title) ?></a></li>
	<?php
	}
	?>
	</ul>
<div class="msgmore">
	<a href="<?php echo url::site() . 'reports/' ?>"><?php echo Kohana::lang('ui_main.view_more'); ?></a>
</div>
<div style="clear:both;"></div>
<?php blocks::close();?>
