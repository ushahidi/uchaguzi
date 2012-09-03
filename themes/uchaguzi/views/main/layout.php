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
                        	<div class="title"><h3>Latest News</h3></div>
                            <div class="widgetcontent">
                                <div id="scroll1" class="mousescroll">
                                        <ul class="entrylist">
                                              <li>
											  Main Stream News
                                              </li>
										</ul>                        
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
                                    <h3><a href="#">By Categories</a></h3>
                                    <div>
                                        <ul class="categorylist">
				<?php
				$color_css = 'class="swatch" style="background-color:#'.$default_map_all.'"';
				$all_cat_image = '';
				if ($default_map_all_icon != NULL)
				{
					$all_cat_image = html::image(array(
						'src'=>$default_map_all_icon,
						'style'=>'float:left;padding-right:5px;'
					));
					$color_css = '';
				}
				?>
				<li>
					<a class="active" id="cat_0" href="#">
						<span <?php echo $color_css; ?>><?php echo $all_cat_image; ?></span>
						<span class="category-title"><?php echo Kohana::lang('ui_main.all_categories');?></span>
					</a>
				</li>
				<?php
					foreach ($categories as $category => $category_info)
					{
						$category_title = $category_info[0];
						$category_color = $category_info[1];
						$category_image = ($category_info[2] != NULL)
						    ? url::convert_uploaded_to_abs($category_info[2])
						    : NULL;

						$color_css = 'class="swatch" style="background-color:#'.$category_color.'"';
						if ($category_info[2] != NULL)
						{
							$category_image = html::image(array(
								'src'=>$category_image,
								'style'=>'float:left;padding-right:5px;'
								));
							$color_css = '';
						}

						echo '<li>'
						    . '<a href="#" id="cat_'. $category .'">'
						    . '<span '.$color_css.'>'.$category_image.'</span>'
						    . '<span class="category-title">'.$category_title.'</span>'
						    . '</a>';

						// Get Children
						echo '<div class="hide" id="child_'. $category .'">';
						if (sizeof($category_info[3]) != 0)
						{
							echo '<ul>';
							foreach ($category_info[3] as $child => $child_info)
							{
								$child_title = $child_info[0];
								$child_color = $child_info[1];
								$child_image = ($child_info[2] != NULL)
								    ? url::convert_uploaded_to_abs($child_info[2])
								    : NULL;
								
								$color_css = 'class="swatch" style="background-color:#'.$child_color.'"';
								if ($child_info[2] != NULL)
								{
									$child_image = html::image(array(
										'src' => $child_image,
										'style' => 'float:left;padding-right:5px;'
									));

									$color_css = '';
								}

								echo '<li style="padding-left:20px;">'
								    . '<a href="#" id="cat_'. $child .'">'
								    . '<span '.$color_css.'>'.$child_image.'</span>'
								    . '<span class="category-title">'.$child_title.'</span>'
								    . '</a>'
								    . '</li>';
							}
							echo '</ul>';
						}
						echo '</div></li>';
					}
				?>
                        </ul>
                        </div>
                        <h3><a href="#">By Counties</a></h3>
                        <div>
						<div class="chatsearch">
                        	<input type="text" name="" value="Search" />
                        </div>
                                  <ul class="categorylist">
                        	<li class="online new"><a href="#"><span>Baringo</span></a><span class="reportcount">36K</span></li>
                            <li><a href="#"><span>Bomet</span></a></li>
                            <li class="online"><a href="#"><span>Bungoma</span></a></li>
                            <li class="online"><a href="#"><span>Busia</span></a></li>
                            <li class="online new"><a href="#"><span>Elgoeyo Marakwet</span></a><span class="reportcount">187K</span></li>
                            <li><a href="#"><span>Embu</span></a></li>
                            <li><a href="#"><span>Garissa</span></a></li>
                        </ul>
                                    </div>
                                    
                                </div>     
                          </div> <!--widgetcontent-->
<!----------------FILTER REPORTS ENDS----------------->
                      <br clear="all" />
                    
            
<!---------------- REPORTS----------------->                            <div class="widgetoptions">
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

