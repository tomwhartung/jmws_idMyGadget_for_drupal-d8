<?php

namespace Drupal\idmygadget;

use Drupal\Core\State\StateInterface;
use Drupal\idMyGadget\JmwsIdMyGadget;

// require 'JmwsIdMyGadget/JmwsIdMyGadgetDrupal.php';

class GadgetDetector {

  public $jmwsIdMyGadget;

  /**
   * @var \Drupal\Core\State\StateInterface
   */
  protected $state;

  public function __construct(StateInterface $state) {
    $this->state = $state;
	// $this->jmwsIdMyGadget = new \Drupal\idmygadget\JmwsIdMyGadget\JmwsIdMyGadgetDrupal();
	// $this->jmwsIdMyGadget = new Drupal\idmygadget\JmwsIdMyGadget\JmwsIdMyGadgetDrupal();
	// $this->jmwsIdMyGadget = new JmwsIdMyGadgetDrupal();
	// $this->jmwsIdMyGadget = new JmwsIdMyGadgetDrupal();
	$teachMe = new TeachMe();
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
