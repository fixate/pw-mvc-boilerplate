<?php

class environment
{
    // String representing current environment (development, production etc)
    public $env = [];

    public static function get_instance()
    {
        static $instance = null;
        if ($instance == null) {
            $instance = new static();
        }

        return $instance;
    }

    public function set_env($env)
    {
        $this->env['env'] = $env;
        $this->env['is_production'] = ($env == 'production');
        $this->env['is_development'] = !$this->is_production;
    }

    public function set($k, $v = null)
    {
        if (is_array($k)) {
            $this->env = array_merge($this->env, $k);
        } else {
            $this->env[$k] = $v;
        }

        $this->set_env($this->env['env']);
    }

    public function unset_key($k)
    {
        unset($this->env[$k]);
    }

    public function has($key)
    {
        return array_key_exists($key, $this->env);
    }

    // Support getting environment singleton with static method calls
    public static function __callStatic($method, $args)
    {
        if (method_exists(__CLASS__, $method)) {
            return call_user_func_array(array(self, $method), $args);
        }

        $instance = static::get_instance();

        if ($instance->has($method)) {
            return $instance->$method;
        }

        trigger_error("No such method for Environment::{$method}.", E_ERROR);
    }

    public function __set($name, $value)
    {
        $this->env[$name] = $value;
    }

    public function __get($name)
    {
        if (array_key_exists($name, $this->env)) {
            return $this->env[$name];
        }

        return;
    }

    private function __clone()
    {
        trigger_error('Clone disabled for singleton class.', E_ERROR);
    }
}
