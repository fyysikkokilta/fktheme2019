<?php 
/**
 * Integrated plugin for pulling instagram stream off the server and showing it in a neat grid
 */

function fk_ig_getFeed($count) {

    $cache_time = fk_get_theme_option( 'cache_timeout' );
    $transient_name = "fk_ig_data";
    $access_token = fk_get_theme_option( 'ig_token' );

    //delete_transient( 'fk_ig_data' ); // Delete transient, for debugging 

    $feed = ''; 
    if( false === ($feed = get_transient($transient_name))) {
        $url  = 'https://api.instagram.com/v1/users/self/media/recent/';
        $url .= '?count=' . $count . '&amp;access_token=' . $access_token;
        
        $response = wp_remote_get($url, array( 'timeout' => 30, 'httpversion' => '1.1' ));
        if( is_array($response)) {
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

    if($feed) {
        for($i = 0; $i < min(8, count($feed)); $i++) {
            $ig_post = $feed[$i];
            $thumb_url = $ig_post->images->standard_resolution->url;
            $link = $ig_post->link;
            echo '<div class="col-6 col-md-4 col-lg-3 ig-wrap"><div class="ig-item"><a href="'. $link .'" alt="Instagram" target="_blank"><img src="'. $thumb_url .'" alt="Instagram feed"></a></div></div>';
        }
    }
}