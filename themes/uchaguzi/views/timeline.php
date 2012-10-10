<div id="content" class="centercontent">
	
	<div id="contentwrapper" class="contentwrapper">
	<div class="two_third dashboard_left">
	<div class="widgetbox">
		<div class="title">
			<h3>Reports</h3>
		</div>

	<div class="widgetcontent">
		 <div class="widgetoptions">
			<div class="right">
				<ul class="pagination">
					<li class="previous"><a href="#" class="prev" id="<?php echo $previous_page; ?>">&lsaquo;</a></li>
					<li><?php echo $pagination;?></li>
					<li class="next"><a href="#" class="next" id="<?php echo $next_page; ?>">&rsaquo;</a></li>
				</ul>
			</div>
			<a class="current" href=""><img src="images/icons/list.png" width="16" height="16" /></a>
			<a href=""><img src="images/icons/globe.png" width="16" height="16" alt="globe" /></a>
			<a href=""><img src="images/icons/mails.png" width="16" height="16" alt="mail" /></a>
			<a href=""><img src="images/icons/phone.png" width="16" height="16" alt="phone" /></a>
			<a href=""><img src="images/icons/twitter.png" width="16" height="16" alt="phone" /></a>
			<a href=""><img src="images/icons/web.png" width="16" height="16" alt="web" /></a>
		</div>

			<?php
				foreach ($incidents as $incident)
				{
					$incident = ORM::factory('incident')->with('location')->find($incident->incident_id);
					$incident_id = $incident->id;
					$incident_title = strip_tags($incident->incident_title);
					$incident_description = strip_tags($incident->incident_description);
					//$incident_category = $incident->incident_category;
					// Trim to 150 characters without cutting words
					// XXX: Perhaps delcare 150 as constant

					$incident_description = text::limit_chars(strip_tags($incident_description), 140, "...", true);
					$incident_date = date('M d, Y', strtotime($incident->incident_date));
					$incident_time = date('H:i', strtotime($incident->incident_date));
					$location_id = $incident->location_id;
					$location_name = $incident->location->location_name;
					$incident_verified = $incident->incident_verified;

					if ($incident_verified)
					{
						$incident_verified = '<span class="r_verified">'.Kohana::lang('ui_main.verified').'</span>';
						$incident_verified_class = "verified";
					}
					else
					{
						$incident_verified = '<span class="r_unverified">'.Kohana::lang('ui_main.unverified').'</span>';
						$incident_verified_class = "unverified";
					}

					$comment_count = $incident->comment->count();

					$incident_thumb = url::file_loc('img')."media/img/report-thumb-default.jpg";
					$media = $incident->media;
					if ($media->count())
					{
						foreach ($media as $photo)
						{
							if ($photo->media_thumb)
							{ // Get the first thumb
								$incident_thumb = url::convert_uploaded_to_abs($photo->media_thumb);
								break;
							}
						}
					}
				?>

				
				<ol id="timeline">

				<li> 
					<div class="time"><?php echo $incident_time; ?></div>
					<span class="corner"></span>
					<div class="avatar"><img src="<?php echo $incident_thumb; ?>" alt="" width="50" height="50" /></div>
					<div class="info">
						<a href="<?php echo url::site(); ?>reports/view/<?php echo $incident_id; ?>"><?php echo html::specialchars($incident_title); ?></a> 
                        <div class="reportdetails" id="reportdetails"><?php echo $incident_verified_class; ?></div><br>
						<?php echo $incident_description; ?> <br>
                        <i><?php echo $incident_date; ?></i>
							<div class="reportdetails" id="reportdetails"><img src="images/icons/phone.png" width="16" height="16" alt="phone" />
								<img src="images/icons/verified.png" width="16" height="16" alt="verified" />
							</div>
                    </div>
				</li>

				</ol>
	<?php } ?>
	</div>
<!--widgetcontent-->
</div>
</div> 
</div>
<!--two-third dashboard-->
