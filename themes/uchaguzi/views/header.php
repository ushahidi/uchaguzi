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
    <div class="topheader">
        <div class="left">
            <h1 class="logo">
				<a href="<?php echo url::site();?>"><?php echo $site_name; ?></a>
			</h1>
            <span class="slogan"><?php echo $site_tagline; ?></span>
<!--search-->
            <div class="search">
  				<!-- searchform -->
				<?php echo $search; ?>
				<!-- / searchform -->
            </div>
<!--search-->
            
            <br clear="all" />
            
        </div><!--left-->
        

	<?php echo $header_nav; ?>
    </div><!--topheader-->
    
    
    <div class="header">
    	<ul class="headermenu">
			<?php nav::header_tabs($this_page); ?>        
		</ul>
        
        <div class="headerwidget">
        	
        </div><!--headerwidget-->
        
        
    </div><!--header-->
    
    <div class="vernav2 iconmenu">
    	<ul>
			<?php nav::main_tabs($this_page); ?>        
		</ul>
        <a class="togglemenu"></a>
        <br /><br />
    </div><!--leftmenu-->

