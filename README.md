# ProcessWire Boilerplate

A boilerplate for new ProcessWire projects. The templates are structured to use the [delegate approach](http://processwire.com/talk/topic/740-a-different-way-of-using-templates-delegate-approach/), so make sure to set all templates to use `main.php` as an alternate template by visiting:

```
Setup -> [template] -> Advanced -> Alternate Template Filename
```
in your admin.

## Purpose

Kickstart ProcessWire projects with a structure that reduces some repetition.

## Usage

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

### License

MIT: http://fixate.mit-license.org/
