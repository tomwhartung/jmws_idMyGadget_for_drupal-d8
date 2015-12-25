<?php
namespace Drupal\idMyGadget\Heirarchy;

class SubClass extends TheBase {
	public function __construct( $createdBy='' ) {
		error_log( 'This SubClass object was created by ' . $createdBy . '.' );
	}

	public function logToday() {
		error_log( 'SubClass class is logging today.' );
	}
}
