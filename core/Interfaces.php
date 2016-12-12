<?php

interface IController
{
    public function call();

    public function before();
    public function after();
}

interface IView
{
    // Called in View
    public function spit();
    public function partial($name);

    // Called in Base Controller
    public function render();
}
