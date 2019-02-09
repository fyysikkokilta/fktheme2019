<?php
require __DIR__ . '/google-cal-api/vendor/autoload.php';

function fk_cal_getClient()
{
    /**
     * Returns an authorized API client.
     * @return Google_Client the authorized client object
     */

    $client = new Google_Client();
    $client->setApplicationName('Fyysikkokilta WEB');
    $client->setScopes(Google_Service_Calendar::CALENDAR_READONLY);
    $client->setAuthConfig(__DIR__ . '/credentials.json');
    $client->setAccessType('offline');
    $client->setPrompt('select_account consent');

    // Load previously authorized token from a file, if it exists.
    // The file token.json stores the user's access and refresh tokens, and is
    // created automatically when the authorization flow completes for the first
    // time.
    $tokenPath = __DIR__ . '/token.json';
    if (file_exists($tokenPath)) {
        $accessToken = json_decode(file_get_contents($tokenPath), true);
        $client->setAccessToken($accessToken);
    }

    // If there is no previous token or it's expired.
    if ($client->isAccessTokenExpired()) {
        // Refresh the token if possible, else fetch a new one.
        if ($client->getRefreshToken()) {
            $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
        } else {
            // Request authorization from the user.
            $authUrl = $client->createAuthUrl();
            printf("Open the following link in your browser:\n%s\n", $authUrl);
            print 'Enter verification code: ';
            $authCode = trim(fgets(STDIN));

            // Exchange authorization code for an access token.
            $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
            $client->setAccessToken($accessToken);

            // Check to see if there was an error.
            if (array_key_exists('error', $accessToken)) {
                throw new Exception(join(', ', $accessToken));
            }
        }
        // Save the token to a file.
        if (!file_exists(dirname($tokenPath))) {
            mkdir(dirname($tokenPath), 0700, true);
        }
        file_put_contents($tokenPath, json_encode($client->getAccessToken()));
    }
    return $client;
}

function fk_cal_fetchEvents($transient_name) {
    /**
     * Fetches events from Google Calendar API
     * 
     * Inputs a name for to-be-saved transient
     * Returns events as an object
     */

    // Get the API client and construct the service object.
    $client = fk_cal_getClient();
    $service = new Google_Service_Calendar($client);

    // All availavle calendars
    // Should this be moved to WP plugin or something?
    $calendars = [
        "tapahtumat"=> "ahe0vjbi6j16p25rcftgfou5eg@group.calendar.google.com",
        "kokoukset"=> "guqva296aoq695aqgq68ak7lkc@group.calendar.google.com",
        //"fuksit"=> "u6eju2k63ond2fs7fqvjbna50c@group.calendar.google.com",
        "kulttuuri"=> "hjhvblcv9n1ue3tf29j3loqqi4@group.calendar.google.com",
        "liikunta"=> "0orqvov2gidl3m24cnsq4ml1ao@group.calendar.google.com",
        "ura"=> "ji339ebgiaauv5nk07g41o65q8@group.calendar.google.com"
    ];

    $optParams = array(
    'maxResults' => 10,
    'orderBy' => 'startTime',
    'singleEvents' => true,
    'timeMin' => date('c'),
    );

    // Returns date or datetime of event as timestring
    function gcal_datetime_parser($event_object) {
        $dt = strtotime($event_object->start->dateTime);
        if(empty($dt)) {
            $dt = strtotime($event_object->start->date);
        }
        return $dt;
    }

    // For each calendar, fetch upcoming events
    $events = [];
    foreach ($calendars as $name => $id) {
        $results = $service->events->listEvents($id, $optParams);
        $calEvent = $results->getItems();
        foreach($calEvent as $event) {
            $event->{"calname"} = $name;
            $event->start->{"dateInt"} = gcal_datetime_parser($event);
            array_push($events, $event);
        }
    }

    // Sorts things into order
    usort($events, function($a, $b) {
        $ad = $a->start->dateInt;
        $bd = $b->start->dateInt;
    
        if ($ad == $bd) {
        return 0;
        }
    
        return $ad < $bd ? -1 : 1;
    });

    /**
     * Here we write the events into database as well
     */

    $cache_time = fk_get_theme_option( 'cache_timeout' ); // This equals to two hours #TODO
    set_transient($transient_name, $events, $cache_time);

    return $events;
}


function fk_cal_getEvents() 
{
    /**
     * Returns event object either from database or (if )
     */

    $transient_name =  "fk_cal_data";

    $events = get_transient($transient_name);
    if ($events === false) {
        $events = fk_cal_fetchEvents($transient_name);
    }
    return $events;

}

function fk_cal_getEventIcon($event_type) {
    $randint = rand(0,2);
    $icons = [];
    switch($event_type):
        case "tapahtumat":
            $icons = ["fas fa-glass-cheers", "fas fa-hot-tub", "fas fa-glass-cheers"];
            break;
        case "kokoukset":
            $icons = ["fas fa-gavel", "fas fa-stamp", "fas fa-gavel"];
            break;
        case "kulttuuri":
            $icons = ["fas fa-theater-masks", "fas fa-film", "fas fa-theater-masks"];
            break;
        case "liikunta":
            $icons = ["fas fa-quidditch", "fas fa-skiing-nordic", "fas fa-dumbbell"];
            break;
        case "ura":
            $icons = ["fas fa-chart-line", "fas fa-industry", "fas fa-briefcase"];
            break;
    endswitch;

    return $icons[$randint];
}

function fk_cal_printEvents($event_count) {
/**
 * Prints events for frontpage
 */

    $events = fk_cal_getEvents(); 

    if (empty($events)) {
        echo '<div class="error"> No upcoming events found. </div>';
    } else {

        for($i = 0; $i < min($event_count, count($events)); $i++) {
            $event = $events[$i];

            //$event_time = date("j.n. H:i", $event->start->dateInt);

            if(!empty($event->start->dateTime)) {
                $event_time = date('j.n. H:i', $event->start->dateInt);
            } else {
                $event_time = date('j.n.', $event->start->dateInt);
            }

            $event_title = $event->getSummary();
        
            $event_type = $event->calname;
            $event_icon = '<i class="' . fk_cal_getEventIcon($event_type) . '"></i>';

            echo '<div class="col-md-3"><div class="calendar-item ' . $event_type .'">' . $event_icon .'<h5>' . $event_title . '</h4><p>' . $event_time .'</p></div></div>';

        }

    }
}