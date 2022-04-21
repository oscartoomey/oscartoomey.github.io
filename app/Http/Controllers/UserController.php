<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SpotifyWebApi;

class SpotifyController extends Controller
{
    public function authorise(){
        $session = new SpotifyWebAPI\Session(
            '5ff3da8d355e43ffb5e1a8a521932728',
            'ab04ee8f382942169f0a4ce64f726fc7',
            'REDIRECT_URI'
        );

        $api = new SpotifyWebAPI\SpotifyWebAPI();

        $state = $session->generateState();
        $options = [
            'scope' => [
                'playlist-read-private',
                'user-read-private',
            ],
            'state' => $state,
        ];

        header('Location: ' . $session->getAuthorizeUrl($options));
        die();
    }
}


