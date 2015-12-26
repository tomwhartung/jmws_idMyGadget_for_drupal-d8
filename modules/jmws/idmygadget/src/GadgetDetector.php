<?php

namespace Drupal\idmygadget;

use Drupal\Core\State\StateInterface;
use Drupal\idmygadget\JmwsIdMyGadget\JmwsIdMyGadget;
use Drupal\idmygadget\JmwsIdMyGadget\JmwsIdMyGadgetDrupal;

// require 'JmwsIdMyGadget/JmwsIdMyGadgetDrupal.php';

class GadgetDetector {

  public $jmwsIdMyGadget;

  /**
   * @var \Drupal\Core\State\StateInterface
   */
  protected $state;

  public function __construct(StateInterface $state) {
    $this->state = $state;

	//
	// $this->jmwsIdMyGadget = new \Drupal\idmygadget\JmwsIdMyGadget\JmwsIdMyGadgetDrupal();
	// $this->jmwsIdMyGadget = new Drupal\idmygadget\JmwsIdMyGadget\JmwsIdMyGadgetDrupal();
	// In this case, it is not enough to create an object of the base class.  
	// We still get an error when trying to use the un-namespaced idMyGadget code.
	// And I am not quite ready to namespace all that right now....
	//
	// $wtfSeriously = new \Drupal\idmygadget\JmwsIdMyGadget\JmwsIdMyGadget();
	// $this->jmwsIdMyGadget = new JmwsIdMyGadgetDrupal();
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
