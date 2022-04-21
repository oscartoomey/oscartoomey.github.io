@extends('layout.layout')

@php
$session = new SpotifyWebAPI\Session(
            '5ff3da8d355e43ffb5e1a8a521932728',
            'ab04ee8f382942169f0a4ce64f726fc7',
            'http://localhost:80/project/public/spotify'
        );

        $api = new SpotifyWebAPI\SpotifyWebAPI();

        $state = $session->generateState();
        $options = [
            'scope' => [
                'playlist-read-private',
                'user-read-private',
                'user-read-recently-played'
            ],
            'state' => $state,
        ];

        header('Location: ' . $session->getAuthorizeUrl($options));
        die();
@endphp