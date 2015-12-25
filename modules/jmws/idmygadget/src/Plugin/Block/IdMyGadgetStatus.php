<?php

namespace Drupal\idmygadget\Plugin\Block;


use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\idmygadget\GadgetDetector;
use Drupal\idmygadget\LearningMore;   // (1)
// use Drupal\idmygadget\LearningMore\LearningMore;  // (2)
use Drupal\idmygadget\TeachMe;
use Drupal\idmygadget\JmwsIdMyGadget;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Reports on idmygadget status.
 *
 * @Block(
 *   id = "idmygadget_status",
 *   admin_label = @Translation("IdMyGadget status"),
 *   category = @Translation("System")
 * )
 */
class IdMyGadgetStatus extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * @var \Drupal\idmygadget\GadgetDetector
   */
  protected $gadgetDetector;

  public function __construct(array $configuration, $plugin_id, $plugin_definition, GadgetDetector $gadgetDetector) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->gadgetDetector = $gadgetDetector;
  }

  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration, $plugin_id, $plugin_definition,
      $container->get('idmygadget.gadget_detector')
    );
  }

  public function defaultConfiguration() {
    return ['enabled' => 1];
  }

  public function blockForm($form, FormStateInterface $form_state) {
    $form['enabled'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('IdMyGadget enabled'),
      '#default_value' => $this->configuration['enabled'],
    ];

    return $form;
  }

  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['enabled'] = (bool)$form_state->getValue('enabled');
  }

  public function build() {
    if ($this->configuration['enabled']) {
      // $message = $this->t('@to was the last person hugged', [
      //   '@to' => $this->gadgetDetector->getLastRecipient()
      // ]);
      $message = $this->t('Using the @gadget_detector detector for device detection', [
        '@gadget_detector' => $this->gadgetDetector->getGadgetDetector()
      ]);
    }
    else {
      $message = $this->t('This module is not enabled.');
    }

	// $jmwsIdMyGadget = new \Drupal\idmygadget\JmwsIdMyGadget\JmwsIdMyGadgetDrupal();
	// $jmwsIdMyGadget = new Drupal\idmygadget\JmwsIdMyGadget\JmwsIdMyGadgetDrupal();
	// $jmwsIdMyGadget = new JmwsIdMyGadgetDrupal();
	// $teachMe = new TeachMe( 'IdMyGadgetStatus::build()' );
	//
	// (1) and (2) Does NOT work in either case, it looks for the class inside of this namespace
	// ie: "Class 'Drupal\\idmygadget\\Plugin\\Block\\Drupal\\idmygadget\\LearningMore\\LearningMore' not found"
	// $learningMore = new Drupal\idmygadget\LearningMore\LearningMore( 'IdMyGadgetStatus::build()' );
	// 
	// (1) Works when we "use Drupal\idmygadget\LearningMore;"
	// (2)            OR "use Drupal\idmygadget\LearningMore\LearningMore;"
	// $learningMore_1 = new \Drupal\idmygadget\LearningMore\LearningMore( 'IdMyGadgetStatus::build() - 1' );
	//
	// (1) Does NOT work when we ""
	// ie: "Class 'Drupal\\idmygadget\\LearningMore' not found..."
	// (2) Works when we "use Drupal\idmygadget\LearningMore\LearningMore;"
	// $learningMore_2 = new LearningMore( 'IdMyGadgetStatus::build() - 2' );

	if ( class_exists('GadgetDetector') ) {
		$message .= '<br />GadgetDetector is a class!';
	}
	else {
		$message .= '<br />Oops GadgetDetector is a NOT class.';
	}

	if ( class_exists('LearningMore') ) {
		$message .= '<br />LearningMore is a class!';
	}
	else {
		$message .= '<br />Oops LearningMore is a NOT class.';
	}

	if ( class_exists('TeachMe') ) {
		$message .= '<br />TeachMe is a class!';
	}
	else {
		$message .= '<br />Oops TeachMe is a NOT class.';
	}

	if ( class_exists('JmwsIdMyGadgetDrupal') ) {
		$message .= '<br />JmwsIdMyGadgetDrupal is a class!';
	}
	else {
		$message .= '<br />Oops JmwsIdMyGadgetDrupal is a NOT class.';
	}

	return [
      '#markup' => $message,
    ];
  }
}
