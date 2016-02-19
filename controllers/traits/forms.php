<?php

trait Forms
{
    public static function __formsInitialize($obj)
    {
        $obj->helper('formHasErrors');
        $obj->helper('formValidateRequiredField');
        $obj->helper('formValidateRequiredEmailField');
        $obj->helper('formSendEmails');
    }

    protected function formHasErrors($form_values)
    {
        $filtered_arr = array_filter($form_values, function($prop_array) {
            return !empty($prop_array['error']);
        });

        return sizeof($filtered_arr) > 0;
    }

    protected function formValidateRequiredField($value, $error_text = 'Please fill in this field', $tag = 'p', $className = 'error')
    {
        $text = '';

        if(empty($value)) {
          $text = $this->formGetErrorTag($error_text, $tag, $className);
        }

        return $text;
    }

    protected function formValidateRequiredEmailField($value, $error_text, $tag = 'p', $className = 'error')
    {
        $text = $this->formValidateRequiredField($value, $error_text);
        $sanitized_email = $this->sanitizer->email($value);

        if (!empty($value) && empty($sanitized_email)) {
          $text = $this->formGetErrorTag('Please enter a valid email address', $tag, $className);
        }

        return $text;
    }

    protected function formSendEmails($fields, $templates)
    {
        $pages = $this->pages;
        $mail_admin = wireMail();
        $mail_submitter = wireMail();
        $admin_body = '';
        $submitter_body = '';

        /**
         * manadatory keys:
         * - admin_email
         * - admin_subject
         * - submitter_email
         * - submitter_subject
         */
        $this->handleExceptions($fields);

        extract($fields);

        if ($admin_template = $templates['to_admin']) {
          ob_start();
          include $admin_template;
          $admin_body = ob_get_clean();
        }

        if ($submitter_template = $templates['to_submitter']) {
          ob_start();
          include $submitter_template;
          $submitter_body = ob_get_clean();
        }

        if (!empty($admin_body)) {
            $mail_admin
              ->to($admin_email)
              ->from($submitter_email)
              ->subject($admin_subject)
              ->bodyHTML($admin_body)
              ->send();
        }

        if (!empty($submitter_body)) {
            $mail_submitter
                ->to($submitter_email)
                ->from($admin_email)
                ->subject($submitter_subject)
                ->bodyHTML($submitter_body)
                ->send();
        }
    }

    private function formGetErrorTag($text, $tag = 'p', $className = 'error')
    {
        $html = "<{$tag} class='{$className}'>{$text}</{$tag}>";
        return $html;
    }

    private function handleExceptions($fields)
    {
        array_map(function($field_name) use ($fields) {
            if (empty($fields[$field_name])) {
              throw new Exception("No {$field_name} field provided.");
            }
        }, array('admin_email', 'submitter_email'));
    }
}

