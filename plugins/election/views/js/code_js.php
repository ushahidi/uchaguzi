/**
 * Form Codes js file.
 * 
 * Handles javascript stuff related to Form codes function.
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

// Codes JS
function fillFields(id, code_id , code_description)
{
	$("#code_id").attr("value", unescape(id));
	$("#code_code_id").attr("value", unescape(code_id));
	$("#code_description").attr("value", unescape(code_description));
}

// Ajax Submission
function codeAction ( action, confirmAction, id )
{
	var statusMessage;
	var answer = confirm('Are You Sure You Want To ' 
		+ confirmAction)
	if (answer){
		// Set Code ID
		$("#code_id_action").attr("value", id);
		// Set Submit Type
		$("#action").attr("value", action);		
		// Submit Form
		$("#codeListing").submit();
	}
}
