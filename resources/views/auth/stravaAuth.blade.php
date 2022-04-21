@extends('layout.layout')

<?php
session_start();

if (
    !empty($_SESSION['strava_access_token'])
    && !empty($_SESSION['strava_refresh_token'])
    && !empty($_SESSION['strava_access_token_expires_at'])
) {
    $api->setAccessToken(
        $_SESSION['strava_access_token'],
        $_SESSION['strava_refresh_token'],
        $_SESSION['strava_access_token_expires_at']
    );
}

$api = new Iamstuartwilson\StravaApi(
    $clientId = 80033,
    $clientSecret = '3fcfc7e84d9de182d321dd34c47ae8942ea76f77'
);

$code = $_GET["code"];
$_SESSION['stravaCode'] = $code;
$result = $api->tokenExchange($code);

$accessToken = $result->access_token;
$refreshToken = $result->refresh_token;
$expiresAt = $result->expires_at;
$_SESSION["strava_accessToken"] = $accessToken;
$_SESSION["strava_refreshToken"] = $refreshToken;
$_SESSION["strava_expiresAt"] = $expiresAt;

$api->setAccessToken($accessToken, $refreshToken, $expiresAt);

header('Location: streaming');
die();

?>


