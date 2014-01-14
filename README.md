# A Rails-inspired MVC boilerplate for ProcessWire

A boilerplate for new ProcessWire projects. The MVC entrypoint is enabled for a template by using the [delegate approach](http://processwire.com/talk/topic/740-a-different-way-of-using-templates-delegate-approach/), so make sure to set all templates to use `mvc.php` as an alternate template by visiting:

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

If you don't do this, processwire will look for site/[template_name].php. mvc.php is the entrypoint into
the MVC framework.

There is no routing, you take care of that by making templates and pages in the ProcessWire admin.

**Controller for 'home' template:**

```php
// site/controllers/home_controller.php
// The name of the class matters! 'Home' in 'HomeController' matches up to
// a template named 'home' in the processwire admin.
// TEMPLATE CONTROLLERS ARE OPTIONAL: If you don't need custom functionality 
// for a template then no controller is needed. By default the mvc.php template
// will use the view matching the template name. e.g. views/basic-page.html.php
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
	
	// Will execute for a page named page-specific/page_specific instead of index()
	// Also renders views/home.html.php
	function page_specific() {
	   	$vars = array('defined' => 'only here!');
		// Optionally pass an array for variables that will be available in the view
		// e.g. <p>var = <?= $defined ?></p> <!-- only here! -->
		return $this->render($vars);
	}
	
	// Also a page specific method
	function override_view_name() {
	  	// Override the implicit view and use views/foobar.html.php
	  	// Also sets the layout to views/layouts/alternative.html.php
		return $this->render('foobar', array('optional' => 'vars'))->set_layout('alternative');
	}
}
```

**Views:**

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

### TODO

- Write tests!!!
- Add controller level layout override
- More...?

### License

MIT: http://fixate.mit-license.org/
