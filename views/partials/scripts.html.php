<?php
/**
 * Partial for outputting scripts to footer.inc.php
 *
 * @package ProcessWire
 * @since Theme_Name 1.0
 */
?>
<?php if (Environment::is_production() && Environment::ga_uacode() !== false): ?>
	<?= $this->partial("google-analytics") ?>;
<?php endif ?>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="<?= $this->assets('js/vendor/jquery-1.10.2.min.js') ?>">\x3C/script>')</script>

<script src="<?= $this->assets('js/vendor/looper.min.js') ?>"></script>
<script type="text/javascript" src="<?= $this->assets('js/main.js') ?>"></script>
