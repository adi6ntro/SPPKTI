<div class="row">
  <div class="col-md-12">
    <?php
    if($this->session->flashdata('result')!=''){
      echo "<div class='alert alert-success alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>".$this->session->flashdata('result')."</div>";
    }
    ?>
    <div class="box box-<?php echo ($exe=='save')?'primary':'warning';?>">
      <div class="box-header with-border">
        <h3 class="box-title"><?php if($title){ echo $title; } ?></h3>
        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          <a class="btn btn-box-tool" href="<?php echo site_url('simulasi/ujian');?>"><i class="fa fa-remove"></i></a>
        </div>
      </div>
      <div class="box-body">
        <form method="post" action="<?php echo site_url('simulasi/execute/ujian/'.$exe.'/'.$id);?>">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Nama Ujian</label>
                <input type='text' class="form-control" placeholder="Nama Ujian" name='quiz_name' value="<?php echo (isset($result['quiz_name']))?$result['quiz_name']:'';?>">
              </div>
              <div class="form-group">
                <label>Deskripsi Ujian</label>
                <textarea class="form-control" name="description" placeholder="Deskripsi Ujian"><?php echo (isset($result['description']))?$result['description']:'';?></textarea>
              </div>
              <div class="form-group">
                <label>Durasi Ujian</label>
                <div class="input-group">
                  <input type='number' class="form-control" min="10" max="1000" name='quiz_time_duration' placeholder="Durasi Ujian" value="<?php echo (isset($result['duration']))?$result['duration']:'';?>">
                  <div class="input-group-addon">Menit</div>
                </div>
              </div>
              <div class="form-group">
                <label>Persentase Lulus</label>
                <div class="input-group">
                  <input type='number' class="form-control" min="0" max="100" name='pass_percentage' placeholder="Persentase lulus" value="<?php echo (isset($result['pass_percentage']))?$result['pass_percentage']:'';?>">
                  <div class="input-group-addon">%</div>
                </div>
              </div>
              <div class="form-group">
                <label>Nama Skema</label>
                <select class="form-control select2" name="assigned_groups" data-placeholder="Pilih Skema" style="width: 100%;">
                  <?php foreach($skema as $key => $group){ ?>
                    <option value="<?php echo $group->id_skema; ?>" <?php if(isset($result['id_skema'])){if($result['id_skema'] == $group->id_skema){ echo "selected"; }} ?>><?php echo $group->id_skema.' - '.$group->nama_skema; ?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="form-group">
                <label>Lihat Jawaban </label>
                <div class="input-group">
                  <span class="input-group-addon"><input type='radio' class="flat-red" name='view_answer' value='1' <?php if(isset($result['view_answer'])){echo ($result['view_answer']=='1')?"checked":''; } ?>></span>
                  <input type="text" class="form-control rotext" value="Yes" readonly>
                </div>
                <div class="input-group">
                  <span class="input-group-addon"><input type='radio' class="flat-red" name='view_answer' value='0' <?php if(isset($result['view_answer'])){echo ($result['view_answer']=='0')?"checked":''; } ?>></span>
                  <input type="text" class="form-control rotext" value="No" readonly>
                </div>
              </div>
              <div class="form-group">
                <label>Nilai Jawaban benar</label>
                <input type='number' name='correct_answer_score' value="<?php echo (isset($result['correct_score']))?$result['correct_score']:'1';?>" class="form-control" >
              </div>
              <div class="form-group">
                <label>Nilai Jawaban salah</label>
                <input type='number' name='incorrect_answer_score' value="<?php echo (isset($result['incorrect_score']))?$result['incorrect_score']:'0';?>" class="form-control" >
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-12">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Daftar Soal</h3>
                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <?php if(isset($result)){
                    echo "<div class='form-group'><a href=\"javascript:questionselection('".$result['quid']."','".$result['quiz_name']."','0');\" class='btn btn-primary'>Add Questions</a></div>";
                  }else{
                    echo "<a href='' class='btn btn-primary disabled'>Add Questions</a>";
                  }?>
                  <div class="row">
                    <?php if($exe=='save'){ ?>
                    <div class="col-md-12">
                      <h3> Klik tombol 'Submit' dan anda akan menuju ke pemilihan soal.</h3>
                    </div>
                    <?php }else{$max = 1;
                      if($assigned_questions ==false){}
                    	else{?>
                			<div class="col-lg-12">
          							<table class="table table-responsive" id='sim'>
          								<thead>
          									<tr>
                              <th>Id</th><th>Pertanyaan</th><th>Unit</th><th>Aksi</th>
          									</tr>
          								</thead>
          								<tbody>
          									<?php	foreach($assigned_questions as $key=> $row){ ?>
          									<tr>
          										<td  data-th="ID"><?php echo $key+1;?></td>
          										<td data-th="Question"><?php echo substr(strip_tags($row->question),"0","50");?></td>
          										<td data-th="Category"><?php echo $row->id_unit.' - '.substr(strip_tags($row->nama_unit),"0","50");?></td>
          										<td data-th="Action">
          											<a href="<?php echo site_url('simulasi/move/remove/'.$result['quid'].'/'.$row->qid );?>"  class="btn btn-danger btn-xs">Remove</a>
          											<?php if($key!="0"){ ?>
          												<a href="javascript:cancelmove('Up','<?php echo $result['quid'];?>','<?php echo $row->qid;?>','<?php echo $key+1;?>');"><img src="<?php echo base_url();?>assets/img/up.png" title="Up"></a>
          											<?php }else{ ?>
          												<img src="<?php echo base_url();?>assets/img/empty.png" >
          											<?php } if($key==(count($assigned_questions)-1)){?>
          												<img src="<?php echo base_url();?>assets/img/empty.png" >
          											<?php }else{ ?>
          												<a href="javascript:cancelmove('Down','<?php echo $result['quid'];?>','<?php echo $row->qid;?>','<?php echo $key+1;?>');"><img src="<?php echo base_url();?>assets/img/down.png" title="Down"></a>
          											<?php } ?>
          										</td>
          									</tr>
          									<?php $max=$key+1;} ?>
          								</tbody>
          							</table>
                			</div>
                    <?php }} ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-6">
              <div class="form-group">
                <input type="submit" value="Submit"  class="btn btn-success">
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<div id="qbank" style="padding:10px; position:fixed;z-index:100;display:none;width:65%;
border-radius:5px;height:500px; border:1px solid #dddddd;left:35%;top:27%;background:#ffffff;margin-left: -15%;
margin-top: -100px;box-shadow: 2px 2px 1px rgba(50, 50, 50, 0.75);"></div>
<div  id="warning_div" style="padding:10px; position:fixed;z-index:100;display:none;width:50%;
border-radius:5px;height:200px; border:1px solid #dddddd;left:50%;top:30%;background:#ffffff;margin-left: -25%;
margin-top: -100px;">
	<center>
		<b>Dari Posisi mana Anda mau memindahkan pertanyaan? </b><br>
		Nomor Urut : <input type="number" style="width:50px" class='form-horizontal form-control' id="qposition" min=1 max=<?php echo $max;?>><br><br>
		<a href="javascript:cancelmove();"   class="btn btn-danger"  style="cursor:pointer;">Cancel</a>
		<a href="javascript:movequestion();"   class="btn btn-info"  style="cursor:pointer;">Move</a>
	</center>
</div>
<?php if(isset($qselect)){ if($qselect=="0"){ ?>
<script type="text/javascript">
	questionselection('<?php echo $result['quid'];?>','<?php echo $result['quiz_name'];?>','0');
</script>
<?php }} ?>
<script language="javascript">
	var position_type="Up";
	var global_quid="0";
	var global_qid="0";
	var global_opos="0";

	function cancelmove(position_t,quid,qid,opos){
		position_type=position_t;
		global_quid=quid;
		global_qid=qid;
		global_opos=opos;
		if((document.getElementById('warning_div').style.display)=="block"){
			document.getElementById('warning_div').style.display="none";
		}else{
			document.getElementById('warning_div').style.display="block";
			if(position_type=="Up"){
				var upos=parseInt(global_opos)-parseInt(1);
			}else{
				var upos=parseInt(global_opos)+parseInt(1);
			}
			document.getElementById('qposition').value=upos;
		}
	}

	function movequestion(){
		var pos=document.getElementById('qposition').value;
		if(position_type=="Up"){
			var npos=parseInt(global_opos)-parseInt(pos);
			window.location="<?php echo site_url('simulasi/move/up');?>/"+global_quid+"/"+global_qid+"/"+npos;
		}else{
			var npos=parseInt(pos)-parseInt(global_opos);
			window.location="<?php echo site_url('simulasi/move/down');?>/"+global_quid+"/"+global_qid+"/"+npos;
		}
	}
</script>
