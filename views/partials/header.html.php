<?php
/**
 * Partial for site's header section.
 *
 * This partial is included via layouts/application.html.php
 */
?>
<header class="area-header">
  <div class="wrap">

    <a class="logo" href="<?= $config->urls->root; ?>">
        <img src="<?= $this->assets('img/logo.svg'); ?>" alt="" />
    </a>

    <?php // allow screenreaders to skip navigation ?>
    <a class="visuallyhidden" href="#main">skip navigation and go to main content</a>

    <?php // get primary menu ?>
    <?= $this->partial('menu_primary') ?>

    <?php // get search form ?>
    <?= $this->partial('search_form') ?>
  </div>
</header>
