<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Overview - Sistem Pakar Penentuan Kompetensi Teknologi Informasi</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/img/logo.png"/>
  <link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="<?php echo base_url();?>assets/css/AdminLTE.min.css">
  <link rel="stylesheet" href="<?php echo base_url();?>assets/css/skin-blue-light.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <style media="screen">
    .tooltip-inner {
      max-width: 350px;
      /* If max-width does not work, try using width instead */
      width: 350px;
    }
    /* Hide all steps by default: */
    .tab {
      display: none;
    }

    /* Make circles that indicate the steps of the form: */
    .step {
      height: 15px;
      width: 15px;
      margin: 0 2px;
      background-color: #bbbbbb;
      border: none;
      border-radius: 50%;
      display: inline-block;
      opacity: 0.5;
    }

    /* Mark the active step: */
    .step.active {
      opacity: 1;
    }

    /* Mark the steps that are finished and valid: */
    .step.finish {
      background-color: #4CAF50;
    }
  </style>
</head>
<body class="hold-transition skin-blue-light layout-top-nav">
<div class="wrapper">
  <header class="main-header">
    <nav class="navbar navbar-static-top">
      <div class="container">
        <div class="navbar-header">
          <a href="<?php echo base_url();?>" class="navbar-brand"><b>SPPKTI</b></a>
        </div>
        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            <li class="dropdown user user-menu">
              <a href="<?php echo base_url();?>" class="dropdown-toggle">
                <i class="fa fa-reply"></i><span class="hidden-xs">Back to home</span>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </header>
  <div class="content-wrapper">
    <div class="container">
      <section class="content-header">
        <h1>
          Overview
          <small>simulasi singkat</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="<?php echo base_url();?>"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="active">Overview</li>
        </ol>
      </section>
      <section class="content">
        <?php if ($this->uri->segment(2)=="") {?>
          <div class="callout callout-info">
            <h4>Tip!</h4>

            <p>Isi kolom dibawah. Kemudian klik tombol submit untuk mendapatkan hasil dari kolom yang Anda isi.</p>
          </div>
        <?php } ?>
        <div class="row">
          <div class="col-md-12">
            <?php
            if($this->session->flashdata('result')!=''){
              echo "<div class='alert alert-success alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>".$this->session->flashdata('result')."</div>";
            }
            ?>
            <?php if(isset($skkni) || isset($hasil)) {?>
              <?php if ($this->uri->segment(2) == "hasil") {?>
                <div class="box box-success">
                <div class="box-header with-border">
                  <h3 class="box-title">Hasil Perhitungan Naive Bayes</h3>
                </div>
                <div class="box-body">
                  <?php echo $hasil;?><br>
                  <a href='<?php echo base_url();?>overview' class='btn btn-primary'>Back to overview</a>
                </div>
              </div>
              <?php } else { ?>
                <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">SKKNI - Tes Kompetensi</h3>
                </div>
                <div class="box-body">
                  <?php echo form_open('overview/hasil');?>
                    <div class="form-horizontal">
                      <?php $no=1;$numItems = count($skkni);
                        foreach ($skkni as $row) {
                          if($no%10==1){echo '<div class="tab">';}?>
                        <div class="form-group">
                          <div class="col-md-10">
                            <label title="<?php echo $row->deskripsi; ?>"><?php echo $row->kode_unit.' - '.$row->nama_unit;?></label>
                            <a href="#" data-toggle="tooltip" title="<?php echo $row->deskripsi; ?>">
                              <span class="label label-info">!</span>
                            </a>
                          </div>
                          <div class="col-md-2">
                            <div class="input-group">
                              <input type="hidden" value="<?php echo $row->id_unit; ?>" name="unit[]">
                              <input type="hidden" value="<?php echo rand(1,5); ?>" name="random[]">
                              <select class="form-control"  name="nilai[]">
                                <option value="BK">Belum Kompeten</option>
                                <option value="K">Kompeten</option>
                                <?php /*<option value="1">Tidak Bisa</option>
                                <option value="2">Kurang Bisa</option>
                                <option value="3">Cukup Bisa</option>
                                <option value="4">Bisa</option>
                                <option value="5">Sangat Bisa</option>*/ ?>
                              </select>
                            </div>
                          </div>
                        </div>
                      <?php
                          if($no%10==0||$numItems==$no){echo '</div>';}
                          $no++;
                        }
                      ?>
                    </div>
                    <div style="overflow:auto;">
                      <div style="text-align:center;">
                        <button type="button" class="btn btn-default" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
                        <button type="button" class="btn btn-success" id="nextBtn" onclick="nextPrev(1)">Next</button>
                      </div>
                    </div>

                    <!-- Circles which indicates the steps of the form: -->
                    <div style="text-align:center;margin-top:40px;">
                      <span class="step"></span>
                      <span class="step"></span>
                      <span class="step"></span>
                      <span class="step"></span>
                      <span class="step"></span>
                      <span class="step"></span>
                    </div>
                    <input type="hidden" name="no" value="<?php echo $no-1;?>">
                    <div class="form-group">
                      <input type="submit" value="Submit" class="btn btn-primary">
                    </div>
                  </form>
                </div>
              </div>
            <?php }} ?>
            <?php if(isset($mbti) || isset($hasilv2)) {?>
              <?php if ($this->uri->segment(2) == "hasilv2") {?>
                <div class="box box-success">
                <div class="box-header with-border">
                  <h3 class="box-title">Hasil Perhitungan Naive Bayes</h3>
                </div>
                <div class="box-body">
                  <?php echo $hasilv2;?><br>
                  <a href='<?php echo base_url();?>overview' class='btn btn-primary'>Back to overview</a>
                </div>
              </div>
              <?php } else { ?>
                <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">MBTI - Tes Kepribadian</h3>
                </div>
                <div class="box-body">
                  <?php echo form_open('overview/hasilv2');?>
                    <?php /*<div class="form-group">
                      <label>Nama MBTI</label>
                      <select class="form-control select2" name="mbti" required>
                        <option>-- Pilih MBTI --</option>
                        <?php foreach($mbti as $group){ ?>
                        <option value="<?php echo $group->tipe_mbti; ?>"><?php echo $group->tipe_mbti; ?></option>
                        <?php } ?>
                      </select>
                    </div>*/?>
                    <table class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th><p class="text-center">#</p></th>
                          <th width="43%"><p class="text-center">Pernyataan A</p></th>
                          <th colspan="2"><p class="text-center">Jawaban</p></th>
                          <th width="43%"><p class="text-center">Pernyataan B</p></th>
                        </tr>
                      </thead>
                    </table>
                        <?php $no=1;$numItems = count($mbti);
                          foreach ($mbti as $row) {
                            if($no%10==1){echo '<div class="tab"><table class="table table-bordered table-striped">';}?>
                        <tr>
                          <td align="center"><?php echo $no;?><input type="hidden" name="dikotomi<?php echo $no;?>" value="<?php echo $row->dikotomi;?>"></td>
                          <td width="43%"><?php echo $row->pernyataan1;?></td>
                          <td align="center"><input type="radio" class="flat-red" id="radiobtn" value="<?php echo $row->atribut1;?>" name="score<?php echo $no;?>" required></td>
                          <td align="center"><input type="radio" class="flat-red" id="radiobtn" value="<?php echo $row->atribut2;?>" name="score<?php echo $no;?>" required></td>
                          <td width="43%"><?php echo $row->pernyataan2;?></td>
                        </tr>
                        <?php
                            if($no%10==0||$numItems==$no){echo '</table></div>';}
                            $no++;
                          }
                        ?>
                    <div style="overflow:auto;">
                      <div style="text-align:center;">
                        <button type="button" class="btn btn-default" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
                        <button type="button" class="btn btn-success" id="nextBtn" onclick="nextPrev(1)">Next</button>
                      </div>
                    </div>

                    <!-- Circles which indicates the steps of the form: -->
                    <div style="text-align:center;margin-top:40px;">
                      <span class="step" style='display:none'></span>
                    </div>
                    <input type="hidden" name="no" value="<?php echo $no-1;?>">
                    <div class="form-group">
                      <input type="submit" value="Submit"  class="btn btn-primary">
                    </div>
                  </form>
                </div>
              </div>
            <?php }} ?>
          </div>
        </div>
      </section>
    </div>
  </div>
  <footer class="main-footer">
    <div class="container">
      <div class="pull-right hidden-xs">
        <b>Version</b> 1.0
      </div>
      <strong>Copyright &copy; 2017 <a href="#">SPPKTI</a>.</strong> All rights reserved.
    </div>
  </footer>
</div>
<script src="<?php echo base_url(); ?>assets/js/jQuery-2.1.4.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
<script src="<?php echo base_url();?>assets/js/jquery.slimscroll.min.js"></script>
<script src="<?php echo base_url();?>assets/js/fastclick.js"></script>
<script src="<?php echo base_url();?>assets/js/app.min.js"></script>
<script type="text/javascript">
var currentTab = 0; // Current tab is set to be the first tab (0)
showTab(currentTab); // Display the current tab

function showTab(n) {
// This function will display the specified tab of the form ...
var x = document.getElementsByClassName("tab");
x[n].style.display = "block";
// ... and fix the Previous/Next buttons:
if (n == 0) {
  document.getElementById("prevBtn").style.display = "none";
} else {
  document.getElementById("prevBtn").style.display = "inline";
}
if (n == (x.length - 1)) {
  document.getElementById("nextBtn").style.display = "none";
} else {
  document.getElementById("nextBtn").style.display = "inline";
}
// ... and run a function that displays the correct step indicator:
fixStepIndicator(n)
}

function nextPrev(n) {
// This function will figure out which tab to display
var x = document.getElementsByClassName("tab");
// Exit the function if any field in the current tab is invalid:
if (n == 1 && !validateForm()) return false;
// Hide the current tab:
x[currentTab].style.display = "none";
// Increase or decrease the current tab by 1:
currentTab = currentTab + n;
// if you have reached the end of the form... :
/*if (currentTab >= x.length) {
  //...the form gets submitted:
  document.getElementById("regForm").submit();
  return false;
}*/
// Otherwise, display the correct tab:
showTab(currentTab);
}

function validateForm() {
// This function deals with validation of the form fields
var x, y, i, valid = true;
x = document.getElementsByClassName("tab");
y = x[currentTab].getElementsByTagName("input");
// A loop that checks every input field in the current tab:
for (i = 0; i < y.length; i++) {
  // If a field is empty...
  if (y[i].value == "") {
    // add an "invalid" class to the field:
    y[i].className += " invalid";
    // and set the current valid status to false:
    valid = false;
  }
}
// If the valid status is true, mark the step as finished and valid:
if (valid) {
  document.getElementsByClassName("step")[currentTab].className += " finish";
}
return valid; // return the valid status
}

function fixStepIndicator(n) {
// This function removes the "active" class of all steps...
var i, x = document.getElementsByClassName("step");
for (i = 0; i < x.length; i++) {
  x[i].className = x[i].className.replace(" active", "");
}
//... and adds the "active" class to the current step:
x[n].className += " active";
}
</script>
</body>
</html>
