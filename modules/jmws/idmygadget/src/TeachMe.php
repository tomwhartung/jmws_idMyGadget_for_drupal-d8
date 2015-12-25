<?php
namespace Drupal\idMyGadget;

class TeachMe {
	public function __construct( $createdBy='' ) {
		// print 'Teach me.';
		error_log( 'TeachMe object created by ' . $createdBy . '.' );
	}

	public function teachMe() {
		error_log( 'Teach me.' );
	}
}
