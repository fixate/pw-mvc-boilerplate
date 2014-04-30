<?php
/**
 * Template for an RSS feed.
 *
 * Create a page using this template, with a name of /feed/
 */
$rss = $modules->get("MarkupRSS");
$rss->title = $rss->title ? $rss->title : $pages->get('/settings')->site_name . ' RSS Feed';
$rss->itemDescriptionField = 'summary|body';
$rss->ttl = $rss->ttl ? $rss->ttl : 60;

$items = $pages->find("limit=10, sort=-modified")->not("path*=process-admin");

$rss->render($items);
