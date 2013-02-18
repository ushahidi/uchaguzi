<?php
/**
 * Boundaries view page.
 *
 * PHP version 5
 * LICENSE: This source file is subject to LGPL license
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/copyleft/lesser.html
 * @author     Ushahidi Team <team@ushahidi.com>
 * @package    Ushahidi - http://source.ushahididev.com
 * @module     Huduma Controller
 * @copyright  Ushahidi - http://www.ushahidi.com
 * @license    http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL)
 */
?>
<div class="centercontent">
<h2>
	<?php election_tool::election_subtabs("boundaries"); ?>
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
<h3>Boundary has been <?php echo $form_action; ?>!</h3>
</div>
	<?php
}
?> <!-- report-table -->
<div class="report-form"><?php print form::open(NULL,array('id' => 'boundaryListing',
					 	'name' => 'boundaryListing')); ?> <input type="hidden"
	name="action" id="action" value=""> <input type="hidden"
	name="boundary_id" id="boundary_id_action" value="">
<div class="table-holder">
<table class="table">
	<thead>
		<tr>
			<th>&nbsp;</th>
			<th>Boundary</th>
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
	foreach ($boundaries as $boundary)
	{
		$boundary_id = $boundary->id;
		$boundary_name = $boundary->boundary_name;
		?>
		<tr>
			<td class="col-1">&nbsp;</td>
			<td class="col-2">
			<div class="post">
			<h4><?php echo $boundary_name; ?></h4>
			</div>
			</td>
			<td class="col-4">
			<ul>
				<li class="none-separator"><a href="#add"
					onClick="fillFields('<?php echo(rawurlencode($boundary_id)); ?>','<?php echo(rawurlencode($boundary_name)); ?>')">Edit</a>
				<li><a
					href="javascript:catAction('d','DELETE','<?php echo(rawurlencode($boundary_id)); ?>')"
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
<div class="tabs"><!-- tabset --> <a name="add"></a>
<ul class="tabset">
	<li><a href="#" class="active">ADD/EDIT</a></li>
</ul>
<!-- tab -->
<div class="tab"><?php print form::open(NULL,array('enctype' => 'multipart/form-data', 
							'id' => 'boundaryMain', 'name' => 'boundaryMain')); ?> <input
	type="hidden" id="boundary_id" name="boundary_id" value="" /> <input
	type="hidden" name="action" id="action" value="a" />
<div class="tab_form_item">Boundary Name<br />
<?php print form::input('boundary_name', '', ' class="text"'); ?></div>
<div style="clear: both"></div>
<div class="tab_form_item">&nbsp;<br />
<input type="image" src="<?php echo url::base() ?>media/img/admin/btn-save.gif"
	class="save-rep-btn" value="SAVE" /></div>
<?php print form::close(); ?></div>
</div>
</div>
