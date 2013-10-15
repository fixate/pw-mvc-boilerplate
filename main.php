<?php

/**
 * Home template
 *
 */

include("./partials/head.inc.php");

/*
	*  template views depending on template name
        *  using TemplateFile method of PW
	*/

	// delegate render view template file
	// all page templates use "main.php" as alternative template file

	if( $page->template ) {
		$t = new TemplateFile($config->paths->templates . "views/{$page->template}.inc.php");
		//$t->set("arr1", $somevar);
		echo $t->render();
	}

include("./partials/footer.inc.php");


