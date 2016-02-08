<?php

use fixate as f8;

abstract class ApiController implements IController
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

    protected $request = null;
    protected $response = null;

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
    }

    public function call()
    {
        $req = $this->request = f8\HttpRequest::instance();
        $this->response = new f8\HttpResponse();
        $method = strtolower($req->method());
        $ret = null;

        try {
            if (method_exists($this, $method)) {
                $ret = $this->$method();

                // Just die on redirect
                if ($this->response->is_redirect()) {
                    die();
                }

                // Body set, just return the response
                $body = $this->response->body();
                if (!empty($body)) {
                    return $this->response;
                }

                // Set created status on sucessfull post
                if ($method == 'post' && $ret && $this->response->status() == 0) {
                    $this->response->set_status(201); // CREATED
                }
            } elseif (method_exists($this, 'all')) {
                $ret = $this->all();
            } elseif ($method == 'get') {
                $ret = $this->page_data();
            } else {
                throw new f8\HttpException(405, "Method '$method' not allowed for resource.");
            }
        } catch (f8\HttpException $ex) {
            $this->response->set_status($ex->getStatusCode());
            $this->response->set_header('Allow', implode(', ', $this->get_allowed()));
            $this->response->set_body(json_encode(array('error' => $ex->getMessage())));
        } catch (Exception $ex) {
            $this->response->set_status(500);
            $this->response->set_body(json_encode(array('error' => $ex->getMessage())));

            return $this->response;
        }

        // Set NO CONTENT on blank responses
        $body = $this->response->body();
        if (!$ret && empty($body)) {
            if ($this->response->status() == 0) {
                $this->response->set_status(204); // No content
            }

            return $this->response;
        }

        if ($ret) {
            // Serialize to JSON
            if (is_array($ret) || is_object($ret)) {
                $this->response->set_header('Content-Type', 'application/json');
                $this->response->set_body(json_encode($ret));
            } elseif (is_string($ret)) {
                if (f8\Strings::starts_with(trim($ret), '<') && f8\Strings::ends_with(trim($ret), '>')) {
                    $this->response->set_header('Content-Type', 'text/html');
                } else {
                    $this->response->set_header('Content-Type', 'text/plain');
                }
                $this->response->set_body($ret);
            }
        }

        return $this->response;
    }

    // Do nothing - override if required
    public function before()
    {
    }
    public function after()
    {
    }

    public function helper($func)
    {
        if (!is_callable($func)) {
            $func = array($this, $func);
        }

        View::add_helper($func);
    }

    // Get user settings
    protected function setting($name)
    {
        static $settings = null;
        if ($settings == null) {
            $settings = wire('pages')->get('/settings/');
        }

        return $settings->$name;
    }

    // Get rendered partial
    protected function partial($name, $data = array())
    {
        return $this->get_view()->partial($name, $data);
    }

    protected function get_view()
    {
        if (isset($this->view)) {
            return $this->view;
        }

        $view = new View($this);
        $view->set_base_path(f8\Paths::join($this->config->paths->templates, 'views'));
        $view->set_asset_uri(f8\Paths::join($this->config->urls->templates, 'assets'));

        return $this->view = $view;
    }

    protected function get_allowed()
    {
        return array_filter(f8\HttpRequest::$http_methods, function ($m) {
            return $m == 'GET' || method_exists($this, strtolower($m));
        });
    }

    protected function param($name)
    {
        if (!$this->request) {
            return;
        }

        return $this->request->param($name);
    }

    protected function page_data()
    {
        $fields = func_get_args();
        $page = &$this->page;
        $outputFormatting = $page->outputFormatting;
        $page->setOutputFormatting(false);

        if (empty($fields)) {
            $fields = array(
                'id', 'parent_id', 'templates_id', 'name', 'status', 'sort',
                'sortfield', 'numChildren', 'template', 'parent', 'data',
            );
        }

        $data = array();
        $has_data_field = false;
        foreach ($fields as $f) {
            switch ($f) {
            case 'data':
                $has_data_field = true;
                break;
            case 'template':
                $data['template'] = $page->template->name;
                break;
            case 'parent':
                $data['parent'] = $page->template->path;
                break;
            default:
                $data[$f] = $page->$f;
            }
        }

        if ($has_data_field) {
            $data['data'] = array();
            foreach ($page->template->fieldgroup as $field) {
                if ($field->type instanceof FieldtypeFieldsetOpen) {
                    continue;
                }

                $value = $page->get($field->name);
                $data['data'][$field->name] = $field->type->sleepValue($page, $field, $value);
            }
        }

        $page->setOutputFormatting($outputFormatting);

        return $data;
    }
}
