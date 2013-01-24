<div id="tools-content">
   	<div class="pageheader">
		<h1 class="pagetitle"><?php echo Kohana::lang('uchaguzi.tools'); ?></h1>
		<ul class="hornav">
			<?php echo admin::tools_nav($this_page);?>
		</ul>
		<nav id="tools-menu">
			<ul class="second-level-menu">
				<?php admin::manage_subtabs("publiclisting"); ?>
			</ul>
		</nav>
	</div>
	
	<div class="page-content cf">
		<div class="table-tabs">
			<iframe src ="https://tracker.ushahidi.com/list/manage.php?id=<?php echo $encoded_stat_id; ?>&key=<?php echo $encoded_stat_key; ?>" width="100%" height="700" border="0" style="border:0px;">
			<p>Error: Your browser does not support iframes.</p>
			</iframe>
		</div>
	</div>	
</div>
