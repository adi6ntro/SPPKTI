<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Group extends CI_Controller {
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
		if($this->su!="1"){
			exit('Permission denied');
			return;
		}
		$data = array(
			'username' => $this->username,
			'user' => $this->user,
			'result' => $this->group_model->group_list($this->user['gid']),
			'title' => "Group"
		);
		$this->load->view('header',$data);
		$this->load->view('group/view',$data);
		$this->load->view('footer',$data);
	}

	function form($act='',$id=''){
		if($this->su!="1"){
			exit('Permission denied');
			return;
		}
		$data = array(
			'username' => $this->username,
			'user' => $this->user
		);
		if($act=='add'){
			$data['title'] = "Add Group";
			$data['exe'] = "save";
			$data['id'] = '';
		}else if($act=='edit'){
			$data['title'] = "Edit Group";
			$data['exe'] = "update";
			$data['id'] = $id;
			$data['group'] = $this->group_model->get_group($id);
		}
		$this->load->view('header',$data);
		$this->load->view('group/add',$data);
		$this->load->view('footer',$data);
	}

	function execute($exe='',$id=''){
		if($this->su!="1"){
			exit('Permission denied');
			return;
		}
		if($exe=='save'){
			$result = $this->group_model->insert_group();
			$url='group/form/add';
		}else if($exe=='update'){
			$result = $this->group_model->update_group($id);
			$url='group/form/edit/'.$id;
		}else{
			$this->group_model->remove_group($id);
			$url='group';
		}
		$this->session->set_flashdata('result', $result);
		redirect($url);
	}
}
