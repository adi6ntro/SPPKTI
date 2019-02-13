<body class="hold-transition login-page" style="background-image:url('<?php echo base_url(); ?>assets/img/bg.jpg');background-size: 100% 100%;">
  <div class="login-box">
    <div class="login-box-body">
      <p class="login-box-msg">Reset Password</p>
    <?php if($this->session->flashdata('result_error')){
      $result_er=$this->session->flashdata('result_error');
      echo "<div class='alert alert-danger' >".$result_er."</div>";
    }
    if($this->session->flashdata('result')){
      $result_r=$this->session->flashdata('result');
      echo "<div class='alert alert-success' >".$result_r."</div>";
    }$attributes = array('id' => 'formlogin');
          echo form_open('login/forgot/', $attributes); ?>
        <div class="form-group has-feedback">
          <input type="email" class="form-control" placeholder="Email" name="user_email" autofocus autocomplete=off required>
          <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>
        <div class="row">
          <div class="col-xs-offset-6 col-xs-6">
            <button type="submit" class="btn btn-primary btn-block btn-flat">Reset Password</button>
          </div>
        </div>
      </form>
      <a href="<?php echo site_url('login/');?>">I already have a membership</a><br>
      <?php if($this->config->item('user_reg')){ ?>
        <a href="<?php echo site_url('login/register/');?>" class="text-center">Register a new membership</a>
      <?php } ?>
    </div>
  </div>
