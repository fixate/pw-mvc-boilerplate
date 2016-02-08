<?php

use fixate as f8;

/**
 * Base Controller.
 */
abstract class controller implements IController
{
    public $config = null;
    public $fields = null;
    public $input = null;
    public $page = null;
    public $pages = null;
    public $permissions = null;
    public $roles = null;
    public $sanitizer = null;
    public $session = null;
    public $templates = null;
    public $user = null;
    public $users = null;

    private $view_vars = array();

    protected $view = null;
    protected $response = null;
    protected $request = null;
    protected static $fallback = null;

    public function __construct(&$config, &$fields, &$input, &$page, &$pages, &$permissions, &$roles, &$sanitizer, &$session, &$templates, &$user, &$users)
    {
        $this->config = $config;
        $this->fields = $fields;
        $this->input = $input;
        $this->page = $page;
        $this->pages = $pages;
        $this->permissions = $permissions;
        $this->roles = $roles;
        $this->sanitizer = $sanitizer;
        $this->session = $session;
        $this->templates = $templates;
        $this->user = $user;
        $this->users = $users;

        $this->initialize();
    }

    public function initialize()
    { /* override if required */
    }

    public function render($view_name = null, $data = null)
    {
        if ($view_name && is_array($view_name)) {
            $data = $view_name;
            $view_name = null;
        }

        if (!isset($view_name)) {
            $view_name = $this->get_implicit_view_name();
        } else {
            $view_name = self::clean_template($view_name);
        }

        return $this->view = $this->load_view($view_name, $data);
    }

    // Do nothing - override if required
    public function before()
    {
    }
    public function after()
    {
    }

    public function get_view_vars($name = null)
    {
        if ($name === null) {
            return $this->view_vars;
        }

        return $this->view_vars[$name];
    }

    public function call()
    {
        $this->request = f8\HttpRequest::instance();
        $this->response = new f8\HttpResponse();
        $input = wire('input');

        $url_segments = '';
        $has_segment = true;
        $i = 1;

        while ($has_segment) {
            $seg = $input->urlSegment($i);

            if (!empty($seg)) {
                $url_segments .= ' '.$seg;
                ++$i;
            } else {
                $has_segment = false;
            }
        }

        $func = 'page_'.f8\Strings::snake_case($this->page->name.$url_segments);
        if (!method_exists($this, $func)) {
            $func = 'index';
        }

        $ret = $this->$func();

        if ($ret instanceof IView) {
            $this->response->set_body($ret->render());
        }

        return $this->response;
    }

    public function helper($func)
    {
        if (!is_callable($func)) {
            $func = array($this, $func);
        }

        View::add_helper($func);
    }

    // Protected functions
    protected function get_implicit_view_name()
    {
        $view_name = f8\Strings::snake_case(get_class($this));

        return f8\Strings::rchomp($view_name, '_controller');
    }

    protected function load_view($view_name, $data)
    {
        $view = new View($this, $view_name);

        $view->set_layout(isset($this->layout) ? $this->layout : 'application');

        $view->set_base_path(f8\Paths::join($this->config->paths->templates, 'views'));
        $view->set_asset_uri(f8\Paths::join($this->config->urls->templates, 'assets'));
        if ($this->view_vars) {
            $view->add_data($this->view_vars);
        }
        $view->add_data($data);

        return $view;
    }

    protected function setting($name)
    {
        static $settings = null;
        if ($settings == null) {
            $settings = wire('pages')->get('/settings/');
        }

        return $settings->$name;
    }

    public function add_view_vars($key, $value = null)
    {
        if (is_array($key)) {
            $vars = $key;
        } else {
            $vars = array($key => $value);
        }

        $this->view_vars = array_merge($this->view_vars, $vars);

        return $this;
    }

    public static function clean_template($template)
    {
        return str_replace('-', '_', $template);
    }

    public static function set_fallback($controller)
    {
        self::$fallback = $controller;
    }

    public static function dynamic_load($app)
    {
        $config = $app->config;
        $fields = $app->fields;
        $input = $app->input;
        $page = $app->page;
        $pages = $app->pages;
        $permissions = $app->permissions;
        $roles = $app->roles;
        $sanitizer = $app->sanitizer;
        $session = $app->session;
        $templates = $app->templates;
        $user = $app->user;
        $users = $app->users;

        if (!$page->template) {
            return false;
        }

        $template = self::clean_template((string) $page->template);

        $path_args = array($config->paths->templates, 'controllers');
        // Ajax requests - load controller from api path
        if ($config->ajax) {
            $path_args[] = 'api';
        }
        $path_args[] = "{$template}_controller.php";
        $controller_path = call_user_func_array('fixate\Paths::join', $path_args);

        $controller = f8\Strings::camel_case($template).'Controller';

        if (file_exists($controller_path)) {
            require_once $controller_path;
        } elseif (isset(self::$fallback)) {
            $controller = self::$fallback;
        } else {
            trigger_error("No controller defined for template '{$template}'", E_USER_ERROR);

            return false;
        }

        // Instantiate controller class
        return new $controller($config, $fields, $input, $page, $pages, $permissions, $roles, $sanitizer, $session, $templates, $user, $users);
    }
}
