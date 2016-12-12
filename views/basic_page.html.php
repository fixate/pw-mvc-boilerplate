<?php
/**
 * Make sure to set 'Alternate Template' to 'mvc' under 'Files' of the template settings
 *
 * @package ProcessWire
 */
?>
<h1><?= $page->get('title'); ?></h1>

<?= $page->body; ?>

<?php // foreach ($page->[your_repeater] as &$[your_repeater]): ?>
  <?php // echo $this->partial('repeater/[your_repeater]', compact('[your_repeater]')) ?>
<?php // endforeach ?>
