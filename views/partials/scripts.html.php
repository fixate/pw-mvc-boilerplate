<?php
/**
 * Partial for outputting scripts to footer.inc.php
 *
 * @package FixateProcesswire
 * @since Theme_Name 1.0
 */
?>
<?php if ($env->is_production && isset($env->ga_uacode)): ?>
	<?= $this->partial("google-analytics") ?>;
<?php endif ?>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="<?= $this->assets('js/vendor/jquery-1.10.2.min.js') ?>">\x3C/script>')</script>
<?php if (isset($loadGmaps) && $loadGmaps): ?>
<script src="https://maps.googleapis.com/maps/api/js?key=<?= $env->gm_api_key ?>&amp;sensor=false"></script>
<script src="//google-maps-utility-library-v3.googlecode.com/svn/trunk/infobox/src/infobox.js"></script>
<?php endif ?>

<?php if (is_array($extraScripts)) foreach ($extraScripts as $script): ?>
<script src="<?= $this->assets("js/${script}") ?>"></script>
<?php endforeach ?>
<script type="text/javascript" src="<?= $this->assets('js/main.js') ?>"></script>
