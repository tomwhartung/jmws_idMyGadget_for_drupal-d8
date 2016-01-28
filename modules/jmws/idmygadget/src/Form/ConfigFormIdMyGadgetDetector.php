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

class ConfigFormIdMyGadgetDetector extends ConfigFormIdMyGadgetBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'idmygadget_config_detector';
  }
  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $formGadgetDetector = $this->gadgetDetectorOption();
    $form = array_merge( $form, $formGadgetDetector );
    return parent::buildForm($form, $form_state);
  }
  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $config = $this->config('idmygadget.settings');
    $config->set('idmygadget_gadget_detector', $form_state->getValue('idmygadget_gadget_detector'));

    $config->save();
  }
  /**
   * {@inheritdoc}
   */
  public function getEditableConfigNames() {
    return ['idmygadget.settings'];
  }

}
