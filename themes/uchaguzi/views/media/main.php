
    <div class="centercontent">
    
        <div class="pageheader notab">
            <h1 class="pagetitle"><?php echo Kohana::lang('uchaguzi.gallery'); ?></h1>
            <span class="pagedesc"><?php echo Kohana::lang('uchaguzi.select_item'); ?></span>
        </div><!--pageheader-->
        
        <div id="contentwrapper" class="contentwrapper nopadding">
        
            <div class="filemgr">
                <div class="filemgr_left">
                    <div class="filemgr_category">
                        <ul>
                            <?php uchaguzi::gallery_tabs(); ?>
                        </ul>
                    </div><!--filemgr_category-->
                    
                    <div id="fl-media" class="filemgr_content">
                        
                        <?php echo $media_listing_view; ?>
                        
                    </div><!--filemgr_content-->
                    
                </div><!--filemgr_left -->
                
                <div class="filemgr_right">
                    <div class="filemgr_rightinner">
                        <div class="contenttitle2" style="margin-top: 0">
                            <h3><?php echo Kohana::lang('uchaguzi.browse_files'); ?></h3>
                        </div><!--contenttitle-->
                        <ul class="menuright">
                            <?php uchaguzi::gallery_reports_menu(); ?>
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
