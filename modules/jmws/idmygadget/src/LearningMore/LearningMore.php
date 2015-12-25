<?php
namespace Drupal\idMyGadget\LearningMore;

class LearningMore {
	public function __construct( $createdBy='' ) {
		// print 'LearningMore today.';
		error_log( 'This LearningMore object was created by ' . $createdBy . '.' );
	}

	public function learningMore() {
		error_log( 'LearningMore today.' );
	}
}
