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

<div id="filters" class="col_4">            
	<h3 class="sub-category"><?php echo Kohana::lang('uchaguzi.browse_files'); ?></h3>
	<ul class="menuright">
		<?php uchaguzi::gallery_reports_menu(); ?>
	</ul>
</div>