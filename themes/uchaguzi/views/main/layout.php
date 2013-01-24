    <div id="primary-content" class="col_6">     
        <?php echo $div_map;?>                         

		<div id="slider">
			<?php echo $div_timeline;?>
		</div>
		
		<div id="reports-summary" class="cf">
			<?php blocks::render(); ?>

			<!-- <div class="reports-latest">
				<h3 class="sub-category">Latest news</h3>			
				<article class="third-party-report">
					<img src="/media/img/report-thumb-default.jpg" class="thumb" />
					<h1><a href="#">Flank hamburger capicola, pork loin short ribs sirloin bacon</a></h1>
					<p class="metadata">By John Doe, <span class="date">Jan. 21, 2013</span></p>
				</article>
			</div> -->

			<!-- <div class="reports-highlights">
				<h3 class="sub-category">Highlights</h3>
			
				<article class="highlight cf">
					<img src="/media/img/report-thumb-default.jpg" class="highlight-thumb" />
					<div class="highlight-summary">
						<h1><a href="#">Flank hamburger capicola, pork loin short ribs sirloin bacon</a></h1>
						<p class="metadata">By John Doe, <span class="date">Jan. 21, 2013</span></p>
					</div>
				</article>
			
				<article class="highlight cf">
					<img src="/media/img/report-thumb-default.jpg" class="highlight-thumb" />
					<div class="highlight-summary">
						<h1><a href="#">Flank hamburger capicola, pork loin short ribs sirloin bacon</a></h1>
						<p class="metadata">By John Doe, <span class="date">Jan. 21, 2013</span></p>
					</div>
				</article>

				<article class="highlight cf">
					<img src="/media/img/report-thumb-default.jpg" class="highlight-thumb" />
					<div class="highlight-summary">
						<h1><a href="#">Flank hamburger capicola, pork loin short ribs sirloin bacon</a></h1>
						<p class="metadata">By John Doe, <span class="date">Jan. 21, 2013</span></p>
					</div>
				</article>
			</div> -->
		</div>
	</div>
     
	<div id="filters" class="col_4">
		<div class="widgetbox">
            <div class="title">
				<h3>Filter reports</h3>
			</div>
			
			<div class="widgetcontent">
				<div id="accordion" class="accordion">
					<h3 class=""><a href="#"><?php echo Kohana::lang('ui_main.category')?></a></h3>

					<!--<ul id="category_switch" class="categorylist">-->

					<ul id="category_switch" class="categorylist">
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

					<?php
					// Action::main_sidebar - Add Items to the Entry Page Sidebar
					Event::run('ushahidi_action.main_sidebar');
					?>
				</div>								
			</div>     
		</div>
		
		<section class="how-to">
			<h1 class="sub-category">How to submit a report</h1>
			<ul>
				<li><i class="icon-mobile"></i><strong>Text (SMS) message</strong> <span>Send a message to <em>555555</em></span></li>
				<li><i class="icon-apple"></i><a href="#"><strong>iOS</strong> <span>Install the free Uchaguzi app for iPhone and iPad.</span></a></li>
				<li><i class="icon-android"></i><a href="#"><strong>Android</strong> <span>Install the free Uchaguzi app for Android-powered phones and tablets.</span></a></li>
				<li><i class="icon-publish"></i><a href="#"><strong>Web</strong> <span>Create a report using this website.</span></a></li>
			</ul>
		</section>	
	</div>