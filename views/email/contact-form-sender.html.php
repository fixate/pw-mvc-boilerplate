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
				<p>Hi <?= $sender_name; ?>,</p>
				<p>Thank you for your message:</p>
			</td>
		</tr>
		<tr>
			<td valign="top">
			<table id="contentTable" cellpadding="0" cellspacing="0" border="0" align="center">
				<tr>
					<td width="100" valign="top">Message:</td>
					<td valign="top"><?= $sender_message; ?></td>
				</tr>
			</table>
			</td>
		</tr>
		<tr>
			<td><p>We will be in touch at our soonest!</p></td>
		</tr>
		<tr>
			<td><p>Kind regards, <br>[Company Name]</p></td>
		</tr>
	</table>

</body>
</html>
