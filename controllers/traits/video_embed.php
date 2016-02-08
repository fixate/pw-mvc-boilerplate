<?php

require_once TEMPLATE_DIR.'/lib/VideoEmbedder.php';

trait VideoEmbed
{
    public static function __vidembedInitialize($obj)
    {
        $obj->helper('video_embed');
    }
    /**
     * Embed code for videos.
     * Supports:
     *  - Youtube: converts video links to embed links.
     */
    public function video_embed($url, $options = array())
    {
        if (!$url) {
            return '';
        }

        $options = array_merge(array(
            'width' => 560,
            'height' => 315,
            'allowfullscreen' => true,
        ), $options);

        $embedder = Embedder::factory($url);
        if ($embedder == null) {
            return $url;
        }

        return $embedder->code($options);
    }
}
