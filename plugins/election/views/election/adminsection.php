<?php
/**
 * Adminsection page.
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
		<?php election_tool::election_subtabs("admin_sections"); ?>
	</h2>
<?php if ($form_error) { ?> <!-- red-box -->
<div class="red-box">
<h3><?php echo Kohana::lang('ui_main.error');?></h3>
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
<h3><?php echo Kohana::lang('ui_main.organization_has_been');?> <?php echo $form_action; ?></h3>
</div>
		<?php
	}
	?> <!-- adminsection-table -->
<div class="report-form"><?php print form::open(NULL,array('id' => 'adminsectionListing','name' => 'adminsectionListing')); ?>
<input type="hidden" name="action" id="action" value=""> <input
	type="hidden" name="adminsection_id" id="adminsection_id_action"
	value="">
<div class="table-holder">
<table class="table">
	<thead>
		<tr>
			<th class="col-1">&nbsp;</th>
			<th class="col-2"><?php echo Kohana::lang('election.admin_sections');?></th>
			<th class="col-3">Report Section</th>
			<th class="col-4"><?php echo Kohana::lang('ui_main.actions');?></th>
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
			<h3><?php echo Kohana::lang('ui_main.no_results');?></h3>
			</td>
		</tr>
		<?php
	}
	foreach ($adminsections as $adminsection)
	{
		$adminsection_id = $adminsection->id;
		$adminsection_title = $adminsection->adminsection_title;
		$adminsection_reportsection_name =
$reportsection_array[$adminsection->reportsection_id];
		$adminsection_active = $adminsection->adminsection_active;

		?>
		<tr>
			<td class="col-1">&nbsp;</td>
			<td class="col-2">
			<div class="post">
			<h4><?php echo $adminsection_title; ?></h4>
			</div>
			</td>

			<td class="col-3"><?php echo $adminsection_reportsection_name; ?></td>
			<td class="col-4">
			<ul>
				<li class="none-separator"><a href="#add"
					onClick="fillFields(
					'<?php echo(rawurlencode($adminsection_id)); ?>',
					'<?php echo(rawurlencode($adminsection_title)); ?>')"> 
					<?php echo Kohana::lang('ui_main.edit');?></a></li>
				<li class="none-separator"><a
					href="javascript:adminsectionAction('v','SHOW/HIDE','<?php echo(rawurlencode($adminsection_id)); ?>')"
					<?php if ($adminsection_active) echo " class=\"status_yes\"" ?>><?php echo Kohana::lang('ui_main.visible');?></a></li>
				<li><a
					href="javascript:adminsectionAction('d','DELETE','<?php echo(rawurlencode($adminsection_id)); ?>')"
					class="del"><?php echo Kohana::lang('ui_main.delete');?></a></li>
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

<div class="tabs"><!-- tabset --> <a name="add"></a>
<ul class="tabset">
	<li><a href="#" class="active"><?php echo Kohana::lang('ui_main.add_edit');?></a></li>
</ul>
<!-- tab -->
<div class="tab"><?php print form::open(NULL,array('id' => 'adminsectionMain',
	'name' => 'adminsectionMain')); ?> 
	<input type="hidden" id="adminsection_id" name="adminsection_id"
	value="<?php echo $form['adminsection_id']; ?>" /> 
	<input type="hidden"
	name="action" id="action" value="a" />
<div class="tab_form_item"><strong><?php echo Kohana::lang('election.adminsection_title');?>:</strong><br />
<?php print form::input('adminsection_title', $form['adminsection_title'], ' class="text long"'); ?>
</div>
<div class="tab_form_item">Report Section<br />
<span class="my-sel-holder"> <?php print
form::dropdown('reportsection_id',$reportsection_array,'id'); ?>
</span></div>

<div class="tab_form_item">&nbsp;<br />
<input type="image"
	src="<?php echo url::base() ?>media/img/admin/btn-save.gif"
	class="save-rep-btn" /></div>
<?php print form::close(); ?></div>
</div>

</div>
