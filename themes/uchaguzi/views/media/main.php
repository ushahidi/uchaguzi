
    <div class="centercontent">
    
        <div class="pageheader notab">
            <h1 class="pagetitle"><?php echo Kohana::lang('uchaguzi.gallery'); ?></h1>
            <span class="pagedesc"><?php echo Kohana::lang('uchaguzi.select_item'); ?></span>
        </div><!--pageheader-->
        
        <div id="contentwrapper" class="contentwrapper nopadding">
        
        	<div class="filemgr">
            	<div class="filemgr_left">
                    <div class="filemgr_category">
                    	<ul id="fl-media">
                        	<li class="current"><a href="#" id="filter_link_media_0">All</a></li>
                            <li><a href="#" id="filter_link_media_1"><?php echo Kohana::lang('uchaguzi.image'); ?></a></li>
                            <li><a href="#" id="filter_link_media_2"><?php echo Kohana::lang('uchaguzi.video'); ?></a></li>
                            <li><a href="#" id="filter_link_media_4"><?php echo Kohana::lang('uchaguzi.news'); ?></a></li>
                            <li><a href="#" id="filter_link_media_1"><?php echo Kohana::lang('uchaguzi.audio'); ?></a></li>
                            <li><a href="#" id="filter_link_media_1"><?php echo Kohana::lang('uchaguzi.document'); ?></a></li>
                            <li class="right"><span class="pagenuminfo"><?php echo Kohana::lang('uchaguzi.showing'); ?></span></li>
                        </ul>
                    </div><!--filemgr_category-->
                    
                    <div class="filemgr_content">
						
                        <?php echo $media_listing_view; ?>
                        
                    </div><!--filemgr_content-->
                    
                </div><!--filemgr_left -->
                
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
                <br clear="all" />
            </div><!--filemgr-->
        	
        </div><!--contentwrapper-->
        
	</div><!-- centercontent -->
    
    
</div><!--bodywrapper-->

</body>
</html>
