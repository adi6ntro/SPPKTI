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
              <th>No</th>
							<th>Pelamar</th>
							<th>Posisi Jabatan</th>
							<th>Persentase</th>
							<th>Skema SKKNI</th>
							<th>Persentase</th>
							<th>Hasil Simulasi</th>
							<th>Status</th>
							<th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php if($result==false){ ?>
              <tr><td colspan="7">No record found!</td></tr>
            <?php }else{ $j=0; foreach($result as $row){ $j+=1; ?>
              <tr>
                <td data-th="ID"><?php echo $j;?></td>
								<td data-th="User">username: <?php echo $row->username.'<br>nama: '.$row->nama.'<br>status: '.$row->status;?></td>
                <td data-th="Skema"><?php echo $row->posisi;?></td>
                <td data-th="Percentage" style="text-align:right"><?php echo $row->persen_posisi;?></td>
								<td data-th="Skema"><?php echo $row->skema;?></td>
                <td data-th="Percentage" style="text-align:right"><?php echo $row->persen_skema;?></td>
                <td data-th="Percentage" style="text-align:right"><?php echo $row->hasil_simulasi;?></td>
								<td data-th="Status">
									<?php $arr_persen_skema=explode("<br>",str_replace("%","",$row->persen_skema));
								 		$arr_hasil_simulasi=explode("<br>",str_replace("%","",$row->hasil_simulasi));
										if($arr_hasil_simulasi[0]==0 && !isset($arr_hasil_simulasi[1]) && !isset($arr_hasil_simulasi[2])){
											echo '<span class="label label-warning">BELUM SIMULASI</span>';
										}else{
											if($arr_hasil_simulasi[0]>=75)
												echo '<span class="label label-success">DIREKOMENDASIKAN</span>';
											elseif($arr_hasil_simulasi[1]>=75 || $arr_hasil_simulasi[2]>=75)
												echo '<span class="label label-info">DIPERTIMBANGKAN</span>';
											else
												echo '<span class="label label-danger">TIDAK DIREKOMENDASIKAN</span>';
										}
									?>
								</td>
                <td data-th="Action">
									<a href="<?php echo site_url('result/view_user/'.$row->id);?>" class="btn btn-primary btn-xs">View</a>
									<?php /*<a href="javascript: if(confirm('Do you really want to remove this result?')){ window.location='<?php echo site_url('result/remove/user/'.$row->id);?>';}" class="btn btn-danger btn-xs">Remove</a>*/ ?>
								</td>
              </tr>
            <?php }} ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<?php /*
        <table class="table table-bordered table-striped" id="tabel">
          <thead>
            <tr>
              <th>No</th><th>Username</th><th>Nama Lengkap</th><th>Nama Ujian</th><th>Persentase</th><th>Hasil</th><th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php if($result==false){ ?>
              <tr><td colspan="7">No record found!</td></tr>
            <?php }else{ $j=0; foreach($result as $row){ $j+=1; ?>
              <tr>
                <td data-th="ID"><?php echo $j;?></td>
                <td data-th="Username"><?php echo $row->username;?></td>
                <td data-th="Full Name"><?php echo $row->first_name.' '.$row->last_name;?></td>
                <td data-th="Quiz Name"><?php echo $row->quiz_name;?></td>
                <td data-th="Percentage" style="text-align:right"><?php echo substr($row->percentage , 0, 5 );?>%</td>
                <td data-th="Result"><?php echo ($row->q_result == "1")? "Pass" : (($row->q_result == "0")?"Fail":"Pending"); ?> </td>
                <td data-th="Action">
                  <a href="<?php echo site_url('result/view/'.$row->rid.'/'.$row->quid);?>" class="btn btn-warning btn-xs">View</a>
                  <a href="javascript: if(confirm('Do you really want to remove this result?')){ window.location='<?php echo site_url('result/remove/SPA/'.$row->rid);?>'; }" class="btn btn-danger btn-xs">Remove</a>
                </td>
              </tr>
            <?php }} ?>
          </tbody>
        </table>
*/?>
