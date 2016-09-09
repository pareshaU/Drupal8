<?php
/**
 * @file
 * contains \Drupal\custom_module\Form\SocialmediaSettingsForm
 */

namespace Drupal\custom_module\Form;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Component\Utility\UrlHelper;

class SocialmediaSettingsForm extends ConfigFormBase{
  /**
   * {@inheritdoc}
   */
  public function getFormId(){
    return 'custom_global_settings_form';
  }

   /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['custom.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('custom.settings');

    $form['address'] = array(
      '#type' => 'textarea',
      '#title' => $this->t('Address'),
      '#default_value' => $config->get('site.address'),
      '#type' => 'text_format',
      '#rows' => 3,
      );
    $form['fblink'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Facebook URL'),
      '#default_value' => $config->get('site.fblink'),
      );
    $form['twitterlink'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Twitter URL'),
      '#default_value' => $config->get('site.twitterlink'),
      );
    $form['youtubelink'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Youtube URL'),
      '#default_value' => $config->get('site.youtubelink'),
      );
    $form['linkedinlink'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Linkedin URL'),
      '#default_value' => $config->get('site.linkedinlink'),
      );
    return parent::buildForm($form,$form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    // validate address field.
    if($form_state->isValueEmpty('address')){
      $form_state->setErrorByName('address',$this->t("Address field is required."));
    }

    // Validate facebook URL.
    if (!UrlHelper::isValid($form_state->getValue('fblink'), TRUE)) {
      $form_state->setErrorByName('fblink', $this->t("The Facebook url '%url' is invalid.", array('%url' => $form_state->getValue('fblink'))));
    }

    // Validate twitter URL.
    if (!UrlHelper::isValid($form_state->getValue('twitterlink'), TRUE)) {
      $form_state->setErrorByName('twitterlink', $this->t("The Twitter url '%url' is invalid.", array('%url' => $form_state->getValue('twitterlink'))));
    }

    // Validate youtube URL.
    if (!UrlHelper::isValid($form_state->getValue('youtubelink'), TRUE)) {
      $form_state->setErrorByName('youtubelink', $this->t("The Youtube url '%url' is invalid.", array('%url' => $form_state->getValue('youtubelink'))));
    }

     // Validate linkedin URL.
    if (!UrlHelper::isValid($form_state->getValue('linkedinlink'), TRUE)) {
      $form_state->setErrorByName('linkedinlink', $this->t("The Linkedin url '%url' is invalid.", array('%url' => $form_state->getValue('linkedinlink'))));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('custom.settings')
    ->set('site.address', $form_state->getValue('address'))
      ->set('site.fblink', $form_state->getValue('fblink'))
      ->set('site.twitterlink', $form_state->getValue('twitterlink'))
      ->set('site.youtubelink', $form_state->getValue('youtubelink'))
      ->set('site.linkedinlink', $form_state->getValue('linkedinlink'))
      ->save();

    parent::submitForm($form, $form_state);
  }
}
