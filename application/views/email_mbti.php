<body class="hold-transition login-page" style="background-image:url('<?php echo base_url(); ?>assets/img/bg.jpg');background-size: 100% 100%;">
  <div class="login-box">
    <div class="login-box-body">
      <p class="login-box-msg">Kirim Email MBTI</p>
    <?php if($this->session->flashdata('result_error')){
      $result_er=$this->session->flashdata('result_error');
      echo "<div class='alert alert-danger' >".$result_er."</div>";
    }
    if($this->session->flashdata('result')){
      $result_r=$this->session->flashdata('result');
      echo "<div class='alert alert-success' >".$result_r."</div>";
    }$attributes = array('id' => 'formlogin');
          echo form_open('login/kirim_email_mbti/', $attributes); ?>
        <div class="form-group has-feedback">
          <input type="email" class="form-control" placeholder="Email" name="user_email" autofocus autocomplete=off required>
          <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
          <input type="text" class="form-control" placeholder="Inisial Nama" name="nama" autofocus autocomplete=off required>
          <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
          <select class="form-control" placeholder="MBTI" name="mbti" autofocus autocomplete=off required>
            <option value=""></option><option value="ISTP">ISTP</option><option value="ISTJ">ISTJ</option><option value="ISFP">ISFP</option><option value="ISFJ">ISFJ</option>
            <option value="INTP">INTP</option><option value="INTJ">INTJ</option><option value="INFP">INFP</option><option value="INFJ">INFJ</option><option value="ESTP">ESTP</option>
            <option value="ESTJ">ESTJ</option><option value="ESFP">ESFP</option><option value="ESFJ">ESFJ</option><option value="ENTP">ENTP</option><option value="ENTJ">ENTJ</option>
            <option value="ENFP">ENFP</option><option value="ENFJ">ENFJ</option>
          </select>
        </div>
        <div class="row">
          <div class="col-xs-offset-6 col-xs-6">
            <button type="submit" class="btn btn-primary btn-block btn-flat">Kirim Email</button>
          </div>
        </div>
      </form>
      <a href="<?php echo base_url();?>">Back to home</a><br>
    </div>
  </div>
