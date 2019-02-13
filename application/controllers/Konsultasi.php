<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Konsultasi extends CI_Controller {
	var $username;
	var $su;
	var $user;

	function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('konsultasi_model','',TRUE);
		$this->load->model('mbti_model','',TRUE);
		$this->load->model('skkni_model','',TRUE);
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
			'title' => "Konsultasi"
		);
		$this->load->view('header',$data);
		$this->load->view('konsultasi/view',$data);
		$this->load->view('footer',$data);
	}

	function mbti(){
		$data = array(
			'username' => $this->username,
			'user' => $this->user,
			'title' => "MBTI - Tes Tipe Kepribadian",
			'mbti' => $this->mbti_model->pernyataan('aktif')
		);
		$cek = $this->konsultasi_model->cek($this->user['id']);
		if($cek==true){
			$this->session->set_flashdata('result', 'Konsultasi <strong>MBTI - Tes Tipe Kepribadian</strong> hanya dapat diakses sekali!');
			$this->session->set_flashdata('type', 'error');
			redirect('konsultasi');
		}else{
			$this->load->view('header',$data);
			$this->load->view('konsultasi/mbti',$data);
			$this->load->view('footer',$data);
		}
	}

	function kompetensi(){
		$data = array(
			'username' => $this->username,
			'user' => $this->user,
			'title' => "SKKNI - Tes Kompetensi",
			'skkni' => $this->skkni_model->unit_list('konsultasi')
		);
		$cek = $this->konsultasi_model->cek($this->user['id']);
		if($cek==false){
			$this->session->set_flashdata('result', 'Selesaikan Konsultasi <strong>MBTI - Tes Tipe Kepribadian</strong> dahulu untuk dapat mengakses SKKNI - Tes Kompetensi!');
			$this->session->set_flashdata('type', 'error');
			redirect('konsultasi');
		}else{
			$cek = $this->konsultasi_model->cek_kompetensi($this->user['id']);
			if($cek==false){
				$this->session->set_flashdata('result', 'Selesaikan <strong>Ujian Similasi</strong> dahulu untuk dapat mengakses SKKNI - Tes Kompetensi!');
				$this->session->set_flashdata('type', 'error');
				redirect('konsultasi');
			}else{
				$this->load->view('header',$data);
				$this->load->view('konsultasi/skkni',$data);
				$this->load->view('footer',$data);
			}
		}
	}

	function execute($exe='',$id=''){
		if($exe=='mbti'){
			$mbti = $this->mbti_model->mbti_list();
			$result = $this->konsultasi_model->insert_mbti($mbti);
			$url='konsultasi';
		}else if($exe=='skkni'){
			$result = $this->konsultasi_model->insert_skkni();
			$url='konsultasi';
		}else{
			$url='konsultasi';
		}
		$this->session->set_flashdata('result', $result['result']);
		$this->session->set_flashdata('type', $result['type']);
		redirect($url);
	}

	function tes()
	{
		$gej = $this->db->select('A.id_unit')->from('skkni_unit A')
			->join('relasi B', 'A.id_unit = B.id_unit AND B.id_skema = "SK01"')->get();
		$atribut = $gej->result_array();
		$geja = $this->db->get('skkni_unit');
		$all = $geja->result_array();
		$nilai=array();
		$unit=array();
		$unit1=array();
 		$result = array();
		foreach ($atribut as $value) {
			$unit[]=$value['id_unit'];
		}
		foreach ($all as $value) {
			$unit1[]=$value['id_unit'];
		}
		foreach ($unit1 as $value) {
			if(in_array($value,$unit)){$nilai[]=(rand(80,100));}else{$nilai[]=(rand(0,50));}
		}
		foreach($all AS $key => $val){
			$result[] = array(
				"id_hasil" => 'SK01',
				"id_unit"  => $val['id_unit'],
				"nilai"  => $nilai[$key]
			);
		}
	}
}
