<?php
/**
 * Partial for outputting scripts to footer.inc.php
 *
 * @package Processwire
 */

// add built.js last so that it renders last
$this->js_add_script('built');
?>

<?= $this->render_scripts() ?>
