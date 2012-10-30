<div class="centercontent">
    
        <div class="pageheader">
		<h1 class="pagetitle"><?php echo Kohana::lang('uchaguzi.tools'); ?></h1>
            <ul class="hornav">
			<?php foreach ($main_tabs as $page => $tab_name): ?>
			<li>
				<a href="<?php echo url::site(); ?>admin/<?php echo $page; ?>" <?php if($this_page==$page) echo 'class="active"' ;?>><?php echo $tab_name; ?></a>
			</li>
			<?php endforeach; ?>
            </ul>
        </div><!--pageheader-->
        
        <div id="contentwrapper" class="contentwrapper">	
			<div id="updates" class="subcontent"> 
                  <div class="notibar announcement">
					<a class="close"></a>
					<?php echo $version_sync; ?>
					<?php echo $security_info; ?>
				 </div> <!--notification announcement-->
				 
				 <div class="two_third dashboard_left">
					<ul class="shortcuts">
						<li><a href="" class="reports"><span><?php echo $reports_total .' '.Kohana::lang('ui_main.reports');?></span></a></li>
						<li><a href="" class="messages"><span><?php echo $message_count .' '.Kohana::lang('ui_main.messages');?></span></a></li>
						<li><a href="" class="published"><span><?php echo $reports_approved .' '.Kohana::lang('ui_main.approved');?></span></a></li>
						<li><a href="" class="verified"><span><?php echo $reports_verified .' '.Kohana::lang('ui_main.verified');?></span></a></li>
					</ul>
					<br clear="all" /><!--contenttitle--><!--overviewhead-->
					
					<br clear="all" /><!-- widgetbox --> 
									 
				 </div> <!--two third dashboard--> 

				 <div class="one_third last dashboard_right">
					<div class="contenttitle2 nomargintop">
						<h3>UCHAGUZI TASKS</h3>
					</div><!--contenttitle-->
					<ul class="toplist">
						<li>
							<div>
								<span class="three_fourth">
									<span class="left">
										<span class="title"><a href=""><?php echo Kohana::lang('ui_main.unverified');?></a></span>
										<span class="desc"><?php echo Kohana::lang('ui_main.reports') .' '.Kohana::lang('ui_main.awaiting_verification');?></span>
									</span><!--left-->
								</span><!--three_fourth-->
								<span class="one_fourth last">
									<span class="right">
										<span class="h3"><?php echo $reports_unverified;?></span>
									</span><!--right-->
								</span><!--one_fourth-->
								<br clear="all" />
							</div>
						</li>
						<li>
							<div>
								<span class="three_fourth">
									<span class="left">
										<span class="title"><a href=""><?php echo Kohana::lang('ui_main.not_approved');?></a></span>
										<span class="desc"><?php echo Kohana::lang('ui_main.reports') .' '.Kohana::lang('ui_main.awaiting_approval');?></span>
									</span><!--left-->
								</span><!--three_fourth-->
								<span class="one_fourth last">
									<span class="right">
										<span class="h3"><?php echo $reports_unapproved;?></span>
									</span><!--right-->
								</span><!--one_fourth-->
								<br clear="all" />
							</div>
						</li>


					</ul>
            </div>            
        </div><!--contentwrapper-->
 </div><!-- centercontent -->
    
