<?php

if ( filter_input( INPUT_GET, 'app-builder-search' ) ) {

	define( 'SHORINIT', true );

	require_once ABSPATH . '/wp-load.php';

	$search = sanitize_text_field( $_GET["app-builder-search"] );

	global $wpdb;

	$return = array();

	$posts = $wpdb->get_results( "SELECT * FROM wp_posts WHERE MATCH (`post_title`, `post_content`) AGAINST ('$search' IN NATURAL LANGUAGE MODE)" );

	foreach ( $posts as $post ) {
		$newPost = array();

		$newPost['id']      = (int) $post->ID;
		$newPost['title']   = $post->post_title;
		$newPost['url']     = $post->guid;
		$newPost['type']    = $post->post_type;
		$newPost['subtype'] = $post->post_type;

		$return[] = $newPost;
	}

	wp_send_json( $return );
}

if ( filter_input( INPUT_GET, 'app-builder-lang' ) ) {

	define( 'SHORINIT', true );

	require_once ABSPATH . '/wp-load.php';

	$lang = sanitize_text_field( $_GET["app-builder-lang"] );

	$languages = file_get_contents( plugin_dir_url( dirname( __FILE__ ) ) . "assets/lang/$lang" );

	wp_send_json( json_decode( $languages ) );
}