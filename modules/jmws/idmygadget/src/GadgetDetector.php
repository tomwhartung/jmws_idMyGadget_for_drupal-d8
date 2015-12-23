<?php

namespace Drupal\idmygadget;

use Drupal\Core\State\StateInterface;

// require 'JmwsIdMyGadget/JmwsIdMyGadgetDrupal.php';

class GadgetDetector {

  /**
   * @var \Drupal\Core\State\StateInterface
   */
  protected $state;

  public function __construct(StateInterface $state) {
    $this->state = $state;
  }

  public function addHug($target_name) {
    $this->state->set('idmygadget.last_recipient', $target_name);
    return $this;
  }

  public function getLastRecipient() {
    return $this->state->get('idmygadget.last_recipient');
  }

  public function getGadgetDetector() {
    $supportedGadgetDetectors = array(
      'detect_mobile_browsers',   // note that this is used as the default throughout
      'mobile_detect',
      'tera_wurfl',
      'no_detection'      // defaults to desktop (allows for isolating responsive behavior)
   );

    $config = \Drupal::config('idmygadget.settings');
    $detectorIndex = $config->get('idmygadget_gadget_detector');
    return $supportedGadgetDetectors[$detectorIndex];
  }
}
