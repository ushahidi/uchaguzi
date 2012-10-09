<?php //blocks::open("news");?>
<!--<div class="title"><?php //blocks::title(Kohana::lang('ui_main.official_news'));?></div>-->
<div class="title">Latest News</div>
<div class="widgetcontent">
	<div id="scroll1" class="mousescroll">
		<ul class="entrylist">
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
			<li>
				<div class="entry_wrap">
					<div class="entry_img"></div>
					<div class="entry_content">
						<a href="<?php echo $feed_link; ?>" target="_blank"><?php echo $feed_title ?></a>
						<small><?php echo Kohana::lang('ui_main.source'); ?>:: <a href=""><strong><?php echo $feed_source; ?></strong></a> - <?php echo $feed_date; ?></small>
					</div>
				</div>
			</li>
			<?php
			}
		}
		else
		{
			?>
			<?php
		}
		?>
		</ul>
	</div>
</div>
<div style="clear:both;"></div>
<?php //blocks::close();?>
