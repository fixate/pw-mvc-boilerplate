<?php
/**
 * Basic page template
 *
 * This site uses the delegate approach:
 * http://processwire.com/talk/topic/740-a-different-way-of-using-templates-delegate-approach/
 *
 * Make sure to set 'Alternate Template' to 'mvc' under Template Settings
 *
 * @package ProcessWire
 */
?>
<h1><?= $page->get("headline|title"); ?></h1>

<?= $page->body; ?>

<?php // foreach ($page->[your_repeater] as &$[your_repeater]): ?>
	<?php // echo $this->partial('repeater/[your_repeater]', compact('[your_repeater]')) ?>
<?php // endforeach ?>
