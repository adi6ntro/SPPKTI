<?php if($nama!=false){ ?>
  <script type="text/javascript" src="https://www.google.com/jsapi"></script>
  <script type="text/javascript">
    google.load("visualization", "1", {packages:["corechart"]});
    google.setOnLoadCallback(drawChart);
    function drawChart() {
      var data = google.visualization.arrayToDataTable(<?php echo $value;?>);
      var options = {
        title: 'Top 10 results for Skema:<?php echo $nama;?>',
        hAxis: {title: 'Number of result', titleTextStyle: {color: 'red'}}
      };
      var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
      chart.draw(data, options);
    }
  </script>
  <div id="chart_div" style="width: 800px; height: 500px;"></div>
<?php }else{ echo $value; } ?>
