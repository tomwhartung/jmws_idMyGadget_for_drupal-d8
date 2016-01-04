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
    $config = $this->config('idmygadget.settings');

    //
    // Add a section to the module's Settings screen that contains
    // radio buttons allowing the admin to set the device detector.
    // This shows up under Configuration -> IdMyGadget -> Gadget Detector
    //
    $form['idmygadget_gadget_detector'] = array(
      '#type' => 'radios',
      '#title' => t('Gadget Detector'),
      // '#default_value' => $this->supportedGadgetDetectors[0],
      '#default_value' => $config->get('idmygadget_gadget_detector'),
      '#options' => $this->supportedGadgetDetectors,
      '#description' => $this->t('Select the 3rd party device detector to use for this site.'),
      '#required' => TRUE,
    );

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
