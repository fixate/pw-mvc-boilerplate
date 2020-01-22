<?php

trait Presenters
{
    public static function __presenterInitialize($obj)
    {
        if (is_dir(TEMPLATE_DIR.'presenters')) {
            require TEMPLATE_DIR.'lib/Presenter.php';
            \fixate\Php::require_all(TEMPLATE_DIR.'presenters/');

            $obj->helper('new_presenter');
        }
    }

    public function new_presenter($view, $object, $options = array())
    {
        if (is_object($object)) {
            $type_prefix = get_class($object);
        } elseif (!isset($options['with'])) {
            throw new InvalidArgumentException("Must supply presenter class name in 'with' key when presenting non-objects.");
        }
    } elseif (!isset($options['presenter_name'])) {
      throw new InvalidArgumentException("Must supply presenter class name in 'presenter_name' key when presenting non-objects.");

    $class = isset($options['presenter_name']) ? $options['presenter_name'] : "{$type_prefix}Presenter";

        return new $class($this, $view, $object, $options);
    }
}
