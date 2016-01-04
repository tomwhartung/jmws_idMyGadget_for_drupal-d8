<?php
/**
 * Defines the configuration form for options in the admin back end
 * Based on hugs example from Drupal Con LA Crash Course video
 * Reference:https://www.drupal.org/node/2206551
 */
namespace Drupal\idmygadget\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class ConfigFormIdMyGadgetTablet extends ConfigFormIdMyGadgetBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'idmygadget_config_tablet';
  }
  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('idmygadget.settings');

    $formSiteNameOptions = $this->siteNameOptions( 'tablet' );
    $form = array_merge( $form, $formSiteNameOptions );

    return parent::buildForm($form, $form_state);
  }
  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);
    $config = $this->config('idmygadget.settings');

    $settingName = 'idmygadget_show_site_name_tablet';
    $config->set( $settingName, $form_state->getValue($settingName) );
    $settingName = 'idmygadget_site_name_element_tablet';
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
