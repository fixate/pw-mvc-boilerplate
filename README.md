# A Rails-inspired MVC boilerplate for ProcessWire

(Our [[wiki]] is under development, but already has more detailed information than this readme.)

A boilerplate for new ProcessWire projects (tested only with PHP 5.4.24). The MVC entrypoint is enabled for a template by using the [delegate approach](http://processwire.com/talk/topic/740-a-different-way-of-using-templates-delegate-approach/), so make sure to set all templates to use `mvc.php` as an alternate template by visiting:

```
Setup -> [template] -> Advanced -> Alternate Template Filename
```
in your admin.

## Purpose

Kickstart ProcessWire projects with a light-weight structure that reduces repetition, separates logic from markup, and logically organises your code for easier management.

## Features

- `html`, `body`, and structural markup is defined in a single template
- header, footer, and other global sections are defined once
- logic is abstracted from markup
- contains a working, and easy to understand contact form built through the API
- Rails-inspired MVC pattern
- Page-specific and fallback controller actions
- OpenGraph features

## Requirements

The boilerplate uses traits to separate concerns in the `ApplicationController`, as such it required `PHP 5.4`. If you would rather run on `PHP =< 5.3` you just need to remove the traits and inline the code into `ApplicationController`.

## Installation

Clone this repo into

```
site
├── templates
```

Move the contents of `!root` to the root of your site (.gitignore to your project root), and get cracking!

**NOTE:** ProcessWire creates its own .htaccess. The .htaccess in this repo extends the [H5BP .htaccess](https://github.com/h5bp/html5-boilerplate/blob/master/.htaccess) with the ProcessWire 2.3 .htaccess. You may override that .htaccess with this one.

## Usage

**IMPORTANT:** For all of your templates that you want to work through a `Controller` use the mvc.php template. To enable that set `Alternate Template Filename` to 'mvc' in the advanced tab of your template.

If you don't do this, processwire will look for site/[template_name].php. mvc.php is the entrypoint into the MVC framework.

There is no routing, you take care of that by making templates and pages in the ProcessWire admin.

#### Most Basic Controller

```php
class ContactController extends Controller {
	function index() {
		// Render views/contact.html.php
		return $this->render();
	}
}
```


#### More Complete Controller Example For The 'home' Template:

```php
// site/controllers/home_controller.php
// The name of the class matters! 'Home' in 'HomeController' matches up to
// a template named 'home' in the processwire admin.
class HomeController extends Controller {
  // Index will be executed by all pages using the Home template.
  // Except if a page-specific method is defined (see below)
  // This function MUST be defined in your template controller.
	function index() {
		// Render views/home.html.php
		return $this->render();
	}

	// Optional
	function before() { /* Will run before controller method */ }
	// Optional
	function after() { /* Will run after controller method */ }

	// Will execute for a page named foo-bar or foo_bar instead of index()
	// Also renders views/home.html.php
	function foo_bar() {
    $vars = array('defined' => 'only here!');
		// Optionally pass an array for variables that will be available in the view
		// e.g. <p>var = <?= $defined ?></p> <!-- only here! -->
		return $this->render($vars);
	}

	// Also a page specific method - demonstrating overriding of view name and layout
	function bar_baz() {
	  	// Override the implicit view and use views/foobar.html.php
	  	// Also sets the layout to views/layouts/alternative.html.php
		return $this->render('foobar', array('optional' => 'vars'))->set_layout('alternative');
	}

  // To set the layout globally to this controller, just define $layout
  protected $layout = 'alternative';
}
```

#### Views:

Basic layout: `views/layouts`

```php
<!-- views/layouts/application.html.php -->
<html>
<!-- This will process and output the file views/partials/my_partial.html.php -->
<?= $this->partial('my_partial') ?>

<!-- This is Rails' yield ('yield' is a reserved word in php 5.5 - so let's 'spit' the content out) -->
<?php $this->spit() ?>

<!-- This will process and output the file views/partials/footer.html.php with the variable foo-->
<?= $this->partial('footer', array('foo' => 'bar')) ?>
</html>

```

#### JSON API Anyone?

Uses ProcesWire's $config->is_ajax to determine whether to use api controller or normal controller

```php
// controllers/api/contact_controller.php
class ContactController extends ApiController {
  // Get method is optional, by default a get request
  // returns the page data for this page.
  // To get hold of this data use $this->page_data().
  // GET /contact/?id=1
  function get() {
    $id = $this->param('id');
    return array('foo' => 'bar'.$id);
    // {"foo":"bar1"}
  }

  // POST /contact (with optional request and response objects)
  function post($req, $resp) {
    $id = $this->param('id'); // equivalent to $req->param('id')
    // Lets serve a dummy 404 page here for some reason
    $resp->set_status(404);
    $resp->set_body("<strong>$ID NOT FOUND</strong>");
    $resp->set_header('Content-Type', 'text/html');
  }

  function all($req, $resp) {
    // Catch all for all remaining requests methods
    if ($req->method() == 'PATCH') { /*...*/ }
  }

  // Other methods are
  // PUT, PATCH, DELETE, COPY, HEAD, OPTIONS, LINK, UNLINK and PURGE
  // If a request is made and the controller doesnt implement that method
  // then http status 405 Method Not Allowed is used. The Allow header is
  // given with the allowed methods.
}
```

## TODO

- Write tests!!!
- ~~Add controller level layout override~~
- ~~Add JSON rendering support for RESTful APIs~~ NEW!
- Add bash script to install into your processwire, complete with dependencies
- Add Wiki
- Add easy installation script (wget -O- https://raw.github.com/fixate/pw-mvc-boilerplate/master/install.sh | sh)
- More...?

### License

MIT: http://fixate.mit-license.org/
