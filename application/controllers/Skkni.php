<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Skkni extends CI_Controller {
	var $username;
	var $su;
	var $user;

	function __construct()
	{
		parent::__construct();
		$this->load->model('skkni_model','',TRUE);
		$this->load->library('form_validation');
		if(!$this->session->userdata('logged_in')){
			redirect('login', 'refresh');
		}else{
			$session_data = $this->session->userdata('logged_in');
			$this->username = $session_data['username'];
			$user_id=$session_data['id'];
			$this->su=$session_data['su'];
			$this->user = $this->users_model->get_user($user_id,$this->su);
		}
	}

	function unit($act='',$id=''){
		if($this->su!="1" && $this->su!="2"){
			exit('Permission denied');
			return;
		}
		$data = array(
			'username' => $this->username,
			'user' => $this->user
		);
		if($act=='add'){
			$data['title'] = "Add Unit";
			$data['exe'] = "save";
			$data['id'] = '';
			$view = 'add';
		}else if($act=='edit'){
			$data['title'] = "Edit Unit";
			$data['exe'] = "update";
			$data['id'] = $id;
			$data['skkni'] = $this->skkni_model->get_unit($id);
			$view = 'add';
		}else{
			$data['title'] = "Unit Kompetensi SKKNI";
			$data['result'] = $this->skkni_model->unit_list();
			$view = 'view';
		}
		$this->load->view('header',$data);
		$this->load->view('skkni/'.$view,$data);
		$this->load->view('footer',$data);
	}

	function skema($act='',$id=''){
		if($this->su!="1" && $this->su!="2"){
			exit('Permission denied');
			return;
		}
		$data = array(
			'username' => $this->username,
			'user' => $this->user
		);
		if($act=='add'){
			$data['title'] = "Add Skema";
			$data['exe'] = "save";
			$data['id'] = '';
			$view = 'skema_add';
		}else if($act=='edit'){
			$data['title'] = "Edit Skema";
			$data['exe'] = "update";
			$data['id'] = $id;
			$data['skkni'] = $this->skkni_model->get_skema($id);
			$view = 'skema_add';
		}else{
			$data['title'] = "Skema Kompetensi SKKNI";
			$data['result'] = $this->skkni_model->skema_list();
			$view = 'skema_view';
		}
		$this->load->view('header',$data);
		$this->load->view('skkni/'.$view,$data);
		$this->load->view('footer',$data);
	}

	function dataset($act='',$id=''){
		if($this->su!="1" && $this->su!="2"){
			exit('Permission denied');
			return;
		}
		$data = array(
			'username' => $this->username,
			'user' => $this->user
		);
		$this->load->model('mbti_model','',TRUE);
		if($act=='add'){
			$data['title'] = "Add Dataset";
			$data['exe'] = "save";
			$data['id'] = '';
			$data['skema'] = $this->skkni_model->skema_list();
			$data['mbti'] = $this->mbti_model->mbti_dataset();
			$data['unit'] = $this->skkni_model->unit_list();
			$view = 'dataset_add';
		}else if($act=='edit'){
			$data['title'] = "Edit Dataset";
			$data['exe'] = "update";
			$data['id'] = $id;
			$data['skema'] = $this->skkni_model->skema_list();
			$data['mbti'] = $this->mbti_model->mbti_dataset();
			$data['hasil'] = $this->skkni_model->get_hasil($id);
			$data['dataset'] = $this->skkni_model->get_dataset($id);
			$data['unit'] = $this->skkni_model->unit_list();
			$view = 'dataset_add';
		}else{
			$data['title'] = "Dataset Kompetensi SKKNI";
			$data['result'] = $this->skkni_model->dataset_list();
			$view = 'dataset_view';
		}
		$this->load->view('header',$data);
		$this->load->view('skkni/'.$view,$data);
		$this->load->view('footer',$data);
	}

	function execute($type='',$exe='',$id=''){
		if($this->su!="1" && $this->su!="2"){
			exit('Permission denied');
			return;
		}
		if($type=='unit'){
			if($exe=='save'){
				$result = $this->skkni_model->insert_unit();
				$url='skkni/unit';
			}elseif($exe=='update'){
				$result = $this->skkni_model->update_unit($id);
				$url='skkni/unit';
			}else{
				$result = $this->skkni_model->remove_unit($id);
				$url='skkni/unit';
			}
		}elseif($type=='skema'){
			if($exe=='save'){
				$acak=rand(00000000000,99999999999);
				$bersih=$_FILES['userfile']['name'];
				$ext = pathinfo($bersih)['extension'];
				$foto = $acak.'.'.$ext;
				$config["file_name"]=$acak;
				$config['upload_path'] = './assets/img/skema';
				$config['allowed_types'] = 'gif|jpg|png';
				$config['max_size']	= '9000';
				$config['max_width']  = '1024';
				$config['max_height']  = '768';
				$this->load->library('upload', $config);
				if (!$this->upload->do_upload('userfile')){
					$result = $this->upload->display_errors();
				}else{
					$result = $this->skkni_model->insert_skema($foto);
				}
				$url='skkni/skema';
			}elseif($exe=='update'){
				if($_FILES['userfile']['name']!= ''){
					$acak=rand(00000000000,99999999999);
					$bersih=$_FILES['userfile']['name'];
					$ext = pathinfo($bersih)['extension'];
					$foto = $acak.'.'.$ext;
					$config["file_name"]=$acak;
					$config['upload_path'] = './assets/img/skema';
					$config['allowed_types'] = 'gif|jpg|png';
					$config['max_size']	= '9000';
					$config['max_width']  = '1024';
					$config['max_height']  = '768';
					$this->load->library('upload', $config);
					if ( ! $this->upload->do_upload('userfile')){
						$result = $this->upload->display_errors();
					}else{
						$result = $this->skkni_model->update_skema($id,$foto);
					}
				}else{
					$result = $this->skkni_model->update_skema($id);
				}
				$url='skkni/skema';
			}else{
				$result = $this->skkni_model->remove_skema($id);
				$url='skkni/skema';
			}
		}elseif($type=='dataset'){
			if($exe=='save'){
				$result = $this->skkni_model->insert_dataset();
				$url='skkni/dataset/add';
			}elseif($exe=='update'){
				$result = $this->skkni_model->update_dataset($id);
				$url='skkni/dataset';
			}else{
				$result = $this->skkni_model->remove_dataset($id);
				$url='skkni/dataset';
			}
		}
		$this->session->set_flashdata('result', $result);
		redirect($url);
	}
	function tes(){
		$query = $this->db->get('skkni_dataset');
		$res = $query->result_array();
		foreach ($res as $key) {
			if($key['nilai']<=100 && $key['nilai']>84) $update=5;
			elseif($key['nilai']<=84 && $key['nilai']>70) $update=4;
			elseif($key['nilai']<=70 && $key['nilai']>59) $update=3;
			elseif($key['nilai']<=59 && $key['nilai']>45) $update=2;
			else $update=1;
			$this->db->where('id_dataset', $key['id_dataset']);
			if($this->db->update('skkni_dataset',array('nilai'=>$update))){
				echo "oke<br>";
			}else{
				echo "salah<br>";
			}
		}
	}
}
