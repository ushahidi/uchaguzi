<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">

<head>
	<title><?php echo html::specialchars($page_title.$site_name); ?></title>
	<?php if (!Kohana::config('settings.enable_timeline')) { ?>
		<style>
			#graph{display:none;}
			#map{height:480px;}
		</style>
	<?php } ?>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<!-- Admin css and javascript -->
	<?php
	echo html::stylesheet(url::file_loc('css').'media/css/admin/all', '', TRUE);
	echo html::stylesheet(url::file_loc('css').'media/css/jquery-ui-themeroller', '', TRUE);
	echo "<!--[if lt IE 7]>".
		html::stylesheet(url::file_loc('css').'media/css/ie6', '', TRUE)
		."<![endif]-->";

	// Load OpenLayers
	if ($map_enabled)
	{
		echo html::script(url::file_loc('js').'media/js/OpenLayers', TRUE);
		echo html::script(url::file_loc('js').'media/js/ushahidi', TRUE);
		echo $api_url . "\n";
		echo "<script type=\"text/javascript\">
			OpenLayers.ImgPath = '".url::file_loc('img').'media/img/openlayers/'."';
			</script>";
		echo html::stylesheet(url::file_loc('css').'media/css/openlayers','',TRUE);
	}

	// Load jQuery
	echo html::script(url::file_loc('js').'media/js/jquery', TRUE);
	echo html::script(url::file_loc('js').'media/js/jquery.form', TRUE);
	echo html::script(url::file_loc('js').'media/js/jquery.validate.min', TRUE);
	echo html::script(url::file_loc('js').'media/js/jquery.ui.min', TRUE);
	echo html::script(url::file_loc('js').'media/js/selectToUISlider.jQuery', TRUE);
	echo html::script(url::file_loc('js').'media/js/jquery.hovertip-1.0', TRUE);
	echo html::script(url::file_loc('js').'media/js/jquery.base64', TRUE);
	?>

	<?php if ($datepicker_enabled): ?>
	<script type="text/javascript">
		Date.dayNames = [
		    '<?php echo Kohana::lang('datetime.sunday.full'); ?>',
		    '<?php echo Kohana::lang('datetime.monday.full'); ?>',
		    '<?php echo Kohana::lang('datetime.tuesday.full'); ?>',
		    '<?php echo Kohana::lang('datetime.wednesday.full'); ?>',
		    '<?php echo Kohana::lang('datetime.thursday.full'); ?>',
		    '<?php echo Kohana::lang('datetime.friday.full'); ?>',
		    '<?php echo Kohana::lang('datetime.saturday.full'); ?>'
		];
		Date.abbrDayNames = [
		    '<?php echo Kohana::lang('datetime.sunday.abbv'); ?>',
		    '<?php echo Kohana::lang('datetime.monday.abbv'); ?>',
		    '<?php echo Kohana::lang('datetime.tuesday.abbv'); ?>',
		    '<?php echo Kohana::lang('datetime.wednesday.abbv'); ?>',
		    '<?php echo Kohana::lang('datetime.thursday.abbv'); ?>',
		    '<?php echo Kohana::lang('datetime.friday.abbv'); ?>',
		    '<?php echo Kohana::lang('datetime.saturday.abbv'); ?>'
		];
		Date.monthNames = [
		    '<?php echo Kohana::lang('datetime.january.full'); ?>',
		    '<?php echo Kohana::lang('datetime.february.full'); ?>',
		    '<?php echo Kohana::lang('datetime.march.full'); ?>',
		    '<?php echo Kohana::lang('datetime.april.full'); ?>',
		    '<?php echo Kohana::lang('datetime.may.full'); ?>',
		    '<?php echo Kohana::lang('datetime.june.full'); ?>',
		    '<?php echo Kohana::lang('datetime.july.full'); ?>',
		    '<?php echo Kohana::lang('datetime.august.full'); ?>',
		    '<?php echo Kohana::lang('datetime.september.full'); ?>',
		    '<?php echo Kohana::lang('datetime.october.full'); ?>',
		    '<?php echo Kohana::lang('datetime.november.full'); ?>',
		    '<?php echo Kohana::lang('datetime.december.full'); ?>'
		];
		Date.abbrMonthNames = [
		    '<?php echo Kohana::lang('datetime.january.abbv'); ?>',
		    '<?php echo Kohana::lang('datetime.february.abbv'); ?>',
		    '<?php echo Kohana::lang('datetime.march.abbv'); ?>',
		    '<?php echo Kohana::lang('datetime.april.abbv'); ?>',
		    '<?php echo Kohana::lang('datetime.may.abbv'); ?>',
		    '<?php echo Kohana::lang('datetime.june.abbv'); ?>',
		    '<?php echo Kohana::lang('datetime.july.abbv'); ?>',
		    '<?php echo Kohana::lang('datetime.august.abbv'); ?>',
		    '<?php echo Kohana::lang('datetime.september.abbv'); ?>',
		    '<?php echo Kohana::lang('datetime.october.abbv'); ?>',
		    '<?php echo Kohana::lang('datetime.november.abbv'); ?>',
		    '<?php echo Kohana::lang('datetime.december.abbv'); ?>'
		];
		Date.firstDayOfWeek = 1;
		Date.format = 'mm/dd/yyyy';
	</script>

	<?php
		echo html::script(url::file_loc('js').'media/js/jquery.datePicker', TRUE);
		echo '<!--[if IE]>'.
			html::script(url::file_loc('js').'media/js/jquery.bgiframe.min', TRUE)
			.'<![endif]-->';
	?>
	<?php endif; ?>

	<?php
	echo html::stylesheet(url::file_loc('css').'media/css/jquery.hovertip-1.0', '', TRUE);

	echo "<script type=\"text/javascript\">
		$(function() {
			if($('.tooltip[title]') != null)
			$('.tooltip[title]').hovertip();
		});
	</script>";

	// Load Flot
	if ($flot_enabled)
	{
		echo html::script(url::file_loc('js').'media/js/jquery.flot', TRUE);
		echo html::script(url::file_loc('js').'media/js/excanvas.min', TRUE);
		echo html::script(url::file_loc('js').'media/js/timeline.js', TRUE);
	}

	// Load TreeView
	if ($treeview_enabled)
	{
		echo html::script(url::file_loc('js').'media/js/jquery.treeview');
		echo html::stylesheet(url::file_loc('css').'media/css/jquery.treeview');
	}

	// Load ProtoChart
	if ($protochart_enabled)
	{
		echo "<script type=\"text/javascript\">jQuery.noConflict()</script>";
		echo html::script(url::file_loc('js').'media/js/protochart/prototype', TRUE);
		echo '<!--[if IE]>';
		echo html::script(url::file_loc('js').'media/js/protochart/excanvas-compressed', TRUE);
		echo '<![endif]-->';
		echo html::script(url::file_loc('js').'media/js/protochart/ProtoChart', TRUE);
	}

	// Load Raphael
	if ($raphael_enabled)
	{
		// The only reason we include prototype is to keep the div element naming convention consistent
		//echo html::script(url::file_loc('js').'media/js/protochart/prototype', TRUE);
		echo html::script(url::file_loc('js').'media/js/raphael', TRUE);
		echo '<script type="text/javascript" charset="utf-8">';
		echo 'var impact_json = '.$impact_json .';';
		echo '</script>';
		echo html::script(url::file_loc('js').'media/js/raphael-ushahidi-impact', TRUE);
	}

	// Load ColorPicker
	if ($colorpicker_enabled)
	{
		echo html::stylesheet(url::file_loc('css').'media/css/colorpicker', '', TRUE);
		echo html::script(url::file_loc('js').'media/js/colorpicker', TRUE);
	}

	// Load jwysiwyg
	if ($editor_enabled)
	{
		if (Kohana::config("cdn.cdn_ignore_jwysiwyg") == TRUE) {
			echo html::script(url::file_loc('ignore').'media/js/jwysiwyg/jwysiwyg/jquery.wysiwyg.js', TRUE);
		} else {
			echo html::script(url::file_loc('js').'media/js/jwysiwyg/jwysiwyg/jquery.wysiwyg.js', TRUE);
		}
	}

	// Table Row Sort
	if ($tablerowsort_enabled)
	{
		echo html::script(url::file_loc('js').'media/js/jquery.tablednd_0_5', TRUE);
	}

	// JSON2 for IE+
	if ($json2_enabled)
	{
		echo html::script(url::file_loc('js').'media/js/json2', TRUE);
	}

	// Turn on picbox
	echo html::script(url::file_loc('js').'media/js/picbox', TRUE);
	echo html::stylesheet(url::file_loc('css').'media/css/picbox/picbox');

	//Turn on jwysiwyg
	echo html::stylesheet(url::file_loc('css').'media/js/jwysiwyg/jwysiwyg/jquery.wysiwyg.css');

	// Header Nav
	echo html::script(url::file_loc('js').'media/js/global', TRUE);
	echo html::stylesheet(url::file_loc('css').'media/css/global','',TRUE);

	// Render CSS and Javascript Files from Plugins
	echo plugin::render('stylesheet');
	echo plugin::render('javascript');

	// Action::header_scripts_admin - Additional Inline Scripts
	Event::run('ushahidi_action.header_scripts_admin');
	?>
	<script type="text/javascript" charset="utf-8">
		<?php echo $js . "\n"; ?>
		function info_search(){
			$("#info-search").submit();
		}
		function show_addedit(toggle){
			var addEditForm = $("#addedit");
			if (toggle) {
				addEditForm.toggle(400);
			} else {
				addEditForm.show(400);
			}
			// Clear fields, but not buttons or the CSRF token.
			$(':input','#addedit')
			 .not(':button, :submit, :reset, #action, :checkbox, [name="form_auth_token"]')
			 .val('')
			 .removeAttr('selected');
			
			// Reset checkbox separately to avoid wiping its value
			$(':checkbox','#addedit').removeAttr('checked');
				
			$("a.add").focus();
		}
		<?php if ($form_error): ?>
			$(document).ready(function() { $("#addedit").show(); });
		<?php endif; ?>
	</script>


	<!--/Admin css/js -->

	<?php echo $header_block; ?>
	<?php
	// Action::header_scripts - Additional Inline Scripts from Plugins
	Event::run('ushahidi_action.header_scripts');
	?>

</head>

<?php
  // Add a class to the body tag according to the page URI

  // we're on the home page
  if (count($uri_segments) == 0)
  {
  	$body_class = "page-main";
  }
  // 1st tier pages
  elseif (count($uri_segments) == 1)
  {
    $body_class = "page-".$uri_segments[0];
  }
  // 2nd tier pages... ie "/reports/submit"
  elseif (count($uri_segments) >= 2)
  {
    $body_class = "page-".$uri_segments[0]."-".$uri_segments[1];
  }
?>

<body id="page" class="withvernav">

<div class="bodywrapper">
    <header id="global-header" class="cf">
		<hgroup class="col_4 cf">
			<h1 class="logo"><a href="<?php echo url::site();?>"><?php echo $site_name; ?></a></h1>
			<h2 class="slogan"><?php echo $site_tagline; ?></h2>
		</hgroup>

		<div class="search col_4">
			<?php echo $search; ?>
		</div>        

		<div class="user-tools col_4">
			<?php echo $header_nav; ?>
    	</div>
    </header>
    
    <nav id="top-level-menu" class="cf">
    	<ul>
    		<?php nav::header_tabs($this_page); ?>
		</ul>
        <div class="headerwidget"></div>  
    </nav>
    
    <div class="body-content-area">
    
		<nav id="second-level-menu" class="col_2 cf">
			<ul>
				<?php nav::main_tabs($this_page); ?>        
			</ul>
			<div class="toggle-second-level-menu">
				<a href="#"><span class="point-left icon-arrow-left"></span><span class="point-right icon-arrow-right-2"></span></a>
			</div>
		</nav>