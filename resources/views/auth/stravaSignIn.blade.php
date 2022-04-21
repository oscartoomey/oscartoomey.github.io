@extends('layout.layout')

@php


$api = new Iamstuartwilson\StravaApi(
    $clientId = 80033,
    $clientSecret = '3fcfc7e84d9de182d321dd34c47ae8942ea76f77'
);

header("Location: https://www.strava.com/oauth/authorize?client_id=80033&response_type=code&redirect_uri=http://localhost:80/project/public/stravaAuth&approval_prompt=force&scope=activity:read_all");
//header('Location: ' . $api->authenticationUrl($redirect = 'http://localhost:80/project/public/stravaSignIn', $approvalPrompt = 'auto', $scope = null, $state = null));
die();
@endphp