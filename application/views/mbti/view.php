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
            <tr><th>Id</th><th>Nama</th><th>Gambar</th><th>Action</th></tr>
          </thead>
          <tbody>
            <?php if($result==false){?>
              <tr>
                <td colspan="5">No record found!</td>
              </tr>
            <?php }else{$no=1;
              foreach($result as $row){
            ?>
              <tr>
                <td data-th="Id"><?php echo $no;?></td>
                <td data-th="Group Name"><?php echo $row->tipe_mbti;?></td>
                <td data-th="Id"><img class="img-rounded" height="100" width="200" src="<?php echo base_url()."assets/img/mbti/".$row->gambar;?>" alt=""></td>
                <td data-th="Action">
                  <a href="javascript: if(confirm('Do you really want to remove this Type?')){ window.location='<?php echo site_url('mbti/execute/tipe/delete/'.$row->tipe_mbti);?>'; }"  class="btn btn-danger btn-xs">Remove</a>
                  <a href="<?php echo site_url('mbti/tipe/edit/'.$row->tipe_mbti );?>"  class="btn btn-warning btn-xs">Edit</a>
                </td>
              </tr>
            <?php $no++;} } ?>
          </tbody>
        </table>
        <a class="btn btn-app" href="<?php echo site_url('mbti/tipe/add');?>"><i class="fa fa-plus"></i> Add</a>
      </div>
    </div>
  </div>
</div>
