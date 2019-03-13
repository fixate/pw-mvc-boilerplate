<?php if ($env->is_production) : ?>
  <?php if ($env->gtm_container_id !== false) : ?>
    <?= $this->partial('analytics/google_tag_manager_head') ?>
  <?php endif ?>

  <?php if ($env->ga_uacode !== false) : ?>
    <?= $this->partial('analytics/google_analytics') ?>
  <?php endif ?>

  <?php if ($env->ga_wmt_meta !== false) : ?>
    <?= $this->partial('analytics/google_webmaster_tools') ?>
  <?php endif ?>
<?php endif ?>
