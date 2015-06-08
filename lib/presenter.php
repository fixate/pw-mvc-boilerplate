<?php

class Presenter {
  protected $controller;
  protected $object;
  protected $options;

  function __construct($controller, $view, $object, $options = array()) {
    $this->controller = $controller;
    $this->view = $view;
    $this->object = $object;
    $this->options = $options;

    $this->initialize();
  }

  # @override
  protected function initialize() {}
}
