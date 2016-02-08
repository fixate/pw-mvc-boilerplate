<?php
/**
 * Search template.
 *
 * Make sure to set 'Alternate Template' to 'mvc' under Template Settings
 */
?>

<?php if ($q) : ?>
  <?php if ($count) : ?>

    <small><?= $result_str; ?></small>

    <?php foreach ($results as $item) : ?>
    <h4><a href='<?= $item->url; ?>'><?= $item->title; ?></a></h4>
    <p><?= $item->summary; ?></p>
    <?php endforeach; ?>

  <?php else : ?>
    <small><?= $result_str; ?></small>
  <?php endif ?>

<?php else : ?>
  <p>Please enter a search term in the search box.</p>
<?php endif ?>
