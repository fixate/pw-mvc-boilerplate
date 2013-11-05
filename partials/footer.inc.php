<?php
/**
 * Partial for site footer
 *
 * This partial is included via main.php
 *
 * @package ProcessWire
 * @since Theme_Name 1.0
 */
 ?>
<div class="area-footer">
  <div class="wrap">

    <div>
      &copy; <?php echo date('Y'); ?> Powered by <a href="http://processwire.com">ProcessWire</a>
    </div>

  </div>
</div>

<?php

// If the page is editable, then output a link that takes us straight to the page edit screen:
if($page->editable()) {
  echo "<a class='nav' id='editpage' href='{$config->urls->admin}page/edit/?id={$page->id}'>Edit</a>";
}

?>

<?php include('./partials/scripts.inc.php');
