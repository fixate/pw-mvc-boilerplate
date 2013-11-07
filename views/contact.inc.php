<?php
/**
 * Contact template
 *
 * This site uses the delegate approach:
 * http://processwire.com/talk/topic/740-a-different-way-of-using-templates-delegate-approach/
 *
 * Make sure to set 'Alternate Template' to 'main.php' under Template Settings
 *
 * @package ProcessWire
 * @since Theme_Name 1.0
 */

echo $page->body;

$out = '';

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

$name = $modules->get("InputfieldText");
$name->label = "Name";
$name->attr('id+name','name');
$name->required = 1;
$form->append($name); // append the field to the form

$email = $modules->get("InputfieldEmail");
$email->label = "E-Mail";
$email->attr('id+name','email');
$email->required = 1;
$form->append($email); // append the field

$message = $modules->get("InputfieldTextarea");
$message->label = "Message";
$message->attr('id+name','message');
$message->required = 1;
$form->append($message); // append the field to the form

$submit = $modules->get("InputfieldSubmit");
$submit->attr("value","Send");
$submit->attr("id+name","submit");
$submit->attr("class","btn");
$form->append($submit);

// form was submitted so we process the form
if($input->post->submit) {

    // user submitted the form, process it and check for errors
    $form->processInput($input->post);

    if($form->getErrors()) {
        // the form is processed and populated
        // but contains errors
        $out .= $form->render();
    } else {

        // do with the form what you like, create and save it as page
        // or send emails. to get the values you can use
        // $email = $form->get("email")->value;
        // $name = $form->get("name")->value;
        // $pass = $form->get("pass")->value;
        //
        // to sanitize input
        // $name = $sanitizer->text($input->post->name);
        // $email = $sanitizer->email($form->get("email")->value);

        mail('larry@fixate.it', "website contact form submission", $form->get("message")->value, 'From: ' . $form->get('email')->value);

        $out .= "<p>You submission was completed! Thanks for your time.";

    }
} else {
    // render out form without processing
    $out .= $form->render();
}


echo $out;
