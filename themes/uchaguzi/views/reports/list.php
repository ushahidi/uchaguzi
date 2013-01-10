<?php
/**
 * View file for updating the reports display
 *
 * PHP version 5
 * LICENSE: This source file is subject to LGPL license 
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/copyleft/lesser.html
 * @author     Ushahidi Team - http://www.ushahidi.com
 * @package    Ushahidi - http://source.ushahididev.com
 * @copyright  Ushahidi - http://www.ushahidi.com
 * @license    http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL) 
 */
?>
    <div>
    
       <div id="contentwrapper" class="contentwrapper">
      
                    
        <div class="three_third dashboard_left">
                
            <div class="two_third widgetbox">
                <div class="title"><h3> reports</h3></div>
            <div class="widgetcontent userlistwidget nopadding">
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
					$incident_date = date('H:i M d, Y', strtotime($incident->incident_date));
					//$incident_time = date('H:i', strtotime($incident->incident_date));
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

				 <ul>
                    <li>
                         <div class="avatar"><p class="r_photo" style="text-align:center;"> <a href="<?php echo url::site(); ?>reports/view/<?php echo $incident_id; ?>"><img src="<?php echo $incident_thumb; ?>" style="max-width:89px;max-height:59px;" /> </a></p>

						<!-- Only show this if the report has a video -->
						<p class="r_video" style="display:none;"><a href="#"><?php echo Kohana::lang('ui_main.video'); ?></a></p>

						</div>
                         <div class="info">
                            <a href="<?php echo url::site(); ?>reports/view/<?php echo $incident_id; ?>"><?php echo html::specialchars($incident_title); ?></a> 
							<div class="reportdetails" id="reportdetails"><?php echo $incident_verified_class; ?></div><br />
                            <?php echo $incident_description; ?>  
							<a class="btn-show btn-more" href="#<?php echo $incident_id ?>"><?php echo Kohana::lang('ui_main.more_information'); ?> &raquo;</a> 
							<a class="btn-show btn-less" href="#<?php echo $incident_id ?>">&laquo; <?php echo Kohana::lang('ui_main.less_information'); ?></a> 
							<?php echo $incident_date; ?>
                             <div class="reportdetails" id="reportdetails"><img src="images/icons/phone.png" width="16" height="16" alt="phone" /></div>
                        </div><!--info-->
                     </li>
			<?php } ?>
                </ul>

                <a href="" class="more">View More REPORTS</a>
                                
            </div>
            <!--widgetcontent-->
        </div><!--widgetbox-->
        
