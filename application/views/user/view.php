<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-header">
        <h3 class="box-title"><?php if($title){ echo $title; } ?></h3>
      </div>
      <div class="box-body">
        <table id="tabel" class="table table-bordered table-striped">
          <thead>
            <tr><th>#</th><th>Username</th><th>Nama Depan</th><th>Nama Belakang</th><th>Email</th><th>Role</th><th>Date Created</th><th>Last Login</th><th>Aksi</th></tr>
          </thead>
          <tbody>
            <?php if($result==false){ ?>
              <tr><td colspan="7">No record found!</td></tr>
            <?php }else{
              foreach($result as $row){
              if($row->su=="0"){$type="User";}
              elseif($row->su=="1"){$type="Administrator";}
              elseif($row->su=="2"){$type="Pakar SKKNI";}
              elseif($row->su=="3"){$type="Pakar MBTI";}
              else{$type="Undefined";}
            ?>
              <tr>
                <td><?php echo $row->id;?></td>
                <td><?php echo $row->username;?></td>
                <td><?php echo $row->first_name;?></td>
                <td><?php echo $row->last_name;?></td>
                <td><?php echo $row->email;?></td>
                <td><?php echo $type;?></td>
                <td><?php echo $row->date_created;?></td>
                <td><?php echo $row->last_login;?></td>
                <td>
                  <a href="javascript: if(confirm('Do you really want to remove this user?')){ window.location='<?php echo site_url('users/execute/delete/'.$row->id );?>'; }" class="btn btn-danger btn-xs">Remove</a>
                  <a href="<?php echo site_url('users/form/edit/'.$row->id );?>" class="btn btn-warning btn-xs">Edit</a>
                  <a href="<?php echo site_url('users/login_user_by_admin/'.$row->id );?>" class="btn btn-success btn-xs">Login</a>
                </td>
              </tr>
            <?php }} ?>
          </tbody>
        </table>
        <a class="btn btn-app" href="<?php echo site_url('users/form/add');?>"><i class="fa fa-plus"></i> Add</a>
      </div>
    </div>
  </div>
</div>
