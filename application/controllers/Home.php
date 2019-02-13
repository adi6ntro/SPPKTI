<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->model('home_model','',TRUE);
	}

	public function index()
	{
		$data['result'] = $this->home_model->SkemaList();
		$this->load->view('home',$data);
	}

	public function Skema()
	{
		$id = $_GET['id'];
		$hasil = $this->home_model->SkemaList($id);
		if(is_array($hasil)){
		foreach($hasil as $row){
			$unit = $this->db->query("select A.* from skkni_unit A join relasi B on A.id_unit=B.id_unit
				join skkni_skema C on B.id_skema=C.id_skema where C.id_skema='".$row->id_skema."'")->result();
			$tabel_unit='';
			if($unit!=false){
				$n=1;
				$tabel_unit = '
				<table id="tabel" class="table table-bordered table-striped">
					<thead>
						<tr><th>No</th><th>Kode Unit</th><th>Nama Kompetensi</th></tr>
					</thead>
					<tbody>';
						foreach($unit as $row1){
							$tabel_unit .='
							<tr>
								<td>'.$n.'</td>
								<td>'.$row1->kode_unit.'</td>
								<td>'.$row1->nama_unit.'</td>
							</tr>';
							$n++;
						}
						$tabel_unit .='
					</tbody>
				</table>';
			}
			echo '
			<div class="col-md-3">
					<div class="portfolio-item baris" kode="'.$row->id_skema.'">
							<a href="#portfolioModal'.$row->id_skema.'" data-toggle="modal" title="Skema '.$row->nama_skema.'"><img class="img-portfolio img-responsive" src="'.base_url().'assets/img/skema/'.$row->foto.'" alt="'.$row->nama_skema.'"></a>
					</div>
			</div>
			<div class="modal fade" id="portfolioModal'.$row->id_skema.'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog">
							<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
										<h4 class="modal-title" id="myModalLabel">'.$row->nama_skema.'</h4>
									</div>
									<div class="modal-body">
										<center>
											'.$row->deskripsi.$tabel_unit.'
										</center>
									</div>
									<div class="modal-footer">
										<center><button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button></center>
									</div>
							</div>
					</div>
			</div>
			';
		}}
	}
}
