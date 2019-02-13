<section class="content-header">
  <h1>Dashboard <small>Control panel</small></h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Dashboard</li>
  </ol>
</section>
<section class="content">
  <div class="row">
    <div class="col-lg-6 col-xs-6">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Total Record</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          </div>
        </div>
        <div class="box-body">
          <div class="col-lg-6 col-xs-6">
            <div class="small-box bg-aqua">
              <div class="inner">
                <h3><?php echo $num_users; ?></h3>
                <p>Users</p>
              </div>
              <div class="icon"><i class="ion ion-person-add"></i></div>
              <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-6 col-xs-6">
            <div class="small-box bg-green">
              <div class="inner">
                <h3><?php echo $num_skkni; ?></h3>
                <p>Dataset SKKNI</p>
              </div>
              <div class="icon"><i class="ion ion-connection-bars"></i></div>
              <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-6 col-xs-6">
            <div class="small-box bg-yellow">
              <div class="inner">
                <h3><?php echo $num_mbti; ?></h3>
                <p>Dataset MBTI</p>
              </div>
              <div class="icon"><i class="ion ion-stats-bars"></i></div>
              <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-6 col-xs-6">
            <div class="small-box bg-red">
              <div class="inner">
                <h3><?php echo $num_qbank; ?></h3>
                <p>Question</p>
              </div>
              <div class="icon"><i class="ion ion-help"></i></div>
              <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-6 col-xs-6">
       <div class="box box-danger">
         <div class="box-header with-border">
           <h3 class="box-title">MBTI per Kelas</h3>
           <div class="box-tools pull-right">
             <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
           </div>
         </div>
         <div class="box-body">
           <div class="col-md-12">
             <div class="chart-responsive">
               <div id="mbtiperkelas" ></div>
             </div>
           </div>
         </div>
       </div>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-12 col-xs-12">
      <div class="box box-success">
        <div class="box-header with-border">
          <h3 class="box-title">SPPKTI per Skema</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          </div>
        </div>
        <div class="box-body">
          <div class="chart-responsive">
            <div id="skkniperskema" ></div>
            <!--canvas id="skkniperskema" style="height:230px"></canvas-->
          </div>
        </div>
      </div>
    </div>
  </div>
  <script type="text/javascript">
  // Radialize the colors
  Highcharts.setOptions({
      colors: Highcharts.map(Highcharts.getOptions().colors, function (color) {
          return {
              radialGradient: {
                  cx: 0.5,
                  cy: 0.3,
                  r: 0.7
              },
              stops: [
                  [0, color],
                  [1, Highcharts.Color(color).brighten(-0.3).get('rgb')] // darken
              ]
          };
      })
  });

  // Build the chart
  Highcharts.chart('mbtiperkelas', {
      chart: {
          plotBackgroundColor: null,
          plotBorderWidth: null,
          plotShadow: false,
          type: 'pie'
      },
      title: {
          text: "Grafik"
      },
      tooltip: {
          pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
      },
      plotOptions: {
          pie: {
              allowPointSelect: true,
              cursor: 'pointer',
              dataLabels: {
                enabled: false,
                format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                style: {
                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                },
                connectorColor: 'silver'
              },
              showInLegend: true
          }
      },
      series: [{
          name: 'Persentase',
          data: [
            <?php
            foreach ($mbti as $value) {
              echo "{ name: '".$value['nama']."', y: ".$value['jml']." },";
            }
            ?>
          ]
      }]
  });
  Highcharts.chart('skkniperskema', {
      chart: {
         inverted: true,
          polar: false
      },
      title: {
          text: 'Grafik'
      },
      xAxis: {
          categories: ['Analyst Programmer', 'Junior Programmer', 'Programmer', 'Junior Database Programmer', 'Database Programmer', 'Junior Web Programmer', 'Web Programmer', 'Junior Mobile Programmer', 'Mobile Programmer', 'Client Server Programmer', 'Cloud Programmer']
      },
      yAxis: {
          min: 0,
          title: {
              text: 'Jumlah dataset'
          }
      },
      tooltip: {
          pointFormat: 'Jumlah Dataset: <b>{point.y} data</b>'
      },
      series: [{
          type: 'column',
          colorByPoint: true,
          data: [
            <?php
            foreach ($skkni as $value) {
              echo "{ name: '".$value['nama']."', y: ".$value['jml']." },";
            }
            ?>
          ],
          showInLegend: false
      }]
  });
  </script>
