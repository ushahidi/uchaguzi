<!-- main body -->
    <div class="centercontent">
    
       <div id="contentwrapper" class="contentwrapper">
      
                    
                   	<div class="two_third dashboard_left">
                    
					<?php echo $div_map;?>                         
					<div id="slider">
						<?php echo $div_timeline;?>
					</div>

<!----------------LATEST NEWS----------------->
                                 <br clear="all" />     
           <div class="widgetbox">
                        	<!--<div class="title"><h3>Latest News</h3></div>-->
                            <div class="widgetcontent">
                                <div id="scroll1" class="mousescroll">
										<?php
											blocks::render(); 
										?>
                                </div>
                            </div> <!--widgetcontent-->
                        </div><!-- widgetbox -->
                       	  <div class="widgetcontent">
                        	  
                      	  </div><!--widgetcontent-->
                        
                    </div><!--two_third dashboard_left -->
                    
                    <div class="one_third last dashboard_right">
<!----------------FILTER REPORTS----------------->
                      <div class="widgetbox">
                        <div class="title">
                          <h3>Filter reports</h3></div>
                            <div class="widgetcontent">
                                <div id="accordion" class="accordion">
                                   <h3><a href="#"><?php echo Kohana::lang('ui_main.category')?></a></h3>
                                	<ul class="categorylist">
                        				<li><?php
										$all_cat_image = '&nbsp';
										$all_cat_image = '';
										if($default_map_all_icon != NULL) {
										$all_cat_image = html::image(array('src'=>$default_map_all_icon));
										}
										?>
										<span class="item-swatch" style="background-color: #<?php echo Kohana::config('settings.default_map_all'); ?>"><?php echo $all_cat_image ?></span>
										<span class="item-title"><?php echo Kohana::lang('ui_main.all_categories'); ?></span>
										</a>
										</li>
										<?php echo $category_tree_view; ?>
									</ul>
                        			<h3><a href="#">By Counties</a></h3>
									<div class="chatsearch">
                        				<input type="text" name="" value="Search" />
                        			</div>
                            		<ul class="categorylist">
                        				<li>
									
										</li>
										<?php echo $county_tree_view; ?>
                        			</ul>
                                    
                     			</div>     
                			</div> <!--widgetcontent-->
<!----------------FILTER REPORTS ENDS----------------->
                      <br clear="all" />
                    
            <!---------------- REPORTS----------------->  
          <div class="widgetoptions">
                                <div class="right"><a href="#">View All Reports</a></div>
                                <a href="#">Create a Report</a>
                            </div>
                           <div class="widgetcontent">
                                <ul class="recent_list">
                                    <li class="user new">
                                        <div class="msg">Narok Residents Being Used by Politicians.
                                        </div>
                                    </li>
                                    <li class="call new">
                                        <div class="msg">Resource mis-management in Emali, Makueni County</div>
                                    </li>
                                    <li class="twitter new">
                                        <div class="msg">
                                            <a href="#">No Water Rongai</a><a href="#"></a>.
                                        </div>
                                    </li>
                                    <li class="call new">
                                        <div class="msg">
                                            <a href="#">Fix Roads in Kariobangi, Nairobi</a>.
                                        </div>
                                    </li>
                                    <li class="user">
                                        <div class="msg">
                                            <a href="#">Empower the disabled.</a>
                                        </div>
                                    </li>
                                </ul>
                                <div class="msgmore"><a href="#">View All Reports</a></div>
                            </div><!--widgetcontent-->
                        </div><!--widgetbox-->
<!---------------- REPORTS ENDS-------------->

