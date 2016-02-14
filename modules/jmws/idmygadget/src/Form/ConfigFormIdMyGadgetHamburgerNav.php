<?php
/**
 * Defines the configuration form for options in the admin back end
 * Based on hugs example from Drupal Con LA Crash Course video
 * Reference:https://www.drupal.org/node/2206551
 */
namespace Drupal\idmygadget\Form;
use Drupal\Core\Form\FormStateInterface;

class ConfigFormIdMyGadgetHamburgerNav extends ConfigFormIdMyGadgetBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'idmygadget_config_hamburger_nav';
  }
  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    // $formJqmDataTheme= $this->jqmDataThemeOption();
    $form = array_merge( $form, $formJqmDataTheme );

    foreach( $this->gadgetTypes as $gadgetType ) {
      // $formHamburgerNavOptions = $this->hamburgerNavOptions( $gadgetType );
      $form = array_merge( $form, $formHamburgerNavOptions );
    }

    return parent::buildForm($form, $form_state);
  }
  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);
    $config = $this->config('idmygadget.settings');
    // $config->set('idmygadget_jqm_data_theme', $form_state->getValue('idmygadget_jqm_data_theme'));

    foreach( $this->gadgetTypes as $gadgetType ) {
      $gadgetTypePlural = $gadgetType . 's';
      $settingName = 'idmygadget_phone_nav_on_' . $gadgetTypePlural;  // e.g., 'idmygadget_phone_nav_on_phones'
      // $config->set( $settingName, $form_state->getValue($settingName) );
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
