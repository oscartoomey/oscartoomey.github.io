<?php 
namespace App\Models;
use LastFmApi\Api\AuthApi;
use LastFmApi\Api\UserApi;
use App\Models\Song as Song;
use SpotifyWebAPI;


class LastFm {
    private $apiKey;

    public function __construct($user) {
        $this->apiKey = '79442229b53529893d8352bc2266bfbb'; //required
        $auth = new AuthApi('setsession', array('apiKey' => $this->apiKey));
        $this->lastfmApi = new UserApi($auth);
        $this->user = $user;

        $session = new SpotifyWebAPI\Session(
            '5ff3da8d355e43ffb5e1a8a521932728',
            'ab04ee8f382942169f0a4ce64f726fc7',
            'http://localhost:80/project/public/spotify'
        );

        $spotifyApi = new SpotifyWebAPI\SpotifyWebAPI();

        $spotifyApi->setAccessToken($_SESSION["spotifyAccessToken"]);
        $this->spotifyApi = $spotifyApi;
    }

    public function getRecentTracks($startDate, $totalTime) {
        $recentTracks = $this->lastfmApi->getRecentTracks(array("user" => $this->user), $startDate, $totalTime);

        $this->tracks = $recentTracks;
    }
    
    public function searchSpotify($songName){
        $options = array(null, 5, null);
        $results = $this->spotifyApi->search($songName, 'track', $options);
        $trackInfo = json_encode($results);
        $trackInfo = json_decode($trackInfo, true);
        $trackId = $trackInfo["tracks"]["items"][0]["id"];
        return $trackId;
    }

    public function createSongArray($startDate, $totalTime){
        $songArray = array();
        if (is_null($this->tracks)){
            return $songArray;
        }
        else {
            foreach($this->tracks as $song) {
                $runTime = $song["date"] + 3600;
                $songId = $song["mbid"];
                $songName = $song["name"];
                $songAlbum = $song["album"]["name"];
                $songArtist = $song["artist"]["name"];
                $playedAt = $song["date"];
                $songUrl = $song["url"];
                $songImage = $song["images"]["large"];
                ${"song$songName"} = new Song($songId, $songName, $songAlbum, $songArtist, $playedAt, $songUrl, $songImage);
                $trackId = $this->searchSpotify($songName);
                ${"song$songName"}->addInfo($trackId);
                $songArray[] = ${"song$songName"};
            }
        return $songArray;
        }
    }
}

?>