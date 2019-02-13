<style>
  @media print {.clearfix{display:none;}#footer{display:none;}.hide_btn_while_print{display:none;}.show_btn_while_print{display:block;float:right;}}
  @media screen {.show_btn_while_print{display:none;}}
</style>
<div class="row">
  <div class="col-md-12">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title"><?php if($title1){ echo $title1; } ?></h3>
        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          <a type="button" class="btn btn-box-tool" href="<?php echo ($user['su']=='1')?site_url('result/'):site_url('result/user');?>"><i class="fa fa-remove"></i></a>
        </div>
      </div>
      <div class="box-body">
        <table class="table table-hover">
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
          <a href="javascript:print();" class="btn btn-warning" style="margin-left:20px;">Print</a>
        </table>
      </div>
    </div>
  </div>
</div>
