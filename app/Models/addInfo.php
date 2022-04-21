<?php 

namespace App\Models;
use App\Models\Song as Song;
class addInfo {

    public function addingInfo($songId){
        session_start();

        $session = new SpotifyWebAPI\Session(
            '5ff3da8d355e43ffb5e1a8a521932728',
            'ab04ee8f382942169f0a4ce64f726fc7',
            'http://localhost:80/project/public/spotify'
        );

        $spotifyApi = new SpotifyWebAPI\SpotifyWebAPI();

        $spotifyApi->setAccessToken($_SESSION["spotifyAccessToken"]);
        $me = $spotifyApi->me();

        $trackInfo = $spotifyApi->getAudioFeatures($songId);

        return $trackInfo;
    }
}

?>