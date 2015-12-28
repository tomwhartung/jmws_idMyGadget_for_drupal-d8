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

    $gadgetDetectorIndex = $this->getGadgetDetectorIndex();
    $getJmwsIdMyGadgetDrupal = new GetJmwsIdMyGadgetDrupal( $gadgetDetectorIndex );
    $this->jmwsIdMyGadget = $getJmwsIdMyGadgetDrupal->getJmwsIdMyGadget();

  }

  public function addHug($target_name) {
    $this->state->set('idmygadget.last_recipient', $target_name);
    return $this;
  }

  public function getLastRecipient() {
    return $this->state->get('idmygadget.last_recipient');
  }

  public function getGadgetDetectorIndex() {
    $config = \Drupal::config('idmygadget.settings');
    $detectorIndex = $config->get('idmygadget_gadget_detector');
    return $detectorIndex;
  }
}
