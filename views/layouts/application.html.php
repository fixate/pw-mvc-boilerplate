<?php
/**
 * Base template for delegating which view to use to render content.
 *
 * This template should be set as the alternate template for all templates. Each
 * template view must match the template name.
 *
 * Information on using the delegate approach can be found here:
 * http://processwire.com/talk/topic/740-a-different-way-of-using-templates-delegate-approach/
 *
 * @package ProcessWire
 * @since Theme_Name 1.0
 */
?>
<!doctype html>
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="<?= __('en', 'theme_text_domain'); ?>"> <![endif]-->
<!--[if IE 9]>    <html class="no-js ie9 oldie" lang="<?= __('en', 'theme_text_domain'); ?>"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js" lang="<?= __('en', 'theme_text_domain'); ?>"> <!--<![endif]-->
<?= $this->partial('meta') ?>
<body>
	<?= $this->partial('edit-page') ?>
	<?= $this->partial('header') ?>

	<?= $this->primary_nav() ?>

	<div class="area-content">
		<div id="main" class="wrap" role="main">

			<h1><?= $page->get("headline|title"); ?></h1>

			<?php $this->yield(); ?>

		</div><!-- #main -->
	</div><!-- .area-content -->

	<?= $this->partial('footer') ?>
</body>
</html>
