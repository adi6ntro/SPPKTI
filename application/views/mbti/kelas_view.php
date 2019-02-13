<div class="row">
  <div class="col-xs-6">
    <div class="box">
      <div class="box-header">
        <h3 class="box-title"><?php if($title){ echo $title; } ?></h3>
      </div>
      <div class="box-body">
        <table class="table table-bordered table-striped" id="tabel">
          <thead>
            <tr><th>No</th><th>Nama Kelas</th><th>Action</th></tr>
          </thead>
          <tbody>
            <?php if($result==false){ ?>
              <tr>
                <td colspan="5">No record found!</td>
              </tr>
            <?php }else{$no=1;
              foreach($result as $row){ ?>
              <tr>
                <td data-th="Id"><?php echo $no;?></td>
                <td data-th="Group Name"><?php echo $row->nama_kelas;?></td>
                <td data-th="Action">
                  <a href="javascript: if(confirm('Do you really want to remove this Kelas?')){ window.location='<?php echo site_url('mbti/execute/kelas/delete/'.$row->id_mbti_kelas );?>'; }"  class="btn btn-danger btn-xs">Remove</a>
                  <a href="<?php echo site_url('mbti/kelas/edit/'.$row->id_mbti_kelas );?>"  class="btn btn-warning btn-xs">Edit</a>
                </td>
              </tr>
            <?php $no++;}} ?>
          </tbody>
        </table>
        <a class="btn btn-app" href="<?php echo site_url('mbti/kelas/add');?>"><i class="fa fa-plus"></i> Add</a>
      </div>
    </div>
  </div>
</div>
