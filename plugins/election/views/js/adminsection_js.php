/** 
 * Adminsection js file. 
 * 
 * Handles javascript stuff related to organization function. 
 * 
 * PHP version 5 
 * LICENSE: This source file is subject to LGPL license 
 * that is available through the world-wide-web at the following URI: 
 * http://www.gnu.org/copyleft/lesser.html 
 * @author Ushahidi Team <team @ushahidi.com>
 * @package Ushahidi - http://source.ushahididev.com 
 * @module API Controller 
 * @copyright Ushahidi - http://www.ushahidi.com 
 * @license http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL) 
 */ 
 // Adminsection JS 
 function fillFields(id, adminsection_title ) { 
 	$("#adminsection_id").attr("value",unescape(id)); 
 	$("#adminsection_title").attr("value",unescape(adminsection_title)); 
 } 

// Ajax Submission 
function adminsectionAction ( action, confirmAction, id ) { 
	var statusMessage;
	var answer = confirm('Are You Sure You Want To ' + confirmAction + 'items?') 
	if (answer){ // Set Category ID

		$("#adminsection_id_action").attr("value", id); // Set Submit Type
		$("#action").attr("value", action); // Submit Form
		$("#adminsectionListing").submit(); 
	} 
	
}
