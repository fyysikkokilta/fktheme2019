<?php
require __DIR__ . '/google-cal-api/vendor/autoload.php';

function fk_cal_getClient()
{
    /**
     * This is only used for authorization. It shouldn't happen usually
     * If calendar puller does not work, then this should somehow be used to generate new api credentials
     * However, I (Alpi) am not 100% sure how it whould happen :Ds
     * 
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

function fk_cal_fetchEvents($transient_name, $event_count) {
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
    'maxResults' => $event_count,
    'orderBy' => 'startTime',
    'singleEvents' => true,
    'timeMin' => date('c'),
    );

    // Returns date or datetime of event as unix timestring for sorting purposes
    function gcal_datetime_parser($event) {
        $dt = strtotime($event->start->dateTime);
        if(empty($dt)) {
            $dt = strtotime($event->start->date);
        }
        return $dt;
    }

    // Returns date or datetime as formatted string for frontend purposes
    function gcal_event_time($event) {
        if(!empty($event->start->dateTime)) {
            $dt = new DateTime($event->start->dateTime);
            $timeString = $dt->format('j.n. H:i');
        } else {
            $dt = new DateTime($event->start->date);
            $timeString = $dt->format('j.n.');
        }   
        return $timeString;
    }

    // For each calendar, fetch upcoming events
    $events = [];
    foreach ($calendars as $calname => $id) {
        $results = $service->events->listEvents($id, $optParams);
        $calEvent = $results->getItems();
        foreach($calEvent as $event) {
            $event->{"calname"} = $calname;
            $event->start->{"dateInt"} = gcal_datetime_parser($event);
            $event->start->{"timeString"} = gcal_event_time($event);

            $event_location = '';
            if(!empty($event->location)) {
                $event_location = explode(',', $event->location)[0];
            }

            $event->{"locationString"} = $event_location;

            $event->{"icon"} = fk_cal_getEventIcon($calname);

            array_push($events, $event);
        }
    }

    // Sorts events into order
    usort($events, function($a, $b) {
        $ad = $a->start->dateInt;
        $bd = $b->start->dateInt;
    
        if ($ad == $bd) {
        return 0;
        }
    
        return $ad < $bd ? -1 : 1;
    });

    /**
     * Take requested number of events events, write into transient and return
     */

    $events_slice = array_slice($events, 0, $event_count);

    $cache_time = fk_get_theme_option( 'cache_timeout' );
    set_transient($transient_name, $events_slice, $cache_time);

    return $events;
}


function fk_cal_getEvents($event_count) 
{
    /**
     * Returns event object either from database or (if )
     */

    $transient_name =  "fk_cal_data";
    //delete_transient($transient_name); // delete transient always for debugging purposes

    $events = get_transient($transient_name);
    if ($events === false) {
        $events = fk_cal_fetchEvents($transient_name, $event_count);
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

    $events = fk_cal_getEvents($event_count); 

    if (empty($events)) {
        echo '<div class="error"> No upcoming events found. </div>';
    } else {

        $output = '';
        for($i = 0; $i < min($event_count, count($events)); $i++) {
            $event = $events[$i];

            $output .= '<div class="col-md-4 col-lg-3 cal-wrap">';
            $output .= '<div class="calendar-item ' . $event->calname .'">';
            $output .= '<i class="'  . $event->icon . '"></i><a href="' . $event->htmlLink . '" target="_blank">';
            $output .= '<h5>' . $event->getSummary() . '</h5></a><p class="cal_location">' . $event->locationString . '</p><p class="cal_time">' . $event->start->timeString .'</p>';
            $output .= '</div></div>';
            
        }

        echo $output;

    }
}