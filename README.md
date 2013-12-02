# ProcessWire Boilerplate

A boilerplate for new ProcessWire projects. The templates are structured to use the [delegate approach](http://processwire.com/talk/topic/740-a-different-way-of-using-templates-delegate-approach/), so make sure to set all templates to use `main.php` as an alternate template by visiting:

```
Setup -> [template] -> Advanced -> Alternate Template Filename
```
in your admin.

## Purpose

Kickstart ProcessWire projects with a structure that reduces repetition, separates logic from markup, and logically organises your code for easier management.

## Features

- `html`, `body`, and structural markup is defined in a single template
- header, footer, and other global sections are defined once
- logic is abstracted from markup
- contains a working, and easy to understand contact form built through the API

## Installation

Clone this repo into

```
site
├── templates
```

Ensure you have uncommented the following line in `site/config.php`:

```
$config->prependTemplateFile = '_init.php';
```

Move the contents of `!root` to the root of your site (.gitignore to your project root), and get cracking!

**NOTE:** ProcessWire creates its own .htaccess. The .htaccess in this repo extends the [H5BP .htaccess](https://github.com/h5bp/html5-boilerplate/blob/master/.htaccess) with the ProcessWire 2.3 .htaccess. You may override that .htaccess with this one.

## Usage

**Basic Controller:**

```php
class HomeController extends Controller {
	function index() {
		return $this->render();
	}
}
```

**Views:**

Basic layout: `views/layouts`

```php
<html>
<?= $this>partial('...') ?>

<?php $this->yield() ?>
</html>

```

### License

MIT: http://fixate.mit-license.org/
