<div class="filemgr_content">
	<?php if (count($media) > 0 ): ?>                       
		<?php foreach ($media as $image) { 

			$media_type = $image->media_type;
			
			$media_name = $image->media_link;
			if (!empty($image->media_title))
			{
				$media_name = $image->media_title;
			}
			elseif (!empty($image->incident->incident_title))
			{
				$media_name = $image->incident->incident_title;
			}
			
			?>

			<?php if ($media_type==1) { ?>
			<article class="media image">
				<a rel="lightbox-group1" href="<?php echo url::convert_uploaded_to_abs($image->media_link); ?>">
					<span class="icon-camera icon"></span>
					<img src="<?php echo url::convert_uploaded_to_abs($image->media_thumb); ?>" alt="" />
					<span class="filename"><?php echo $media_name; ?></span>
				</a>
			</article>
		<?php } ?> <!--end if-->

		<?php if ($media_type==2) { ?>
			<article class="media video">
				<span class="icon-video icon"></span>
				<?php echo $videos_embed->embed($image->media_link,'');?>
				<span class="filename"><?php echo $media_name; ?></span>
			</article>
		<?php } ?> <!--end else if-->

		<?php if ($media_type==4) { ?>
			<article class="media news">
				<a href="<?php echo url::convert_uploaded_to_abs($image->media_link); ?>">
					<span class="icon-newspaper icon"></span>
					<h1><?php echo $media_name; ?></h1>
				</a>
			</article>
		<?php } ?> <!--end else if-->
		
		<?php } ?> <!--end foreach-->
	<?php else: ?>
		<div class="no-items">
			<h3><?php echo Kohana::lang('uchaguzi.no_items'); ?></h3>
		</div>
	<?php endif?> <!-- end if -->
</div><!--filemgr_content-->