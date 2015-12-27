<?php

namespace Drupal\idmygadget;

use Drupal\Core\State\StateInterface;

// require 'JmwsIdMyGadget/JmwsIdMyGadgetDrupal.php';
// use Drupal\idmygadget\JmwsIdMyGadget\JmwsIdMyGadget;
// use Drupal\idmygadget\JmwsIdMyGadget\JmwsIdMyGadgetDrupal;

use Drupal\idmygadget\JmwsIdMyGadget\GetJmwsIdMyGadgetDrupal;

class GadgetDetector {

  /**
   * The Service: device detection via the selected detector, via IdMyGadget
   * @var type JmwsIdMyGadgetDrupal
   */
  public $jmwsIdMyGadget = null;

  /**
   * @var \Drupal\Core\State\StateInterface
   */
  protected $state;

  public function __construct(StateInterface $state) {
    $this->state = $state;

    $gadgetDetectorString = $this->getGadgetDetectorString();
    $getJmwsIdMyGadgetDrupal = new GetJmwsIdMyGadgetDrupal( $gadgetDetectorString );
    $this->jmwsIdMyGadget = $getJmwsIdMyGadgetDrupal->getJmwsIdMyGadget();

  }

  public function addHug($target_name) {
    $this->state->set('idmygadget.last_recipient', $target_name);
    return $this;
  }

  public function getLastRecipient() {
    return $this->state->get('idmygadget.last_recipient');
  }

  public function getGadgetDetectorString() {
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
