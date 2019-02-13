<body class="hold-transition login-page" style="background-image:url('<?php echo base_url(); ?>assets/img/bg.jpg');background-size: 100% 100%;">
  <div class="login-box">
    <div class="login-box-body">
      <p class="login-box-msg">Sign in to start your session</p>
      <?php if(validation_errors()||$this->session->flashdata('result_error')){ ?>
        <div class="alert alert-danger">
          <?php echo validation_errors().$this->session->flashdata('result_error'); ?>
        </div>
      <?php } if($this->session->flashdata('result')){
      				$result_r=$this->session->flashdata('result');
      				echo "<div class='alert alert-success' >".$result_r."</div>";
      			}
      echo form_open('login/verify'); ?>
        <div class="form-group has-feedback">
          <input type="text" class="form-control" placeholder="Username or Email" name="username" autofocus autocomplete=off>
          <span class="glyphicon glyphicon-user form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
          <input type="password" class="form-control" placeholder="Password" name="password" autocomplete=off>
          <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="row">
          <div class="col-xs-8"></div>
          <div class="col-xs-4">
            <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
          </div>
        </div>
      </form>
      <a href="<?php echo site_url('login/forgot/');?>">I forgot my password</a><br>
      <?php if($this->config->item('user_reg')){ ?>
        <a href="<?php echo site_url('login/register/');?>" class="text-center">Register a new membership</a>
      <?php } ?>
    </div>
  </div>
