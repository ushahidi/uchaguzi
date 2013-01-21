<?php
/**
 * Media listing js file.
 *
 * Handles javascript stuff related to reports list function.
 *
 * PHP version 5
 * LICENSE: This source file is subject to LGPL license 
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/copyleft/lesser.html
 * @author     Ushahidi Team <team@ushahidi.com> 
 * @package    Ushahidi - http://source.ushahididev.com
 * @module     Gallery Controller
 * @copyright  Ushahidi - http://www.ushahidi.com
 * @license    http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL) 
 */
?>
	
	// Tracks the current URL parameters
	var urlParameters = <?php echo $url_params; ?>;
	var deSelectedFilters = [];
	
	if (urlParameters.length == 0)
	{
		urlParameters = {};
	}
	
	$(document).ready(function() {
		
		// When image filter is clicked
		$('.filemgr li a').click(function() {

			var type = $("#fl-media").val();
			var mediaType = parseFloat(this.id.replace('filter_link_media_', '')) || 0;
		
			// Fetch all images
			attachFilterMediaAction(mediaType);
		});


	});
	
	
	/**
	 * Gets the reports using the specified parameters
	 */
	function fetchMedia()
	{
		
		var loadingURL = "<?php echo url::file_loc('img').'media/img/loading_g.gif'; ?>";
		var statusHtml = "<div style=\"width: 100%; margin-top: 100px;\" align=\"center\">" + 
					"<div><img src=\""+loadingURL+"\" border=\"0\"></div>" + 
					"<p style=\"padding: 10px 2px;\"><h3><?php echo Kohana::lang('uchaguzi.loading_media'); ?>...</h3></p>" +
					"</div>";
	
		$("#fl-media").html(statusHtml);
		
		// Check if there are any parameters
		if ($.isEmptyObject(urlParameters))
		{
			urlParameters = {show: "all"}
		}
		
		// Get the content for the new page
		$.get('<?php echo url::site().'gallery/fetch_media'?>',
			urlParameters,
			function(data) {
				if (data != null && data != "" && data.length > 0) {
				
					// Animation delay
					setTimeout(function(){
						$("#fl-media").html(data);
						
					}, 400);
				}
			}
		);
	}
	
	/**
	 * Adds an event handler for filtering media by type
	 */
	function attachFilterMediaAction(mediaType)
	{
		if (mediaType > 0)
		{
			urlParameters["t"] = mediaType;
		} else  {
			urlParameters["t"] = null;
		}
		
		// Fetch the media
		fetchMedia();
	}
	