<?php

use fixate as f8;

class ViewException extends Exception
{
}

class View implements IView
{
    protected static $helpers = array();
    protected $layout = '';
    protected $data = array();
    protected $base_path = null;
    public $controller = null;

    public function __construct(IController &$controller, $name = '')
    {
        $this->controller = $controller;
        $this->name = $name;
    }

    // Spit out the page
    public function spit()
    {
        if (!empty($this->name)) {
            echo $this->render_file($this->name);
        }
    }

    public function partial($name, $data = array())
    {
        return $this->render_file(f8\Paths::join('partials', $name), $data);
    }

    public function assets($path, $use_min = true)
    {
        $is_production = Environment::is_production();
        if ($is_production) {
            // If use MD5# manifest in use get proper path
            if (Environment::use_manifest()) {
                $path = Manifest::prod_path($path);
            }
        }

        if ($use_min) {
            $ext = f8\Paths::get_extension($path);
            // Only css and js
            if ($ext == 'js' || $ext == 'css') {
                $is_min = f8\Strings::ends_with($path, ".min.${ext}") !== false;

                // If in production change file to use .min extension
                if ($is_production && !$is_min && $use_min) {
                    $path = f8\Paths::change_extension($path, "min.{$ext}");
                }
            }
        }

        $templates = $this->controller->config->urls->templates;

        return f8\Paths::join($templates, 'assets', $path);
    }

    public function set_layout($name)
    {
        $this->layout = $name;

        return $this;
    }

    public function add_data($data)
    {
        if ($data) {
            $this->data = array_merge($this->data, $data);
        }

        return $this;
    }

    public function set_asset_uri($uri)
    {
        $this->assets_uri = $uri;

        return $this;
    }

    public function set_base_path($path)
    {
        $this->base_path = $path;

        return $this;
    }

    public function render()
    {
        if (!isset($this->layout)) {
            return '';
        }

        return $this->render_file("layouts/{$this->layout}");
    }

    public function view_exists($file)
    {
        return file_exists($this->resolve_view_path($file));
    }

    public function partial_exists($file)
    {
        return $this->view_exists(f8\Paths::join('partials', $file));
    }

    protected function resolve_view_path($file)
    {
        if (!($base_path = $this->base_path)) {
            $base_path = f8\Paths::resolve(f8\Paths::join(dirname(__FILE__), '../views'));
        }

        $path = f8\Paths::join($base_path, $file);
        if (!f8\Strings::ends_with($path, '.html.php')) {
            $path .= '.html.php';
        }

        return $path;
    }

    protected function render_file($file, $_data = array(), $fallback = null)
    {
        if (!isset($this->data)) {
            $this->data = array();
        }

        $_path = $this->resolve_view_path($file);

        $view = $this;

        $config = $this->controller->config;
        $fields = $this->controller->fields;
        $input = $this->controller->input;
        $page = $this->controller->page;
        $pages = $this->controller->pages;
        $permissions = $this->controller->permissions;
        $roles = $this->controller->roles;
        $sanitizer = $this->controller->sanitizer;
        $session = $this->controller->session;
        $templates = $this->controller->templates;
        $user = $this->controller->user;
        $users = $this->controller->users;

        $env = Environment::get_instance();
        extract(array_merge($this->data, $_data));

        ob_start();
        try {
            if (!file_exists($_path)) {
                if (is_callable($fallback)) {
                    echo $fallback($this);
                } else {
                    throw new ViewException("View file {$file}.html.php does not exist.");
                }
            } else {
                include $_path;
            }
        } catch (Exception $ex) {
            return ob_get_clean().'ERROR in View: '.$ex->getMessage();
        }

        return ob_get_clean();
    }

    public function __call($method, $args)
    {
        if (property_exists(__CLASS__, $method) && is_callable($method)) {
            return call_user_func_array(array($this, $method), $args);
        } else {
            if (in_array($method, array_keys(self::$helpers))) {
                $method = self::$helpers[$method];
                if (!is_callable($method)) {
                    if (is_array($method) && count($method) >= 2) {
                        $method = $method[1];
                    }

                    throw new ViewException("Method '{$method}' not found.");
                }

                if (is_array($method)) {
                    return call_user_func_array($method, $args);
                } else {
                    return call_user_func($method, $args);
                }
            } else {
                throw new ViewException("Method '{$method}' not found.");
            }
        }
    }

    public static function add_helper($func)
    {
        if (is_array($func)) {
            $func_name = $func[1];
        } elseif (is_string($func)) {
            $func_name = $func;
        } else {
            $func_name = (string) $func;
        }

        self::$helpers[$func_name] = $func;
    }
}

