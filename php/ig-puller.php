<?php 
/**
 * Integrated plugin for pulling instagram stream off the server and showing it in a neat grid
 */

function fk_ig_getFeed($count) {
    $cache_time = 2*60*60;
    $transient_name = "fk_ig_data";
    $access_token = '';

    $feed = ''; 
    if( false === ($feed = get_transient($transient_name))) {
        $url  = 'https://api.instagram.com/v1/users/self/media/recent/';
        $url .= '?count=' . $count . '&amp;access_token=' . $access_token;
        
        $response = wp_remote_get($url);
        if($response) {
            $body = json_decode( $response['body'] );
			$feed = $body->data;

			// Cache the response in your database so that you
			set_transient( $transient_name, $feed, $cache_time);
        }
    }
    return $feed;
}