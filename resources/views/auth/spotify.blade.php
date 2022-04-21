@extends('layout.layout')

@php

$session = new SpotifyWebAPI\Session(
    '5ff3da8d355e43ffb5e1a8a521932728',
    'ab04ee8f382942169f0a4ce64f726fc7',
    'http://localhost:80/project/public/spotify'
);

$state = $_GET['state'];

// Fetch the stored state value from somewhere. A session for example


// Request a access token using the code from Spotify
$session->requestAccessToken($_GET['code']);

$accessToken = $session->getAccessToken();
$refreshToken = $session->getRefreshToken();

// Store the access and refresh tokens somewhere. In a session for example
session_start();
$_SESSION["spotifyAccessToken"] = $accessToken;
$_SESSION["spotifyRefreshToken"] = $refreshToken;
$_SESSION["streaming"] = "spotify";
$_SESSION["spotify"] = true;



// Send the user along and fetch some data!
header('Location: run');
die();


@endphp