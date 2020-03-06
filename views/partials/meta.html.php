<?php

/**
 * Page head.
 */
?>

<head>
  <meta charset="utf-8">
  <link rel="dns-prefetch" href="//ajax.googleapis.com" />

  <title><?= $seo_title; ?></title>
  <?= $seo_desc; ?>
  <?= $seo_noindex; ?>
  <?= $this->seo_rel_next_prev() ?>

  <?php // enable responsive behaviour for all devices
  ?>
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <?php // prevent iOS Safari from styling telephone numbers
  ?>
  <meta name="format-detection" content="telephone=no" />

  <?= $this->twitter_meta_tags() ?>
  <?= $this->opengraph_meta_tags() ?>

  <link rel="logo" type="image/svg" href="http://<?= $config->httpHost . $this->assets('img/logo.svg') ?>" />

  <link rel="stylesheet" type="text/css" href="<?= $this->assets('css/style.css') ?>" />

  <link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="/feed" />

  <?= $this->partial('analytics') ?>

  <script>
    document.querySelector('html').classList.remove('no-js');
  </script>
</head>
