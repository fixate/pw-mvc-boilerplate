<?php
use fixate as f8;

/*------------------------------------*\
	USER ENVIRONMENT
\*------------------------------------*/
$ga_uacode = $pages->get('/settings')->ga_uacode ? $pages->get('/settings')->ga_uacode : false;
$ga_wmt_meta = $pages->get('/settings')->ga_wmt_meta ? $pages->get('/settings')->ga_wmt_meta : false;

$environment = array(
	// 'env' => 'production',

	// Google analytics
	'ga_uacode' => $ga_uacode,
	'ga_wmt_meta' => $ga_wmt_meta,
	// Asset Manifest
	'use_manifest' => true
);

?>
