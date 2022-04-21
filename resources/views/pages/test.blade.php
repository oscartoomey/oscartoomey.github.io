@extends('layout.layout')

<div id="workoutName"> <?php echo "hi"?> </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.min.js"></script>
    <h3 class="box-title">BPM analysis</h3>
    <div class="chart">
        <canvas id="myChart1" height="100"></canvas>
    </div>
<script>
var myChart1 = document.getElementById('myChart1').getContext('2d');

// Global Options
Chart.defaults.global.defaultFontFamily = 'Lato';
Chart.defaults.global.defaultFontSize = 18;
Chart.defaults.global.defaultFontColor = '#777';

var div = document.getElementById("workoutName");
var myData = div.textContent;

var massPopChart = new Chart(myChart1, {
  type:'scatter', // bar, horizontalBar, pie, line, doughnut, radar, polarArea
  data:{
    labels:[ 'penis', 'Worcester', 'Springfield', 'Lowell', 'Cambridge', 'New Bedford'],
    datasets:[{
      label:'Population',
      data:[
        {x: 2000,
        y: 2000},
        {x: 2000,
        y: 20000}
      ],
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
      borderColor:'#777',
      hoverBorderWidth:3,
      hoverBorderColor:'#000'
    }]
  },
  options:{
    title:{
      display:true,
      text: myData,
      fontSize:25,
      responsive: true
    },
    legend:{
      display:true,
      position:'right',
      labels:{
        fontColor:'#000'
      }
    },
    layout:{
      padding:{
        left:50,
        right:0,
        bottom:0,
        top:0
      }
    },
    tooltips:{
      enabled:true
    }
  }
});
  </script>

<script>

  function loadDoc() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
       document.getElementById("demo").innerHTML = this.responseText;
      }
    };
    xhttp.open("GET", "information", true);
    xhttp.send();
  }
  </script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.min.js"></script>
   <h3 class="box-title">BPM analysis</h3>
  <div class="chart">
    <canvas id="myChart1" height="100"></canvas>
  </div>
<script>
var myChart1 = document.getElementById('myChart1').getContext('2d');

// Global Options
Chart.defaults.global.defaultFontFamily = 'Lato';
Chart.defaults.global.defaultFontSize = 18;
Chart.defaults.global.defaultFontColor = '#000000';
Chart.defaults.global.showLines = true;

var jsArray = JSON.parse('<?php echo json_encode($formattedData); ?>');
var myLabel = JSON.parse('<?php echo json_encode($labels); ?>');

var massPopChart = new Chart(myChart1, {
  type:'scatter', // bar, horizontalBar, pie, line, doughnut, radar, polarArea
  data:{
    labels: myLabel,
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
      hoverBorderColor:'#000'
    }]
  },
  options:{
    title:{
      display:true,
      text: "BPM Analysis",
      fontSize:25,
      responsive: true
    },
    legend:{
      display:true,
      position:'right',
      labels:{
        fontColor:'#000'
      }
    },
    layout:{
      padding:{
        left:50,
        right:0,
        bottom:0,
        top:0
      }
    },
    tooltips:{
      enabled:true
    },
    scales: {
            x: [{
                type: 'linear',
                position: 'bottom',
                text: 'pace'
            }]
        }
  }
});
  </script>

<?php $datasets = json_encode($datasets); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <h3 class="box-title">BPM analysis</h3>
  <div class="chart">
    <canvas id="myChart1" height="100"></canvas>
  </div>
<script>
var myChart1 = document.getElementById('myChart1').getContext('2d');

// Global Options
Chart.defaults.defaultFontFamily = 'Lato';
Chart.defaults.defaultFontSize = 18;
Chart.defaults.color = '#000000';
Chart.defaults.showLines = true;

var jsArray = JSON.parse('<?php echo json_encode($formattedData); ?>');
var myLabel = JSON.parse('<?php echo json_encode($labels); ?>');

var massPopChart = new Chart(myChart1, {
  type:'scatter', // bar, horizontalBar, pie, line, doughnut, radar, polarArea
  data:{
    labels: myLabel,
    datasets:[{
      label: "Hover to see run",
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
      hoverBorderColor:'#000'
    }]
  },
  options:{
    title:{
      display:true,
      text: "BPM Analysis",
      fontSize:25,
      responsive: true
    },
    legend:{
      display:true,
      position:'right',
      labels:{
        fontColor:'#000'
      }
    },
    layout:{
      padding:{
        left:50,
        right:0,
        bottom:0,
        top:0
      }
    },
    tooltips: {
      display: true,
         callbacks: {
            label: function(tooltipItem, data) {
               var label = data.labels[tooltipItem.index];
               return label + ': (' + tooltipItem.xLabel + ', ' + tooltipItem.yLabel + ')';
            }
         }
      },
    scales: {
      y: {
        display: true,
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

tooltips: {
  display: true,
     callbacks: {
        label: function(tooltipItem, data) {
           var label = data.labels[tooltipItem.index];
           return label + ': (' + tooltipItem.xLabel + ', ' + tooltipItem.yLabel + ')';
        }
     }
  }

