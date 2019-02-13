<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Overview extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->model('home_model','',TRUE);
		$this->load->model('skkni_model','',TRUE);
		$this->load->model('mbti_model','',TRUE);
	}

	public function index()
	{
		$data['skkni'] = $this->skkni_model->unit_list();
		$this->load->view('overview',$data);
	}

	public function hasil()
	{
		//$data['hasil'] = (!$this->input->post())?'Belum ada inputan data...':$this->home_model->hasil($this->input->post('unit'),$this->input->post('random'));
		$data['hasil'] = (!$this->input->post())?'Belum ada inputan data...':$this->home_model->hasilKBK($this->input->post('unit'),$this->input->post('nilai'));
		$this->load->view('overview',$data);
	}

	public function v2()
	{
		$data['mbti'] = $this->mbti_model->pernyataan('aktif'); // $this->mbti_model->mbti_list();
		$this->load->view('overview',$data);
	}

	public function hasilv2()
	{
		$mbti_list = $this->mbti_model->mbti_list();
		$n1=0;$n2=0;$n3=0;$n4=0;$E=0;$I=0;$S=0;$N=0;$T=0;$F=0;$J=0;$P=0;$mbti="";
		$no=$this->input->post('no');
		for ($i=1; $i <= $no; $i++) {
			if ($this->input->post('dikotomi'.$i)=="1"){if($this->input->post('score'.$i)=="Extrovert"){$E++;}else{$I++;}$n1++;}
			elseif($this->input->post('dikotomi'.$i)=="2"){if($this->input->post('score'.$i)=="Sensing"){$S++;}else{$N++;}$n2++;}
			elseif($this->input->post('dikotomi'.$i)=="3"){if($this->input->post('score'.$i)=="Thinking"){$T++;}else{$F++;}$n3++;}
			elseif($this->input->post('dikotomi'.$i)=="4"){if($this->input->post('score'.$i)=="Judging"){$J++;}else{$P++;}$n4++;}
		}
		$extrovert = round(($E/$n1)*100);$introvert = round(($I/$n1)*100);
		$sensing = round(($S/$n2)*100);$intuition = round(($N/$n2)*100);
		$thinking = round(($T/$n3)*100);$feeling = round(($F/$n3)*100);
		$judging = round(($J/$n4)*100);$perceiving = round(($P/$n4)*100);
		if($extrovert>$introvert){$mbti.="E";}else {$mbti.="I";}
		if($sensing>$intuition){$mbti.="S";}else {$mbti.="N";}
		if($thinking>$feeling){$mbti.="T";}else {$mbti.="F";}
		if($judging>$perceiving){$mbti.="J";}else {$mbti.="P";}
		foreach ($mbti_list as $nama_mbti) {if($nama_mbti->tipe_mbti==$mbti){$id_mbti=$nama_mbti->tipe_mbti;}}
		$data['hasilv2'] = (!$this->input->post())?'Belum ada inputan data...':$this->home_model->hasilv2($id_mbti);
		$this->load->view('overview',$data);
	}
}
