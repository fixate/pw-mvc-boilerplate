<?php
/**
 * Partial for outputting scripts to footer.inc.php
 *
 * @package FixateProcesswire
 * @since Theme_Name 1.0
 */
?>
<?php if ($env->is_production && $env->ga_uacode !== false): ?>
	<?= $this->partial("google-analytics") ?>
<?php endif ?>

<?= $this->render_scripts() ?>
