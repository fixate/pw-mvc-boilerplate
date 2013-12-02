<?php
/**
 * Home Controller
 *
 * Fields and functions specific to the home template.
 *
 * @package ProcessWire
 */
class HomeController extends ApplicationController {
	function index() {
		return $this->render();
	}
}
