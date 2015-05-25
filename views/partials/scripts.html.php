<?php
/**
 * Partial for outputting scripts to footer.inc.php
 *
 * @package Processwire
 */

// add built.js last so that it renders last
$this->js_add_script('main');
?>

<?= $this->render_scripts() ?>
