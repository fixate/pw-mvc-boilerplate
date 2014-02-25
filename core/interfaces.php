<?php

interface IController {
	function call();

	function before();
	function after();
}

interface IView {
	// Called in View
	function spit();
	function partial($name);

	// Called in Base Controller
	function render();
}
