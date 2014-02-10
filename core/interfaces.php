<?php

interface IController {
	function call($req);

	function before();
	function after($resp);
}

interface IView {
	// Called in View
	function spit();
	function partial($name);

	// Called in Base Controller
	function render();
}
