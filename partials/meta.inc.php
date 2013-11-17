<?php
/**
 * Page head.
 *
 * Included via main.php
 *
 * @package ProcessWire
 * @since Theme_Name 1.0
 */
?>
<head>
  <meta charset="utf-8">
  <link rel="dns-prefetch" href="//ajax.googleapis.com" />

	<title><?= $seo_title; ?></title>
  <meta name="description" content="<?= $seo_desc; ?>" />

  <?php // enable responsive behaviour for all devices ?>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <?php // Windows 8 start screen tile ?>
  <meta name="msapplication-TileColor" content="#ffffff"/>
  <meta name="msapplication-TileImage" content="apple-touch-icon-152x152-precomposed.png"/>

  <link rel="SHORTCUT ICON" href="<?= $assets_uri; ?>/img/favicon.ico" type="image/x-icon" />
  <link rel="logo" type="image/svg" href="<?= $assets_uri; ?>/img/logo.svg"/>

  <!--[if ! lte IE 7]><!-->
	<link rel="stylesheet" type="text/css" href="<?= $assets_uri; ?>/css/style.css" />
  <!--<![endif]-->

  <link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="/feed" />

  <!--[if lte IE 7]>
  <link rel="stylesheet" href="http://universal-ie6-css.googlecode.com/files/ie6.1.1.css" media="screen, projection">
  <![endif]-->

  <!--[if lt IE 9]>
  <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->
</head>

