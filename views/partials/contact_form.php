<?php if ($has_sent) : ?>
  Thank you for contacting us, we will be in touch shortly.
<?php endif ?>

<form action="./" method="post" id="contact-form" name="contact-form">
  <label for="name">Name</label>
  <input type="text" name="name" srequired value="<?= $form['name']['value'] ?>">
  <?= $form['name']['error'] ?>

  <label for="email">Email</label>
  <input type="email" name="email" srequired value="<?= $form['email']['value'] ?>">
  <?= $form['email']['error'] ?>

  <label for="message">Message</label>
  <textarea name="message" srequired><?= $form['message']['value'] ?></textarea>
  <?= $form['message']['error'] ?>

  <button type="submit" name="submit" value="submit">submit</button>
</form>
