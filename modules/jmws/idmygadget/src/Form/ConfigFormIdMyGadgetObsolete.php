<?php
/**
 * Defines the configuration form for options in the admin back end
 * **************************************************************
 * THIS CLASS IS OBSOLETE AND USEFUL AS AN EXAMPLE ONLY
 * **************************************************************
 * Based on hugs example from Drupal Con LA Crash Course video
 * Reference:https://www.drupal.org/node/2206551
 */
namespace Drupal\idmygadget\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
// use Drupal\idMyGadget\JmwsIdMyGadget;

class ConfigFormIdMyGadgetObsolete extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'idmygadget_config';
  }
  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('idmygadget.settings');

    $supported_gadget_detectors = array(
      'detect_mobile_browsers',   // note that this is used as the default throughout
      'mobile_detect',
      'tera_wurfl',
      'no_detection'      // defaults to desktop (allows for isolating responsive behavior)
    );
    //
    // Add a section to the module's Settings screen that contains
    // radio buttons allowing the admin to set the device detector.
    // This shows up under Configuration -> IdMyGadget -> Gadget Detector
    //
    $form['idmygadget_gadget_detector'] = array(
      '#type' => 'radios',
      '#title' => t('Gadget Detector (ConfigForm)'),
      // '#default_value' => $supported_gadget_detectors[0],
      '#default_value' => $config->get('idmygadget_gadget_detector'),
      '#options' => $supported_gadget_detectors,
      '#description' => $this->t('Select the 3rd party device detector to use for this site.'),
      '#required' => TRUE,
    );

    $gadgetTypes = array( 'phone', 'tablet', 'desktop' );
    foreach( $gadgetTypes as $gadgetType ) {
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

    $gadgetTypes = array( 'phone', 'tablet', 'desktop' );
    foreach( $gadgetTypes as $gadgetType ) {
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

  protected function siteNameOptions( $gadgetType='desktop' ) {
    $siteNameOptionsForm = array();
/*
    $siteNameOptionsForm['idmygadget_'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Experimental textfield input defined in ConfigForm class'),
      '#default_value' => $config->get('exp_textfield'),
    ];
 */
    $gadgetTypePlural = $gadgetType . 's';
    $gadgetTypeUcfirst = ucfirst( $gadgetType );
    $gadgetTypePluralUcfirst = ucfirst( $gadgetTypePlural );

    $config = $this->config('idmygadget.settings');

    $radioChoices = array( 'No', 'Yes' );  // NOTE: 'No' must be the zeroeth elt ;-)
    $settingName = 'idmygadget_show_site_name_' . $gadgetType;   // e.g., 'idmygadget_show_site_name_phone'
    $siteNameOptionsForm[$settingName] = array(
      '#type' => 'radios',
      '#title' => t( 'Show Site Name on ' . $gadgetTypePluralUcfirst . '?' ),
      '#default_value' => $config->get( $settingName ),
      '#options' => $radioChoices,
      '#description' => t( 'Select whether you want the name of this site to display in the header on ' . $gadgetTypePlural . '.' ),
      '#required' => TRUE,
    );

    $validElements = array( 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'p', 'div', 'span' );
    $settingName = 'idmygadget_site_name_element_' . $gadgetType;     // e.g., 'idmygadget_site_name_element_phone'
    $siteNameOptionsForm[$settingName] = array(
      '#type' => 'select',
      '#title' => t( 'Site Name Element ' . $gadgetTypeUcfirst ),
      '#default_value' => $config->get( $settingName ),
      '#options' => $validElements,
      '#description' => t( 'Select the html element in which you want to display the name of this site in the header on ' . $gadgetTypePlural . '.' ),
      '#required' => FALSE,
    );

    return $siteNameOptionsForm;
  }

}
