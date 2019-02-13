<?php
Class Mbti_model extends CI_Model{
	function mbti_list(){
		$query = $this -> db -> get('mbti');
		if($query -> num_rows() >= 1){
			return $query->result();
		}else{
			return false;
		}
	}

	function insert_mbti(){
		$insert_mbti = array(
			"tipe_mbti" => $this->input->post('nama'),
			"gambar" => basename( $_FILES['userfile']['name']),
			"keterangan" => $this->input->post('keterangan')
		);
		if($this->db->insert('mbti',$insert_mbti)){
			return "MBTI successfully added";
		}else{
			return "Failed to add MBTI";
		}
	}

	function get_mbti($cid){
		$query = $this->db->get_where('mbti',array('tipe_mbti' => $cid));
		return $query->row_array();
	}

	function update_mbti($cid){
		$update_mbti = array(
			"tipe_mbti" => $this->input->post('nama'),
			"keterangan" => $this->input->post('keterangan')
		);
		if($_FILES['userfile']['name']!=''){
			$this->db->where('tipe_mbti',$cid);
			$query = $this->db->get('mbti');
			$row = $query->row();
			unlink("./assets/img/mbti/".$row->gambar);
			$update_mbti['gambar'] = basename($_FILES['userfile']['name']);
		}
		$this->db->where('tipe_mbti', $cid);
		if($this->db->update('mbti',$update_mbti)){
			return "MBTI successfully updated";
		}else{
			return "Failed to update MBTI";
		}
	}

	function remove_mbti($cid){
		$this->db->where('tipe_mbti',$cid);
		$query = $this->db->get('mbti');
		$row = $query->row();
		unlink("./assets/img/mbti/".$row->gambar);
		if($this->db->delete('mbti', array('tipe_mbti' => $cid))){
			return "MBTI successfully removed";
		}else{
			return "Failed to remove MBTI";
		}
	}

	function pernyataan($id=null){
		if($id!=null){
			$this->db->order_by("id_pernyataan", "asc");
			$this->db->where('status', '1');
		}else{
			$this->db->order_by("id_pernyataan", "desc");
			$this->db->select("*,IF(`status`=0, 'Tidak Aktif', 'Aktif') AS `status_nama`", FALSE);
		}
		$query = $this -> db -> get('mbti_pernyataan');
		if($query -> num_rows() >= 1){
			return $query->result();
		}else{
			return false;
		}
	}

	function insert_pernyataan(){
		if($this->input->post('pilihan1') != $this->input->post('pilihan2')){
			$insert_mbti = array(
				"dikotomi" => $this->input->post('dikotomi'),
				"atribut1" => $this->input->post('pilihan1'),
				"pernyataan1" => $this->input->post('pernyataan1'),
				"atribut2" => $this->input->post('pilihan2'),
				"pernyataan2" => $this->input->post('pernyataan2'),
				"status" => $this->input->post('status')
			);
			$this->db->insert('mbti_pernyataan',$insert_mbti);
			return "Berhasil Menambah Pernyataan";
		}else{
			return "Jenis Pernyataan Tidak Boleh Sama";
		}
	}

	function get_pernyataan($cid){
		$query = $this->db->get_where('mbti_pernyataan',array('id_pernyataan' => $cid));
		return $query->row_array();
	}

	function update_pernyataan($cid){
		if($this->input->post('pilihan1') != $this->input->post('pilihan2')){
			$update_mbti = array(
				"dikotomi" => $this->input->post('dikotomi'),
				"atribut1" => $this->input->post('pilihan1'),
				"pernyataan1" => $this->input->post('pernyataan1'),
				"atribut2" => $this->input->post('pilihan2'),
				"pernyataan2" => $this->input->post('pernyataan2'),
				"status" => $this->input->post('status')
			);
			$this->db->where('id_pernyataan', $cid);
			$this->db->update('mbti_pernyataan',$update_mbti);
			return "Berhasil Mengubah Pernyataan";
		}else{
			return "Jenis Pernyataan Tidak Boleh Sama";
		}
	}

	function remove_pernyataan($cid){
		if($this->db->delete('mbti_pernyataan', array('id_pernyataan' => $cid))){
			return "Berhasil Menghapus Pernyataan";
		}else{
			return "Pernyataan Tidak Bisa Dihapus";
		}
	}

	function mbti_dataset(){
		$sql = "SELECT A.id_mbti_hasil as 'NO', D.username as 'NAMA', A.tipe_mbti as 'MBTI', C.nama_kelas as 'KELAS'
			from mbti_hasil A, mbti_kelas C, users D where A.id_mbti_kelas=C.id_mbti_kelas and A.id_user=D.id
			order by A.id_mbti_hasil desc";
		$query = $this->db->query($sql);
		if($query -> num_rows() >= 1){
			return $query->result();
		}else{
			return false;
		}
	}

	function get_kelas(){
		$query = $this->db->get('mbti_kelas');
		return $query->result();
	}

	function insert_dataset(){
		$mbti=str_split($this->input->post('mbti'));
		if($this->input->post('dikotomi')!=""){
			$introvert=($mbti[0]=='I')?$this->input->post('dikotomi1'):100-$this->input->post('dikotomi1');
			$extrovert=($mbti[0]=='E')?$this->input->post('dikotomi1'):100-$this->input->post('dikotomi1');
			$sensing=($mbti[1]=='S')?$this->input->post('dikotomi2'):100-$this->input->post('dikotomi2');
			$intuition=($mbti[1]=='N')?$this->input->post('dikotomi2'):100-$this->input->post('dikotomi2');
			$thinking=($mbti[2]=='T')?$this->input->post('dikotomi3'):100-$this->input->post('dikotomi3');
			$feeling=($mbti[2]=='F')?$this->input->post('dikotomi3'):100-$this->input->post('dikotomi3');
			$judging=($mbti[3]=='J')?$this->input->post('dikotomi4'):100-$this->input->post('dikotomi4');
			$perceiving=($mbti[3]=='P')?$this->input->post('dikotomi4'):100-$this->input->post('dikotomi4');
		}else{
			if($mbti[0]=='I'){$introvert=round((rand(8,15)/15)*100);$extrovert=100-$introvert;}
			if($mbti[0]=='E'){$extrovert=round((rand(8,15)/15)*100);$introvert=100-$extrovert;}
			if($mbti[1]=='S'){$sensing=round((rand(8,15)/15)*100);$intuition=100-$sensing;}
			if($mbti[1]=='N'){$intuition=round((rand(8,15)/15)*100);$sensing=100-$intuition;}
			if($mbti[2]=='T'){$thinking=round((rand(8,15)/15)*100);$feeling=100-$thinking;}
			if($mbti[2]=='F'){$feeling=round((rand(8,15)/15)*100);$thinking=100-$feeling;}
			if($mbti[3]=='J'){$judging=round((rand(8,15)/15)*100);$perceiving=100-$judging;}
			if($mbti[3]=='P'){$perceiving=round((rand(8,15)/15)*100);$judging=100-$perceiving;}
		}
		$data = array(
			"tipe_mbti" => $this->input->post('mbti'),
			"id_user" => $this->session->userdata('logged_in')['id'],
			"id_mbti_kelas" => $this->input->post('kelas'),
			"Extrovert" => $extrovert,"Introvert" => $introvert,"Sensing" => $sensing,"Intuition" => $intuition,
			"Thinking" => $thinking,"Feeling" => $feeling,"Judging" => $judging,"Perceiving" => $perceiving
		);
		$this->db->insert('mbti_hasil',$data);
		return "Berhasil Menambah Dataset";
	}

	function get_dataset($cid){
		$cari="select tipe_mbti from mbti_hasil where id_mbti_hasil =".$this->db->escape($cid);
		$query1 = $this->db->query($cari);$s=$query1->row_object();
		$mbti=str_split($s->tipe_mbti);
		$dikotomi1=($mbti[0]=='I')?'Introvert':'Extrovert';
		$dikotomi2=($mbti[1]=='S')?'Sensing':'Intuition';
		$dikotomi3=($mbti[2]=='T')?'Thinking':'Feeling';
		$dikotomi4=($mbti[3]=='J')?'Judging':'Perceiving';
		$sql="SELECT tipe_mbti, ".$dikotomi1." as 'dikotomi1', ".$dikotomi2." as 'dikotomi2',
			".$dikotomi3." as 'dikotomi3', ".$dikotomi4." as 'dikotomi4', id_mbti_kelas
			from mbti_hasil where id_mbti_hasil =".$this->db->escape($cid);
		$query = $this->db->query($sql);
		return $query->row_object();
	}

	function update_dataset($id){
		$mbti=str_split($this->input->post('mbti'));
		$introvert=($mbti[0]=='I')?$this->input->post('dikotomi1'):100-$this->input->post('dikotomi1');
		$extrovert=($mbti[0]=='E')?$this->input->post('dikotomi1'):100-$this->input->post('dikotomi1');
		$sensing=($mbti[1]=='S')?$this->input->post('dikotomi2'):100-$this->input->post('dikotomi2');
		$intuition=($mbti[1]=='N')?$this->input->post('dikotomi2'):100-$this->input->post('dikotomi2');
		$thinking=($mbti[2]=='T')?$this->input->post('dikotomi3'):100-$this->input->post('dikotomi3');
		$feeling=($mbti[2]=='F')?$this->input->post('dikotomi3'):100-$this->input->post('dikotomi3');
		$judging=($mbti[3]=='J')?$this->input->post('dikotomi4'):100-$this->input->post('dikotomi4');
		$perceiving=($mbti[3]=='P')?$this->input->post('dikotomi4'):100-$this->input->post('dikotomi4');
		$data = array(
			"tipe_mbti" => $this->input->post('mbti'),
			"id_user" => $this->session->userdata('logged_in')['id'],
			"id_mbti_kelas" => $this->input->post('kelas'),
			"Extrovert" => $extrovert,"Introvert" => $introvert,"Sensing" => $sensing,"Intuition" => $intuition,
			"Thinking" => $thinking,"Feeling" => $feeling,"Judging" => $judging,"Perceiving" => $perceiving
		);
		$this->db->where('id_mbti_hasil', $id);
		$this->db->update('mbti_hasil',$data);
		return "Berhasil Mengubah Dataset";
	}

	function remove_dataset($cid){
		if($this->db->delete('mbti_hasil', array('id_mbti_hasil' => $cid))){
			return "Berhasil Menghapus Dataset";
		}else{
			return "Dataset Tidak Bisa Dihapus";
		}
	}

	function mbti_kelas(){
		$query = $this -> db -> get('mbti_kelas');
		if($query -> num_rows() >= 1){
			return $query->result();
		}else{
			return false;
		}
	}

	function insert_kelas(){
		$data['nama_kelas'] = $this->input->post('nama');
		if($this->db->insert('mbti_kelas',$data)){
			return "MBTI Kelas successfully added";
		}else{
			return "Failed to add MBTI Kelas";
		}
	}

	function get_mbti_kelas($cid){
		$query = $this->db->get_where('mbti_kelas',array('id_mbti_kelas' => $cid));
		return $query->row_array();
	}

	function update_kelas($cid){
		$data['nama_kelas'] = $this->input->post('nama');
		$this->db->where('id_mbti_kelas', $cid);
		if($this->db->update('mbti_kelas',$data)){
			return "MBTI Kelas successfully updated";
		}else{
			return "Failed to update MBTI Kelas";
		}
	}

	function remove_kelas($cid){
		if($this->db->delete('mbti_kelas',array('id_mbti_kelas' => $cid))){
			return "MBTI Kelas successfully removed";
		}else{
			return "Failed to remove MBTI Kelas";
		}
	}
}
?>
