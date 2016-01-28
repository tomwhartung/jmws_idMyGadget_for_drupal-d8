<?php

namespace Drupal\idmygadget\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\idmygadget\IdMyGadgetService;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\node\NodeInterface;

class IdMyGadgetController extends ControllerBase {

  /**
   * @var \Drupal\idmygadget\IdMyGadgetService
   */
  protected $idMyGadgetService;

  public function __construct(IdMyGadgetService $idMyGadgetService) {
    $this->idMyGadgetService = $idMyGadgetService;
  }

  /**
   * From hello world example under "Creating Drupal 8 modules"
   * Reference: https://www.drupal.org/node/2464199
   */
  public function content() {
    return array(
        '#type' => 'markup',
        '#markup' => $this->t('Hello, World - from IdMyGadgetController.php::content'),
    );
  }
  public static function create(ContainerInterface $container) {
    return new static($container->get('idmygadget.idmygadget_service'));
  }

  public function idMyGadget() {
    return array(
        '#type' => 'markup',
        '#markup' => $this->t('Hello, World - from IdMyGadgetController.php::idMyGadget'),
    );
  }
}
