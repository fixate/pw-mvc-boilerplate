<?php
/**
 * Google Analytics tracking code. Optimised asynchronous snippet as per:
 * http://mathiasbynens.be/notes/async-analytics-snippet
 *
 * Add your Google Analytics UACode in templates/config/environment.php
 *
 * @package ProcessWire
 */
?>
<?php if ($env->is_production && $env->ga_uacode !== false): ?>
<script>
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', '<?= Environment::ga_uacode() ?>']);
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
<?php endif ?>
