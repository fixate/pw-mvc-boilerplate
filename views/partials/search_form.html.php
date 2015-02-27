<?php
/**
 * Search form partial
 *
 * This partial is included via header.inc.php
 *
 * @package ProcessWire
 */
?>
<form id='search_form' action='<?= $config->urls->root?>search/' method='get'>
	<input type='text' name='q' id='search_query' value='<?= htmlentities($q, ENT_QUOTES, 'UTF-8'); ?>' />
	<button type='submit' class="btn btn_-primary" id='search_submit'>Search</button>
</form>
