<?php
/**
 * Search template
 *
 * This site uses the delegate approach:
 * http://processwire.com/talk/topic/740-a-different-way-of-using-templates-delegate-approach/
 *
 * Make sure to set 'Alternate Template' to 'main.php' under Template Settings
 *
 * @package ProcessWire
 */

if ($q) :

  if($count) : ?>

    <small><?= $result_str; ?></small>

    <?php foreach($results as $item) : ?>
    <h4><a href='<?= $item->url; ?>'><?= $item->title; ?></a></h4>
    <p><?= $item->summary; ?></p>
    <?php endforeach; ?>

  <?php else : ?>
    <small><?= $result_str; ?></small>
  <?php endif; // $count ?>

<?php else : ?>
  <p>Please enter a search term in the search box.</p>
<?php endif; // $query
