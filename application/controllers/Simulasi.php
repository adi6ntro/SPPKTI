<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Simulasi extends CI_Controller {
	var $username;
	var $su;
	var $user;

	function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('skkni_model','',TRUE);
		$this->load->model('simulasi_model','',TRUE);
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

	function index(){
		unset($_COOKIE['rid']);
		$id = $this->simulasi_model->cek($this->user['id']);
		if($id!=false){
			$this->load->helper('cookie');
			if($this->input->cookie('rid', TRUE)){
				redirect('simulasi/attempt', 'refresh');
			}
			$persenskema=explode(", ",$id['presentase_detil_max']);
			$id_skema=array();
			foreach ($persenskema as $key => $value) {
				$id_skema[$key]=explode(":",$value)[0];
			}
			$data = array(
				'username' => $this->username,
				'user' => $this->user,
				'result' => $this->simulasi_model->get_quiz2($id_skema),
				'title' => 'Simulasi'
			);
			$this->load->view('header',$data);
			$this->load->view('simulasi/attempt',$data);
			$this->load->view('footer',$data);
		}else{
			$this->session->set_flashdata('result', 'Selesaikan konsultasi <strong>SKKNI - Tes Kompetensi</strong> untuk mengakses simulasi!');
			redirect('konsultasi');
		}
	}

	function soal($act='',$id=''){
		if($this->su!="1"){
			exit('Permission denied');
			return;
		}
		$data = array(
			'username' => $this->username,
			'user' => $this->user
		);
		if($act=='add'){
			$data['unit'] = $this->skkni_model->unit_list();
			$data['title'] = "Add Soal";
			$data['exe'] = "save";
			$data['id'] = '';
			$view='add';
		}else if($act=='edit'){
			$data['result'] = $this->simulasi_model->get_soal($id);
			$data['unit'] = $this->skkni_model->unit_list();
			$data['title'] = "Edit Soal";
			$data['exe'] = "update";
			$data['id'] = $id;
			$view='add';
		}else{
			$data['result'] = $this->simulasi_model->question_list();
			$data['title'] = "Daftar Soal Simulasi";
			$view='view';
		}
		$this->load->view('header',$data);
		$this->load->view('simulasi/'.$view,$data);
		$this->load->view('footer',$data);
	}

	function select_questions($quid='0',$quiz_name='',$cid='0'){
		$data = array(
			'fcid' => $cid,
			'result' => $this->simulasi_model->question_list($cid),
			'title' => "Question Bank",
			'quid' => $quid,
			'quiz_name' => $quiz_name,
			'assigned_questions' => $this->simulasi_model->assigned_questions($quid)
		);
		$this->load->view('simulasi/select_questions',$data);
	}

	function move($act,$quid,$qid,$not='1'){
		for($i=1; $i <= $not; $i++){
			$this->simulasi_model->move($act,$quid,$qid);
		}
		redirect('simulasi/ujian/edit/'.$quid, 'refresh');
	}

	function ujian($act='',$id='',$qselect=''){
		if($this->su!="1"){
			exit('Permission denied');
			return;
		}
		$data = array(
			'username' => $this->username,
			'user' => $this->user
		);
		if($act=='add'){
			$data['title'] = "Add Ujian";
			$data['exe'] = "save";
			$data['id'] = '';
			$data['skema'] = $this->skkni_model->skema_list();
			$view='quiz_add';
		}else if($act=='edit'){
			$data['result'] = $this->simulasi_model->get_quiz($id);
			$data['skema'] = $this->skkni_model->skema_list();
			$data['assigned_questions'] = $this->simulasi_model->assigned_questions($id);
			$data['title'] = "Edit Ujian";
			$data['exe'] = "update";
			$data['id'] = $id;
			$data['qselect']=$qselect;
			$view='quiz_add';
		}else{
			$data['result'] = $this->simulasi_model->quiz_list();
			$data['title'] = "Daftar Ujian Simulasi";
			$view='quiz_view';
		}
		$this->load->view('header',$data);
		$this->load->view('simulasi/'.$view,$data);
		$this->load->view('footer',$data);
	}

	function attempt($id_skema){
		$data = array(
			'username' => $this->username,
			'user' => $this->user
		);
		$skema = $this->simulasi_model->cek($this->user['id']);
  	$this->load->helper('cookie');
		$status = $this->simulasi_model->verify($id_skema,$skema['id']);
 		$data['result'] = $this->simulasi_model->get_quiz($id_skema);
 		$data['title']=$data['result']['nama_skema'];
		if($status == "1"){
			if(!$this->input->cookie('rid', TRUE)){
				redirect('simulasi/attempt', 'refresh');
			}
			$rid=$this->input->cookie('rid', TRUE);
			$data['assigned_question']=$this->simulasi_model->get_access('question',$rid);
			$data['time_info']=$this->simulasi_model->get_access('time_info',$rid);
			$data['seconds']=(($data['result']['duration'])*60) - ($data['time_info']['time_spent']);
			$data['quiz_data']=$this->simulasi_model->get_quiz($id_skema);
			$this->load->view('header',$data);
			$this->load->view('simulasi/access',$data);
			$this->load->view('footer',$data);
		}else{
			delete_cookie('rid');
			$this->session->set_flashdata('result', $status);
			redirect('simulasi', 'refresh');
		}
	}

	function attempt_old(){
		$data = array(
			'username' => $this->username,
			'user' => $this->user
		);
		$skema = $this->simulasi_model->cek($this->user['id']);
  	$this->load->helper('cookie');
		#delete_cookie('rid');die();
		$status = $this->simulasi_model->verify($skema['id_skema'],$skema['id']);
 		$data['result'] = $this->simulasi_model->get_quiz($skema['id_skema']);
 		$data['title']=$data['result']['nama_skema'];
		if($status == "1"){
			if(!$this->input->cookie('rid', TRUE)){
				redirect('simulasi/attempt', 'refresh');
			}
			$rid=$this->input->cookie('rid', TRUE);
			$data['assigned_question']=$this->simulasi_model->get_access('question',$rid);
			$data['time_info']=$this->simulasi_model->get_access('time_info',$rid);
			$data['seconds']=(($data['result']['duration'])*60) - ($data['time_info']['time_spent']);
			$data['quiz_data']=$this->simulasi_model->get_quiz($skema['id_skema']);
			$this->load->view('header',$data);
			$this->load->view('simulasi/access',$data);
			$this->load->view('footer',$data);
		}else{
			delete_cookie('rid');
			$this->session->set_flashdata('result', $status);
			redirect('simulasi', 'refresh');
		}
	}

	function attempt_update($act,$id,$data){
		$this->simulasi_model->attempt_update($act,$id,$data);
	}

	function attempt_submit($id){
		$this->load->helper('cookie');
		$status=$this->simulasi_model->quiz_submit($id);
		$this->session->set_flashdata('result', $status);
		redirect('simulasi', 'refresh');
	}

	function execute($type='',$exe='',$id='',$q=''){
		if($this->su!="1"){
			exit('Permission denied');
			return;
		}
		if($type=='soal'){
			if($exe=='save'){
				$result = $this->simulasi_model->insert_soal();
				$url='simulasi/soal';
			}elseif($exe=='update'){
				$result = $this->simulasi_model->update_soal($id);
				$url='simulasi/soal';
			}elseif($exe=='delete'){
				$result = $this->simulasi_model->remove_soal($id);
				$url='simulasi/soal';
			}elseif($exe=='removeqids'){
				$result = $this->simulasi_model->remove_qids();
				$url='simulasi/soal';
			}
		}elseif($type=='ujian'){
			if($exe=='save'){
				$result = $this->simulasi_model->insert_quiz();
				$qselect=$this->input->post('qselect');
				$url='simulasi/ujian/edit/'.$result.'/'.$qselect;
			}elseif($exe=='update'){
				$result = $this->simulasi_model->update_quiz($id);
				$url='simulasi/ujian';
			}elseif($exe=='aktif'){
				$result = $this->simulasi_model->status_quiz($id);
				$url='simulasi/ujian';
			}else{
				$result = $this->simulasi_model->remove_quiz($id);
				$url='simulasi/ujian';
			}
		}elseif($type=='dataset'){
			if($exe=='save'){
				$result = $this->skkni_model->insert_dataset();
				$url='skkni/dataset';
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
}
