<?php
namespace Drupal\idMyGadget\Heirarchy;

class SubClass extends TheBase {
	public function __construct( $createdBy='' ) {
		error_log( 'This TheBase object was created by ' . $createdBy . '.' );
	}

	public function logToday() {
		error_log( 'TheBase class is logging today.' );
	}
}
