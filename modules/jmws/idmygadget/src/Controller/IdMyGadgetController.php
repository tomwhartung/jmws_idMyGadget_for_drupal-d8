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

  public function nodeHug(NodeInterface $node) {
    if ($node->isPublished()) {
      // These are the same!
      $body = $node->body->value;
      $body = $node->body[0]->value;

      // But we really want...
      $formatted = $node->body->processed;

      $terms = [];
      foreach ($node->field_tags as $tag) {
        $terms[] = $tag->entity->label();
      }

      $message = $this->t('Everyone hug @name because @reasons!', [
        '@name' => $node->getOwner()->label(),
        '@reasons' => implode(', ', $terms),
      ]);

      return [
        '#title' => $node->label() . ' (' . $node->bundle() . ')',
        '#markup' => $message . $formatted,
      ];
    }
    return $this->t('Not published');
  }

  public function hug($to, $from, $count) {
    $this->idMyGadgetService->addHug($to);
    if (!$count) {
      $count = $this->config('idmygadget.settings')->get('default_count');
    }
    return [
      '#theme' => 'hug_page',
      '#from' => $from,
      '#to' => $to,
      '#count' => $count
    ];
  }

  public function hug3($to, $from, $count) {
    if (!$count) {
      $count = $this->config('idmygadget.settings')->get('default_count');
    }
    return [
      '#theme' => 'hug_page',
      '#from' => $from,
      '#to' => $to,
      '#count' => $count
    ];
  }

  public function hug2($to, $from) {
    return [
      '#theme' => 'hug_page',
      '#from' => $from,
      '#to' => $to,
    ];
  }

  public function hug1($to, $from) {
    $message = $this->t('%from sends hugs to %to', [
      '%from' => $from,
      '%to' => $to,
    ]);

    return $message;
  }
}
