<?php 


session_start();

//$date = $_SESSION["activity"]["start_date_local"];

//$dt = new DateTime($date);
//$date = $dt->format('d-m-Y');
//$time = $dt->format('h:i:s A');
//echo $date, $time;

$session = new SpotifyWebAPI\Session(
            '5ff3da8d355e43ffb5e1a8a521932728',
            'ab04ee8f382942169f0a4ce64f726fc7',
            'http://localhost:80/project/public/spotify'
        );

$api = new SpotifyWebAPI\SpotifyWebAPI();

$api->setAccessToken($_SESSION["spotifyAccessToken"]);
$me = $api->me();

?>
<h1> Charts: </h1>