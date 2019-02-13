<style>
  .button-success, .button-error {
    background:#3a78b8;color:#ffffff;padding:5px;padding-left:4px;padding-right:4px;font-size:15px;
    font-family:'arial';border-radius:4px;border:1px solid #87b0d9;margin-bottom:4px;line-height:34px;
  }
</style>
<form action="<?php echo site_url('simulasi/attempt_submit/'.$result['quid']);?>" method="post" id="testform" onsubmit="showquestion('0');">
  <div id="content" class="testd"  oncontextmenu="return false">
    <div class="box box-solid">
      <div class="box-header with-border">
        <h4 class="box-title">Simulasi <?php echo $title;?></h4>
        <div style="float:right">
          Time left:
          <div id='timer' style="display:inline;"/>
            <script type="text/javascript">window.onload = CreateTimer("timer", <?php echo $seconds;?>);</script>
          </div>
        </div>
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-md-8">
            <?php
              $category_name=explode(",",$time_info['id_unit']);
              $cate_range=array();
              $startnextcate=array();
              $qids_range=explode(",",$time_info['qids_range']);
              foreach($qids_range as $key => $rangeval){
                $rangeval_arr=explode("-",$rangeval);
                $gen_range=array();
                $startnextcate[]=$rangeval_arr['1'];
                for($x=$rangeval_arr['0']; $x<=$rangeval_arr['1']; $x++){
                  $gen_range[]=$x;
                }
                $cate_range[]=$gen_range;
              }
            ?>
            <input type="hidden"  id="json_category_range" value='<?php echo json_encode($cate_range);?>'>
            <?php foreach($category_name as $key=> $cvalue){
              if($key=='0'){ ?>
                <input type="hidden" value="0" id="current_cate">
              <?php } ?>
              <div class="category_box" id="cate-<?php echo $key;?>" onClick="changecategory('<?php echo $key;?>');" style="display:none;visibility: hidden"><?php echo $cvalue; ?></div>
            <?php }?>
            <input type="hidden" value="<?php echo $key;?>" id="total_cate">
            <?php $category_number=0;
            $selected_oids=explode(",",$time_info['oids']);
            foreach($assigned_question[0] as $key => $question){
              if($key=='0'){ ?>
                <input type="hidden" value="0" id="current_question">
              <?php } ?>
              <table id="ques<?php echo $key;?>" class="<?php if($key=='0'){ echo 'showquestion'; }else{ echo 'hidequestion'; } ?>">
                <tr><td><b>Question <?php echo $key+1; ?></b></td></tr-->
                <tr><td> <?php echo $question['question'];?></td></tr>
                <?php
                $opcount=0;
                // shuffle options
                shuffle($assigned_question[1]);
                foreach($assigned_question[1] as $keys => $option){
                  if($option['qid']==$question['qid']){ ?>
                    <tr>
                      <td>
                        <table>
                          <tr>
                            <td style="width:10px; border:0px;">
                              <input type="radio"  id="op-<?php echo $key;?>-<?php echo $opcount;?>" name="answers<?php echo $key;?>"
                              value="<?php echo $option['oid'];?>"
                              onClick="" <?php if($selected_oids[$key] == $option['oid']){ echo "checked"; } ?> >
                            </td>
                            <td style="border:0px;width:750px;"> <?php echo $option['option_value'];?></td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                    <?php $opcount+=1;
                  }
                }?>
                <tr>
                  <td>
                    <div class="div_exp_corr" id="div_exp_id<?php echo $key; ?>">
                      <span><img style="height:20px;" src="<?php echo base_url(); ?>/images/tick.png"></span>
                      <?php echo $question['description']?>
                    </div>
                    <div class="div_exp_wrong" id="div_exp_id_wrong<?php echo $key; ?>">
                      <span><img style="height:20px;" src="<?php echo base_url(); ?>/images/RidqqzKi9.png"> Wrong Answer</span><br><br>
                      <?php echo $question['description']?>
                    </div>
                  </td>
                </tr>
                <tr  style="position:fixed; bottom:0px;left:0px;padding:5px;background:#ffffff;border-top:1px solid #ddd;width:100%;max-height:65px;">
                  <td>
                    <?php if($key >="1"){ ?>
                      <a href="#"   class="btn btn-success"  onClick="showquestion('<?php echo $key-1;?>');" >Back</a>
                    <?php }
                    if($key!=(count($assigned_question['0'])-1)){
                      if(in_array($key,$startnextcate)){
                        $category_number+=1;
                        ?>
                        <a href="#"   class="btn btn-success"  onClick="showquestion('<?php echo $key+1;?>');changecategory('<?php echo $category_number;?>');update_curr_ans('<?php echo $key;?>');" > Save & Next</a>
                      <?php }else{ ?>
                        <a href="#"   class="btn btn-success" style="cursor:pointer;"  onClick="showquestion('<?php echo $key+1;?>');update_curr_ans('<?php echo $key;?>');" > Save & Next</a>
                      <?php }
                    }?>
                    <a href="#"   class="btn btn-warning"  onClick="reviewlater();"> Review later </a>
                    <a href="#"   class="btn btn-info"  onClick="clearresponse('<?php echo $key;?>');" > Clear-Response </a>
                    <a href="javascript:pre_sbtform();" class="btn btn-danger">Submit Test</a>
                  </td>
                </tr>
              </table>
            <?php } ?>
          </div>
          <div class="col-md-4">
            <div id="category_name_view"></div>
            <b>Questions</b><br>
            <div style="overflow-y:scroll;height:280px; width:100%;">
              <?php foreach($assigned_question[0] as $key => $question){ ?>
                <div class="count_btn" id="nq<?php echo $key;?>" onClick="showquestion('<?php echo $key;?>');"><?php echo $key+1;?></div>
              <?php } ?>
            </div>
            <input type="hidden" name="noq" id="noq" value="<?php echo $key;?>"><br>
            <table>
              <tr><td style="font-size:12px;"><div class="count_btn" style="background:#267B02;width:10px;height:10px;">&nbsp;</div> Answered</td></tr>
              <tr><td style="font-size:12px;"><div class="count_btn" style="background:#D03800;width:10px;height:10px;">&nbsp;</div> UnAnswered</td></tr>
              <tr><td style="font-size:12px;"><div class="count_btn" style="background:#FFD800;width:10px;height:10px;">&nbsp;</div> Review-Later</td></tr>
              <tr><td style="font-size:12px;"><div class="count_btn" style="background:#212121;width:10px;height:10px;">&nbsp;</div> Not-visited</td></tr>
            </table>
            <br><br>
          </div>
        </div>
      </div>
    </div>
    <br><br>
  </div>
  <div  id="warning_div" style="padding:10px; position:fixed;z-index:100;display:none;width:50%;
    border-radius:5px;height:200px; border:1px solid #dddddd;left:50%;top:30%;background:#ffffff;margin-left: -25%;
    margin-top: -100px;" >
    <center><b>Do you really want to submit Quiz? </b><br><b>Make sure you click save button in every question </b><br>
      <a href="javascript:pre_sbtform();"   class="btn btn-danger"  style="cursor:pointer;" >Cancel</a> &nbsp; &nbsp; &nbsp; &nbsp;
      <a href="javascript:sbtform();"   class="btn btn-info" style="cursor:pointer;">Submit Quiz</a>
    </center>
  </div>
</form>
<script language="javascript">
  setTimeout(submitform,'<?php echo $seconds * 1000;?>');
  function submitform(){
  	alert('Time Over');
  	document.getElementById('testform').submit();
  }
  setInterval(setqtime,1000);
  function setqtime(){
  	qtime+=1;
  }
  document.onmousedown=disableclick;
  status="Right Click Disabled";
  function disableclick(event){
    if(event.button==2){
      return false;
    }
  }
  function pre_sbtform(){
    if((document.getElementById('warning_div').style.display)=="block"){
      document.getElementById('warning_div').style.display="none";
    }else{
      document.getElementById('warning_div').style.display="block";
    }
  }
  function sbtform(){
    document.getElementById('testform').submit();
  }
  //hideqnobycate();
  $(document).ready(function(){
    var dheight=$(window).height();
    var qsheight=(parseInt(dheight)-parseInt(200))+"px";
    $('.showquestion').css('height',qsheight);
    $('.hidequestion').css('height',qsheight);
    $('#page-wrapper').css('margin','0px');
    $('#page-wrapper').css('padding','10px');
  });
</script>
