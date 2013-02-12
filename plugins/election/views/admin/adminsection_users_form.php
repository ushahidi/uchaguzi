<?php 
/**
 * Users view page.
 *
 * PHP version 5
 * LICENSE: This source file is subject to LGPL license 
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/copyleft/lesser.html
 * @author     Ushahidi Team <team@ushahidi.com> 
 * @package    Ushahidi - http://source.ushahididev.com
 * @module     API Controller
 * @copyright  Ushahidi - http://www.ushahidi.com
 * @license    http://www.gnu.org/copyleft/lesser.html GNU Lesser General
 * Public License (LGPL) 
 */
?>
<br/>
<div class="row">
	<strong><?php echo
Kohana::lang('election.admin_sections');?></strong><br />
	<span class="my-sel-holder">
		<?php print form::dropdown('adminsection_title',$adminsections,""); ?>
	</span>
</div>
