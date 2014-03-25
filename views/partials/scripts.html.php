<?php
/**
 * Partial for outputting scripts to footer.inc.php
 *
 * @package Processwire
 */

// add main last so that it renders last
$this->js_add_script('main');
?>

<?php if ($env->is_production && $env->ga_uacode !== false): ?>
	<?= $this->partial("google-analytics") ?>
<?php endif ?>

<?= $this->render_scripts() ?>
