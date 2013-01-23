<div class="filemgr_content">                       
	<?php foreach ($media as $image) { 

		$media_type = $image->media_type;
		$media_name = $image->media_link;
		
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
			<a rel="lightbox-group1" href="<?php echo url::convert_uploaded_to_abs($image->media_link); ?>">
				<span class="icon-newspaper icon"></span>
				<img src="<?php echo url::convert_uploaded_to_abs($image->media_link); ?>" alt="" />
				<span class="filename"><?php echo uchaguzi::page_title($image->media_link); ?></span></a>
		</article>
	<?php } ?> <!--end else if-->
	
	<?php } ?> <!--end foreach-->	
</div><!--filemgr_content-->