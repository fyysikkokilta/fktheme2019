<?php
require __DIR__ . '/google-cal-api/vendor/autoload.php';

/*if (php_sapi_name() != 'cli') {
    throw new Exception('This application must be run on the command line.');
}*/

//$time_start = microtime(true); 

/**
 * Returns an authorized API client.
 * @return Google_Client the authorized client object
 */
function getClient()
{

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

function getGcalEvents() {
    // Get the API client and construct the service object.
    $client = getClient();
    $service = new Google_Service_Calendar($client);

    //$time_client = microtime(true);

    // All availavle calendars
    // Should this be moved to WP plugin or something?
    $calendars = [
        "tapahtumat"=> "ahe0vjbi6j16p25rcftgfou5eg@group.calendar.google.com",
        "kokoukset"=> "guqva296aoq695aqgq68ak7lkc@group.calendar.google.com",
        "fuksit"=> "u6eju2k63ond2fs7fqvjbna50c@group.calendar.google.com",
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

    $events = [];
    foreach ($calendars as $name => $id) {
        $results = $service->events->listEvents($id, $optParams);
        //printf("%s\n", $name);
        $calEvent = $results->getItems();
        foreach($calEvent as $event) {
            $event->{"calname"} = $name;
            $event->start->{"dateInt"} = gcal_datetime_parser($event);
            array_push($events, $event);
        }
    }

    //$time_fetch = microtime(true);


    // Sorts things into order
    usort($events, function($a, $b) {
        $ad = $a->start->dateInt;
        $bd = $b->start->dateInt;
    
        if ($ad == $bd) {
        return 0;
        }
    
        return $ad < $bd ? -1 : 1;
    });

    /*
    $time_sort = microtime(true);
    $time1 = ($time_client - $time_start)/60;
    $time2 = ($time_fetch - $time_client)/60;
    $time3 = ($time_sort - $time_fetch)/60;
    echo $time1 . "\n";
    echo $time2 . "\n";
    echo $time3 . "\n";
    */

    /*
    if (empty($events)) {
        print "No upcoming events found.\n";
    } else {
        print "Upcoming events:\n";
        foreach ($events as $event) {
            $start = $event->start->dateTime;
            if (empty($start)) {
                $start = $event->start->date;
            }
            printf("%s (%s) ((%s))\n", $event->getSummary(), $start, $event->calname);
        }
    }
    */

    return $events;
}