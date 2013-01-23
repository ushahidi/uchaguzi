<div id="primary-content" class="col_6">
	<h1 class="sub-category"><?php echo Kohana::lang('uchaguzi.gallery'); ?></h1>

	<div class="filemgr">
		<div class="filemgr_category">
			<ul>
				<li class="current"><a href="">All</a></li>
				<li><a href=""><?php echo Kohana::lang('uchaguzi.image'); ?></a></li>
				<li><a href=""><?php echo Kohana::lang('uchaguzi.video'); ?></a></li>
				<li><a href=""><?php echo Kohana::lang('uchaguzi.audio'); ?></a></li>
				<li><a href=""><?php echo Kohana::lang('uchaguzi.document'); ?></a></li>
				<li class="right"><span class="pagenuminfo"><?php echo Kohana::lang('uchaguzi.showing'); ?></span></li>
			</ul>
		</div><!--filemgr_category-->
		
		<div class="filemgr_content">
			
			<small>
				<strong>
					<em><?php echo Kohana::lang('uchaguzi.tips'); ?></em>
				</strong>
			</small>
			
			<?php foreach ($media as $image) { ?>

				<?php $media_type = $image->media_type;
				
				?>

				<?php if ($media_type==1) { ?>
				<article class="media image">
					<a href="<?php echo url::convert_uploaded_to_abs($image->media_thumb); ?>">
						<img src="<?php echo url::convert_uploaded_to_abs($image->media_thumb); ?>" alt="" />
						<span class="filename"></span>
					</a>
				</article>
			<?php } ?> <!--end if-->

			<?php if ($media_type==2) { ?>
				<article class="media video">
					<a href="<?php echo url::convert_uploaded_to_abs($image->media_link); ?>">
					<img src="<?php echo url::convert_uploaded_to_abs($image->media_link); ?>" alt="" />
					<span class="filename"></span></a>
				</article>
			<?php } ?> <!--end else if-->

			<?php if ($media_type==4) { ?>
				<article class="media news">
					<a href="<?php echo url::convert_uploaded_to_abs($image->media_link); ?>">
					<img src="<?php echo url::convert_uploaded_to_abs($image->media_link); ?>" alt="" />
					<span class="filename"></span></a>
				</article>
			<?php } ?> <!--end else if-->
			
			<?php } ?> <!--end foreach-->

		</div><!--filemgr_content-->
	</div><!--filemgr-->     	
</div>

<div id="filters" class="col_4">
	<div class="filemgr_right">
		<div class="filemgr_rightinner">
			<div class="contenttitle2" style="margin-top: 0">
				<h3>Browse Files</h3>
			</div><!--contenttitle-->
			<ul class="menuright">
				<li class="current"><a href=""><?php echo Kohana::lang('uchaguzi.all_reports'); ?></a></li>
				<li><a href=""><?php echo Kohana::lang('uchaguzi.recent_reports'); ?></a></li>
				<li><a href=""><?php echo Kohana::lang('uchaguzi.popular_reports'); ?></a></li>
				<li><a href=""><?php echo Kohana::lang('uchaguzi.amplified_reports'); ?></a></li>
				<li><a href=""><?php echo Kohana::lang('uchaguzi.flagged_reports'); ?></a></li>
			</ul>
		</div><!-- filemgr_rightinner -->
	</div><!-- filemgr_right -->
</div>
	
</div><!--bodywrapper-->

</body>
</html>
