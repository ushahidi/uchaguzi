<?php
/**
 * Monitors view page.
 *
 * PHP version 5
 * LICENSE: This source file is subject to LGPL license
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/copyleft/lesser.html
 * @author     Ushahidi Team <team@ushahidi.com>
 * @package    Ushahidi - http://source.ushahididev.com
 * @module     API Controller
 * @copyright  Ushahidi - http://www.ushahidi.com
 * @license    http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL)
 */
?>
<div
	class="bg">
<h2><?php election_tool::election_subtabs("monitors"); ?></h2>
<?php
if ($form_error) {
	?> <!-- red-box -->
<div class="red-box">
<h3>Error</h3>
<ul>
<?php
foreach ($errors as $error_item => $error_description)
{
	print (!$error_description) ? '' : "<li>" . $error_description . "</li>";
}
?>
</ul>
</div>
<?php
}

if ($form_saved) {
	?> <!-- green-box -->
<div class="green-box">
<h3>Monitor <?php echo $form_action; ?></h3>
</div>
	<?php
}
?> <!-- report-table -->
<div class="report-form"><?php print form::open(NULL,array('id' => 'monitorListing',
                                                'name' => 'monitorListing')); ?>
<input type="hidden" name="action" id="action" value=""> <input
	type="hidden" name="monitor_id" id="monitor_id_action" value="">
<div class="table-holder">
<table class="table">
	<thead>
		<tr>
			<th class="col-1">Phone Number</th>
			<th class="col-2">Polling station</th>
			<th class="col-3">Location</th>
			<th class="col-4">Actions</th>
		
		</tr>
	</thead>
	<tfoot>
		<tr class="foot">
			<td colspan="4"><?php echo $pagination; ?></td>
		</tr>
	</tfoot>
	<tbody>
	<?php
	if ($total_items == 0)
	{
		?>
		<tr>
			<td colspan="4" class="col">
			<h3>No Results</h3>
			</td>
		</tr>
		<?php
	}

	foreach ($monitors as $key => $monitor)
	{
		$monitor_id = $monitor->id;
		$monitor_location_id = $monitor->location_id;
		$monitor_location_name = $location_array[$monitor->location_id];
		$monitor_polling_station = $monitor->polling_station;
		$monitor_phonenumber = $monitor->phonenumber;

		?>
		<tr>
			<td class="col-1">
			<div class="post"><?php echo $monitor_phonenumber; ?></div>
			</td>
			<td class="col-2">
			<?php echo $monitor_polling_station; ?>
			</td>
			<td class="col-3"><?php echo $monitor_location_name; ?></td>
			<td class="col-4">
			<ul>
				<li class="none-separator"><a href="#add"
					onClick="fillFields('<?php echo(rawurlencode($monitor_id)); ?>',
					'<?php echo(rawurlencode($monitor_phonenumber)); ?>',
					'<?php echo(rawurlencode($monitor_location_id)); ?>',
					'<?php echo(rawurlencode($monitor_polling_station)); ?>')">Edit</a></li>		
				<li><a
					href="javascript:userAction('d','DELETE','<?php echo(rawurlencode($monitor_id)); ?>')"
					class="del">Delete</a></li>
			</ul>
			</td>

		</tr>
		<?php
	}
	?>
	</tbody>
</table>
</div>
<?php print form::close(); ?></div>
<!-- tabs -->
<div class="tabs"><!-- tabset -->
<ul class="tabset">
	<li><a href="#" class="active">Add/Edit</a></li>
</ul>
<!-- tab -->
<div class="tab"><?php print form::open(NULL,array('id' => 'monitorMain', 'name' => 'monitorMain')); ?> 
 
<input type="hidden" name="monitor_id" id="monitor_id" value="<?php echo $form['monitor_id']; ?>">
<input type="hidden" name="action" id="action" value="a" />
<div class="tab_form_item">Phone Number<br />
<?php print form::input('phonenumber'); ?></div>

<div class="tab_form_item">Polling Station<br />
<?php print form::input('polling_station',$form['polling_station'],''); ?></div>

<div class="tab_form_item">Location<br />
<span class="my-sel-holder"> <?php print form::dropdown('location_id',$location_array,'id'); ?>
</span></div>

<div class="tab_form_item">&nbsp;<br />
<input type="image" src="<?php echo url::base() ?>media/img/admin/btn-save.gif"
	class="save-rep-btn" value="SAVE" /></div>
<?php print form::close(); ?></div>
</div>
</div>
