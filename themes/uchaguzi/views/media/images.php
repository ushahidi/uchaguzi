<div id="primary-content" class="col_6">
	<h1 class="sub-category"><?php echo Kohana::lang('uchaguzi.gallery'); ?></h1>
        
	<div class="filemgr">
		<div class="filemgr_category">
			<ul>
				<?php uchaguzi::gallery_tabs(); ?>
			</ul>
		</div><!--filemgr_category-->
		
		<div id="fl-media" class="filemgr_content">
			
			<?php echo $media_listing_view; ?>
			
		</div><!--filemgr_content-->
	</div>
</div>

<div class="col_4">            
	<div class="filemgr_rightinner">
		<div class="contenttitle2" style="margin-top: 0">
			<h3 class="sub-category"><?php echo Kohana::lang('uchaguzi.browse_files'); ?></h3>
		</div><!--contenttitle-->
		<ul class="menuright">
			<?php uchaguzi::gallery_reports_menu(); ?>
		</ul>
	</div><!-- filemgr_rightinner -->
</div>