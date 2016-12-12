<div id="contact">
  <style type="text/css">.hp-model{ display: none;}</style>
  <?php if ($has_sent) : ?>
    Thank you for contacting us, we will be in touch shortly.
  <?php endif ?>

  <form action="./#contact" method="post" id="contact-form" name="contact-form">
    <label for="name">Name</label>
    <input id="name" type="text" name="name" required value="<?= $form['name']['value'] ?>">
    <?= $form['name']['error'] ?>

    <label for="email">Email</label>
    <input id="email" type="email" name="email" required value="<?= $form['email']['value'] ?>">
    <?= $form['email']['error'] ?>

    <label for="message">Message</label>
    <textarea id="message" name="message" required rows=6><?= $form['message']['value'] ?></textarea>
    <?= $form['message']['error'] ?>

    <?php // honeypot ?>
    <input class="hp-model" type="text" name="model" value="">

    <button type="submit" name="submit" value="submit">submit</button>
  </form>
</div>
