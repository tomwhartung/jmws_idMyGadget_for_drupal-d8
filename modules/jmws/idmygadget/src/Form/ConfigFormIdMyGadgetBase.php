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

class ConfigFormIdMyGadgetBase extends ConfigFormBase {

  protected $supportedGadgetDetectors = array(
    'detect_mobile_browsers',   // note that this is used as the default throughout
    'mobile_detect',
    'tera_wurfl',
    'no_detection'      // defaults to desktop (allows for isolating responsive behavior)
  );

  protected $gadgetTypes = array( 'phone', 'tablet', 'desktop' );

  protected $radioChoices = array( 'No', 'Yes' );  // NOTE: 'No' must be the zeroeth elt ;-)

  protected $validElements = array( 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'p', 'div', 'span' );

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
    return parent::buildForm($form, $form_state);
  }
  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    // $config = $this->config('idmygadget.settings');
    // $config->set('idmygadget_', $form_state->getValue('idmygadget_'));

    // $config->save();
  }
  /**
   * {@inheritdoc}
   */
  public function getEditableConfigNames() {
    return ['idmygadget.settings'];
  }

  /**
   * Returns an array of options for how to handle the site name on the specified gadget type
   * @param type $gadgetType e.g., phone, tablet, or desktop
   * @return type array
   */
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

    $settingName = 'idmygadget_show_site_name_' . $gadgetType;   // e.g., 'idmygadget_show_site_name_phone'
    $siteNameOptionsForm[$settingName] = array(
      '#type' => 'radios',
      '#title' => t( $gadgetTypePluralUcfirst . ': Show Site Name?' ),
      '#default_value' => $config->get( $settingName ),
      '#options' => $this->radioChoices,
      '#description' => t( 'Select whether you want the name of this site to display in the header on ' . $gadgetTypePlural . '.' ),
      '#required' => TRUE,
    );

    $settingName = 'idmygadget_site_name_element_' . $gadgetType;     // e.g., 'idmygadget_site_name_element_phone'
    $siteNameOptionsForm[$settingName] = array(
      '#type' => 'select',
      '#title' => t( $gadgetTypePluralUcfirst . ': Site Name Element' ),
      '#default_value' => $config->get( $settingName ),
      '#options' => $this->validElements,
      '#description' => t( 'Select the html element in which you want to display the name of this site in the header on ' . $gadgetTypePlural . '.' ),
      '#required' => FALSE,
    );

    return $siteNameOptionsForm;
  }

}
