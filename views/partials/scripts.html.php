<?php
/**
 * Partial for outputting scripts to footer.inc.php
 *
 * @package Processwire
 */

// add main.bundle.js last so that it renders last
$this->js_add_script('main.bundle.js');
?>

<?= $this->render_scripts() ?>
