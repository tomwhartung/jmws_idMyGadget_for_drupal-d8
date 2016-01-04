<?php
/**
 * Defines the configuration form for options in the admin back end
 * Based on hugs example from Drupal Con LA Crash Course video
 * Reference:https://www.drupal.org/node/2206551
 */
namespace Drupal\idmygadget\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
// use Drupal\idMyGadget\JmwsIdMyGadget;

// class ConfigFormIdMyGadget extends ConfigFormBase {
class ConfigFormIdMyGadgetAll extends ConfigFormIdMyGadgetBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'idmygadget_config_all';
  }
  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('idmygadget.settings');

    //
    // Add a section to the module's Settings screen that contains
    // radio buttons allowing the admin to set the device detector.
    // This shows up under Configuration -> IdMyGadget -> Gadget Detector
    //
    $form['idmygadget_gadget_detector'] = array(
      '#type' => 'radios',
      '#title' => t('Gadget Detector (ConfigForm)'),
      // '#default_value' => $this->supportedGadgetDetectors[0],
      '#default_value' => $config->get('idmygadget_gadget_detector'),
      '#options' => $this->supportedGadgetDetectors,
      '#description' => $this->t('Select the 3rd party device detector to use for this site.'),
      '#required' => TRUE,
    );

    foreach( $this->gadgetTypes as $gadgetType ) {
      $formSiteNameOptions = $this->siteNameOptions( $gadgetType );
      $form = array_merge( $form, $formSiteNameOptions );
    }
    // $form = array_merge( $form, $formSiteNamePhones );

    return parent::buildForm($form, $form_state);
  }
  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $config = $this->config('idmygadget.settings');
    $config->set('idmygadget_gadget_detector', $form_state->getValue('idmygadget_gadget_detector'));
    // $config->set('idmygadget_', $form_state->getValue('idmygadget_'));

    foreach( $this->gadgetTypes as $gadgetType ) {
      $settingName = 'idmygadget_show_site_name_' . $gadgetType;      // e.g., 'idmygadget_show_site_name_phone'
      $config->set( $settingName, $form_state->getValue($settingName) );
      $settingName = 'idmygadget_site_name_element_' . $gadgetType;   // e.g., 'idmygadget_site_name_element_phone'
      $config->set( $settingName, $form_state->getValue($settingName) );
    }

    $config->save();
  }
  /**
   * {@inheritdoc}
   */
  public function getEditableConfigNames() {
    return ['idmygadget.settings'];
  }

}