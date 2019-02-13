<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {
	var $username;
	var $su;
	var $user;

	function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('group_model','',TRUE);
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

	public function index()
	{
		$data = array(
			'username' => $this->username,
			'user' => $this->user,
			'result' => $this->users_model->user_list(),
			'title' => 'Users'
		);
		$this->load->view('header',$data);
		$this->load->view('user/view', $data);
		$this->load->view('footer',$data);
	}

	public function uname($id=0){
		if($id!=0){$a='id !=';$b=$this->session->userdata('logged_in')['id'];}
		else{$a='username';$b=$this->input->post('username');}
		$uname=array('username' => $this->input->post('username'),$a => $b);
		$queryr = $this->db->get_where('users', $uname);
		if($queryr->num_rows() > 0){
			if($this->username==$this->input->post('username')) echo 'true';
			else echo 'false';
		}else {
			echo 'true';
		}
	}

	public function umail($id=0){
		if($id!=0){$a='id !=';$b=$this->session->userdata('logged_in')['id'];}
		else{$a='email';$b=$this->input->post('email');}
		$umail=array('email' => $this->input->post('email'));
		$queryr = $this->db->get_where('users', $umail);
		if($queryr->num_rows() > 0){
			if($this->session->userdata('logged_in')['email']==$this->input->post('email')) echo 'true';
			else echo 'false';
		}else {
			echo 'true';
		}
	}

	function form($act='',$id=''){
		$data = array(
			'username' => $this->username,
			'user' => $this->user,
			'allgroups' => $this->group_model->get_allgroups($this->user['gid'])
		);
		if($act=='add'){
			if($this->su!="1"){
				exit('Permission denied');
				return;
			}
			$data['title'] = "Add User";
			$data['exe'] = "save";
			$data['id'] = '';
		}else if($act=='edit'){
			if($this->su!="1"){
				exit('Permission denied');
				return;
			}
			$data['title'] = "Edit User";
			$data['exe'] = "update";
			$data['id'] = $id;
			$data['myuser'] = $this->users_model->get_user($id,$this->su);
		}else if($act=='profile'){
			$data['title'] = "Profile";
			$data['exe'] = "profile";
			$data['id'] = $this->session->userdata('logged_in')['id'];
			$data['myuser'] = $this->user;
		}
		$this->load->view('header',$data);
		$this->load->view('user/add',$data);
		$this->load->view('footer',$data);
	}

	function execute($exe='',$id=''){
		if(!$this->session->userdata('logged_in')){
			exit('Permission denied');
			return;
		}
		if($exe=='save'){
			$result = $this->users_model->insert_user();
			$url = 'users/form/add';
		}else if($exe=='update'){
			$result = $this->users_model->update_user($id);
			$url='users/form/edit/'.$id;
		}else if($exe=='profile'){
			$result = $this->users_model->update_user($id);
			$url='users/form/profile';
		}else{
			$this->users_model->remove_user($id);
			$url='users';
		}
		$this->session->set_flashdata('result', $result);
		redirect($url);
	}

	function login_user_by_admin($id){
		if($this->su!="1"){
			exit('Permission denied');
			return;
		}
		$result = $this->users_model->login_user_by_admin($id);
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
		redirect('dashboard');
	}
}
