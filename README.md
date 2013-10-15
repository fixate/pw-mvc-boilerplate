# ProcessWire Boilerplate

A boilerplate for new ProcessWire projects. The templates are structured to use the [delegate approach](http://processwire.com/talk/topic/740-a-different-way-of-using-templates-delegate-approach/), so make sure to set all templates to use `main.php` as an alternate template by visiting:

```
Setup -> [template] -> Advanced -> Alternate Template Filename
```
in your admin.

## Purpose

Kickstart ProcessWire projects, and provide a structure which is more suitable to an MVC approach.

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

and get cracking!

### License

MIT: http://fixate.mit-license.org/
