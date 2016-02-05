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

  protected $radioChoices = array( 'No', 'Yes' );
  // protected $radioChoices = array( 1 => 'No', 2 => 'Yes' );
  // protected $radioChoices = array( '1' => 'No', '2' => 'Yes' );

  protected $validElements = array( 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'p', 'div', 'span' );

  protected $jqueryMobileThemeChoices = array( 'a', 'b', 'c', 'd', 'e', 'f' );

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
   * Add a section to the module's Settings screen that contains
   * radio buttons allowing the admin to set the device detector.
   * This shows up under Configuration -> IdMyGadget -> Gadget Detector
   */
  protected function gadgetDetectorOption() {
    $gadgetDetectorOptionForm = array();
    $config = $this->config('idmygadget.settings');

    $gadgetDetectorOptionForm['idmygadget_gadget_detector'] = array(
      '#type' => 'radios',
      '#title' => t('Gadget Detector'),
      // '#default_value' => $this->supportedGadgetDetectors[0],
      '#default_value' => $config->get('idmygadget_gadget_detector'),
      '#options' => $this->supportedGadgetDetectors,
      '#description' => $this->t('Select the 3rd party device detector to use for this site.'),
      '#required' => TRUE,
    );
    return $gadgetDetectorOptionForm;
  }

  protected function jqmDataThemeOption() {
    global $jmwsIdMyGadget;
    $jqmDataThemeOptionForm = array();
    $config = $this->config('idmygadget.settings');

    $jqmDataThemeOptionForm['idmygadget_jqm_data_theme'] = array(
      '#type' => 'select',
      '#title' => t('jQuery Mobile Data Theme'),
      '#default_value' => $config->get('idmygadget_jqm_data_theme'),
      // '#options' => $jmwsIdMyGadget->jqueryMobileThemeChoices,
      '#options' => $this->jqueryMobileThemeChoices,
      '#description' => $this->t('Select the jQuery Mobile Data Theme to use.'),
      '#required' => TRUE,
    );
    return $jqmDataThemeOptionForm;
  }
  /**
   *
   *
   */
  protected function logoFileOptions( $gadgetType='desktop' ) {
    $logoFileOptionsForm = array();
    $gadgetTypePlural = $gadgetType . 's';
    $gadgetTypePluralUcfirst = ucfirst( $gadgetTypePlural );
    $config = $this->config('idmygadget.settings');
    $helpText = '.  (Add file manually and enter the name relative to sites/default/files.)';
    //
    // As the helpText says: add the file manually (or set it as a header in another theme) then
    // enter the name of it (relative to sites/default/files) in the text field.
    // For details, see the comment below.
    //
    $settingName = 'idmygadget_logo_file_' . $gadgetType;   // e.g., 'idmygadget_logo_file_phone'
    $logoFileOptionsForm[$settingName] = [
        '#type' => 'textfield',
        '#title' => t( $gadgetTypePluralUcfirst . ': Logo File for Header' ),
        '#description' => t( 'The logo image file for the header on ' . $gadgetTypePlural . $helpText),
        '#default_value' => $config->get( $settingName ),
    ];
    //
    // Right now, the file upload feature does not work.
    // At this time, I am unable to find adequate documentation, and
    //   unfortunately I do not have the time for further research and experimentation
    // Most of the documentation I am seeing has to do with enabling users to upload their
    //   files in the front end.  And I tried (spent about a day!) reverse-engineering
    //   what the themes (stark and bartik) do, to no avail.  (Drupal seems to be for insiders only sometimes.)
    // Note that the Reference below, which inspired this code, at this time is flagged as "Incomplete" and
    //  pertains to Drupal 6 (but nonetheless works to an extent), so I do not want to spend a lot of time
    //  messing around with something that ultimately is not absolutely necessary, and may well not work anyway...
    //   Reference: https://www.drupal.org/node/347251
    // Also note that this reference includes some code for processing the submit button that I have not used
    // Really I need to finish this up and get on with a real job that pays real money!
    //
    $settingName = 'idmygadget_logo_file_upload_' . $gadgetType;   // e.g., 'idmygadget_logo_file_upload_phone'
    // If this #attribute is not present, upload will fail on submit
    $logoFileOptionsForm['#attributes']['enctype'] = 'multipart/form-data';
    $logoFileOptionsForm[$settingName] = array(
      '#title' => t('Upload logo file for ' . $gadgetTypePlural),
      '#type'  => 'file',
    );
    $logoFileOptionsForm['submit_upload'] = array(
      '#type'  =>  'submit',
      '#value'  =>  'Submit'
    );
    return $logoFileOptionsForm;
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
    // $existingValue = $config->get( $settingName );
    // if ( isset($existingValue) ) {
    //   $defaultValue = $config->get( $settingName );
    // }
    // else {
    //   // $defaultValue = 0;
    //   $defaultValue = 1;
    // }
    $phoneNavOptionsForm[$settingName] = array(
      '#type' => 'radios',
      '#title' => t( $gadgetTypePluralUcfirst . ': Show Header and Footer Nav?' ),
      // '#default_value' => $defaultValue,
      '#default_value' => $config->get( $settingName ),
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

    $settingName = 'idmygadget_site_name_element_' . $gadgetType;     // e.g., 'idmygadget_site_name_element_phone'
    $siteNameOptionsForm[$settingName] = array(
        '#type' => 'select',
        '#title' => t( $gadgetTypePluralUcfirst . ': Site Name Element' ),
        '#default_value' => $config->get( $settingName ),
        '#options' => $this->validElements,
        '#description' => t( 'Select the html element in which you want to display the name of this site on ' . $gadgetTypePlural . '.' ),
        '#required' => FALSE,
    );

    $settingName = 'idmygadget_show_site_name_' . $gadgetType;   // e.g., 'idmygadget_show_site_name_phone'
    // $defaultValue = $config->get( $settingName );
    // $defaultValue = isset( $defaultValue ) ? $defaultValue : '1';
    // $defaultValue = isset( $defaultValue ) ? $defaultValue : 1;
    // $existingValue = $config->get( $settingName );
    // if ( isset($existingValue) ) {
    //   $defaultValue = $config->get( $settingName );
    // }
    // else {
    //   // $defaultValue = 1;
    //   $defaultValue = 2;
    // }
    $siteNameOptionsForm[$settingName] = array(
      '#type' => 'radios',
      '#title' => t( $gadgetTypePluralUcfirst . ': Show Site Name?' ),
      // '#default_value' => $defaultValue,
      '#default_value' => $config->get( $settingName ),
      '#options' => $this->radioChoices,
      '#description' => t( 'Select whether you want the name of this site to display in the header on ' . $gadgetTypePlural . '.' ),
      '#required' => TRUE,
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

    $settingName = 'idmygadget_site_title_element_' . $gadgetType;  // e.g., 'idmygadget_site_title_element_phone'
    $siteTitleOptionsForm[$settingName] = array(
        '#type' => 'select',
        '#title' => t( $gadgetTypePluralUcfirst . ': Site Title Element' ),
        '#default_value' => $config->get( $settingName ),
        '#options' => $this->validElements,
        '#description' => t( 'Select the html element in which you want to display the site title on ' . $gadgetTypePlural . '.' ),
        '#required' => FALSE,
    );

    $settingName = 'idmygadget_site_title_' . $gadgetType;   // e.g., 'idmygadget_site_title_phone'
    $siteTitleOptionsForm[$settingName] = [
      '#type' => 'textfield',
      '#title' => t( $gadgetTypePluralUcfirst . ': Site Title' ),
      '#description' => t( 'Specify the site title, if any, to use in the header on ' . $gadgetTypePlural . '.' ),
      '#default_value' => $config->get( $settingName ),
    ];

    return $siteTitleOptionsForm;
  }

  /**
   * Returns an array of options for how to handle the tag line on the specified gadget type
   * @param type $gadgetType e.g., phone, tablet, or desktop
   * @return type array
   */
  protected function siteSloganOptions( $gadgetType='desktop' ) {
    $siteSloganOptionsForm = array();
    $gadgetTypePlural = $gadgetType . 's';
    // $gadgetTypeUcfirst = ucfirst( $gadgetType );
    $gadgetTypePluralUcfirst = ucfirst( $gadgetTypePlural );
    $config = $this->config('idmygadget.settings');

    $settingName = 'idmygadget_tag_line_element_' . $gadgetType;  // e.g., 'idmygadget_tag_line_element_phone'
    $siteSloganOptionsForm[$settingName] = array(
      '#type' => 'select',
      '#title' => t( $gadgetTypePluralUcfirst . ': Slogan Element' ),
      '#default_value' => $config->get( $settingName ),
      '#options' => $this->validElements,
      '#description' => t( 'Select the html element in which you want to display the tag line on ' . $gadgetTypePlural . '.' ),
      '#required' => FALSE,
    );

    $settingName = 'idmygadget_tag_line_' . $gadgetType;   // e.g., 'idmygadget_tag_line_phone'
    $siteSloganOptionsForm[$settingName] = [
      '#type' => 'textfield',
      '#title' => t( $gadgetTypePluralUcfirst . ': Slogan' ),
      '#description' => t( 'Specify the tag line, if any, to use in the header on ' . $gadgetTypePlural . '.' ),
      '#default_value' => $config->get( $settingName ),
    ];

    return $siteSloganOptionsForm;
  }
}
