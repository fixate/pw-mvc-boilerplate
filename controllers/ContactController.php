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
            'form' => $this->getContactForm(),
        ));
    }

    protected function getContactForm()
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
            'value' => $sanitizer->text($input->message),
            'error' => $is_submission ? $this->formValidateRequiredField($input->message, 'Please add a message'): '',
          ),
        );

        $form_has_errors = $this->formHasErrors($submission);
        $can_send = $is_submission && !$form_has_errors && !$honeypot_filled;

        if ($can_send) {
          $this->handleContactSubmission($submission);
        }

        return $view->partial(
          'contact_form',
          array('form' => $submission, 'has_sent' => $can_send)
        );
    }

    protected function handleContactSubmission($submission)
    {
        $pages = $this->pages;
        $site_name = $pages->get('/settings')->site_name;
        extract($submission);

        $templates = array(
            'to_admin' => './views/email/contact_form_to_admin.html.php',
            'to_submitter' => './views/email/contact_form_to_submitter.html.php',
        );

        $fields = array(
            'admin_email' => $pages->get('/contact')->admin_email,
            'admin_subject' => "{$site_name} - Contact Query",
            'submitter_subject' => "{$site_name} - Thank you for your message",
            'submitter_name' => $name['value'],
            'submitter_email' => $email['value'],
            'submitter_message' => $message['value'],
        );

        $this->formSendEmails($fields, $templates);
        $this->saveContactSubmission($fields, $templates);
    }

    private function saveContactSubmission(array $fields)
    {
        $newpage = new Page();
        $newpage->template = 'contact_submission';
        $newpage->title = "{$fields['submitter_name']} - " . date('[H:i d M Y]');
        $newpage->email = $fields['submitter_email'];
        $newpage->body = $fields['submitter_message'];
        $newpage->setOutputFormatting(true);
        $newpage->parent_id = $this->page->id;
        $newpage->save();
    }
}
