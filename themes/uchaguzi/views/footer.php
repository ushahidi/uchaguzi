			</div>
		</div>
		<!-- / main body -->

	<footer id="global-footer" class="cf">
		<h1><a href="<?php echo url::site();?>"><?php echo $site_name; ?></a></h1>
		<?php if(isset($site_message) AND $site_message != '') { ?>
		<p><?php echo $site_message; ?></p>
		<?php } ?>
		<?php if ($site_copyright_statement != ''): ?>
		<p class="copyright"><?php echo $site_copyright_statement; ?></p>
		<?php endif; ?>
	</footer>
</body>
</html>