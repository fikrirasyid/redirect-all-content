<?php
/*
    Plugin Name: Redirect All Content
    Version: 0.1
    Description: The simplest plugin which let you redirect all your post/content to new domain
    Author: Fikri Rasyid
    Author URI: http://fikrirasy.id
*/

/**
 * Get current URL, courtesy of Konstantin Kovshenin
 * 
 * @return string of current URL
 */
function rac_redirect_url(){
    global $wp;

    $current_url = add_query_arg( $wp->query_string, '', home_url( $wp->request ) );
    
    $parse_url = parse_url( $current_url );

    $parse_url['host'] = 'fikrirasy.id'; // replace this with your new domain

    $redirect_url = "{$parse_url['scheme']}://{$parse_url['host']}";

    if( isset( $parse_url['path'] ) ){
    	$redirect_url .= "{$parse_url['path']}/";
    }

    if( isset( $parse_url['query'] ) ){
    	$redirect_url .= '?' . urldecode( $parse_url['query'] );
    }

    return $redirect_url;
}

/**
 * Redirect current URL to the new one
 * 
 * @return void
 */
function rac_redirect(){
	if( !is_admin() ){
		wp_redirect( rac_redirect_url() );
		die();
	}
}
add_action( 'wp', 'rac_redirect' );