<div class="row">
  <div class="col-md-12">
    <?php
    if($this->session->flashdata('result')!=''){
      echo "<div class='alert alert-success alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>".$this->session->flashdata('result')."</div>";
    }
    ?>
    <div class="box box-<?php echo ($exe=='save')?'primary':'warning';?>">
      <div class="box-header with-border">
        <h3 class="box-title"><?php if($title){ echo $title; } ?></h3>
        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          <a class="btn btn-box-tool" href="<?php echo site_url('simulasi/soal');?>"><i class="fa fa-remove"></i></a>
        </div>
      </div>
      <div class="box-body">
        <form method="post" action="<?php echo site_url('simulasi/execute/soal/'.$exe.'/'.$id);?>">
          <div class="row">
            <div class="col-lg-6">
              <div class="form-group">
                <label>Pilih Unit</label>
                <select class="form-control select2" name="cid">
                  <?php foreach($unit as $value){ ?>
                    <option value="<?php echo $value->id_unit; ?>" <?php if(isset($result['0']['id_unit'])){if($result['0']['id_unit'] == $value->id_unit){ echo "selected"; }} ?>><?php echo $value->id_unit.' - '.$value->nama_unit; ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-12">
              <div class="box box-primary">
                <div class="box-header">
                  <h3 class="box-title">Pertanyaan</h3>
                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                  </div>
                </div>
                <div class="box-body">
                  <div class="form-group">
                    <textarea class="ckeditor" id="pertanyaan" name="question"><?php echo (isset($result['0']['question']))?$result['0']['question']:"";?></textarea>
                  </div>
                </div>
              </div>
              <div class="box box-primary">
                <div class="box-header">
                  <h3 class="box-title">Deskripsi (Optional)</h3>
                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                  </div>
                </div>
                <div class="box-body">
                  <div class="form-group">
                    <textarea class="ckeditor" id="deskripsi" name="description"><?php echo (isset($result['0']['description']))?$result['0']['description']:"";?></textarea>
                    <p class="help-block">
                      Deskripsikan bagaimana pertanyaan bisa di selesaikan. <br>
                      User bisa melihat deskripsi setelah men-submit ujian.
                    </p>
                  </div>
                </div>
              </div>
            </div>
            <?php if(isset($result['1'])){ foreach($result['1'] as $okey => $option_value){ ?>
            <div class="col-lg-6">
              <div class="box box-success">
                <div class="box-header">
                  <h3 class="box-title">
                    <input type="radio" class="flat-red" id="radiobtn" value="<?php echo $okey;?>" name="score" <?php if($option_value['score'] == "1"){ echo "checked"; }?> required>
                    Pilihan <?php echo $okey+1;?>
                  </h3>
                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                  </div>
                </div>
                <div class="box-body">
                  <input type="hidden" value="<?php echo $option_value['oid'];?>" name="oids[]">
                  <textarea class="ckeditor" id="option<?php echo $okey+1;?>" name="option[]"><?php echo $option_value['option_value'];?></textarea>
                </div>
              </div>
            </div>
            <?php }}else{ for ($op=1; $op < 5; $op++) { ?>
            <div class="col-lg-6">
              <div class="box box-success">
                <div class="box-header">
                  <h3 class="box-title">
                    <input type="radio" class="flat-red" id="radiobtn" value="<?php echo $op-1; ?>" name="score" required> Pilihan <?php echo $op; ?>
                  </h3>
                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                  </div>
                </div>
                <div class="box-body">
                  <textarea class="ckeditor" id="option<?php echo $op; ?>" name="option[]"></textarea>
                </div>
              </div>
            </div>
            <?php }} ?>
          </div>
          <div class="row">
            <div class="col-lg-6">
              <div class="form-group">
                <input type="submit" value="Submit"  class="btn btn-success">
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
