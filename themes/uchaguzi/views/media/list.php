                    <div class="filemgr_content">
                        
                        <small>
                            <strong>
                                <em><?php echo Kohana::lang('uchaguzi.tips'); ?></em>
                            </strong>
                        </small>
                        
                        <br /><br />
                        
                        <ul class="listfile" id="media-content">
                            <?php foreach ($media as $image) { 

                                $media_type = $image->media_type;
                                $media_name = $image->media_link;
                                
                                ?>

                                <?php if ($media_type==1) { ?>
                                <li>
                                <a class="image" href="<?php echo url::convert_uploaded_to_abs($image->media_link); ?>">
                                    <span class="img"><img src="<?php echo url::convert_uploaded_to_abs($image->media_thumb); ?>" alt="" /></span>
                                    <span class="filename"><?php echo $media_name; ?></span></a>
                            </li>
                            <?php } ?> <!--end if-->

                            <?php if ($media_type==2) { ?>
                                <li>
                                <a class="video" href="<?php echo url::convert_uploaded_to_abs($image->media_link); ?>">
                                    <span class="img"><img src="<?php echo url::convert_uploaded_to_abs($image->media_link); ?>" alt="" /></span>
                                    <span class="filename"><?php echo $media_name; ?></span></a>
                            </li>
                            <?php } ?> <!--end else if-->

                            <?php if ($media_type==4) { ?>
                                <li>
                                <a class="news" href="<?php echo url::convert_uploaded_to_abs($image->media_link); ?>">
                                    <span class="img"><img src="<?php echo url::convert_uploaded_to_abs($image->media_link); ?>" alt="" /></span>
                                    <span class="filename"><?php echo $media_name; ?></span></a>
                            </li>
                            <?php } ?> <!--end else if-->
                            
                            <?php } ?> <!--end foreach-->
                        </ul>
                        
                        <br clear="all" />
                        
                    </div><!--filemgr_content-->