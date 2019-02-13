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
          <a class="btn btn-box-tool" href="<?php echo site_url('mbti/pernyataan');?>"><i class="fa fa-remove"></i></a>
        </div>
      </div>
      <div class="box-body">
        <?php echo form_open_multipart('mbti/execute/pernyataan/'.$exe.'/'.$id);?>
          <div class="form-group">
            <label>Dikotomi</label>
            <select id="dikotomi" onchange="loaddikotomi()" name="dikotomi" class="form-control">
              <option selected>-- Pilih Dikotomi --</option>
              <option value="1" <?php if(isset($mbti['dikotomi'])){if($mbti['dikotomi']==1) echo "selected";}?>>Extrovert - Introvert</option>
              <option value="2" <?php if(isset($mbti['dikotomi'])){if($mbti['dikotomi']==2) echo "selected";}?>>Sensing - Intuition</option>
              <option value="3" <?php if(isset($mbti['dikotomi'])){if($mbti['dikotomi']==3) echo "selected";}?>>Thinking - Feeling</option>
              <option value="4" <?php if(isset($mbti['dikotomi'])){if($mbti['dikotomi']==4) echo "selected";}?>>Judging - Perceiving</option>
            </select>
          </div>
          <div class="form-group">
            <label>Pernyataan A</label>
            <select name="pilihan1" id="pilihan1" class="form-control" required><?php echo (isset($mbti['atribut1']))?'<option value="'.$mbti['atribut1'].'" selected>'.$mbti['atribut1'].'</option>':'';?></select>
            <input type='text'  class="form-control" placeholder="Pernyataan A" name='pernyataan1' value="<?php echo (isset($mbti['pernyataan1']))?$mbti['pernyataan1']:'';?>" required/>
          </div>
          <div class="form-group">
            <label>Pernyataan B</label>
            <select name="pilihan2" id="pilihan2" class="form-control" required><?php echo (isset($mbti['atribut2']))?'<option value="'.$mbti['atribut2'].'" selected>'.$mbti['atribut2'].'</option>':'';?></select>
            <input type='text'  class="form-control" placeholder="Pernyataan B" name='pernyataan2' value="<?php echo (isset($mbti['pernyataan2']))?$mbti['pernyataan2']:'';?>" required/>
          </div>
          <div class="form-group">
            <label>Status</label>
            <select id="status" name="status" class="form-control">
              <option value="0" <?php if(isset($mbti['status'])){if($mbti['status']==0) echo "selected";}?>>Tidak Aktif</option>
              <option value="1" <?php if(isset($mbti['status'])){if($mbti['status']==1) echo "selected";}?>>Aktif</option>
            </select>
          </div>
          <div class="form-group">
            <input type="submit" value="Submit"  class="btn btn-primary">
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  function loaddikotomi()
  {
    var metode = $("#dikotomi").val();
    $.ajax({
      type:'GET',
      url:"<?php echo base_url(); ?>mbti/dikotomi",
      data:"id=" + metode,
      success: function(html)
      {
        $("#pilihan1").html(html);
        $("#pilihan2").html(html);
      }
    });
  }
</script>
