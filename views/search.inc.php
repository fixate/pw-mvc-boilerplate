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
 * @since Theme_Name 1.0
 */

if ($query) :

  if($count) : ?>

    <small><?= $results; ?></small>

    <?php foreach($matches as $match) : ?>
    <h4><a href='<?= $match->url; ?>'><?= $match->title; ?></a></h4>
    <p><?= $match->summary; ?></p>
    <?php endforeach; ?>

  <?php else : ?>
    <small><?= $results; ?></small>
  <?php endif; // $count ?>

<?php else : ?>
  <p>Please enter a search term in the search box.</p>
<?php endif; // $query
