<?php blocks::open("highlights");?>

<?php blocks::title(Kohana::lang('uchaguzi.highlights'));?>
<?php
if ($incidents->count() == 0)
{
	?>
	<?php echo Kohana::lang('ui_main.no_reports'); ?>
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
<article class="highlight cf">
	<img src="<?php echo url::file_loc('img'); ?>media/img/report-thumb-default.jpg" class="highlight-thumb" />
	<div class="highlight-summary">
		<h1><a href="<?php echo url::site() . 'reports/view/' . $incident_id; ?>"> <?php echo html::specialchars($incident_title) ?></a></h1>
		<p class="metadata">By John Doe, <span class="date"><?php echo $incident_date; ?></span></p>
	</div>
</article>
<?php
}
?>

<a class="more" href="<?php echo url::site() . 'reports/' ?>"><?php echo Kohana::lang('ui_main.view_more'); ?></a>

<?php blocks::close();?>