<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rule extends CI_Controller {
	var $username;
	var $su;
	var $user;

	function __construct()
	{
		parent::__construct();
		$this->load->model('rule_model','',TRUE);
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
		if($this->su!="1" && $this->su!="2"){
			exit('Permission denied');
			return;
		}
		$this->load->model('skkni_model','',TRUE);
		$data = array(
			'username' => $this->username,
			'user' => $this->user,
			'title' => 'Rule Pengetahuan',
			'result' => $this->skkni_model->skema_list()
		);
		$this->load->view('header',$data);
		$this->load->view('rule/view', $data);
		$this->load->view('footer',$data);
	}

	function get_table($id='') {
		if (trim($id) != '0') {
			echo '<div class="left col-md-6">Kompetensi yang terikat:
				<ul class="target connected">';
          echo $this->rule_model->get_atribut_linked($id);
        echo '</ul>
			</div>
      <div class="right  col-md-6">Kompetensi yang tidak terikat :
				<ul class="source connected">';
          echo $this->rule_model->get_atribut_not_linked($id);
        echo '</ul>
      </div>';
		}
	}

	function update_relasi($id = '') {
		if (trim($id) != '0' && isset($_POST['data'])) {
			$s = json_decode($_REQUEST['data']);
			$data = array();
			foreach ($s as $value) {
				$data[] = $value;
			}
			$delete = $this->db->where('id_skema', $id)->where_not_in('id_unit', $data)->delete('relasi');
			$gej = $this->db->select('id_unit')
				->where('id_skema', $id)
				->get('relasi');
			$gej = $gej->result();
			$unit = array();
			foreach ($gej as $value) {
				$unit[] = $value->id_unit;
			}
			$new = array();
			foreach ($data as $value) {
				if (!in_array($value, $unit)) {
					$new[] = "( '$id', '$value' )";
				}
			}
			$insert = $this->db->query("INSERT INTO relasi (id_skema, id_unit) VALUES ". implode(", ", $new));
			#print_r($data);
		}
	}
}
