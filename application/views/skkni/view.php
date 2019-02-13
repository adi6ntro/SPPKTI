<div class="row">
  <div class="col-xs-12">
    <?php if($this->session->flashdata('result')!=''){
      echo "<div class='alert alert-success alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>".$this->session->flashdata('result')."</div>";
    } ?>
    <div class="box">
      <div class="box-header">
        <h3 class="box-title"><?php if($title){ echo $title; } ?></h3>
      </div>
      <div class="box-body">
        <table class="table table-bordered table-striped" id="tabel">
          <thead>
            <tr><th>Id</th><th>Kode</th><th>Nama Kompetensi</th><th>Action</th></tr>
          </thead>
          <tbody>
            <?php if($result==false){?>
              <tr>
                <td colspan="5">No record found!</td>
              </tr>
            <?php }else{
              foreach($result as $row){
            ?>
              <tr>
                <td data-th="Id"><?php echo $row->id_unit;?></td>
  							<td data-th="Kode"><?php echo $row->kode_unit;?></td>
  							<td data-th="Nama Kompetensi"><?php echo $row->nama_unit;?></td>
  							<td data-th="Action">
  								<a href="javascript: if(confirm('Do you really want to remove this Attribute?')){ window.location='<?php echo site_url('skkni/execute/unit/delete/'.$row->id_unit );?>'; }"  class="btn btn-danger btn-xs">Remove</a>
  								<a href="<?php echo site_url('skkni/unit/edit/'.$row->id_unit);?>"  class="btn btn-warning btn-xs">Edit</a>
  							</td>
              </tr>
            <?php } } ?>
          </tbody>
        </table>
        <a class="btn btn-app" href="<?php echo site_url('skkni/unit/add');?>"><i class="fa fa-plus"></i> Add</a>
      </div>
    </div>
  </div>
</div>
