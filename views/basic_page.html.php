<?php
/**
 * Basic page template.
 *
 * Make sure to set 'Alternate Template' to 'mvc' under Template Settings
 */
?>
<h1><?= $page->get('title'); ?></h1>

<?= $page->body; ?>

<?php // foreach ($page->[your_repeater] as &$[your_repeater]): ?>
  <?php // echo $this->partial('repeater/[your_repeater]', compact('[your_repeater]')) ?>
<?php // endforeach ?>
