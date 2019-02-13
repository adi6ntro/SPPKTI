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
        <table class="table table-bordered table-striped" id="tabel">
          <thead>
            <tr>
							<tr><th>No</th><th>Nama Quiz</th><th>Skema</th><th>Jumlah Soal</th><th>Durasi</th><th>Status</th><th>Aksi</th></tr>
            </tr>
          </thead>
          <tbody>
            <?php if($result==false){ ?>
              <tr><td colspan="6">No record found!</td></tr>
            <?php }else{ $j=0; foreach($result as $row){ $j+=1; ?>
              <tr>
								<td data-th="Id"><?php echo $j;?></td>
								<td data-th="Quiz Name"><?php echo $row->quiz_name;?></td>
								<td data-th="Start Time"><?php echo $row->id_skema;?></td>
								<td data-th="End Time" class="text-right"><?php $jml=array_filter(explode(',',$row->qids_static)); echo (count($jml)>0)?count($jml):'Belum Ada';?> Soal</td>
								<td data-th="Duration" class="text-right"><?php echo $row->duration;?> Min </td>
								<td data-th="Duration"><?php echo $row->status;?></td>
								<td data-th="Action">
									<a href="javascript: if(confirm('Do you really want to remove this quiz?')){ window.location='<?php echo site_url('simulasi/execute/ujian/delete/'.$row->quid );?>'; }" class="btn btn-danger btn-xs">Remove</a>
									<a href="<?php echo site_url('simulasi/ujian/edit/'.$row->quid );?>"  class="btn btn-warning btn-xs">Edit</a>
									<?php if($row->status=='INACTIVE'){?>
										<a href="<?php echo site_url('simulasi/execute/ujian/aktif/'.$row->quid );?>"  class="btn btn-primary btn-xs">Activate</a>
									<?php } ?>
								</td>
              </tr>
            <?php }} ?>
          </tbody>
        </table>
      	<a class="btn btn-app" href="<?php echo site_url('simulasi/ujian/add');?>"><i class="fa fa-plus"></i> Add</a>
      </div>
    </div>
  </div>
</div>
