<?php
  $assignedids=array();
  if($assigned_questions!=false){
  foreach($assigned_questions as $key => $aqid){
    $assignedids[]=$aqid->qid;
  }}
?>
<div class="row">
  <div class="col-lg-12">
    <div class="box box-solid">
      <div class="box-header  with-border">
        <h3 class="box-title">Add question into quiz: '<?php echo urldecode($quiz_name); ?>'</h3>
        <div class="box-tools pull-right">
          <a class="btn btn-danger" href="javascript:closeqselection('<?php echo $quid;?>');">Close & Go to quiz</a>
        </div>
      </div>
      <div class="box-body">
        <div class="table-responsive">
          <table class="table table-hover" id="tabel">
            <thead>
              <tr><th>Id</th><th>Pertanyaan</th><th>Unit</th><th>Action</th></tr>
            </thead>
            <tbody>
              <?php if($result==false){ ?>
              <tr><td colspan="5">No record found!</td></tr>
              <?php }else{foreach($result as $key=> $row){?>
              <tr>
                <td><?php echo $row->qid;?></td>
                <td><?php echo substr(strip_tags($row->question),"0","50");?></td>
                <td><?php echo substr(strip_tags($row->nama_unit),"0","50");?></td>
                <td>
                  <a href="<?php echo site_url('qbank/edit_question/'.$row->qid);?>" target="edit_question" class="btn btn-warning btn-xs">Edit</a>
                  <a href="javascript:addquestion('<?php echo $quid;?>','<?php echo $row->qid;?>');qadded('add<?php echo $key;?>');"  id="add<?php echo $key;?>" class="btn btn-success btn-xs"><?php echo (in_array($row->qid,$assignedids))?"Added":"Add"; ?></a>
                </td>
              </tr>
              <?php }} ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="<?php echo base_url(); ?>assets/js/jquery-3.1.0.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {$("#tabel").DataTable();});
</script>
