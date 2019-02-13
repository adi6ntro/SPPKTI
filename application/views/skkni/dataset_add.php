<div class="row">
  <div class="col-md-12">
    <?php if($this->session->flashdata('result')!=''){
      echo "<div class='alert alert-success alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>".$this->session->flashdata('result')."</div>";
    } ?>
    <div class="box box-<?php echo ($exe=='save')?'primary':'warning';?>">
      <div class="box-header with-border">
        <h3 class="box-title"><?php if($title){ echo $title; } ?></h3>
        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          <a class="btn btn-box-tool" href="<?php echo site_url('skkni/dataset');?>"><i class="fa fa-remove"></i></a>
        </div>
      </div>
      <div class="box-body">
        <?php echo form_open_multipart('skkni/execute/dataset/'.$exe.'/'.$id);?>
          <div class="form-group">
            <input type="submit" value="Submit"  class="btn btn-primary">
          </div>
          <div class="form-group">
            <label>Nama Skema</label>
            <select class="form-control select2"  name="skema">
              <option>-- Pilih Skema --</option>
              <?php foreach($skema as $value){ ?>
              <option value="<?php echo $value->id_skema; ?>" <?php if(isset($hasil->id_skema)){if($hasil->id_skema == $value->id_skema){ echo "selected"; }} ?>><?php echo $value->id_skema.' - '.$value->nama_skema; ?></option>
              <?php } ?>
            </select>
          </div>
          <div class="form-group">
            <label>MBTI Dataset</label>
            <select class="form-control select2"  name="mbti">
              <option>-- Pilih MBTI Dataset --</option>
              <?php foreach($mbti as $value){ ?>
              <option value="<?php echo $value->NO; ?>" <?php if(isset($hasil->id_mbti_hasil)){if($hasil->id_mbti_hasil == $value->NO){ echo "selected"; }} ?>><?php echo $value->NO.' - '.$value->MBTI.' - '.$value->KELAS; ?></option>
              <?php } ?>
            </select>
          </div>
          <div class="form-horizontal">
            <?php $no=1;
            if(isset($dataset)){
              foreach ($dataset as $row) {?>
              <div class="form-group">
                <div class="col-md-10"><label><?php echo $row->id_unit.' - '.$row->nama_unit;?></label></div>
                <div class="col-md-2">
                  <input type="hidden" value="<?php echo $row->id_unit; ?>" name="unit[]">
                  <select class="form-control"  name="nilai[]">
                    <option value="1" <?php if($row->nilai == 1){ echo "selected"; } ?>>Tidak Bisa</option>
                    <option value="2" <?php if($row->nilai == 2){ echo "selected"; } ?>>Kurang Bisa</option>
                    <option value="3" <?php if($row->nilai == 3){ echo "selected"; } ?>>Cukup Bisa</option>
                    <option value="4" <?php if($row->nilai == 4){ echo "selected"; } ?>>Bisa</option>
                    <option value="5" <?php if($row->nilai == 5){ echo "selected"; } ?>>Sangat Bisa</option>
                  </select>
                </div>
              </div>
            <?php $no++;}
            }else{
              foreach ($unit as $row) {?>
              <div class="form-group">
                <div class="col-md-10"><label><?php echo $row->id_unit.' - '.$row->nama_unit;?></label></div>
                <div class="col-md-2">
                  <input type="hidden" value="<?php echo $row->id_unit; ?>" name="unit[]">
                  <select class="form-control"  name="nilai[]">
                    <option value="1">Tidak Bisa</option>
                    <option value="2">Kurang Bisa</option>
                    <option value="3">Cukup Bisa</option>
                    <option value="4">Bisa</option>
                    <option value="5">Sangat Bisa</option>
                  </select>
                </div>
              </div>
            <?php $no++;}
            } ?>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
