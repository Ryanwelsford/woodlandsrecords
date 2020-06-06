<div class="container">
  <div class="ch">  
    <div class="row row-row">
        <div class="col col-col">
            <h4 class="numb">56</h4>
            <h5 class="numb">Number of students</h5>
        </div>

        <div class="col col-col">
            <h4 class="numb">100</h4>
            <h5 class="numb">Number of Staff members</h5>
        </div>
    </div>
    </div>

    <div class="row">
        <div class="col pie">
            <h4>Pie Chart</h4>
            <div id="donutchart" style="width: 500px; height: 400px;"></div>
            <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
          ['Work',     11],
          ['Eat',      2],
          ['Commute',  2],
          ['Watch TV', 2],
          ['Sleep',    7]
        ]);

        var options = {
          title: 'My Daily Activities',
          pieHole: 0.4,
          chartArea: {
              backgroundColor: {
                  fill: '#FF0000',
                  fillOpacity: 0.1
              },
          }
        };

        var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
        chart.draw(data, options);
      }
    </script>
        </div>
    </div>
</div>