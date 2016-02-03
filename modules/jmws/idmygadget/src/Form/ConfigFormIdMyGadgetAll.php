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
    $formGadgetDetector = $this->gadgetDetectorOption();
    $form = array_merge( $form, $formGadgetDetector );

    $formJqmDataTheme= $this->jqmDataThemeOption();
    $form = array_merge( $form, $formJqmDataTheme );

    foreach( $this->gadgetTypes as $gadgetType ) {
      $formPhoneNavOptions = $this->phoneNavOptions( $gadgetType );
      $formLogoFileOptions = $this->logoFileOptions( $gadgetType );
      $formSiteNameOptions = $this->siteNameOptions( $gadgetType );
      $formSiteTitleOptions = $this->siteTitleOptions( $gadgetType );
      $formTagLineOptions = $this->tagLineOptions( $gadgetType );
      $form = array_merge( $form,
        $formPhoneNavOptions,
        $formLogoFileOptions,
        $formSiteNameOptions,
        $formSiteTitleOptions,
        $formTagLineOptions );
    }

    return parent::buildForm($form, $form_state);
  }
  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $config = $this->config('idmygadget.settings');
    $config->set('idmygadget_gadget_detector', $form_state->getValue('idmygadget_gadget_detector'));
    $config->set('idmygadget_jqm_data_theme', $form_state->getValue('idmygadget_jqm_data_theme'));

    foreach( $this->gadgetTypes as $gadgetType ) {
      $gadgetTypePlural = $gadgetType . 's';
      $settingName = 'idmygadget_phone_nav_on_' . $gadgetTypePlural;  // e.g., 'idmygadget_phone_nav_on_phones'
      $config->set( $settingName, $form_state->getValue($settingName) );
      $settingName = 'idmygadget_logo_file_' . $gadgetType;           // e.g., 'idmygadget_logo_file_phone'
      $config->set( $settingName, $form_state->getValue($settingName) );
      $settingName = 'idmygadget_show_site_name_' . $gadgetType;      // e.g., 'idmygadget_show_site_name_phone'
      $config->set( $settingName, $form_state->getValue($settingName) );
      $settingName = 'idmygadget_site_name_element_' . $gadgetType;   // e.g., 'idmygadget_site_name_element_phone'
      $config->set( $settingName, $form_state->getValue($settingName) );
      $settingName = 'idmygadget_site_title_' . $gadgetType;          // e.g., 'idmygadget_show_site_name_phone'
      $config->set( $settingName, $form_state->getValue($settingName) );
      $settingName = 'idmygadget_site_title_element_' . $gadgetType;  // e.g., 'idmygadget_site_name_element_phone'
      $config->set( $settingName, $form_state->getValue($settingName) );
      $settingName = 'idmygadget_tag_line_' . $gadgetType;            // e.g., 'idmygadget_show_tag_line_phone'
      $config->set( $settingName, $form_state->getValue($settingName) );
      $settingName = 'idmygadget_tag_line_element_' . $gadgetType;    // e.g., 'idmygadget_tag_line_element_phone'
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