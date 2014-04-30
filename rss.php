<?php
/**
 * Template for an RSS feed.
 *
 * Create a page using this template, with a name of /feed/
 */
$rss = $modules->get("MarkupRSS");
$rss->title = $rss->title ? $rss->title : $pages->get('/settings')->site_name . ' RSS Feed';
$rss->itemDescriptionField = 'summary|body';
$rss->itemDescriptionLength = $rss->itemDescriptionLength ? $rss->itemDescriptionLength : 10;

$items = $pages->find("limit=10, sort=-modified");

$rss->render($items);
