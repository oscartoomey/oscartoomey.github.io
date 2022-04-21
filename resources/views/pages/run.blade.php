@extends('layout.layout')

<?php

use App\Models\Run as Run;
use App\Models\Song as Song;
use App\Models\Spotify as Spotify;
use App\Models\LastFm as LastFm;

//start the session for storing session variables 
session_start();
//setting counter for use in naming variables

//setting up tockenexchange - Strava
$i = 0;


$api = new Iamstuartwilson\StravaApi(
    $clientId = 80033,
    $clientSecret = '3fcfc7e84d9de182d321dd34c47ae8942ea76f77'
);

$api->tokenExchange($_SESSION["strava_accessToken"]);

$api->setAccessToken($_SESSION["strava_accessToken"], $_SESSION["strava_refreshToken"], $_SESSION["strava_expiresAt"]);


$activities = $api->get('/athlete/activities');

$totalRuns = array();
$labels = array();
$formattedData = array();
$datasets = array();
?>
<h1> Sign into services to use analysis: </h1>
<div class="boxes">
<?php if (isset($_SESSION["spotifyAccessToken"])) { ?>
  <a class="btn btn-outline-success" href="/project/public/signin"> <img src = img/spotify.png alt="logo" height=100> </a>
<?php }
  else { ?>
  <a class="btn btn-outline-danger" href="/project/public/signin"> <img src = img/spotify.png alt="logo" height=100> </a>
  <?php }?>
<?php if ($_SESSION["lastfm"] == true) { ?>
    <a class="btn btn-outline-success" href="/project/public/lastfm"> <img src = img/lastfm.png alt="logo" height=100> </a>
<?php }
  else { ?>
    <a class="btn btn-outline-danger" href="/project/public/lastfm"> <img src = img/lastfm.png alt="logo" height=100></a>
  <?php }?>
<?php if (isset($_SESSION["strava_accessToken"])) { ?>
  <a class="btn btn-outline-success" href="/project/public/stravaSignIn"> <img src = img/strava.png alt="logo" height=100></a>
<?php }
  else { ?>
    <a class="btn btn-outline-danger" href="/project/public/stravaSignIn"> <img src = img/strava.png alt="logo" height=100></a>
  <?php }?>
</div>

<h1> Activity Analysis: </h1>
@foreach($activities as $item) 
    <?php
    $i++;
    $item = json_encode($item); //encoding and decoding so it can be parsed as an array
    $item = json_decode($item, true);
    if ($item["type"] == "Run") {
      ${"run$i"} = new Run($item["name"], strtotime($item["start_date_local"]), $item["distance"], $item["elapsed_time"], $item["average_speed"], $item["max_speed"]);
      if ($item["has_heartrate"] == true) {
        ${"run$i"}->addHeartRate($item["average_heartrate"], $item["max_heartrate"]);
      }
      
      ${"run$i"}->addTotalTime(strtotime($item["start_date_local"]), $item["elapsed_time"]);
      $totalRuns[] = (array) ${"run$i"};
      ${"run$i"}->workoutPace();
      
      $startDate = strtotime($item["start_date_local"]);
      if ($_SESSION["streaming"] == "spotify") {
        $spotify = new Spotify();
        $spotify->getRecentTracks();
        $tracks = $spotify->createSongArray($startDate, ${"run$i"}->totalTime);
      }
      elseif ($_SESSION["streaming"] == "lastFM") {
        $lastFM = new LastFm("oscartoomey1");
        try{
          $lastFM->getRecentTracks($startDate, ${"run$i"}->totalTime);
        }
        catch(Exception $e){
          sleep(5);
          $lastFM->getRecentTracks($startDate, ${"run$i"}->totalTime);
        }
        $tracks = $lastFM->createSongArray($startDate, ${"run$i"}->totalTime);
      }
      ${"run$i"}->addTracks($tracks);
      ${"run$i"}->workoutAverageBpm(${"run$i"}->tracks);
      if (${"run$i"}->hasTracks == true) {
        $labels[] = ${"run$i"}->workoutName;
        $formattedData[] = [
          "x"     => (int) ${"run$i"}->averageBPM,
          "y"     => (int) ${"run$i"}->pace
          ];
      }
    }
    else{
      continue;
    }
    ?>
        <div class="card">
          <div class="card-body">
            <h5 class="card-title"> <?php echo ${"run$i"}->workoutName; ?> </h5>
            <p class="card-text"> 
              <?php echo gmdate("jS \of F Y H:i:s", ${"run$i"}->workoutDate); ?> 
             </p>
          </div>
          <ul class="list-group list-group-flush">
            <li class="list-group-item">Workout time: <?php echo gmdate('H:i:s', ${"run$i"}->workoutTime); ?></li>
            <li class="list-group-item">Workout distance: <?php echo number_format((${"run$i"}->workoutDistance / 1000),2); ?> km </li>
            <li class="list-group-item">Average speed of run: <?php echo ${"run$i"}->averageSpeed; ?> km/h </li>
            <li class="list-group-item"> Max speed of run: <?php echo ${"run$i"}->maxSpeed; ?> km/h</li>
            <li class="list-group-item"> Pace of run (km per minute): <?php echo ${"run$i"}->pace; ?></li> 
          <?php if ($item["has_heartrate"] == true) { ?>
            <li class="list-group-item"> Average heartrate: <?php echo ${"run$i"}->averageHeartRate; ?> bpm</li>
            <li class="list-group-item"> Max heartrate: <?php echo ${"run$i"}->maxHeartRate; ?> bpm </li>
            <?php } ?>
            <?php if (${"run$i"}->hasTracks == false) { ?>
            </ul>
            <?php } 
             else { ?>
              <li class="list-group-item"> Average song tempo: <?php echo number_format(${"run$i"}->averageBPM,0); ?> bpm </li>
            </ul>
            <?php }
          if (${"run$i"}->hasTracks == true) {
            ?>
            Songs Listened to:
            @foreach(array_chunk(${"run$i"}->tracks,6) as $chunk)
            <div class="row">
              @foreach($chunk as $photos)
                <div class="col-md-1">
                    <a class="thumbnail" href=<?php echo $photos->songUrl; ?> >
                  <img class="img-responsive" src=<?php echo $photos->songImage; ?> height="100" alt="">
                </a>
              </div>
              @endforeach
          </div>
          @endforeach
          <?php } ?>
        </div>
@endforeach


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <h3 class="box-title">Hover over icons for run title</h3>
  <div class="chart">
    <canvas id="myChart1" height="100"></canvas>
  </div>

<script>
var myChart1 = document.getElementById('myChart1').getContext('2d');

// Global Options
Chart.defaults.defaultFontFamily = 'Lato';
Chart.defaults.defaultFontSize = 18;
Chart.defaults.color = '#000000';
Chart.defaults.showLine = true;

var jsArray = JSON.parse('<?php echo json_encode($formattedData); ?>');
var myLabel = JSON.parse('<?php echo json_encode($labels); ?>');

var massPopChart = new Chart(myChart1, {
  type:'scatter', // bar, horizontalBar, pie, line, doughnut, radar, polarArea
  data:{
    labels: "Hover over for run title",
    datasets:[{
      label: myLabel,
      data: jsArray,
      //backgroundColor:'green',
      backgroundColor:[
        'rgba(255, 99, 132, 0.6)',
        'rgba(54, 162, 235, 0.6)',
        'rgba(255, 206, 86, 0.6)',
        'rgba(75, 192, 192, 0.6)',
        'rgba(153, 102, 255, 0.6)',
        'rgba(255, 159, 64, 0.6)',
        'rgba(255, 99, 132, 0.6)'
      ],
      borderWidth:1,
      borderColor:'#000000',
      hoverBorderWidth:3,
      hoverBorderColor:'#000',
      pointRadius: 7
    }]
  },
  options:{
    layout:{
      padding:{
        left:50,
        right:0,
        bottom:0,
        top:0
      }
    },
    plugins: {
      title:{
        display:true,
        text: "BPM Analysis",
        fontSize:25,
        responsive: true
      },
      legend:{
        display: false,
        position:'right',
        labels:{
          fontColor:'#000'
        }
      },
      tooltip: {
        display: true,
        callbacks: {
          label: function(tooltipItem, data) {
            //console.log(tooltipItem);
            //console.log(dataIndex);
           var label = massPopChart.data.datasets[tooltipItem.datasetIndex].label[tooltipItem.dataIndex];
           return label;
          }
        }
      }
    },
    scales: {
      y: {
        display: true,
        reverse: true,
        title: {
          display: true,
          text: 'Pace'
        }
      },
      x: {
        display: true,
        title: {
          display: true,
          text: 'Average BPM'
        }
      }
    }
  }
});
  </script>


