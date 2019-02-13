<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reset_password extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->model('login_model');
		$this->load->library('form_validation');
	}

	public function index()
	{
		redirect('login/forgot');
	}

	function token($token){
		$user_info = $this->login_model->isTokenValid($token); //either false or array();
		if(!$user_info){
			$this->session->set_flashdata('result_error', 'Link URL tidak valid atau kadaluarsa');
			redirect(site_url('login/forgot'),'refresh');
		}
		$data['token'] = $token;
		$this->form_validation->set_rules('user_password', 'Password', 'required');
		$this->form_validation->set_rules('confirm_password', 'Password Confirmation', 'required|matches[user_password]');
		if ($this->form_validation->run() == FALSE) {
			$data['title']="Reset Password";
			$this->load->view('header',$data);
			$this->load->view('login/update_password',$data);
			$this->load->view('footer',$data);
		}else{
			$cleanPost = $user_info->id;
			if(!$this->login_model->updatePassword($cleanPost)){
				$this->session->set_flashdata('result_error', 'Update password gagal.');
			}else{
				$this->session->set_flashdata('result', 'Password anda sudah diperbaharui. Silakan login.');
			}
			redirect('login','refresh');
		}
	}
}
