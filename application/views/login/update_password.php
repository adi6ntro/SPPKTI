<body class="hold-transition login-page" style="background-image:url('<?php echo base_url(); ?>assets/img/bg.jpg');background-size: 100% 100%;">
  <div class="login-box">
    <div class="login-box-body">
      <p class="login-box-msg">Reset Password</p>
      <?php if(validation_errors()||$this->session->flashdata('result_error')){ ?>
        <div class="alert alert-danger">
          <?php echo validation_errors().$this->session->flashdata('result_error'); ?>
        </div>
      <?php } $attributes = array('id' => 'formlogin');
          echo form_open('reset_password/token/'.$token, $attributes); ?>
        <div class="form-group has-feedback">
          <input name="user_password" id="user_password" type="password" class="form-control" placeholder="Password Baru" required>
        </div>
        <div class="form-group has-feedback">
          <input name="confirm_password" id="confirm_password" type="password" class="form-control" placeholder="Konfirmasi Password Baru" required>
        </div>
        <div class="row">
          <div class="col-xs-offset-6 col-xs-6">
            <button type="submit" class="btn btn-primary btn-block btn-flat">Reset Password</button>
          </div>
        </div>
      </form>
    </div>
  </div>
