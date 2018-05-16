<?php

if ( ! function_exists( 'dd' ) ) {
	function dd( $data ) {
		var_dump( $data );
		die();
	}
}

if ( ! function_exists( 'public_path' ) ) {
	function public_path( $folder = null ) {
		if ( $folder ) {
			return dirname( __DIR__ ) . "/public/{$folder}";
		}

		return dirname( __DIR__ ) . '/public/';
	}
}
