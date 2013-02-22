<div id="tools-content">    
	<div class="pageheader">
		<h1 class="pagetitle">Info</h1>
		<ul class="hornav">
			<li><?php uchaguzi::info_tabs($this_page); ?></li>
		</ul>
	</div>
        
<!--	<h1 class="sub-category"><?php echo $page_title; ?></h1>-->

	<div class="page-content">
		<div class="table-tabs">
			<?php 
			echo htmlspecialchars_decode($page_description);
			Event::run('ushahidi_action.page_extra', $page_id);
			?>
		</div>
	</div>
</div>