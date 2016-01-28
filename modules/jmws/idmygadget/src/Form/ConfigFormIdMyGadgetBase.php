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

  // protected $radioChoices = array( 'No', 'Yes' );
  protected $radioChoices = array( 1 => 'No', 2 => 'Yes' );
  // protected $radioChoices = array( '1' => 'No', '2' => 'Yes' );

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
   * Returns an array of options for whether to display the jQuery Mobile Navigation in the
   * header and footer on the specified gadget type
   * @param type $gadgetType e.g., phone, tablet, or desktop
   * @return type array
   */
  protected function phoneNavOptions( $gadgetType='desktop' ) {
    $phoneNavOptionsForm = array();
    $gadgetTypePlural = $gadgetType . 's';
    $gadgetTypePluralUcfirst = ucfirst( $gadgetTypePlural );

    $config = $this->config('idmygadget.settings');

    $settingName = 'idmygadget_phone_nav_on_' . $gadgetTypePlural;   // e.g., 'idmygadget_phone_nav_on_phones'
    // $defaultValue = $config->get( $settingName );
    // $defaultValue = isset( $defaultValue ) ? $defaultValue : '0';
    // $defaultValue = isset( $defaultValue ) ? $defaultValue : 0;
    $existingValue = $config->get( $settingName );
    if ( isset($existingValue) ) {
      $defaultValue = $config->get( $settingName );
    }
    else {
      // $defaultValue = 0;
      $defaultValue = 1;
    }
    $phoneNavOptionsForm[$settingName] = array(
      '#type' => 'radios',
      '#title' => t( $gadgetTypePluralUcfirst . ': Show Header and Footer Nav?' ),
      // '#default_value' => $config->get( $settingName ),
      '#default_value' => $defaultValue,
      '#options' => $this->radioChoices,
      '#description' =>
         t( 'Select whether to display jQuery Mobile Navigation in the header and footer on ' . $gadgetTypePlural . '.' ),
      '#required' => TRUE,
    );

    return $phoneNavOptionsForm;
  }

  /**
   * Returns an array of options for how to handle the site name on the specified gadget type
   * @param type $gadgetType e.g., phone, tablet, or desktop
   * @return type array
   */
  protected function siteNameOptions( $gadgetType='desktop' ) {
    $siteNameOptionsForm = array();
    $gadgetTypePlural = $gadgetType . 's';
    $gadgetTypePluralUcfirst = ucfirst( $gadgetTypePlural );

    $config = $this->config('idmygadget.settings');

    $settingName = 'idmygadget_show_site_name_' . $gadgetType;   // e.g., 'idmygadget_show_site_name_phone'
    // $defaultValue = $config->get( $settingName );
    // $defaultValue = isset( $defaultValue ) ? $defaultValue : '1';
    // $defaultValue = isset( $defaultValue ) ? $defaultValue : 1;
    $existingValue = $config->get( $settingName );
    if ( isset($existingValue) ) {
      $defaultValue = $config->get( $settingName );
    }
    else {
      // $defaultValue = 1;
      $defaultValue = 2;
    }
    $siteNameOptionsForm[$settingName] = array(
      '#type' => 'radios',
      '#title' => t( $gadgetTypePluralUcfirst . ': Show Site Name?' ),
      // '#default_value' => $config->get( $settingName ),
      '#default_value' => $defaultValue,
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
      '#description' => t( 'Select the html element in which you want to display the name of this site on ' . $gadgetTypePlural . '.' ),
      '#required' => FALSE,
    );

    return $siteNameOptionsForm;
  }

  /**
   * Returns an array of options for how to handle the site title on the specified gadget type
   * @param type $gadgetType e.g., phone, tablet, or desktop
   * @return type array
   */
  protected function siteTitleOptions( $gadgetType='desktop' ) {
    $siteTitleOptionsForm = array();
    $gadgetTypePlural = $gadgetType . 's';
    // $gadgetTypeUcfirst = ucfirst( $gadgetType );
    $gadgetTypePluralUcfirst = ucfirst( $gadgetTypePlural );

    $config = $this->config('idmygadget.settings');

    $settingName = 'idmygadget_site_title_' . $gadgetType;   // e.g., 'idmygadget_site_title_phone'
    $siteTitleOptionsForm[$settingName] = [
      '#type' => 'textfield',
      '#title' => t( $gadgetTypePluralUcfirst . ': Site Title' ),
      '#description' => t( 'Specify the site title, if any, to use in the header on ' . $gadgetTypePlural . '.' ),
      '#default_value' => $config->get( $settingName ),
    ];

    $settingName = 'idmygadget_site_title_element_' . $gadgetType;  // e.g., 'idmygadget_site_title_element_phone'
    $siteTitleOptionsForm[$settingName] = array(
      '#type' => 'select',
      '#title' => t( $gadgetTypePluralUcfirst . ': Site Title Element' ),
      '#default_value' => $config->get( $settingName ),
      '#options' => $this->validElements,
      '#description' => t( 'Select the html element in which you want to display the site title on ' . $gadgetTypePlural . '.' ),
      '#required' => FALSE,
    );

    return $siteTitleOptionsForm;
  }

  /**
   * Returns an array of options for how to handle the tag line on the specified gadget type
   * @param type $gadgetType e.g., phone, tablet, or desktop
   * @return type array
   */
  protected function tagLineOptions( $gadgetType='desktop' ) {
    $tagLineOptionsForm = array();
    $gadgetTypePlural = $gadgetType . 's';
    // $gadgetTypeUcfirst = ucfirst( $gadgetType );
    $gadgetTypePluralUcfirst = ucfirst( $gadgetTypePlural );

    $config = $this->config('idmygadget.settings');

    $settingName = 'idmygadget_tag_line_' . $gadgetType;   // e.g., 'idmygadget_tag_line_phone'
    $tagLineOptionsForm[$settingName] = [
      '#type' => 'textfield',
      '#title' => t( $gadgetTypePluralUcfirst . ': Tag Line' ),
      '#description' => t( 'Specify the tag line, if any, to use in the header on ' . $gadgetTypePlural . '.' ),
      '#default_value' => $config->get( $settingName ),
    ];

    $settingName = 'idmygadget_tag_line_element_' . $gadgetType;  // e.g., 'idmygadget_tag_line_element_phone'
    $tagLineOptionsForm[$settingName] = array(
      '#type' => 'select',
      '#title' => t( $gadgetTypePluralUcfirst . ': Tag Line Element' ),
      '#default_value' => $config->get( $settingName ),
      '#options' => $this->validElements,
      '#description' => t( 'Select the html element in which you want to display the tag line on ' . $gadgetTypePlural . '.' ),
      '#required' => FALSE,
    );

    return $tagLineOptionsForm;
  }

}