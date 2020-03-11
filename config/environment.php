<?php


/*------------------------------------*\
    USER ENVIRONMENT
\*------------------------------------*/
$gtm_container_id = $pages->get('/settings')->gtm_container_id;
$ga_uacode = $pages->get('/settings')->ga_uacode;
$ga_wmt_meta = $pages->get('/settings')->ga_wmt_meta;

$environment = array(
  // 'env' => 'production',

  // Google analytics
  'gtm_container_id' => $gtm_container_id,
  'ga_uacode' => $ga_uacode,
  'ga_wmt_meta' => $ga_wmt_meta,
  // Asset Manifest
  'use_manifest' => true,
);
