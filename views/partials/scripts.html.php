<?php
/**
 * Partial for outputting scripts to footer.inc.php
 *
 * @package Processwire
 */

// add main last so that it renders last
$this->js_add_script('main');
?>

<?= $this->partial("google_analytics") ?>

<?= $this->render_scripts() ?>
