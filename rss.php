<?php
/**
 * Template for an RSS feed.
 *
 * Create a page using this template, with a name of /feed/
 */
$rss = $modules->get("MarkupRSS");
$items = $pages->find("limit=10, sort=-modified");

$rss->render($items);
