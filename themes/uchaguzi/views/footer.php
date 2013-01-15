			</div>
		</div>
		<!-- / main body -->

	</div>
	<!-- / wrapper -->

	<?php
	echo $footer_block;
	// Action::main_footer - Add items before the </body> tag
	Event::run('ushahidi_action.main_footer');
	?>
</body>
</html>
