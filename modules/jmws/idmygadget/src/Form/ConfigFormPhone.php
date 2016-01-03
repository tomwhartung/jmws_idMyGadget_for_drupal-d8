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

class ConfigFormPhone extends ConfigFormBase {

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

    $formSiteNameOptions = $this->siteNameOptions( 'phone' );
    $form = array_merge( $form, $formSiteNameOptions );

    return parent::buildForm($form, $form_state);
  }
  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $config = $this->config('idmygadget.settings');

    // $gadgetTypes = array( 'phone', 'tablet', 'desktop' );
    $settingName = 'idmygadget_show_site_name_phone';
    $config->set( $settingName, $form_state->getValue($settingName) );
    $settingName = 'idmygadget_site_name_element_phone';
    $config->set( $settingName, $form_state->getValue($settingName) );

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
