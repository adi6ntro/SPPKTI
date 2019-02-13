<div class="row">
  <div class="col-md-12">
    <?php if($this->session->flashdata('result')!=''){
      echo "<div class='alert alert-success alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>".$this->session->flashdata('result')."</div>";
    } ?>
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title"><?php if($title){ echo $title; } ?></h3>
        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          <a type="button" class="btn btn-box-tool" href="<?php echo site_url('konsultasi');?>"><i class="fa fa-remove"></i></a>
        </div>
      </div>
      <div class="box-body">
        <?php foreach ($result as $key => $value) { ?>
        <div class="box">
          <div class="box-header">
            <strong class="box-title"><?php echo $value['quiz_name']; ?></strong>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
          </div>
          <div class="box-body">
            <table class="table table-hover">
              <tr><th valign="top">Deskripsi / Intruksi</th><td><?php echo $value['description'];?></td></tr>
              <tr><th valign="top">Durasi</th><td><?php echo $value['duration'];?> Menit</td></tr>
              <tr><th valign="top">Persentase lulus</td><td><?php echo $value['pass_percentage'];?>%</td></tr>
              <tr><th valign="top">Nilai jawaban yang benar</th><td><?php echo $value['correct_score'];?> </td></tr>
              <tr><th valign="top">Nilai jawaban yang salah</th><td><?php echo $value['incorrect_score'];?> </td></tr>
              <tr>
                <td valign="top">
                  <input type="checkbox" name="agree" id="agree" class="flat-red"> centak checkbox ini , jika anda telah membaca semua intruksi dan siap untuk simulasi.
                  <div id="warning_checkbox"  class="arrow_box" style="display:none;color:#ffffff;background:#D03800;padding:2px; width:150px;">Tick above check box ! </div>
                </td>
                <td><input type="button" id="starttestbtn" Value="<?php echo ($this->session->flashdata('result')!='')?'Restart Test':'Start Test';?>" onClick="javascript:checkbox_validate('<?php echo $value['id_skema']; ?>');" class="btn btn-success" style="cursor:pointer;"></td>
              </tr>
            </table>
          </div>
        </div>
        <?php }?>
      </div>
    </div>
  </div>
</div>
<script language="JavaScript">
  function checkbox_validate(id_skema){
    if(document.getElementById('agree').checked==true){
      window.location='<?php echo site_url('simulasi/attempt');?>'+'/'+id_skema;
    }else{
      document.getElementById('warning_checkbox').style.display="block";
    }
  }
</script>
