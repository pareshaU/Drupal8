<?php
/**
* @file
* Contains \Drupal\custom_module\Form\ContactForm.
*/

namespace Drupal\custom_module\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
* Custom Contact Form.
*/
class ContactForm extends FormBase {
/**
* {@inheritdoc}
*/
public function getFormId() {
return 'contact_form';
}

/**
* {@inheritdoc}
*/
public function buildForm(array $form, FormStateInterface $form_state) {

$form['name'] = array(
'#type' => 'textfield',
'#size' => 15,
'#placeholder' => t('Name'),
);

$form['email'] = array(
'#type' => 'email',
'#required' => TRUE,
'#placeholder' => t('Email'),
);

$form['phone'] = array(
'#type' => 'tel',
'#required' => TRUE,
'#placeholder' => t('Phone'),
);

$form['message'] = array(
'#type' => 'textarea',
'#required' => TRUE,
'#placeholder' => t('Message'),
);

$form['submit'] = array(
'#type' => 'submit',
'#value' => t('Submit'),
);

return $form;
}

/**
* {@inheritdoc}
*/
public function validateForm(array &$form, FormStateInterface $form_state) {
  if ($form_state->getValue('name') == '' ) {
    $form_state->setErrorByName('name', t('This is a required field.'));
  }

  if ($form_state->getValue('email') !== '' && !\Drupal::service('email.validator')->isValid($form_state->getValue('email'))) {
      $form_state->setError('email', t('The email address %mail is not valid.', array('%mail' => $form_state->getValue('email'))));
    }

  if ($form_state->getValue('phone') == '' ) {
    $form_state->setErrorByName('phone', t('This is a required field.'));
  }
  if ($form_state->getValue('message') == '' ) {
    $form_state->setErrorByName('message', t('This is a required field.'));
  }
}

/**
* {@inheritdoc}
*/
public function submitForm(array &$form, FormStateInterface $form_state) {

$name = $form_state->getValue('name');
$phone = $form_state->getValue('phone');

/**
 * send email for contact.
*/
    $attr_id = \Drupal::request()->attributes->get('arg_0');//  id from url
    $attr = \Drupal\node\Entity\Node::load($attr_id);
    $attr_name = $attr->field_first_name->value . ' ' . $attr->field_last_name->value;
    $attr_email = $attr->field_email->value;

  $to = $attr_email; // email to be sent
  $from = $form_state->getValue('email');; // from user who sends inquiries.
  $params['message'] = $form_state->getValue('message');
  $params['subject'] = t('Get introduced to '.$attr_name);

  $mail = \Drupal::service('plugin.manager.mail')->mail('custom_module', 'contact_form', $to, \Drupal::languageManager()->getDefaultLanguage()->getId(), $params);
    if($mail['result']){
      $message_thankyou = t('Your information has been successfully submitted.') ;
      drupal_set_message($message_thankyou);
    }

}
}
