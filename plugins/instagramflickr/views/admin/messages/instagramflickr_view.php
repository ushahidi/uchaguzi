<?php 
/**
 * Flickr photo view page.
 */
?>

<div class="table-tabs">
	<!-- tabs -->
	<div class="tabs">
		<div class="tab">
			<ul>
				<li><a href="#" onClick="messagesAction('d', 'DELETE', '')"><?php echo Kohana::lang('ui_main.delete');?></a></li>
			</ul>
		</div>
	</div>

	<?php if ($form_error): ?>
		<!-- red-box -->
		<div class="red-box">
			<h3><?php echo Kohana::lang('ui_main.error');?></h3>
			<ul><?php echo Kohana::lang('ui_main.select_one');?></ul>
		</div>
	<?php endif; ?>

	<?php if ($form_saved): ?>
		<!-- green-box -->
		<div class="green-box" id="submitStatus">
			<h3><?php echo Kohana::lang('ui_main.messages');?> <?php echo $form_action; ?> <a href="#" id="hideMessage" class="hide">hide this message</a></h3>
		</div>
	<?php endif;?>

	<!-- report-table -->
	<?php print form::open(NULL, array('id' => 'messageMain', 'name' => 'messageMain')); ?>
		<input type="hidden" name="action" id="action" value="">
		<input type="hidden" name="level"  id="level"  value="">
		<input type="hidden" name="message_id[]" id="message_single" value="">
		<div class="table-holder">
			<table class="table">
				<thead>
					<tr>
						<th class="col-1"><input id="checkall" type="checkbox" class="check-box" onclick="CheckAll( this.id, 'message_id[]' )" /></th>
						<th class="col-2"><?php echo Kohana::lang('ui_main.message_details');?></th>
						<th class="col-3"><?php echo Kohana::lang('ui_main.date');?></th>
						<th class="col-4"><?php echo Kohana::lang('ui_main.actions');?></th>
					</tr>
				</thead>
				<tfoot>
					<tr class="foot">
						<td colspan="4">
							<?php echo $pagination; ?>
						</td>
					</tr>
				</tfoot>
				<tbody>
					<?php if ($total_items == 0): ?>
								
					<tr>
						<td colspan="4" class="col">
							<h3><?php echo Kohana::lang('ui_main.no_results');?></h3>
						</td>
					</tr>
					<?php endif; ?>
					<?php 
					foreach ($photos as $photo)
					{
						$photo_id = $photo->id;
						$photo_from = $photo->reporter->service_account;
						$photo_to = strip_tags($photo->photo_to);
						$incident_id = $photo->incident_id;
						$photo_title = text::auto_link(strip_tags($photo->photo_title));
						$photo_description = nl2br(text::auto_link(strip_tags($photo->photo_description)));
						$photo_date = date('Y-m-d  H:i', strtotime($photo->photo_date));
						$photo_type = $photo->photo_type;
						$photo_level = $photo->photo_level;
						$latitude = $photo->latitude;
						$longitude = $photo->longitude;

						$level_id = $photo->reporter->level_id;
					?>
					<tr>
						<td class="col-1">
							<input name="message_id[]" id="message" value="<?php echo $photo_id; ?>" type="checkbox" 
							class="check-box"/>
						</td>
						<td class="col-2">
							<div class="post">
								<div class="incident-id">
									<a href="<?php echo url::site() . 'admin/reports/edit?ifid=' 
									. $photo_id; ?>" class="more">#
										<?php echo $photo_id; ?>
									</a>
								</div>
								<p><?php echo $photo_title ?></p>
								<p><?php echo $photo_description; ?></p>
								

								<?php
								$media = media::get_media($photo_id);
								if ( ($media != NULL) AND count($media) > 0 )
								{
									// Retrieve Attachments if any
									
									foreach($media as $foto) 
									{
										if ($foto->media_type == 1)
										{
											print "<div class=\"attachment_thumbs\" id=\"photo_". $foto->id ."\">";

											$thumb = $foto->media_thumb;
											$photo_link = $foto->media_link;
											$prefix = url::base().Kohana::config('upload.relative_directory');
											print "<a class='photothumb' rel='lightbox-group".$photo_id."' href='$photo_link'>";
											print "<img src=\"$thumb\" border=\"0\" >";
											print "</a>";
											print "</div>";
										}
									}
								}
								?>
							</div>
							<ul class="info">
								<li class="none-separator"><?php echo Kohana::lang('ui_admin.to');?>: <strong><?php echo $photo_to; ?></strong></li>
								<li class="none-separator"><?php echo Kohana::lang('ui_admin.to');?>: <strong><?php echo $photo_from; ?></strong></li>
								<?php
								
								if ($latitude != NULL AND $longitude != NULL)
								{
									?><li class="none-separator"> @ <?php echo $latitude; ?>,<?php echo $longitude; ?></li><?php
								}
								?>
							</ul>
						</td>
						<td class="col-3"><?php echo $photo_date; ?></td>
						<td class="col-4">
							<ul>
								<?php
								if ($incident_id != 0 ) {
									echo "<li class=\"none-separator\"><a href=\"". url::base() . 'admin/reports/edit/' . $incident_id ."\" class=\"status_yes\"><strong>".Kohana::lang('ui_admin.view_report')."</strong></a></li>";
								}
								else
								{
									echo "<li class=\"none-separator\"><a href=\"". url::base() . 'admin/reports/edit?ifid=' . $photo_id ."\">".Kohana::lang('ui_admin.create_report')."?</a></li>";
								}
								?>
								<li><a href="javascript:messagesAction('d','DELETE','<?php echo(rawurlencode($photo_id)); ?>')" class="del"><?php echo Kohana::lang('ui_main.delete');?></a></li>
							</ul>
						</td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	<?php print form::close(); ?>
</div>
