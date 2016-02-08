<?php

namespace fixate;

/**
 * Provides a HttpResponse object.
 *
 * ProcessWire 2.x
 * Copyright (C) 2011 by Stan Bondi
 * Licensed under GNU/GPL v2, see LICENSE.TXT
 *
 * http://www.processwire.com
 * http://www.fixate.it
 */
class http_response
{
    protected $status = 0;
    protected $body = '';
    protected $headers = array();

    public function __construct()
    {
        $this->headers = headers_list();
    }

    public function set_header($name, $value)
    {
        $this->headers[$name] = $value;
        header("$name: $value");
    }

    public function set_status($code)
    {
        $this->status = $code;
        http_response_code($code);
    }

    public function set_body($body)
    {
        $this->body = $body;
    }

    public function body()
    {
        return $this->body;
    }

    public function status()
    {
        return $this->status;
    }

    public function redirect($to, $status = 301)
    {
        $this->set_status($status);
        $this->set_header('Location', $to);
    }

    public function is_redirect()
    {
        return $this->status == 301 || $this->status == 302;
    }

    public function header($name)
    {
        return $this->headers[$name];
    }
}
