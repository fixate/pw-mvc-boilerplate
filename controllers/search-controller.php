<?php
/**
 * Search Controller
 *
 * Fields and functions specific to the search template.
 *
 * @package ProcessWire
 * @since Theme_Name 1.0
 */
/*------------------------------------*\
  $FIELDS
\*------------------------------------*/





/*------------------------------------*\
  $VARIABLES
\*------------------------------------*/
$query = $sanitizer->selectorValue($input->get->q);
$matches = $pages->find("title|body~=$query, limit=50");
$count = count($matches);
$results = ($count === 1 ) ? $count . ' result' : $count . ' results';





/*------------------------------------*\
  $FUNCTIONS
\*------------------------------------*/
/**
 * Add query to whitelist to be output on search form
 */
$input->whitelist('q', $query);
