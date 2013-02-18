<?php 
/**
 * Form Codes view page.
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
					<?php election_tool::election_subtabs("codes"); ?>
				</h2>
				<?php
				if ($form_error) {
				?>
					<!-- red-box -->
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
				?>
					<!-- green-box -->
					<div class="green-box">
						<h3>Form Code has been <?php echo $form_action; ?>!</h3>
					</div>
				<?php
				}
				?>
				<!-- report-table -->
				<div class="report-form">
					<?php print form::open(NULL,array('id' => 'codeListing',
					 	'name' => 'codeListing')); ?>
						<input type="hidden" name="action" id="action" value="">
						<input type="hidden" name="code_id" id="code_id_action" value="">
						<div class="table-holder">
							<table class="table">
								<thead>
									<tr>
										<th class="col-1">&nbsp;</th>
										<th class="col-2">Code</th>
										<th class="col-3">Description</th>
										<th class="col-4">Actions</th>
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
									foreach ($codes as $code)
									{
										$code_id = $code->id;
										$code_code_id = $code->code_id;
										$code_description = substr($code->code_description, 0, 200);
										?>
										<tr>
											<td class="col-1">&nbsp;</td>
											<td class="col-2"><?php echo $code_code_id; ?></td>
											<td class="col-3">
												<div class="post">
													<h4><?php echo $code_description; ?></h4>
												</div>
											</td>
											<td class="col-4">
												<ul>
													<li class="none-separator"><a href="#add" onClick="fillFields('<?php echo(rawurlencode($code_id)); ?>','<?php echo(rawurlencode($code_code_id)); ?>','<?php echo(rawurlencode($code_description)); ?>')">Edit</a></li>
<li><a href="javascript:codeAction('d','DELETE','<?php echo(rawurlencode($code_id)); ?>')" class="del">Delete</a></li>
												</ul>
											</td>
										</tr>
										<?php
										
									}
									?>
								</tbody>
							</table>
						</div>
					<?php print form::close(); ?>
				</div>
				
				<!-- tabs -->
				<div class="tabs">
					<!-- tabset -->
					<a name="add"></a>
					<ul class="tabset">
						<li><a href="#" class="active">ADD/EDIT</a></li>
					</ul>
					<!-- tab -->
					<div class="tab">
						<?php print form::open(NULL,array('enctype' => 'multipart/form-data', 
							'id' => 'codeMain', 'name' => 'codeMain')); ?>
						<input type="hidden" id="code_id" 
							name="code_id" value="" />
						<input type="hidden" name="action" 
							id="action" value="a"/>
							<div class="tab_form_item">
						Code<br />
							<?php print form::input('code_code_id',$form['code_code_id'],'') ?>
						</div>
						<div style="clear:both"></div>
						
						<div class="tab_form_item">
						Description<br />
							<?php print form::textarea('code_description',$form['code_description'], ' rows="10" cols="50"'); ?>
						</div>

						<div style="clear:both"></div>
						<div class="tab_form_item">
							&nbsp;<br />
							<input type="image" src="<?php echo url::base() ?>media/img/admin/btn-save.gif" class="save-rep-btn" value="SAVE"/>
						</div>
						<?php print form::close(); ?>			
					</div>
				</div>

			</div>
