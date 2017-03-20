<?php

use ProcessWire as PW;

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

  protected function formSendEmail($fields, $partial)
  {
    $pages = $this->pages;
    $mailer = PW\wireMail();
    $body = '';

    /*
     required keys in $fields:
       email_from
       email_to
       subject
     */
    $this->handleExceptions($fields);

    extract($fields);

    ob_start();
    include $partial;
    $body = ob_get_clean();

    if (!empty($body)) {
      $mailer
        ->to($email_to)
        ->from($email_from)
        ->subject($subject)
        ->bodyHTML($body)
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
        throw new Exception("Required array item {$field_name} not provided.");
      }
    }, array('email_from', 'email_to', 'subject'));
  }
}
