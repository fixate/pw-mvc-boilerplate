<?php

/**
 * Base template for delegating which view to use to render content.
 *
 * This template should be set as the alternate template for all templates. Each
 * template view must match the template name.
 *
 * Information on using the delegate approach can be found here:
 * http://processwire.com/talk/topic/740-a-different-way-of-using-templates-delegate-approach/
 *
 * @package ProcessWire
 * @since Theme_Name 1.0
 */

include("./partials/head.inc.php");

	if( $page->template ) {
		$t = new TemplateFile($config->paths->templates . "views/{$page->template}.inc.php");
		//$t->set("arr1", $somevar);
		echo $t->render();
	}

include("./partials/footer.inc.php");


