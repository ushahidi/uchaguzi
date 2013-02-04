<div id="primary-content" class="col_6">
	<h1 class="sub-category"><?php echo Kohana::lang('uchaguzi.gallery'); ?></h1>
        
	<div class="filemgr">
		<div class="filemgr_category">
			<ul>
				<?php uchaguzi::gallery_tabs(); ?>
			</ul>
		</div><!--filemgr_category-->
		
		<?php echo $media_listing_view; ?>			
	</div>
</div>


