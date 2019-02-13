<div class="row">
	<div class="col-xs-12">
    <?php if($this->session->flashdata('result')!=''){
      echo "<div class='alert alert-success alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>".$this->session->flashdata('result')."</div>";
    } ?>
    <div class="box">
      <div class="box-header">
        <h3 class="box-title"><?php if($title){ echo $title; } ?></h3>
      </div>
      <div class="box-body">
        <form method="post" action="<?php echo site_url('simulasi/execute/soal/removeqids');?>" id="removeqids">
          <table class="table table-bordered table-striped" id="soal">
            <thead>
              <tr>
                <th><input type="checkbox" name="qid[]" id="selectAll" /></th>
                <th>No</th><th>Pertanyaan</th><th>Nama Unit</th><th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php if($result==false){ ?>
                <tr><td colspan="6">No record found!</td></tr>
              <?php }else{ $j=0; foreach($result as $row){ $j+=1; ?>
                <tr>
                  <td data-th="Select"><input type="checkbox" name="qid[]" value="<?php echo $row->qid;?>" /></td>
                  <td data-th="ID"><?php echo $j;?></td>
                  <td data-th="Question"><?php echo substr(strip_tags($row->question),"0","50");?></td>
                  <td data-th="Category"><?php echo $row->id_unit.' - '.substr(strip_tags($row->nama_unit),"0","50");?></td>
                  <td data-th="Action">
                    <a href="javascript: if(confirm('Do you really want to remove this question?')){ window.location='<?php echo site_url('simulasi/execute/soal/delete/'.$row->qid );?>'; }" class="btn btn-danger btn-xs">Remove</a>
                    <a href="<?php echo site_url('simulasi/soal/edit/'.$row->qid);?>" class="btn btn-warning btn-xs">Edit</a>
                  </td>
                </tr>
              <?php }} ?>
            </tbody>
          </table>
        </form>
        <a class="btn btn-app" onclick="return confirm('Do you really want to delete this record?')" href="javascript:removeqids();" id="delete"><i class="fa fa-trash"></i> Remove</a>
        <a class="btn btn-app" href="<?php echo site_url('simulasi/soal/add');?>"><i class="fa fa-plus"></i> Add</a>
      </div>
    </div>
  </div>
</div>
<script>
  function removeqids(){
    document.getElementById('removeqids').submit();
  }
</script>
