<?php
use fixate as f8;

/*------------------------------------*\
	USER ENVIRONMENT
\*------------------------------------*/
$ga_uacode = $pages->get('/settings')->ga_uacode ? $pages->get('/settings')->ga_uacode : false;

$environment = array(
	'env' => 'production',

	// Google analytics
	'ga_uacode' => $ga_uacode,
	// Asset Manifest
	'use_manifest' => true
);

?>
