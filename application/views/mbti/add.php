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
          <a class="btn btn-box-tool" href="<?php echo site_url('mbti/tipe');?>"><i class="fa fa-remove"></i></a>
        </div>
      </div>
      <div class="box-body">
        <?php echo form_open_multipart('mbti/execute/tipe/'.$exe.'/'.$id);?>
          <div class="form-group">
            <label>Nama MBTI</label>
            <input type='text' class="form-control" placeholder="Nama MBTI" name='nama' maxlength="4" value="<?php echo (isset($mbti['tipe_mbti']))?$mbti['tipe_mbti']:'';?>" required/>
          </div>
          <div class="form-group">
            <label>Gambar</label>
            <div class="fileupload fileupload-new" data-provides="fileupload">
                <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;"><img src="<?php echo (isset($mbti['gambar']))?base_url().'assets/img/mbti/'.$mbti['gambar']:base_url().'assets/img/demoUpload.jpg';?>" alt="" /></div>
                <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                <div>
                    <span class="btn btn-file btn-primary">
                      <span class="fileupload-new">Select image</span>
                      <span class="fileupload-exists">Change</span>
                      <input type="file" name="userfile" <?php echo ($exe=='save')?'required':'';?>>
                    </span>
                    <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload">Remove</a>
                </div>
            </div>
          </div>
          <div class="form-group">
            <label>Keterangan</label>
            <textarea class="ckeditor" name="keterangan" class="form-control" required><?php echo (isset($mbti['keterangan']))?$mbti['keterangan']:'';?></textarea>
          </div>
          <div class="form-group">
            <input type="submit" value="Submit"  class="btn btn-primary">
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
