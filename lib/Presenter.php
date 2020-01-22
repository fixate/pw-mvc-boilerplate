<?php

class Presenter
{
  protected $controller;
  protected $context;
  protected $options;

  public function __construct(ApplicationController $controller, View $view, $context, $options = array())
  {
    $this->controller = $controller;
    $this->view = $view;
    /**
     * The context presenter is passed when created, e.g. a page, page array, etc.
     */
    $this->context = $context;
    $this->options = $options;

    $this->initialize();
  }

  # @override
  protected function initialize()
  {
  }
}
