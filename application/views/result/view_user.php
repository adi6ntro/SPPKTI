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
              <th>No</th><?php echo ($user['su']=='1')?'<th>Username</th><th>Kelas</th>':''; ?><th>Skema</th><th>Persentase</th><th>Nilai Tertinggi</th><th>Status</th><th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php if($result==false){ ?>
              <tr><td colspan="7">No record found!</td></tr>
            <?php }else{ $j=0; foreach($result as $row){ $j+=1; ?>
              <tr>
                <td data-th="ID"><?php echo $j;?></td>
								<?php echo ($user['su']=='1')?'<td data-th="User">'.$row->username.'</td><td data-th="Kelas">'.$row->kelas.'</td>':''; ?>
                <td data-th="Skema"><?php echo $row->skema;?></td>
                <td data-th="Percentage" style="text-align:right"><?php echo $row->persentase;?>%</td>
                <td data-th="Percentage" style="text-align:right"><?php echo $row->maxnilai;?>%</td>
								<td data-th="Status"><?php echo $row->status;?></td>
                <td data-th="Action">
									<a href="<?php echo site_url('result/view_user/'.$row->id);?>" class="btn btn-primary btn-xs">View</a>
									<?php /*<a href="javascript: if(confirm('Do you really want to remove this result?')){ window.location='<?php echo site_url('result/remove/user/'.$row->id);?>';}" class="btn btn-danger btn-xs">Remove</a>*/ ?>
								</td>
              </tr>
            <?php }} ?>
          </tbody>
        </table>
      </div>
			<?php //echo ($user['su']=='1')?'':'<a class="btn btn-app" href="javascript: if(confirm(\'Do you really want to remove your all data?\')){ window.location=\''.site_url('result/remove/data/'.$user['id']).'\';}"><i class="fa fa-remove"></i>Reset Your Data</a>'; ?>
    </div>
  </div>
</div>
