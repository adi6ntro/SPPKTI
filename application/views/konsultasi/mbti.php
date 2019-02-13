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
<div class="row">
  <div class="col-md-12">
    <div class="alert alert-info alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
      <h4><i class="icon fa fa-info"></i> PERHATIAN</h4>
      <p>1. Masing-masing nomor memiliki dua pernyataan yang bertolak belakang (PERNYATAAN A & B).<br/>
      2. Pilihlah salah satu pernyataan yang paling sesuai dengan diri Anda pada kolom yang sudah disediakan (KOLOM ISIAN).<br/>
      3. Tes Kepribadian MBTI hanya dapat di akses sekali.<br/>
      4. Anda HARUS jujur dalam mengisi dan memilih salah satu yang dominan serta mengisi semua nomor.</p>
    </div>
    <?php
    if($this->session->flashdata('result')!=''){
      echo "<div class='alert alert-success alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>".$this->session->flashdata('result')."</div>";
    }
    ?>
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title"><?php if($title){ echo $title; } ?></h3>
        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          <a class="btn btn-box-tool" href="<?php echo site_url('konsultasi');?>"><i class="fa fa-remove"></i></a>
        </div>
      </div>
      <div class="box-body">
        <?php echo form_open_multipart('konsultasi/execute/mbti');?>
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
  </div>
</div>
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
