<div id="primary-content" class="col_6">
	<!-- green-box -->
	<div class="green-box">
		<h2><?php echo Kohana::lang('ui_main.reports_submitted');?></h2>

		<div class="thanks_msg">
			<p><a href="<?php echo
			url::site().'reports' ?>"><?php echo Kohana::lang('ui_main.reports_return');?></a></p>	
		</div>
	</div>
</div>

<div id="filters" class="col_4">
	<h3><?php echo Kohana::lang('ui_main.feedback_reports');?></h3>
	<?php 
	print form::open('http://feedback.ushahidi.com/fillsurvey.php?sid=2', array('target'=>'_blank'));
	print form::hidden('alert_code', $_SERVER['SERVER_NAME']);
	print form::submit('button', Kohana::lang('ui_main.feedback'), ' class=btn_gray ');
	print form::close();
	?>
</div>