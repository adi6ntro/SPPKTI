<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->model('login_model');
		$this->load->library('form_validation');
		if($this->session->userdata('logged_in')){
			redirect('dashboard');
		}
	}

	public function index()
	{
		$data['title']="Login";
		$this->load->view('header',$data);
		$this->load->view('login/view',$data);
		$this->load->view('footer',$data);
	}

	function verify(){
		$this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|callback_check_database');
		if($this->form_validation->run() == FALSE){
			$this->index();
		}else{
			redirect('dashboard', 'refresh');
		}
	}

	function check_database($password){
		$username = $this->input->post('username');
		$result = $this->login_model->login($username, md5($password));
		if($result){
			foreach($result as $row){
				$sess_array = array(
					'id' => $row->id,
					'username' => $row->username,
					'email' => $row->email,
					'gid'=> $row->gid,
					'su'=> $row->su
				);
				$this->session->set_userdata('logged_in', $sess_array);
			}
			return true;
		}else{
			$this->form_validation->set_message('check_database', 'Invalid username and password or email address not verified');
			return false;
		}
	}

	function register(){
		$this->load->model('group_model','',TRUE);
		$data['allgroups'] = $this->group_model->get_allgroups('user');
		$data['title']="Daftar Akun";
		$this->load->view('header',$data);
		$this->load->view('login/register',$data);
		$this->load->view('footer',$data);
	}

	public function uname(){
		$uname=array('username' => $this->input->post('username'));
		$queryr = $this->db->get_where('users', $uname);
		if($queryr->num_rows() > 0){
			echo 'false';
		}else {
			echo 'true';
		}
	}

	public function umail(){
		$umail=array('email' => $this->input->post('email'));
		$queryr = $this->db->get_where('users', $umail);
		if($queryr->num_rows() > 0){
			echo 'false';
		}else {
			echo 'true';
		}
	}

	function register_user(){
		if(!$this->config->item('user_reg')){
			exit('Permission denied');
			return;
		}
		$this->form_validation->set_rules('username', 'Username', 'required|min_length[4]|is_unique[users.username]');
		$this->form_validation->set_rules('user_password', 'Password', 'required|matches[confirm_password]');
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required');
		$this->form_validation->set_rules('first_name', 'First Name', 'required');
		$this->form_validation->set_rules('last_name', 'Last Name', 'required');
		$this->form_validation->set_rules('user_email', 'Email', 'required|valid_email|is_unique[users.email]');
		if ($this->form_validation->run() == FALSE){
			$this->session->set_flashdata('result_error', validation_errors());
			redirect('login/register');
		}else{
			$rr = $this->login_model->register_user();
			$this->session->set_flashdata('result', $rr);
			redirect('login');
		}
	}

	function forgot(){
		if($this->input->post('user_email')){
			$user_email=$this->input->post('user_email');
			$result=$this->login_model->reset_password($user_email);
			if($result == '0'){
				$result_error="Email address doesn't exist!";
				$this->session->set_flashdata('result_error', $result_error);
				redirect('login/forgot');
			}else{
				$this->session->set_flashdata('result', $result);
				redirect('login/forgot');
			}
		}
		$data['title']="Reset Password";
		$this->load->view('header',$data);
		$this->load->view('login/reset_password',$data);
		$this->load->view('footer',$data);
	}

	function kirim_email_mbti(){
		if($this->input->post('user_email')){
			$user_email=$this->input->post('user_email');
			$nama=$this->input->post('nama');
			$mbti=$this->input->post('mbti');
			$result=$this->login_model->kirim_email_mbti($user_email,$nama,$mbti);
			if($result == '0'){
				$result_error="Email address doesn't exist!";
				$this->session->set_flashdata('result_error', $result_error);
				redirect('login/kirim_email_mbti');
			}else{
				$this->session->set_flashdata('result', $result);
				redirect('login/kirim_email_mbti');
			}
		}
		$data['title']="Reset Password";
		$this->load->view('header',$data);
		$this->load->view('email_mbti',$data);
		$this->load->view('footer',$data);
	}
}
