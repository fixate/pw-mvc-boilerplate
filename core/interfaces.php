<?php

interface IController {
	function render($view_name = null, $data = array());
	function call();

	// User page entry point
	function index();
}

interface IView {
	// Called in View
	function spit();
	function partial($name);

	// Called in Base Controller
	function render();
}
