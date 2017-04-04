<?php
/**
 * Contact Controller.
 *
 * Fields and functions specific to the contact template.
 */
class ContactController extends ApplicationController
{
  public function index()
  {
    return $this->render(array(
      'form' => $this->get_contact_form(),
    ));
  }

  protected function get_contact_form()
  {
    $can_send = false;
    $form_has_errors = false;
    $input = $this->input;
    $honeypot_filled = !!$input->post->model; // this is a deliberately misleading name
    $is_submission = !!$input->post->submit;
    $sanitizer = $this->sanitizer;
    $view = new View($this);

    $submission = array(
      'name' => array(
        'value' => $sanitizer->text($input->name),
        'error' => $is_submission ? $this->formValidateRequiredField($input->name, 'Please fill in your name') : '',
      ),
      'email' => array(
        'value' => $sanitizer->email($input->email),
        'error' => $is_submission ? $this->formValidateRequiredEmailField($input->email, 'Please fill in your email address') : '',
      ),
      'message' => array(
        'value' => $sanitizer->textarea($input->message),
        'error' => $is_submission ? $this->formValidateRequiredField($input->message, 'Please add a message'): '',
      ),
    );

    $form_has_errors = $this->formHasErrors($submission);
    $can_send = $is_submission && !$form_has_errors && !$honeypot_filled;

    if ($can_send) {
      $this->handle_contact_submission($submission);
      $this->create_submission_page($submission);
    }

    return $view->partial(
      'forms/contact',
      array('form' => $submission, 'has_sent' => $can_send)
    );
  }

  protected function handle_contact_submission($submission)
  {
    $pages = $this->pages;
    $site_name = $pages->get('/settings')->site_name;
    $admin_email = $pages->get('template=contact')->email;
    extract($submission);

    $admin_template = './views/email/contact/to_admin.html.php';
    $submitter_template = './views/email/contact/to_submitter.html.php';

    $admin_fields = array(
      'email_from' => $admin_email,
      'email_to' => $admin_email,
      'subject' => "{$site_name} - Contact Query",
      'name' => $name['value'],
      'message' => $message['value'],
    );

    $submitter_fields = array(
      'email_from' => $admin_email,
      'email_to' => $email['value'],
      'subject' => "{$site_name} - Thank you for your message",
      'name' => $name['value'],
      'message' => $message['value'],
    );

    $this->formSendEmail($admin_fields, $admin_template);
    $this->formSendEmail($submitter_fields, $submitter_template);
  }

  private function create_submission_page(array $fields)
  {
    $newpage = new Page();
    $newpage->template = 'contact_submission';
    $newpage->title = "{$fields['name']['value']} - " . date('[H:i d M Y]');
    $newpage->email = $fields['email']['value'];
    $newpage->body = $fields['message']['value'];
    $newpage->setOutputFormatting(true);
    $newpage->parent_id = $this->page->id;
    $newpage->save();
  }
}
