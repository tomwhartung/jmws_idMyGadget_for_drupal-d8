<?php
/**
 * Defines the configuration form for options in the admin back end
 * Based on hugs example from Drupal Con LA Crash Course video
 * Reference:https://www.drupal.org/node/2206551
 */
namespace Drupal\idmygadget\Form;
use Drupal\Core\Form\FormStateInterface;

class ConfigFormIdMyGadgetPhone extends ConfigFormIdMyGadgetBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'idmygadget_config_phone';
  }
  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $formPhoneNavOptions = $this->phoneNavOptions( 'phone' );
    $formLogoFileOptions = $this->logoFileOptions( 'phone' );
    $formSiteNameOptions = $this->siteNameOptions( 'phone' );
    $formSiteTitleOptions = $this->siteTitleOptions( 'phone' );
    $formSiteSloganOptions = $this->siteSloganOptions( 'phone' );
    $form = array_merge( $form,
      $formPhoneNavOptions,
      $formLogoFileOptions,
      $formSiteNameOptions,
      $formSiteTitleOptions,
      $formSiteSloganOptions );

    return parent::buildForm($form, $form_state);
  }
  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);
    $config = $this->config('idmygadget.settings');

    $settingName = 'idmygadget_phone_nav_on_phones';
    $config->set( $settingName, $form_state->getValue($settingName) );
    $settingName = 'idmygadget_logo_file_phone';
    $config->set( $settingName, $form_state->getValue($settingName) );

    $settingName = 'idmygadget_show_site_name_phone';
    $config->set( $settingName, $form_state->getValue($settingName) );
    $settingName = 'idmygadget_site_name_element_phone';
    $config->set( $settingName, $form_state->getValue($settingName) );

    $settingName = 'idmygadget_site_title_phone';
    $config->set( $settingName, $form_state->getValue($settingName) );
    $settingName = 'idmygadget_site_title_element_phone';
    $config->set( $settingName, $form_state->getValue($settingName) );

    $settingName = 'idmygadget_site_slogan_phone';
    $config->set( $settingName, $form_state->getValue($settingName) );
    $settingName = 'idmygadget_site_slogan_element_phone';
    $config->set( $settingName, $form_state->getValue($settingName) );

    $config->save();
  }
  /**
   * {@inheritdoc}
   */
  public function getEditableConfigNames() {
    return ['idmygadget.settings'];
  }
}