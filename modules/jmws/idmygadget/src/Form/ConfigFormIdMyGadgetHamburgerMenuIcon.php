<?php
/**
 * Defines the configuration form for options in the admin back end
 * Based on hugs example from Drupal Con LA Crash Course video
 * Reference:https://www.drupal.org/node/2206551
 */
namespace Drupal\idmygadget\Form;
use Drupal\Core\Form\FormStateInterface;

class ConfigFormIdMyGadgetHamburgerMenuIcon extends ConfigFormIdMyGadgetBase {

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
    $formHamburgerMenuIconLeft = $this->hamburgerMenuIconOptions('left');
    $formHamburgerMenuIconRight = $this->hamburgerMenuIconOptions('right');
    $form = array_merge( $form, $formHamburgerMenuIconLeft );
    $form = array_merge( $form, $formHamburgerMenuIconRight );
    return parent::buildForm($form, $form_state);
  }
  /**
   * {@inheritdoc}
   */
  public function hamburgerMenuIconOptions( $leftOrRight ) {
    $formHamburgerMenuIconOptions = array();
    
    foreach( $this->gadgetTypes as $gadgetType ) {
      $formHamburgerNavGadgetTypeOptions = $this->hamburgerNavGadgetTypeOptions( $gadgetType, $leftOrRight );
      $formHamburgerMenuIconOptions = array_merge( $formHamburgerMenuIconOptions, $formHamburgerNavGadgetTypeOptions );
    }

    $formHamburgerMenuIconSizeOptions = $this->hamburgerMenuIconSizeOptions( $leftOrRight );
    $formHamburgerMenuIconOptions = array_merge( $formHamburgerMenuIconOptions, $formHamburgerMenuIconSizeOptions );

    return $formHamburgerMenuIconOptions;
  }
  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);
    $config = $this->config('idmygadget.settings');

    foreach( $this->gadgetTypes as $gadgetType ) {
      $gadgetTypePlural = $gadgetType . 's';
      $settingName = 'idmygadget_hamburger_nav_left_on_' . $gadgetTypePlural;    // e.g., 'idmygadget_hamburger_nav_left_on_phones'
      $config->set( $settingName, $form_state->getValue($settingName) );
      $settingName = 'idmygadget_hamburger_nav_right_on_' . $gadgetTypePlural;   // e.g., 'idmygadget_hamburger_nav_right_on_phones'
      $config->set( $settingName, $form_state->getValue($settingName) );
    }

    $settingName = 'idmygadget_hamburger_menu_icon_left_size';
    $config->set( $settingName, $form_state->getValue($settingName) );
    $settingName = 'idmygadget_hamburger_menu_icon_right_size';
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
