<?php
/**
 * Report section view page.
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
<div class="centercontent">
<h2>
	<?php election_tool::election_subtabs("report_sections"); ?>
</h2>
<?php
if ($form_error) {
	?> <!-- red-box -->
<div class="red-box">
<h3>Error</h3>
<ul>
<?php
foreach ($errors as $error_item => $error_description)
{
	// print "<li>" . $error_description . "</li>";
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
<h3>Report Section has been <?php echo $form_action; ?>!</h3>
</div>
	<?php
}
?> <!-- report-table -->
<div class="report-form"><?php print form::open(NULL,array('id' =>
'reportsectionListing',
					 	'name' => 'reportsectionListing')); ?> 
<input type="hidden" name="action" id="action" value="">
<input type="hidden" name="reportsection_id" id="reportsection_id_action"
value="">
<input type="hidden" name="reportsection_id_action" id="reportsection_id_action" value="">
<div class="table-holder">
<table class="table">
	<thead>
		<tr>
			<th>&nbsp;</th>
			<th>Report Section</th>
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
	foreach ($reportsections as $reportsection)
	{
		$reportsection_id = $reportsection->id;
		$reportsection_name = $reportsection->reportsection_name;
		?>
		<tr>
			<td class="col-1">&nbsp;</td>
			<td class="col-2">
			<div class="post">
			<h4><?php echo $reportsection_name; ?></h4>
			</div>
			</td>
			<td class="col-4">
			<ul>
				<li class="none-separator">
				<!--<a href="#add"  onClick="fillFields('<?php
				//echo(rawurlencode($reportsection_id)); ?>','<?php
				////echo(rawurlencode($reportsection_name)); ?>')">Edit</a>-->
				<a href="#" class="active" onclick="show_addedit(true)">Edit</a>
<?php if($reportsection_id != 1 && $reportsection_id != 2) {
?>
				<li><a
					href="javascript:catAction('d','DELETE','<?php
echo(rawurlencode($reportsection_id)); ?>')"
					class="del">Delete</a></li>
			<?php
}
?>
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
<?php 
if($form_action == 'a')
{
?>
<div class="tabs"><!-- tabset --> <a name="add"></a>
<ul class="tabset">
	<li><a href="#" class="active">ADD/EDIT</a></li>
</ul>
<!-- tab -->
<div class="tab id="addedit" style="display:none""><?php print form::open(NULL,array('enctype' => 'multipart/form-data', 
							'id' => 'reportsectionMain', 'name' =>
'reportsectionMain')); ?> <input
	type="hidden" id="reportsection_id" name="reportsection_id" value="" /> <input
	type="hidden" name="action" id="action" value="a" />
<div class="tab_form_item">Report Section Name<br />
<?php print form::input('reportsection_name', '', ' class="text"'); ?></div>
<div class="tab_form_item">
	<strong>Color:</strong><br />
	<?php print form::input('category_color','', ' class="text"'); ?>
	<script type="text/javascript" charset="utf-8">
		$(document).ready(function() {
			$('#category_color').ColorPicker({
				onSubmit: function(hsb, hex, rgb) {
					$('#category_color').val(hex);
				},
				onChange: function(hsb, hex, rgb) {
					$('#category_color').val(hex);
				},
				onBeforeShow: function () {
					$(this).ColorPickerSetColor(this.value);
										}
			})
			.bind('keyup', function(){
				$(this).ColorPickerSetColor(this.value);
			});
		});
	</script>
</div>

<div style="clear: both"></div>
<div class="tab_form_item">&nbsp;<br />
<input type="image" src="<?php echo url::base() ?>media/img/admin/btn-save.gif"
	class="save-rep-btn" value="SAVE" /></div>
<?php print form::close(); ?></div>
</div>
<?php
}
	
?>

</div>
