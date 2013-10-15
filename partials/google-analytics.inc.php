<?php
/**
 * Add Google Analytics to footer
 *
 * @since Theme_Name 1.0
 */

if (defined('PW_LOCAL_DEV') && PW_LOCAL_DEV !== true && GA_UACODE !== false): ?>

<script>
	var _gaq = _gaq || [];
	_gaq.push(['_setAccount', '<?= GA_UACODE; ?>']);
	_gaq.push(['_trackPageview']);
	(function() {
		var ga = document.createElement('script');
		ga.type = 'text/javascript';
		ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script')[0];
		s.parentNode.insertBefore(ga, s);
	})();
</script>

<?php endif;
