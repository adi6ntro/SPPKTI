<div class="row">
  <div class="col-xs-6">
    <div class="box">
      <div class="box-header">
        <h3 class="box-title"><?php if($title){ echo $title; } ?></h3>
      </div>
      <div class="box-body">
        <table class="table table-bordered table-striped" id="tabel">
          <thead>
            <tr><th>Id</th><th>Group</th><th>Action</th></tr>
          </thead>
          <tbody>
            <?php if($result==false){ ?>
              <tr>
                <td colspan="5">No record found!</td>
              </tr>
            <?php }else{
              foreach($result as $row){ ?>
              <tr>
                <td data-th="Id"><?php echo $row->gid;?></td>
                <td data-th="Group Name"><?php echo $row->group_name;?></td>
                <td data-th="Action">
                  <a href="javascript: if(confirm('Do you really want to remove this group?')){ window.location='<?php echo site_url('group/execute/delete/'.$row->gid );?>'; }"  class="btn btn-danger btn-xs">Remove</a>
                  <a href="<?php echo site_url('group/form/edit/'.$row->gid );?>"  class="btn btn-warning btn-xs">Edit</a>
                </td>
              </tr>
            <?php }} ?>
          </tbody>
        </table>
        <a class="btn btn-app" href="<?php echo site_url('group/form/add');?>"><i class="fa fa-plus"></i> Add</a>
      </div>
    </div>
  </div>
</div>
