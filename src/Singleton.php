<?php
namespace OAN\Helpers;

/**
 * Singleton Pattern.
 *
 * Modern implementation.
 */
class Singleton {
	/**
	 * Call this method to get singleton
	 */
	public static function instance() {
		static $instance = false;

		if ( $instance === false ) {
			$instance = new static();
		}

		return $instance;
	}

	/**
	 * Make constructor private, so nobody can call "new Class".
	 */
	private function __construct() {}

	/**
	 * Make clone magic method private, so nobody can clone instance.
	 */
	private function __clone() {}
}
