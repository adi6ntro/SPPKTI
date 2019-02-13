<?php
Class Skkni_model extends CI_Model{
	function unit_list($act=''){
		if($act=='konsultasi') $this->db->order_by("kode_unit", "asc");
		$query = $this -> db -> get('skkni_unit');
		if($query -> num_rows() >= 1){
			return $query->result();
		}else{
			return false;
		}
	}

	function kode($tipe) {
		if($tipe=='unit'){
			$sql="select max(id_unit) as id from skkni_unit";
			$i='UK';
		}elseif($tipe=='skema'){
			$sql="select max(id_skema) as id from skkni_skema";
			$i='SK';
		}
		$cari_id = $this->db->query($sql);
		$kode_temp = $cari_id->row_array();
		if ($kode_temp['id'] == ''){
			$kode = ($i=='UK')?$i.'001':$i.'01';
		} else {
			$jum = substr($kode_temp['id'], 2);
			$jum++;
			if ($jum <= 9){$kode = ($i=='UK')?$i."00".$jum:$i."0".$jum;}
			elseif ($jum <= 99){$kode = ($i=='UK')?$i."0".$jum:$i.$jum;}
			elseif ($jum <= 999){if($i=='UK'){$kode = $i.$jum;}}
			else{die("Kode melebihi batas");}
		}
		return $kode;
	}

	function insert_unit(){
		$data = array(
			"id_unit" => $this->kode('unit'),
			"kode_unit" => $this->input->post('kode'),
			"nama_unit" => $this->input->post('nama'),
			"deskripsi" => $this->input->post('deskripsi')
		);
		if($this->db->insert('skkni_unit',$data)){
			return "Unit successfully added";
		}else{
			return "Failed to add Unit";
		}
	}

	function get_unit($cid=''){
		if($cid==''){
			$query = $this->db->get('skkni_unit');
			return $query->result();
		}else{
			$query = $this->db->get_where('skkni_unit',array('id_unit' => $cid));
			return $query->row_array();
		}
	}

	function update_unit($cid){
		$data = array(
			"id_unit" => $cid,
			"kode_unit" => $this->input->post('kode'),
			"nama_unit" => $this->input->post('nama'),
			"deskripsi" => $this->input->post('deskripsi')
		);
		$this->db->where('id_unit', $cid);
		if($this->db->update('skkni_unit',$data)){
			return "Unit successfully updated";
		}else{
			return "Failed to update Unit";
		}
	}

	function remove_unit($cid){
		if($this->db->delete('skkni_unit', array('id_unit' => $cid))){
			return "Unit successfully removed";
		}else{
			return "Failed to remove Unit";
		}
	}

	function skema_list(){
		$query = $this -> db -> get('skkni_skema');
		if($query -> num_rows() >= 1){
			return $query->result();
		}else{
			return false;
		}
	}

	function insert_skema($foto){
		$data = array(
			"id_skema" => $this->kode('skema'),
			"nama_skema" => $this->input->post('nama'),
			"foto" => $foto,
			"deskripsi" => $this->input->post('deskripsi')
		);
		if($this->db->insert('skkni_skema',$data)){
			return "Skema successfully added";
		}else{
			return "Failed to add Skema";
		}
	}

	function get_skema($cid){
		$query = $this->db->get_where('skkni_skema',array('id_skema' => $cid));
		return $query->row_array();
	}

	function update_skema($cid,$foto=''){
		$data = array(
			"id_skema" => $cid,
			"nama_skema" => $this->input->post('nama'),
			"deskripsi" => $this->input->post('deskripsi')
		);
		if($foto!=''){
			$this->db->where('id_skema',$cid);
			$query = $this->db->get('skkni_skema');
			$row = $query->row();
			unlink("./assets/img/skema/".$row->foto);
			$data['foto'] = $foto;
		}
		$this->db->where('id_skema', $cid);
		if($this->db->update('skkni_skema',$data)){
			return "Skema successfully updated";
		}else{
			return "Failed to update Skema";
		}
	}

	function remove_skema($cid){
		if($this->db->delete('skkni_skema', array('id_skema' => $cid))){
			return "Berhasil Menghapus Skema";
		}else{
			return "Skema Tidak Bisa Dihapus";
		}
	}

	function dataset_list(){
		$sql = "select A.id as NO, F.username as NAMA, E.tipe_mbti as MBTI, C.nama_skema as KELAS from result A
			join skkni_skema C on A.id_skema=C.id_skema
			join mbti_hasil E on A.id_mbti_hasil=E.id_mbti_hasil
			join users F on A.id_user=F.id
			where A.status <> 'delete'
			order by A.id desc";
		$query = $this->db->query($sql);
		if($query -> num_rows() >= 1){
			return $query->result();
		}else{
			return false;
		}
	}

	function insert_dataset(){
		$data = array(
			"id_user" => $this->session->userdata('logged_in')['id'],
			"id_skema" => $this->input->post('skema'),
			"id_mbti_hasil" => $this->input->post('mbti'),
		);
 		$this->db->insert('result',$data);
		$hasil = $this->db->insert_id();
		$data_detail = array(
			"id" => $hasil,
			"id_skema" => $this->input->post('skema'),
			"persentase" => '0'
		);
 		$this->db->insert('result_detail',$data_detail);
 		/*$nm = $this->input->post('unit');
		$result = array();
		foreach($nm AS $key => $val){
			$result[] = array(
				"id_hasil" => $hasil,
				"id_unit"  => $this->input->post('unit')[$key],
				"nilai"  => $this->input->post('nilai')[$key]
			);
		}*/
		if($this->input->post('skema')=='SK03'){
			$skemaunit="'SK02','SK03'";
		}elseif($this->input->post('skema')=='SK02'){
			$skemaunit="'SK02'";
		}elseif($this->input->post('skema')=='SK05'){
			$skemaunit="'SK04','SK05'";
		}elseif($this->input->post('skema')=='SK04'){
			$skemaunit="'SK04'";
		}elseif($this->input->post('skema')=='SK07'){
			$skemaunit="'SK06','SK07'";
		}elseif($this->input->post('skema')=='SK06'){
			$skemaunit="'SK06'";
		}elseif($this->input->post('skema')=='SK09'){
			$skemaunit="'SK08','SK09'";
		}elseif($this->input->post('skema')=='SK08'){
			$skemaunit="'SK08'";
		}elseif($this->input->post('skema')=='SK10'){
			//$skemaunit="'SK02','SK03','SK10'"; // 8 kali
			//$skemaunit="'SK06','SK07','SK10'"; // 8 kali
			//$skemaunit="'SK04','SK05','SK10'"; // 7 kali
			$skemaunit="'SK08','SK09','SK10'"; // 7 kali
		}elseif($this->input->post('skema')=='SK11'){
			//$skemaunit="'SK02','SK03','SK11'"; // 10 kali
			//$skemaunit="'SK06','SK07','SK11'";
			$skemaunit="'SK04','SK05','SK11'";
		}elseif($this->input->post('skema')=='SK01'){
			//$skemaunit="'SK01','SK02','SK03','SK10'"; // 4 kali
			//$skemaunit="'SK01','SK06','SK07','SK10'";
			//$skemaunit="'SK01','SK04','SK05','SK10'";
			//$skemaunit="'SK01','SK08','SK09','SK10'";
			//$skemaunit="'SK02','SK03','SK01'"; // 2 kali
			//$skemaunit="'SK06','SK07','SK01'";
			//$skemaunit="'SK04','SK05','SK01'";
			//$skemaunit="'SK08','SK09','SK01'";
			//$skemaunit="'SK01','SK02','SK03','SK11'"; // 2 kali
			//$skemaunit="'SK01','SK06','SK07','SK11'";
			$skemaunit="'SK01','SK04','SK05','SK11'";
			// $skemaunit="";
			// $chars = array("'SK02','SKO3'", "'SK04','SK05'", "'SK06','SKO7'", "'SK08','SK09'", "'SK10'", "'SK11'");
			// shuffle($chars);
			// $num_chars = count($chars) - 1;
			// $token = $chars[mt_rand(0, $num_chars)];
			// $skemaunit.=$token;
		}else{
			$skemaunit="'".$this->input->post('skema')."'";
		}
		$gej = $this->db->select('A.id_unit')->from('skkni_unit A')
			->join('relasi B', 'A.id_unit = B.id_unit AND B.id_skema in ('.$skemaunit.')')
			->group_by('A.id_unit')->get();
		$atribut = $gej->result_array();//print_r($this->input->post('skema'));print_r($skemaunit);echo '<pre>';print_r($atribut);echo '</pre>';
		$geja = $this->db->get('skkni_unit');
		$all = $geja->result_array();
		$nilai=array();
		$unit=array();
		$unit1=array();
 		$result = array();
		foreach ($atribut as $value) {
			$unit[]=$value['id_unit'];
		}//print_r($unit);die();
		foreach ($all as $value) {
			$unit1[]=$value['id_unit'];
		}
		foreach ($unit1 as $value) {
			// if(in_array($value,$unit)){$nilai[]=(rand(3,5));}else{$nilai[]=(rand(1,3));}
			if(in_array($value,$unit))
				$nilai[]='K';
			else
				$nilai[]='BK';
		}
		foreach($all AS $key => $val){
			$result[] = array(
				"id_hasil" => $hasil,
				"id_unit"  => $val['id_unit'],
				"nilai"  => $nilai[$key]
			);
		}
		if($this->db->insert_batch('skkni_dataset', $result)){
			return "Dataset successfully added";
		}else{
			return "Unable to add Dataset";
		}
	}

	function get_hasil($cid){
		$query = $this->db->query("select * from result where id=".$this->db->escape($cid));
		return $query->row_object();
	}

	function get_dataset($cid){
		$query = $this->db->query("select * from skkni_dataset A join skkni_unit B on A.id_unit=B.id_unit where id_hasil=".$this->db->escape($cid));
		return $query->result_object();
	}

	function update_dataset($id){
		$data = array(
			"id_user" => $this->session->userdata('logged_in')['id'],
			"id_skema" => $this->input->post('skema'),
			"id_mbti_hasil" => $this->input->post('mbti'),
		);
		$this->db->where('id', $id);
 		$this->db->update('result',$data);
 		$nm = $this->input->post('unit');
		$result = array();
		foreach($nm AS $key => $val){
			$result[] = array(
				"id_hasil" => $id,
				"id_unit"  => $this->input->post('unit')[$key],
				"nilai"  => $this->input->post('nilai')[$key]
			);
		}
		$this->db->delete('skkni_dataset', array('id_hasil' => $id));
		if($this->db->insert_batch('skkni_dataset', $result)){
			return "Dataset successfully added";
		}else{
			return "Unable to add Dataset";
		}
	}

	function remove_dataset($cid){
		//$this->db->delete('skkni_dataset', array('id_hasil' => $cid));
		//if($this->db->delete('result', array('id' => $cid))){
		$this->db->where('id', $cid);
		if($this->db->update('result',array('status'=>'delete'))){
			return "Berhasil Menghapus Dataset";
		}else{
			return "Dataset Tidak Bisa Dihapus";
		}
	}
}
?>
