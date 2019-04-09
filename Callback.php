<?php namespace OAN\Helpers;

use ReflectionException;
use ReflectionMethod;

/**
 * Callback class, for working with function or method callbacks.
 */
class Callback {

	/**
	 * Get callback from string or callable array
	 *
	 * @param array|string $callback function or class method
	 * @param object $instance If callback is part of an class, static or not.
	 * @return array|string Callable
	 */
	public static function get( $callback, $instance ) {
		if ( is_string( $callback ) and substr( $callback, 0, 4 ) === 'this' ) {
			$callback = [ $instance, end( explode( 'this::', $callback ) ) ];

			if ( self::is_static( implode( '::', array_map( function( $item ) {
				if ( is_object( $item ) )
					return get_class( $item );
				return $item;
			}, $callback ) ) ) ) {
				return '';
			}
		} else if ( is_string( $callback ) and substr( $callback, 0, 4 ) === 'self' ) {
			$callback = get_class( $instance ) . '::' . end( explode( 'self::', $callback ) );

			if ( ! self::is_static( $callback ) ) {
				return '';
			}
		} else if ( is_array( $callback ) and isset( $callback[0] ) and isset( $callback[1] ) ) {
			if ( is_string( $callback[0] ) ) {
				if ( ! self::is_static( implode( '::', $callback ) ) ) {
					return '';
				}
			}
		}

		if ( ! is_callable( $callback, true ) ) {
			return '';
		}

		return $callback;
	}

	/**
	 * Test if method is a static method
	 *
	 * @param string $str
	 * @return boolean
	 */
	public static function is_static( $str = '' ) {
		try {
			$method = new ReflectionMethod( $str );

			if ( $method->isStatic() ) {
				return true;
			}
		} catch ( ReflectionException $e ) {
		}

		return false;
	}

}
