<style>
  @media print {.clearfix{display:none;}#footer{display:none;}.hide_btn_while_print{display:none;}.show_btn_while_print{display:block;float:right;}}
  @media screen {.show_btn_while_print{display:none;}}
  .result_card tr td{border-bottom:1px solid #dddddd;}
  .sharing-buttons{list-style: none;text-decoration: none;}
  .sharing-buttons li{display: inline;}
  .sharing-buttons a{border: 1px solid;padding: 0.5em;color: #fff;text-decoration: none;}
  .sharing-buttons a:hover{color: #eee;text-decoration: none;}
  .fa{padding: 0.5em;}
  .facebook{background: #3B5998; }
  .twitter{background: #00ACED;}
  .google-plus{background: #D14836}
</style>
<div class="row">
  <div class="col-md-12">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title"><?php if($title){ echo $title; } ?></h3>
        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          <a type="button" class="btn btn-box-tool" href="<?php echo site_url('result');?>"><i class="fa fa-remove"></i></a>
        </div>
      </div>
      <div class="box-body">
        <table class="table table-hover">
          <tr><th >Result ID</th><td><?php echo $result->rid;?></td></tr>
          <tr><th >User Name</th><td><?php echo $result->username;?></td></tr>
          <tr><th >Email</th><td><?php echo $result->email;?></td></tr>
          <tr><th >First Name</th><td><?php echo $result->first_name;?></td></tr>
          <tr><th >Last Name</th><td><?php echo $result->last_name;?></td></tr>
          <tr><th >Quiz Name</th><td><?php echo $result->quiz_name;?></td></tr>
          <tr>
            <th >Score obtained</th>
            <td>
              <?php
                $correct_score=explode(",",$result->correct_score);
                if(count($correct_score) >= "2"){ echo $result->score."/".(array_sum($correct_score)); }
                else{ echo $result->score."/".(count(explode(',',$result->qids)) * $correct_score['0'] ); }
              ?>
            </td>
          </tr>
          <tr><th >Percentage obtained</th><td><?php echo substr($result->percentage , 0, 5 );?>%</td></tr>
          <tr><th >Percentile obtained</th><td><?php echo substr(((($percentile[1]+1)/$percentile[0])*100),0,5); ?>%</td></tr>
          <tr>
            <th valign="top">Percentage obtained by Category</th>
            <td>
              <table>
                <?php foreach($cct_per_total as $vk => $vval){ ?>
                  <tr>
                    <td><?php echo $vk ; ?>:</td>
                    <td><?php $sper=(($cct_per[$vk]/$cct_per_total[$vk])*100);  echo number_format((float)$sper, 2, '.', '');?>%  (<?php echo $cct_per[$vk]."/".$cct_per_total[$vk]; ?>)</td>
                  </tr>
                <?php } ?>
              </table>
            </td>
          </tr>
          <tr><th >Result</th><td><?php echo ($result->q_result == "1")? "Pass" : (($result->q_result == "0")?"Fail":"Pending"); ?></td></tr>
          <tr><th >Total Time Spent</th><td><?php echo ($result->time_spent <= ($result->duration * 60 ) )?gmdate("H:i:s", $result->time_spent):gmdate("H:i:s", ($result->duration * 60)); ?></td></tr>
        </table>
        <a href="javascript:print();" class="btn btn-warning" style="margin-left:20px;">Print</a>
      </div>
      <script type="text/javascript" src="https://www.google.com/jsapi"></script>
      <script type="text/javascript">
        google.load("visualization", "1", {packages:["corechart"]});
        google.setOnLoadCallback(drawChart);
        function drawChart() {
          var data = google.visualization.arrayToDataTable(<?php echo $value;?>);
          var options = {
            title: 'Top 10 results for Quiz:<?php echo $result->quiz_name;?>',
            hAxis: {title: 'Quiz(User)', titleTextStyle: {color: 'red'}}
          };
          var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
          chart.draw(data, options);
        }
      </script>
      <div id="chart_div" style="width: 800px; height: 500px;"></div>
      <script type="text/javascript">
        google.load("visualization", "1", {packages:["corechart"]});
        google.setOnLoadCallback(drawChart);
        function drawChart() {
          var data = google.visualization.arrayToDataTable(<?php echo $qtime;?>);
          var options = {
            title: 'Time spent on individual question (in seconds)'
          };
          var chart = new google.visualization.PieChart(document.getElementById('chart_div2'));
          chart.draw(data, options);
        }
      </script>
      <div id="chart_div2" style="width:800px; height: 500px;"></div>
      <script type="text/javascript">
        google.load("visualization", "1", {packages:["corechart"]});
        google.setOnLoadCallback(drawChart);
        function drawChart() {
          var data = google.visualization.arrayToDataTable(<?php echo $ctime;?>);
          var options = {
            title: 'Time spent on categories (in seconds)'
          };
          var chart = new google.visualization.PieChart(document.getElementById('chart_div3'));
          chart.draw(data, options);
        }
      </script>
      <div id="chart_div3" style="width: 800px; height: 500px;"></div>
    </div>
  </div>
</div>
