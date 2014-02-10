<?php

use fixate as f8;

abstract class ApiController implements IController {
	function __construct(&$config, &$page) {
		$this->config = $config;
		$this->page = $page;
	}

	function call($req) {
		$this->set_request($req);

		$resp = new f8\HttpResponse();
		$method = strtolower($req->method());

		try {
			if (method_exists($this, $method)) {
				$ret = $this->$method($req, $resp);

        // Body set, just return the response
				$body = $resp->body();
        if (!empty($body)) {
          return $resp;
        }

        // Set created status on sucessfull post
				if ($method == 'post' && $ret && $resp->status() == 0) {
					$resp->set_status(201); // CREATED
				}
			} elseif (method_exists($this, 'all')) {
				$ret = $this->all($req, $resp);
			} elseif ($method == 'get') {
				$ret = $this->page_data();
			} else {
				throw new f8\HttpException(405, "Method '$method' not allowed for resource.");
			}

		} catch (f8\HttpException $ex) {
			$resp->set_status($ex->getStatusCode());
			$resp->set_header('Allow', implode(', ',$this->get_allowed()));
			$resp->set_body(json_encode(array('error' => $ex->getMessage())));
		} catch (Exception $ex) {
			$resp->set_status(500);
			$resp->set_body(json_encode(array('error' => $ex->getMessage())));
			return $resp;
		}

    // Set NO CONTENT on blank responses
		$body = $resp->body();
		if (!$ret && empty($body)) {
			if ($resp->status() == 0){
				$resp->set_status(204); // No content
			}
			return $resp;
		}

    if ($ret) {
      // Serialize to JSON
      if (is_array($ret) || is_object($ret)) {
        $resp->set_header('Content-Type', 'application/json');
        $resp->set_body(json_encode($ret));
      } else if (is_string($ret)) {
        if (f8\Strings::starts_with(trim($ret), '<') && f8\Strings::ends_with(trim($ret), '>')) {
          $resp->set_header('Content-Type', 'text/html');
        } else {
          $resp->set_header('Content-Type', 'text/plain');
        }
        $resp->set_body($ret);
      }
    }

		return $resp;
	}

	// Do nothing - override if required
	function before() {}
	function after($resp) {}

	// Get user settings
	protected function setting($name) {
		static $settings = null;
		if ($settings == null) {
			$settings = wire('pages')->get('/settings/');
		}

		return $settings->$name;
	}

  // Get rendered partial
  protected function partial($name, $data = array()) {
    $view = new View($this);
    return $view->partial($name, $data);
  }

	protected function get_allowed() {
		return array_filter(f8\HttpRequest::$http_methods, function($m) {
			return $m == 'GET' || method_exists($this, strtolower($m));
		});
	}

	protected function set_request($req) {
		$this->request = $req;
	}

	protected function param($name) {
		if (!$this->request) {
			return null;
		}

		return $this->request->param($name);
	}

	protected function page_data() {
		$fields = func_get_args();
		$page =& $this->page;
		$outputFormatting = $page->outputFormatting;
		$page->setOutputFormatting(false);

		if (empty($fields)) {
			$fields = array(
				'id', 'parent_id', 'templates_id', 'name', 'status', 'sort',
			 	'sortfield', 'numChildren', 'template', 'parent', 'data'
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
				if ($field->type instanceof FieldtypeFieldsetOpen) continue;

				$value = $page->get($field->name);
				$data['data'][$field->name] = $field->type->sleepValue($page, $field, $value);
			}
		}

		$page->setOutputFormatting($outputFormatting);

		return $data;
	}
}
