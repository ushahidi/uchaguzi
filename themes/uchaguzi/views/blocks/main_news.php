<?php blocks::open("latest");?>

<?php blocks::title(Kohana::lang('uchaguzi.latest_news'));?>
<?php
if ($feeds->count() != 0)
{
	foreach ($feeds as $feed)
	{
			$feed_id = $feed->id;
			$feed_title = text::limit_chars($feed->item_title, 40, '...', True);
			$feed_link = $feed->item_link;
			$feed_date = date('M j Y', strtotime($feed->item_date));
			$feed_source = text::limit_chars($feed->feed->feed_name, 15, "...");
	?>
	<article class="third-party-report">
		<img src="<?php echo url::file_loc('img'); ?>media/img/report-thumb-default.jpg" class="thumb" />
		<h1><a href="<?php echo $feed_link; ?>"><?php echo $feed_title ?></a></h1>
		<p class="metadata">from <?php echo $feed_source; ?>, <span class="date"><?php echo $feed_date; ?></p>
	</article>
	<?php
	}
}
else
{
	?>
	<p>No news.</p>
	<?php
}
?>
<a class="more" href="<?php echo url::site() . 'feeds' ?>"><?php echo Kohana::lang('ui_main.view_more'); ?></a>

<?php blocks::close();?>