<?php
/**
 * Contact Controller
 *
 * Fields and functions specific to the contact template.
 *
 * @package ProcessWire
 * @since Theme_Name 1.0
 */

class ContactController extends ApplicationController {
	function index() {
		return $this->render(array(
			'form' => $this->get_contact_form()
		));
	}





/*------------------------------------*\
	$FUNCTIONS
	\*------------------------------------*/
	/**
	 * Contact form
	 *
	 * Inspired by the following article:
	 * http://processwire.com/talk/topic/2089-create-simple-forms-using-api/?p=19505
	 *
	 * @return string               either the rendered form, or a success message on
	 *                              successful submission
	 */
	function get_contact_form() {
		$modules = wire('modules');
		$config = wire('config');
		$input = wire('input');
		$page = wire('page');
		$sanitizer = wire('sanitizer');
		$session = wire('session');

		$to_email = $page->get('email');
		$message_success = '<p>Thank for your message, we\'ll be in touch soon!</p>';
		$output = '';

		// create a form, modify its markup and classes
		$form = $modules->get("InputfieldForm");
		$form->setMarkup(array(
			'list' => "<div {attrs}>{out}</div>",
			'item' => "<div {attrs}>{out}</div>",
			'item_label' => "<label for='{for}'>{out}</label>",
			'item_content' => "{out}",
			'item_error' => "<p>{out}</p>",
			'item_description' => "<p>{out}</p>",
			'item_head' => "<h2>{out}</h2>",
			'item_notes' => "<p class='notes'>{out}</p>",
		));
		$form->setClasses(array(
			'list' => '',
			'list_clearfix' => '',
			'item' => '{class}',
			'item_required' => '',
			'item_error' => '',
			'item_collapsed' => '',
			'item_column_width' => '',
			'item_column_width_first' => ''
		));
		$form->action = "./";
		$form->method = "post";
		$form->attr("id+name",'contact-form');

		// create an input for a visitor's name
		$form_name = $modules->get("InputfieldText");
		$form_name->label = "Name";
		$form_name->required = 1;
		$form_name->attr('id+name','name');
		$form->append($form_name);

		// create an input for a visitor's email
		$form_email = $modules->get("InputfieldEmail");
		$form_email->label = "E-Mail";
		$form_email->required = 1;
		$form_email->attr('id+name','email');
		$form->append($form_email);

		// create a textarea for the visitor's message
		$form_message = $modules->get("InputfieldTextarea");
		$form_message->label = "Message";
		$form_message->required = 1;
		$form_message->attr('id+name','message');
		$form->append($form_message);

		// implement basic honeypot spam proection
		$form_honeypot_markup = $modules->get('InputfieldMarkup');
		$form_honeypot_markup->attr('value', '<label for="sendemail" style="display:none;">carbon life forms, don\'t enter this checkbox!</label>');
		$form->append($form_honeypot_markup);
		$form_honeypot = $modules->get('InputfieldCheckbox');
		$form_honeypot->label = " ";
		$form_honeypot->attr('id+name','sendemail');
		$form_honeypot->attr('style', 'display:none;');
		$form->append($form_honeypot);

		// create a submit button
		$form_submit = $modules->get("InputfieldSubmit");
		$form_submit->attr("value","Send");
		$form_submit->attr("id+name","submit");
		$form_submit->attr("class","btn");
		$form->append($form_submit);

		// check if the form was submitted
		if ($input->post->submit) {

			// process the submitted form
			$form->processInput($input->post);

			// check if honeypot is checked
			$spam_field = $form->get("sendemail");
			$spam_action = $sanitizer->text($input->post->sendemail);

			// if it is checked, add an error to the error array
			if ($spam_action == 1) {
				$spam_field->error("If you are human, you'd best email us directly; your submission is being detected as spam! If you are a robot, please ignore this.");

				// write this attempt to a log
				$spam_log = new FileLog($config->paths->logs . 'detectedspam.txt');
				$spam_log->save('Spam caught: '.$sanitizer->textarea($input->post->body));
			}

			// check if there are errors in the submission
			if($form->getErrors()) {
				$output = $form->render();
			} else {


				// sanitise inputs
				$sender_name     = $sanitizer->text($input->post->name);
				$sender_email    = $sanitizer->email($form->get('email')->value);
				$sender_message  = $sanitizer->textarea($form->get('message')->value);

				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
				$recipient_headers = $headers . 'From: {$sender_email}' . "\r\n";
				$sender_headers = $headers . 'From: larry@fixate.it' . "\r\n";

				ob_start();
				include './views/email/contact-form-recipient.php';
				$recipient_msg = ob_get_clean();

				ob_start();
				include './views/email/contact-form-sender.php';
				$sender_msg = ob_get_clean();

				mail($to_email, "[Company Name] Query", $recipient_msg, $recipient_headers);
				mail($sender_email, "[Company Name] - Thank you for your message", $sender_msg, $sender_headers);

				$output = $message_success;
			}
		} else {
			// render form without processing
			$output = $form->render();
		}

		return $output;
	}
}





/*------------------------------------*\
  $FIELDS
\*------------------------------------*/




