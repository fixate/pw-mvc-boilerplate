<?php
/**
 * Partial for outputting scripts to footer.inc.php
 *
 * @package Processwire
 */
?>
<?php if ($env->is_production && $env->ga_uacode !== false): ?>
	<?= $this->partial("google-analytics") ?>
<?php endif ?>

<?= $this->render_scripts() ?>
