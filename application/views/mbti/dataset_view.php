<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-header">
        <h3 class="box-title"><?php if($title){ echo $title; } ?></h3>
      </div>
      <div class="box-body">
        <table class="table table-bordered table-striped" id="tabel">
          <thead>
            <tr><th>#</th><th>User</th><th>MBTI</th><th>Kelas</th><th>Action</th></tr>
          </thead>
          <tbody>
            <?php if($result==false){?>
              <tr>
                <td colspan="5">No record found!</td>
              </tr>
            <?php }else{
              foreach($result as $row){
            ?>
              <tr>
                <td data-th="Id"><?php echo $row->NO;?></td>
                <td data-th="Group Name"><?php echo $row->NAMA;?></td>
                <td data-th="Id"><?php echo $row->MBTI;?></td>
                <td data-th="Id"><?php echo $row->KELAS;?></td>
                <td data-th="Action">
                  <a href="javascript: if(confirm('Do you really want to remove this MBTI?')){ window.location='<?php echo site_url('mbti/execute/dataset/delete/'.$row->NO);?>'; }"  class="btn btn-danger btn-xs">Remove</a>
                  <a href="<?php echo site_url('mbti/dataset/edit/'.$row->NO);?>"  class="btn btn-warning btn-xs">edit</a>
                </td>
              </tr>
            <?php }}?>
          </tbody>
        </table>
        <a class="btn btn-app" href="<?php echo site_url('mbti/dataset/add');?>"><i class="fa fa-plus"></i> Add</a>
      </div>
    </div>
  </div>
</div>
