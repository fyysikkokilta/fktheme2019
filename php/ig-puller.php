<?php 
/**
 * Integrated plugin for pulling instagram stream off the server and showing it in a neat grid
 */

function fk_ig_getFeed($count) {
    

    $cache_time = fk_get_theme_option( 'cache_timeout' );
    $transient_name = "fk_ig_data";
    $access_token = fk_get_theme_option( 'ig_token' );

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


function fk_ig_printEvents($count) {
    $feed = fk_ig_getFeed($count);
    //print_r($feed);

    for($i = 0; $i < min(8, count($feed)); $i++) {
        $ig_post = $feed[$i];
        $thumb_url = $ig_post->images->standard_resolution->url;
        $link = $ig_post->link;
        echo '<div class="col-md-3 ig-wrap"><div class="ig-item"><a href="'. $link .'" target="_blank"><img src="'. $thumb_url .'"></a></div></div>';
    }
}