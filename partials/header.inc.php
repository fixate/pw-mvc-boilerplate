<?php
/**
 * Include for site's header section.
 *
 * This partial is included via main.php
 *
 * @package ProcessWire
 * @since Theme_Name 1.0
 */
?>
<header class="area-header" role="banner">

  <div class="wrap">

    <a class="logo" href="<?= $config->urls->root; ?>">
      <svg width="100" height="100">
        <image xlink:href="<?= $config->urls->templates; ?>assets/img/logo.svg" src="<?= $config->urls>templates; ?>assets/img/logo.png"  width="100" height="100" />
      </svg>
    </a>

    <?php // allow screenreaders to skip navigation ?>
    <a class="visuallyhidden" href="#main">skip navigation and go to main content</a>

    <?php // get primary nav ?>
    <?php include("./partials/nav-primary.inc.php"); ?>

    <?php // get search form ?>
    <?php include("./partials/search-form.inc.php"); ?>

  </div>

</header>
