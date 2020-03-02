<?php $view = new View($this) ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <title>Your Message Subject or Title</title>
  <?= $view->partial('email/meta') ?>
</head>

<body>

  <table cellpadding="0" cellspacing="0" border="0" id="backgroundTable">
    <tr>
      <td valign="top">
        <p>Hi <?= $name; ?>,</p>
        <p>Thank you for your message:</p>
      </td>
    </tr>
    <tr>
      <td valign="top">
        <blockquote>
          <?= $message; ?>
        </blockquote>
      </td>
    </tr>
    <tr>
      <td>
        <p>We will be in touch soon!</p>
      </td>
    </tr>
    <tr>
      <td>
        <p>Kind regards, <br><?= $this->pages->get('/settings')->site_name ?></p>
      </td>
    </tr>
  </table>

</body>

</html>
