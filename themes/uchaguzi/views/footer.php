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

	<script type="text/javascript">

	  var _gaq = _gaq || [];
	  _gaq.push(['_setAccount', 'UA-12063676-17']);
	  _gaq.push(['_setDomainName', 'www.uchaguzi.co.ke']);
	  _gaq.push(['_setAllowLinker', true]);
	  _gaq.push(['_trackPageview']);

	  (function() {
	    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	  })();

	</script>
</body>
</html>