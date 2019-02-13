<div class="row">
  <div class="col-md-6">
    <div class="box box-<?php echo ($exe=='save')?'primary':'warning';?>">
      <div class="box-header with-border">
        <h3 class="box-title"><?php if($title){ echo $title; } ?></h3>
        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          <a class="btn btn-box-tool" href="<?php echo site_url('skkni/unit');?>"><i class="fa fa-remove"></i></a>
        </div>
      </div>
      <div class="box-body">
        <?php echo form_open_multipart('skkni/execute/unit/'.$exe.'/'.$id);?>
          <div class="form-group">
            <label>Kode Unit</label>
            <input type='text' class="form-control" placeholder="Kode Unit" name='kode' value="<?php echo (isset($skkni['kode_unit']))?$skkni['kode_unit']:'';?>" required/>
          </div>
          <div class="form-group">
            <label>Nama Kompetensi</label>
            <input type='text' class="form-control" placeholder="Nama kompetensi" name='nama' value="<?php echo (isset($skkni['nama_unit']))?$skkni['nama_unit']:'';?>" required/>
          </div>
          <div class="form-group">
            <label>Deskripsi</label>
            <textarea name="deskripsi" rows="4" class="form-control" required><?php echo (isset($skkni['deskripsi']))?$skkni['deskripsi']:'';?></textarea>
          </div>
          <div class="form-group">
            <input type="submit" value="Submit"  class="btn btn-primary">
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
