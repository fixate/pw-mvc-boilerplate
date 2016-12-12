<?php
/**
 * Home Controller.
 *
 * Fields and functions specific to the home template.
 */
class HomeController extends ApplicationController
{
    public function index()
    {
        return $this->render(
            // array(
            //   'extraScripts' => 'your-script.js',
            // )
        );
    }
}
