<?php if ($env->is_production) : ?>
  <?php if ($env->gtm_container_id) : ?>
    <?= $this->partial('analytics/google_tag_manager_head') ?>
  <?php endif ?>

  <?php if ($env->ga_uacode && !$env->gtm_container_id) : ?>
    <?= $this->partial('analytics/google_analytics') ?>
  <?php endif ?>

  <?php if ($env->ga_wmt_meta && !$env->gtm_container_id) : ?>
    <?= $this->partial('analytics/google_webmaster_tools') ?>
  <?php endif ?>
<?php endif ?>
