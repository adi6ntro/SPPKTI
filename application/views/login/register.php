<body class="hold-transition register-page" style="background-image:url('<?php echo base_url(); ?>assets/img/bg.jpg');background-size: 100% 100%;">
  <div class="register-box">
    <div class="register-box-body">
      <p class="login-box-msg">Register a new membership</p>
    <?php if($this->session->flashdata('result_error')){
      $result_er=$this->session->flashdata('result_error');
      echo "<div class='alert alert-danger' >".$result_er."</div>";
    }
    if($this->session->flashdata('result')){
      $result_r=$this->session->flashdata('result');
      echo "<div class='alert alert-success' >".$result_r."</div>";
    }$attributes = array('id' => 'formlogin');
      echo form_open('login/register_user/', $attributes); ?>
        <div class="form-group">
          <input type="text" class="form-control" placeholder="First name" name="first_name" autocomplete="off" required>
        </div>
        <div class="form-group has-feedback">
          <input type="text" class="form-control" placeholder="Last name" name="last_name" autocomplete="off" required>
        </div>
        <div class="form-group has-feedback">
          <input type="email" class="form-control" placeholder="Email" name="user_email" autocomplete="off" required>
        </div>
        <div class="form-group has-feedback">
          <input type="text" class="form-control" placeholder="Username" name="username" id="username" autocomplete="off" required>
        </div>
        <div class="form-group has-feedback">
          <input type="password" class="form-control" placeholder="Password" name="user_password" id="user_password" required>
        </div>
        <div class="form-group has-feedback">
          <input type="password" class="form-control" placeholder="Retype password" name="confirm_password" id="confirm_password" required>
        </div>
        <div class="form-group has-feedback">
          <select name="prop" class="form-control">
            <option value="1">Pelajar / Mahasiswa</option>
            <option value="2">Sudah Bekerja</option>
          </select>
        </div>
        <div class="form-group has-feedback">
          <label>Program Studi</label>
          <select name="user_group" class="form-control" placeholder="Jurusan">
          <?php foreach($allgroups as $key => $group){ ?>
            <option value="<?php echo $group['gid']; ?>"><?php echo $group['group_name']; ?></option>
          <?php } ?>
          </select>
        </div>
        <div class="row">
          <div class="col-xs-offset-8 col-xs-4">
            <button type="submit" class="btn btn-primary btn-block btn-flat">Register</button>
          </div>
        </div>
      </form>
      <a href="<?php echo site_url('login/');?>" class="text-center">I already have a membership</a>
    </div>
  </div>
