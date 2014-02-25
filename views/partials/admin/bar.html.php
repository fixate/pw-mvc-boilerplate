<?php
/**
 * Partial for page edit links. This link is only available to logged in users.
 *
 * This partial is included via main.php
 *
 * @package ProcessWire
 */

if ($page->editable()) : ?>
<div style="background-color: #2d2d2d; text-align: right; padding: .5em 1em;">
  <a class='nav' id='editpage' href="<?= $config->urls->admin; ?>page/edit/?id=<?= $page->id; ?>">Edit</a>
</div>
<?php endif;
