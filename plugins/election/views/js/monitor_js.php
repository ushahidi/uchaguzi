/** 
 * Monitors js file. 
 * 
 * Handles javascript stuff related to monitors function 
 * 
 * PHP version 5 
 * LICENSE: This source file is subject to LGPL license 
 * that is available through the world-wide-web at the following URI: 
 * http://www.gnu.org/copyleft/lesser.html 
 * @author Ushahidi Team <team @ushahidi.com>
 * @package Ushahidi - http://source.ushahididev.com 
 * @module Election Controller 
 * @copyright Ushahidi - http://www.ushahidi.com 
 * @license http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL) 
 */ 
 
 // Monitors JS 
 function fillFields( id,phonenumber,location_id,polling_station) { 
 	$("#monitor_id").attr("value", unescape(id));
	$("#phonenumber").attr("value", unescape(phonenumber));
	$("#polling_station").attr("value",unescape(polling_station));
	$("#location_id").attr("value", unescape(location_id)); 
 } 

// Form Submission 

function userAction ( action, confirmAction, id ) { 
	var statusMessage; 
	var answer = confirm('Are You Sure You Want To ' + confirmAction + ' Monitors?')
	if (answer){ 
		// Set Monitor ID
		$("#monitor_id_action").attr("value", id); // Set Submit Type
		$("#action").attr("value", action); // Submit Form
		$("#monitorListing").submit(); 
	} 
}
