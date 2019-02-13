<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-header">
        <h3 class="box-title"><?php if($title){ echo $title; } ?></h3>
      </div>
      <div class="box-body">
        <table class="table table-bordered table-striped" id="tabel">
          <thead>
            <tr><th>#</th><th>Dikotomi</th><th>Pernyataan A</th><th>Pernyataan B</th><th>Status</th><th>Action</th></tr>
          </thead>
          <tbody>
            <?php if($result==false){ ?>
              <tr>
                <td colspan="5">No record found!</td>
              </tr>
            <?php }else{$no=1;
              foreach($result as $row){
                if($row->dikotomi == 1){$na="Extrovert-Introvert";}elseif($row->dikotomi == 2){$na="Sensing-Intuition";}
                elseif($row->dikotomi == 3){$na="Thinking-Feeling";}elseif($row->dikotomi == 4){$na="Judging-Perceiving";}
            ?>
              <tr>
                <td data-th="Id"><?php echo $no;?></td>
                <td data-th="Id"><?php echo $na;?></td>
                <td data-th="Group Name"><?php echo $row->pernyataan1;?></td>
                <td data-th="Id"><?php echo $row->pernyataan2;?></td>
                <td data-th="Id"><?php echo $row->status_nama;?></td>
                <td data-th="Action">
                  <a href="javascript: if(confirm('Do you really want to remove this item?')){ window.location='<?php echo site_url('mbti/execute/pernyataan/delete/'.$row->id_pernyataan );?>'; }"  class="btn btn-danger btn-xs">Remove</a>
                  <a href="<?php echo site_url('mbti/pernyataan/edit/'.$row->id_pernyataan);?>"  class="btn btn-warning btn-xs">Edit</a>
                </td>
              </tr>
            <?php $no++;}}?>
          </tbody>
        </table>
        <a class="btn btn-app" href="<?php echo site_url('mbti/pernyataan/add');?>"><i class="fa fa-plus"></i> Add</a>
      </div>
    </div>
  </div>
</div>
