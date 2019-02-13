<div class="row">
  <div class="col-md-6">
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
          <a class="btn btn-box-tool" href="<?php echo site_url('group');?>"><i class="fa fa-remove"></i></a>
        </div>
      </div>
      <div class="box-body">
        <form method="post" action="<?php echo site_url('group/execute/'.$exe.'/'.$id);?>">
          <div class="form-group">
            <label>Group ID</label>
            <input type='text'  class="form-control" maxlength="3" placeholder="Group ID" name='gid' value="<?php if(isset($group['gid'])){echo $group['gid'];}?>">
          </div>
          <div class="form-group">
            <label>Group Name</label>
            <input type='text'  class="form-control" placeholder="Group Name" name='groupname' value="<?php if(isset($group['group_name'])){echo $group['group_name'];}?>">
          </div>
          <div class="form-group">
            <input type="submit" value="Submit"  class="btn btn-primary">
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
