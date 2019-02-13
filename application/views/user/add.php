<div class="row">
  <div class="col-md-6">
    <?php if($this->session->flashdata('result')!=''){
      echo "<div class='alert alert-success alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>".$this->session->flashdata('result')."</div>";
    }
    ?>
    <div class="box box-<?php if($exe=='profile') echo'info';elseif($exe=='save') echo'primary';else echo'warning';?>">
      <div class="box-header with-border">
        <h3 class="box-title"><?php if($title){ echo $title; } ?></h3>
        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          <a class="btn btn-box-tool" href="<?php if($exe=='profile'){echo site_url('dashboard');}else{echo site_url('users');}?>"><i class="fa fa-remove"></i></a>
        </div>
      </div>
      <div class="box-body">
        <form method="post" id="formuser" action="<?php echo site_url('users/execute/'.$exe.'/'.$id);?>">
          <div class="form-group">
            <label>Username</label>
            <input class="form-control" type="text" name="username" value="<?php echo (isset($myuser['username']))?$myuser['username']:'';?>" placeholder="Username" autocomplete="off" <?php echo ($user['gid']!="ADM")?"required":"disabled"; ?>>
          </div>
          <div class="form-group">
            <label>Nama Depan</label>
            <input class="form-control" type="text" name="first_name" value="<?php echo (isset($myuser['first_name']))?$myuser['first_name']:'';?>" placeholder="First Name" autocomplete="off" <?php echo ($user['gid']!="ADM")?"required":"disabled"; ?>>
          </div>
          <div class="form-group">
            <label>Nama Belakang</label>
            <input class="form-control" type="text" name="last_name" value="<?php echo (isset($myuser['last_name']))?$myuser['last_name']:'';?>" placeholder="Last Name" autocomplete="off" <?php echo ($user['gid']!="ADM")?"required":"disabled"; ?>>
          </div>
          <div class="form-group">
            <label>Email</label>
            <input class="form-control" type="email" name="email" value="<?php echo (isset($myuser['email']))?$myuser['email']:'';?>" placeholder="Email" autocomplete="off" <?php echo ($user['gid']!="ADM")?"required":"disabled"; ?>>
          </div>
          <?php if($user['gid']!="ADM"){?>
          <div class="form-group">
            <label>Password</label>
            <input class="form-control" type="password" name="user_password" id="user_password" placeholder="Password" autocomplete="off">
          </div>
          <div class="form-group">
            <label>Status</label>
            <select class="form-control" name="prop">
              <?php if($user['su']==1){ ?><option value="0" <?php if(isset($myuser['prop'])){if($myuser['prop'] == 0){ echo "selected"; }} ?>></option><?php } ?>
              <option value="1" <?php if(isset($myuser['prop'])){if($myuser['prop'] == 1){ echo "selected"; }} ?>>Pelajar / Mahasiswa</option>
              <option value="2" <?php if(isset($myuser['prop'])){if($myuser['prop'] == 2){ echo "selected"; }} ?>>Sudah Bekerja</option>
            </select>
          </div>
          <div class="form-group">
            <label>Group</label>
            <select class="form-control" name="group" <?php if(isset($myuser['su'])){echo ($user['su']==0||$user['su']==1)?'':'disabled';} ?>>
              <?php foreach($allgroups as $key => $group){ ?>
              <option value="<?php echo $group['gid']; ?>" <?php if(isset($myuser['gid'])){if($myuser['gid'] == $group['gid']){ echo "selected"; }} ?>><?php echo $group['group_name']; ?></option>
              <?php } ?>
            </select>
          </div>
          <div class="form-group">
            <label>Jenis Akun </label>
            <?php if($this->session->userdata('logged_in')['su'] != 1){?>
              <input class="form-control" type="hidden" name="account_type" value="<?php echo $myuser['su'];?>">
              <input class="form-control" type="text" value="<?php echo ($myuser['su']==2)?'Pakar SKKNI':($myuser['su']==3)?'Pakar MBTI':'User';?>"
              placeholder="Last Name" autocomplete="off" disabled>
            <?php }else{ ?>
              <select class="form-control" name="account_type">
                <option value="0" <?php if(isset($myuser['su'])){if($myuser['su'] == 0){ echo "selected"; }} ?>>User</option>
                <option value="1" <?php if(isset($myuser['su'])){if($myuser['su'] == 1){ echo "selected"; }} ?>>Administrator</option>
                <option value="2" <?php if(isset($myuser['su'])){if($myuser['su'] == 2){ echo "selected"; }} ?>>Pakar SKKNI</option>
                <option value="3" <?php if(isset($myuser['su'])){if($myuser['su'] == 3){ echo "selected"; }} ?>>Pakar MBTI</option>
              </select>
            <?php } ?>
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
        <?php } ?>
        </form>
      </div>
    </div>
  </div>
</div>
