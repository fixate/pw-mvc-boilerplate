<?php
/**
 * Include for site's header section.
 *
 * This partial is included via main.php
 *
 * @package ProcessWire
 */
?>
<header class="area-header" role="banner">
  <div class="wrap">

    <a class="logo" href="<?= $config->urls->root; ?>">
      <svg width="100" height="100">
        <image xlink:href="<?= $config->urls->templates; ?>assets/img/logo.svg" src="<?= $config->urls->templates; ?>assets/img/logo.png" width="100" height="100" />
      </svg>
    </a>

    <?php // allow screenreaders to skip navigation ?>
    <a class="visuallyhidden" href="#main">skip navigation and go to main content</a>

    <?php // get primary nav ?>
    <?= $this->partial('nav_primary') ?>

    <?php // get search form ?>
    <?= $this->partial('search_form') ?>

  </div>
</header>
