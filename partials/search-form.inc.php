<?php
/**
 * Search form partial
 *
 * This partial is included via header.inc.php
 *
 * @package ProcessWire
 * @since Theme_Name 1.0
 */
?>
<form id='search_form' action='<?php echo $config->urls->root?>search/' method='get'>
  <input type='text' name='q' id='search_query' value='<?php echo htmlentities($input->whitelist('q'), ENT_QUOTES, 'UTF-8'); ?>' />
  <button type='submit' id='search_submit'>Search</button>
</form>
