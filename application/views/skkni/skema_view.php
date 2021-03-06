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
            <tr><th>Kode</th><th>Nama Skema</th><th>Foto</th><th>Action</th></tr>
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
                <td data-th="Id"><?php echo $row->id_skema;?></td>
  							<td data-th="Kode"><?php echo $row->nama_skema;?></td>
  							<td data-th="Nama"><img class="img-rounded" height="100" width="100" src="<?php echo base_url()."assets/img/skema/".$row->foto;?>" alt=""></td>
  							<td data-th="Action">
  								<a href="javascript: if(confirm('Do you really want to remove this Skema?')){ window.location='<?php echo site_url('skkni/execute/skema/delete/'.$row->id_skema);?>'; }"  class="btn btn-danger btn-xs">Remove</a>
  								<a href="<?php echo site_url('skkni/skema/edit/'.$row->id_skema);?>"  class="btn btn-warning btn-xs">Edit</a>
  							</td>
              </tr>
            <?php } } ?>
          </tbody>
        </table>
        <a class="btn btn-app" href="<?php echo site_url('skkni/skema/add');?>"><i class="fa fa-plus"></i> Add</a>
      </div>
    </div>
  </div>
</div>
