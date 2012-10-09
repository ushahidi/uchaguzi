
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
                        
                        <br /><br />
                    	
                        <ul class="listfile">
                            <?php foreach ($media as $image) { ?>

                                <?php $media_type = $image->media_type;
                                
                                ?>

                                <?php if ($media_type==1) { ?>
                                <li>
                                <a class="image" href="<?php echo url::convert_uploaded_to_abs($image->media_thumb); ?>">
                                    <span class="img"><img src="<?php echo url::convert_uploaded_to_abs($image->media_thumb); ?>" alt="" /></span>
                                    <span class="filename"></span></a>
                            </li>
                            <?php } ?> <!--end if-->

                            <?php if ($media_type==2) { ?>
                                <li>
                                <a class="video" href="<?php echo url::convert_uploaded_to_abs($image->media_link); ?>">
                                    <span class="img"><img src="<?php echo url::convert_uploaded_to_abs($image->media_link); ?>" alt="" /></span>
                                    <span class="filename"></span></a>
                            </li>
                            <?php } ?> <!--end else if-->

                            <?php if ($media_type==4) { ?>
                                <li>
                                <a class="news" href="<?php echo url::convert_uploaded_to_abs($image->media_link); ?>">
                                    <span class="img"><img src="<?php echo url::convert_uploaded_to_abs($image->media_link); ?>" alt="" /></span>
                                    <span class="filename"></span></a>
                            </li>
                            <?php } ?> <!--end else if-->
                            
                            <?php } ?> <!--end foreach-->
                        </ul>
                        
                        <br clear="all" />
                        
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
