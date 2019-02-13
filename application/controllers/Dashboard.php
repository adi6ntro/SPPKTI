<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	var $username;
	var $su;
	var $user;

	function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata('logged_in')){
			redirect('login', 'refresh');
		}else{
			$this->load->model('home_model','',TRUE);
			$session_data = $this->session->userdata('logged_in');
			$this->username = $session_data['username'];
			$user_id=$session_data['id'];
			$this->su=$session_data['su'];
			$this->user = $this->users_model->get_user($user_id,$this->su);
		}
	}

	public function index()
	{
		$data = array(
			'username' => $this->username,
			'user' => $this->user,
			'title' => 'Dashboard'
		);
		if($this->su=="0"){
			$view = 'view';
			$data['mbti'] = $this->home_model->cek('mbti',$this->user['id']);
			$data['skkni'] = $this->home_model->cek('skkni',$this->user['id']);
		}else{
			$view = 'view_admin';
			$data['mbti'] = $this->home_model->grafik('mbti');
			$data['skkni'] = $this->home_model->grafik('skkni');
			$data['num_users'] = $this->home_model->num_of('users');
			$data['num_skkni'] = $this->home_model->num_of('skkni');
			$data['num_mbti'] = $this->home_model->num_of('mbti');
			$data['num_qbank'] = $this->home_model->num_of('qbank');
		}
		$this->load->view('header',$data);
		$this->load->view('dashboard/'.$view, $data);
		$this->load->view('footer',$data);
	}

	function logout(){
		$this->load->helper('cookie');
		$this->session->unset_userdata('logged_in');
		$this->session->sess_destroy();
		delete_cookie("rid");
		redirect('login', 'refresh');
	}
}
