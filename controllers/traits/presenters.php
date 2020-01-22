<?php

trait Presenters
{
  public static function __presenterInitialize(ApplicationController $controller)
  {
    if (is_dir(TEMPLATE_DIR . 'presenters')) {
      require TEMPLATE_DIR . 'lib/Presenter.php';
      \fixate\Php::require_all(TEMPLATE_DIR . 'presenters/');

      $controller->helper('create_presenter');
    }
  }

  public function create_presenter(View $view, $context, $options = array())
  {
    if (is_object($context)) {
      $type_prefix = get_class($context);
    } elseif (!isset($options['presenter_name'])) {
      throw new InvalidArgumentException("Must supply presenter class name in 'presenter_name' key when presenting non-objects.");
    }

    $class = isset($options['presenter_name']) ? $options['presenter_name'] : "{$type_prefix}Presenter";

    return new $class($this, $view, $context, $options);
  }
}
