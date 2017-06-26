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
      // available as $foo in home.html.php
      // [
      //   'foo' => 'bar',
      // ]
    );
  }
}
