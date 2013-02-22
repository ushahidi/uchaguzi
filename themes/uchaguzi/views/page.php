<div id="primary-content" class="col_6">
	<h1 class="sub-category"><?php echo $page_title ?></h1>
	<div class="page_text">
	<?php 
	echo htmlspecialchars_decode($page_description);
	Event::run('ushahidi_action.page_extra', $page_id);
	?>
	</div>
</div>
