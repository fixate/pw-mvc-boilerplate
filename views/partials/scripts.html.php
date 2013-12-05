<?php
/**
 * Partial for outputting scripts to footer.inc.php
 *
 * @package ProcessWire
 * @since Theme_Name 1.0
 */

get_google_analytics(); ?>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="<?= $config->urls->templates; ?>assets/js/lib/jquery-1.10.2.min.js">\x3C/script>')</script>

<?php if (defined('PW_LOCAL_DEV') && PW_LOCAL_DEV !== true) : ?>
  <script type="text/javascript" src="<?= $config->urls->templates; ?>assets/js/main.min.js"></script>
<?php else: ?>
  <script type="text/javascript" src="<?= $config->urls->templates; ?>assets/js/main.js"></script>
<?php endif; ?>
