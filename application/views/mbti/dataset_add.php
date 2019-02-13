<div class="row">
  <div class="col-md-6">
    <?php if($this->session->flashdata('result')!=''){
      echo "<div class='alert alert-success alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>".$this->session->flashdata('result')."</div>";
    } ?>
    <div class="box box-<?php echo ($exe=='save')?'primary':'warning';?>">
      <div class="box-header with-border">
        <h3 class="box-title"><?php if($title){ echo $title; } ?></h3>
        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          <a class="btn btn-box-tool" href="<?php echo site_url('mbti/dataset');?>"><i class="fa fa-remove"></i></a>
        </div>
      </div>
      <div class="box-body">
        <?php echo form_open_multipart('mbti/execute/dataset/'.$exe.'/'.$id);?>
          <div class="form-group">
            <label>Nama Kelas</label>
            <select class="form-control select2" name="kelas" required>
              <option>-- Pilih Kelas --</option>
              <?php foreach($kelas as $group){ ?>
              <option value="<?php echo $group->id_mbti_kelas; ?>" <?php if(isset($hasil->id_mbti_kelas)){if($hasil->id_mbti_kelas == $group->id_mbti_kelas){ echo "selected"; }} ?>><?php echo $group->nama_kelas; ?></option>
              <?php } ?>
            </select>
          </div>
          <div class="form-group">
            <label>Nama MBTI</label>
            <select class="form-control select2" name="mbti" required>
              <option>-- Pilih MBTI --</option>
              <?php foreach($mbti as $group){ ?>
              <option value="<?php echo $group->tipe_mbti; ?>" <?php if(isset($hasil->tipe_mbti)){if($hasil->tipe_mbti == $group->tipe_mbti){ echo "selected"; }} ?>><?php echo $group->tipe_mbti; ?></option>
              <?php } ?>
            </select>
          </div>
          <div class="form-group">
            <label>Manual Value</label>
            <select class="form-control" name="dikotomi">
              <option value="">No</option>
              <option value="1">Yes</option>
            </select>
          </div>
          <div class="form-group">
            <label>Introvert/Extrovert</label>
            <input type="number" class="form-control" name="dikotomi1" min="50" max="100" value="<?php echo (isset($hasil->dikotomi1))?$hasil->dikotomi1:''; ?>">
          </div>
          <div class="form-group">
            <label>Sensing/Intuition</label>
            <input type="number" class="form-control" name="dikotomi2" min="50" max="100" value="<?php echo (isset($hasil->dikotomi2))?$hasil->dikotomi2:''; ?>">
          </div>
          <div class="form-group">
            <label>Thinking/Feeling</label>
            <input type="number" class="form-control" name="dikotomi3" min="50" max="100" value="<?php echo (isset($hasil->dikotomi3))?$hasil->dikotomi3:''; ?>">
          </div>
          <div class="form-group">
            <label>Judging/Perceiving</label>
            <input type="number" class="form-control" name="dikotomi4" min="50" max="100" value="<?php echo (isset($hasil->dikotomi4))?$hasil->dikotomi4:''; ?>">
          </div>
          <div class="form-group">
            <input type="submit" value="Submit"  class="btn btn-primary">
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
