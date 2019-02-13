<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mbti extends CI_Controller {
	var $username;
	var $su;
	var $user;

	function __construct()
	{
		parent::__construct();
		$this->load->model('mbti_model','',TRUE);
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

	function tipe($act='',$id=''){
		if($this->su!="1" && $this->su!="3"){
			exit('Permission denied');
			return;
		}
		$data = array(
			'username' => $this->username,
			'user' => $this->user
		);
		if($act=='add'){
			$data['title'] = "Add Type";
			$data['exe'] = "save";
			$data['id'] = '';
			$view = 'add';
		}else if($act=='edit'){
			$data['title'] = "Edit Type";
			$data['exe'] = "update";
			$data['id'] = $id;
			$data['mbti'] = $this->mbti_model->get_mbti($id);
			$view = 'add';
		}else{
			$data['title'] = "Myers-Briggs Type Indicator";
			$data['result'] = $this->mbti_model->mbti_list();
			$view = 'view';
		}
		$this->load->view('header',$data);
		$this->load->view('mbti/'.$view,$data);
		$this->load->view('footer',$data);
	}

	function pernyataan($act='',$id=''){
		if($this->su!="1" && $this->su!="3"){
			exit('Permission denied');
			return;
		}
		$data = array(
			'username' => $this->username,
			'user' => $this->user
		);
		if($act=='add'){
			$data['title'] = "Add Pernyataan";
			$data['exe'] = "save";
			$data['id'] = '';
			$view = 'pernyataan_add';
		}else if($act=='edit'){
			$data['title'] = "Edit Pernyataan";
			$data['exe'] = "update";
			$data['id'] = $id;
			$data['mbti'] = $this->mbti_model->get_pernyataan($id);
			$view = 'pernyataan_add';
		}else{
			$data['title'] = "Pernyataan Myers-Briggs Type Indicator";
			$data['result'] = $this->mbti_model->pernyataan();
			$view = 'pernyataan_view';
		}
		$this->load->view('header',$data);
		$this->load->view('mbti/'.$view,$data);
		$this->load->view('footer',$data);
	}

	function dikotomi(){
    $dikotomi = $this->input->get('id');
		if($dikotomi == "1"){
      echo "<option value='Extrovert'>Extrovert</option>";
			echo "<option value='Introvert'>Introvert</option>";
    }elseif($dikotomi == "2"){
      echo "<option value='Sensing'>Sensing</option>";
			echo "<option value='Intuition'>Intuition</option>";
    }elseif($dikotomi == "3"){
      echo "<option value='Thinking'>Thinking</option>";
			echo "<option value='Feeling'>Feeling</option>";
    }elseif($dikotomi == "4"){
      echo "<option value='Judging'>Judging</option>";
			echo "<option value='Perceiving'>Perceiving</option>";
    }
  }

	function kelas($act='',$id=''){
		if($this->su!="1" && $this->su!="3"){
			exit('Permission denied');
			return;
		}
		$data = array(
			'username' => $this->username,
			'user' => $this->user
		);
		if($act=='add'){
			$data['title'] = "Add Kelas";
			$data['exe'] = "save";
			$data['id'] = '';
			$view = 'kelas_add';
		}else if($act=='edit'){
			$data['title'] = "Edit Kelas";
			$data['exe'] = "update";
			$data['id'] = $id;
			$data['mbti'] = $this->mbti_model->get_mbti_kelas($id);
			$view = 'kelas_add';
		}else{
			$data['title'] = "Kelas Myers-Briggs Type Indicator";
			$data['result'] = $this->mbti_model->mbti_kelas();
			$view = 'kelas_view';
		}
		$this->load->view('header',$data);
		$this->load->view('mbti/'.$view,$data);
		$this->load->view('footer',$data);
	}

	function dataset($act='',$id=''){
		if($this->su!="1" && $this->su!="3"){
			exit('Permission denied');
			return;
		}
		$data = array(
			'username' => $this->username,
			'user' => $this->user
		);
		if($act=='add'){
			$data['title'] = "Add Dataset MBTI";
			$data['exe'] = "save";
			$data['id'] = '';
			$data['mbti'] = $this->mbti_model->mbti_list();
			$data['kelas'] = $this->mbti_model->get_kelas();
			$view = 'dataset_add';
		}else if($act=='edit'){
			$data['title'] = "Edit Dataset MBTI";
			$data['exe'] = "update";
			$data['id'] = $id;
			$data['mbti'] = $this->mbti_model->get_mbti();
			$data['kelas'] = $this->mbti_model->get_kelas();
			$data['hasil'] = $this->mbti_model->get_dataset($id);
			$view = 'dataset_add';
		}else{
			$data['title'] = "Dataset Myers-Briggs Type Indicator";
			$data['result'] = $this->mbti_model->mbti_dataset();
			$view = 'dataset_view';
		}
		$this->load->view('header',$data);
		$this->load->view('mbti/'.$view,$data);
		$this->load->view('footer',$data);
	}

	function execute($type='',$exe='',$id=''){
		if($this->su!="1" && $this->su!="3"){
			exit('Permission denied');
			return;
		}
		if($type=='tipe'){
			if($exe=='save'){
				$config['upload_path'] = './assets/img/mbti';
				$config['allowed_types'] = 'gif|jpg|png';
				$config['max_size']	= '9000';
				$config['max_width']  = '1024';
				$config['max_height']  = '768';
				$this->load->library('upload', $config);
				if (!$this->upload->do_upload('userfile')){
					$result = $this->upload->display_errors();
				}else{
					$result = $this->mbti_model->insert_mbti();
				}
				$url='mbti/tipe';
			}elseif($exe=='update'){
				if($_FILES['userfile']['name']!= ''){
					$config['upload_path'] = './assets/img/mbti';
					$config['allowed_types'] = 'gif|jpg|png';
					$config['max_size']	= '9000';
					$config['max_width']  = '1024';
					$config['max_height']  = '768';
					$this->load->library('upload', $config);
					if ( ! $this->upload->do_upload('userfile')){
						$result = $this->upload->display_errors();
					}else{
						$result = $this->mbti_model->update_mbti($id);
					}
				}else{
					$result = $this->mbti_model->update_mbti($id);
				}
				$url='mbti/tipe';
			}else{
				$result = $this->mbti_model->remove_mbti($id);
				$url='mbti/tipe';
			}
		}elseif($type=='pernyataan'){
			if($exe=='save'){
				$result = $this->mbti_model->insert_pernyataan();
				$url='mbti/pernyataan/add';
			}elseif($exe=='update'){
				$result = $this->mbti_model->update_pernyataan($id);
				$url='mbti/pernyataan/edit/'.$id;
			}else{
				$result = $this->mbti_model->remove_pernyataan($id);
				$url='mbti/pernyataan';
			}
		}elseif($type=='dataset'){
			if($exe=='save'){
				$result = $this->mbti_model->insert_dataset();
				$url='mbti/dataset/add';
			}elseif($exe=='update'){
				$result = $this->mbti_model->update_dataset($id);
				$url='mbti/dataset/edit/'.$id;
			}else{
				$result = $this->mbti_model->remove_dataset($id);
				$url='mbti/dataset';
			}
		}elseif($type=='kelas'){
			if($exe=='save'){
				$result = $this->mbti_model->insert_kelas();
				$url='mbti/kelas/add';
			}elseif($exe=='update'){
				$result = $this->mbti_model->update_kelas($id);
				$url='mbti/kelas/edit/'.$id;
			}else{
				$result = $this->mbti_model->remove_kelas($id);
				$url='mbti/kelas';
			}
		}
		$this->session->set_flashdata('result', $result);
		redirect($url);
	}
}
