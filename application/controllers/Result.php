<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Result extends CI_Controller {
	var $username;
	var $su;
	var $user;

	function __construct()
	{
		parent::__construct();
		$this->load->model('result_model','',TRUE);
		$this->load->model('group_model','',TRUE);
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

	public function index(){
		if($this->su!="1"){
			exit('Permission denied');
			return;
		}
		$data = array(
			'username' => $this->username,
			'user' => $this->user,
			'title' => "Result",
			'result' => $this->result_model->result_list('admin')
		);
		$this->load->view('header',$data);
		$this->load->view('result/view',$data);
		$this->load->view('footer',$data);
	}

	public function konsultasi(){
		if($this->su!="1"){
			exit('Permission denied');
			return;
		}
		$data = array(
			'username' => $this->username,
			'user' => $this->user,
			'title' => "Result",
			'result' => $this->result_model->result_list('all')
		);
		$this->load->view('header',$data);
		$this->load->view('result/view_simulasi',$data);
		$this->load->view('footer',$data);
	}

	function user($limit='0'){
		if($this->su!="0"){
			exit('Permission denied');
			return;
		}
		$data = array(
			'username' => $this->username,
			'user' => $this->user,
			'title' => "Result",
			'result' => $this->result_model->result_list('user',$this->user['id'])
		);
		$this->load->view('header',$data);
		$this->load->view('result/view_user',$data);
		$this->load->view('footer',$data);
	}

	function view($id,$quid=''){
		if($this->su!="1"){
			exit('Permission denied');
			return;
		}
		$data = array(
			'username' => $this->username,
			'user' => $this->user,
			'title' => "Result #".$id
		);
		// getting the last ten result of all users of particular quiz
		$last_ten_result = $this->result_model->last_ten_result('all',$quid);
		$value=array();
		$value[]=array('Quiz Name','Percentage (%)');
		foreach($last_ten_result as $val){
			$value[]=array($val['username'].' ('.$val['first_name']." ".$val['last_name'].')',intval($val['percentage']));
		}
		$data['value']=json_encode($value);
		$data['result'] = $this->result_model->result_view($id);
		$correct_score=explode(",",$data['result']->correct_score);
		$incorrect_score=explode(",",$data['result']->incorrect_score);
		$correct_incorrect=explode(",",$data['result']->score_ind);
		$data['percentile'] = $this->result_model->get_percentile($quid, $data['result']->id_user, $data['result']->score);
		$t_category_name=explode(",",$data['result']->id_unit );
		$cct=array();
		$cct_per=array();
		$cct_per_total=array();
		$oids=explode(",",$data['result']->oids);
		foreach(explode(",",$data['result']->qids_range) as $rkey => $rval){
			if(!isset($cct[$t_category_name[$rkey]])){
				$cct[$t_category_name[$rkey]]=0;
			}
			if(!isset($cct_per[$t_category_name[$rkey]])){
				$cct_per[$t_category_name[$rkey]]=0;
			}
			if(!isset($cct_per_total[$t_category_name[$rkey]])){
				$cct_per_total[$t_category_name[$rkey]]=0;
			}
			$jj=explode("-",$rval);
			$j=$jj[0];
			$k=$jj[1];
			for($i=$j; $i<=$k; $i++){
				foreach(explode(",",$data['result']->time_spent_ind) as $ckey => $cval){
					if($ckey==$i){
						$cct[$t_category_name[$rkey]] +=$cval;
						//echo $correct_incorrect[$ckey]."<br>";
						if($correct_incorrect[$ckey] >= 0.1 ){
							$cct_per[$t_category_name[$rkey]]+=$correct_incorrect[$ckey];
						}else if($oids[$ckey] == "0"){
							$cct_per[$t_category_name[$rkey]]+=0;
						}else{
							$cct_per[$t_category_name[$rkey]]+=$correct_incorrect[$ckey];
						}
						if(isset($correct_score[$ckey])){
							$cct_per_total[$t_category_name[$rkey]]+=$correct_score[$ckey];
						}else{
							$cct_per_total[$t_category_name[$rkey]]+=$correct_score['0'];
						}
					}
				}
			}
		}
		//print_r($cct_per_total);
		// getting the individual question time
		$oidss=explode(",",$data['result']->oids);
		$qtime=array();
		$ctime=array();
		$ctime[]=array('Subject','Time in Seconds');
		$qtime[]=array('Question Number','Time in Seconds');
		foreach(explode(",",$data['result']->time_spent_ind) as $key => $val){
			if($correct_incorrect[$key]>="0.1"){
				$qtime[]=array("Q ".($key+1).") - Correct/Partially Correct",intval($val));
			}else if($correct_incorrect[$key]==0 && $oidss[$key]!=0 ){
				$qtime[]=array("Q ".($key+1).") - Wrong ",intval($val));
			}else{
				$qtime[]=array("Q ".($key+1).") - UnAttempted ",intval($val));
			}
		}
		foreach($cct as $cck => $cckval){
			$ctime[]=array($cck.' - Score: '.number_format((float)(($cct_per[$cck]/$cct_per_total[$cck])*100), 2, '.', '')."%",intval($cckval));
		}
		$data['qtime']=json_encode($qtime);
		$data['ctime']=json_encode($ctime);
		$data['cct_per']=$cct_per;
		$data['cct_per_total']=$cct_per_total;
		$this->load->view('header',$data);
		$this->load->view('result/detail',$data);
		$this->load->view('footer',$data);
  }

	function view_user($id_user){
		$data = array(
			'username' => $this->username,
			'user' => $this->user,
			'title' => 'Result'
		);
		$this->load->view('header',$data);
		$result_quiz = $this->result_model->result_list('quiz',$id_user);
		$nomor=count($result_quiz);
		if($result_quiz!=false){
			foreach($result_quiz as $res){
				$id_s=$res->id_user;$id_sk=$res->id_skema;$data['nama']=$res->nama_skema;
				$data['result'] = $this->result_model->result_view($res->rid,$res->id_user);
				$correct_score=explode(",",$data['result']->correct_score);
				$incorrect_score=explode(",",$data['result']->incorrect_score);
				$correct_incorrect=explode(",",$data['result']->score_ind);
				$data['percentile'] = $this->result_model->get_percentile($res->quid, $data['result']->id_user, $data['result']->score);
				$t_category_name=explode(",",$data['result']->id_unit );
				$cct=array();
				$cct_per=array();
				$cct_per_total=array();
				$oids=explode(",",$data['result']->oids);
				foreach(explode(",",$data['result']->qids_range) as $rkey => $rval){
					if(!isset($cct[$t_category_name[$rkey]])){
						$cct[$t_category_name[$rkey]]=0;
					}
					if(!isset($cct_per[$t_category_name[$rkey]])){
						$cct_per[$t_category_name[$rkey]]=0;
					}
					if(!isset($cct_per_total[$t_category_name[$rkey]])){
						$cct_per_total[$t_category_name[$rkey]]=0;
					}
					$jj=explode("-",$rval);
					$j=$jj[0];
					$k=$jj[1];
					for($i=$j; $i<=$k; $i++){
						foreach(explode(",",$data['result']->time_spent_ind) as $ckey => $cval){
							if($ckey==$i){
								$cct[$t_category_name[$rkey]] +=$cval;
								//echo $correct_incorrect[$ckey]."<br>";
								if($correct_incorrect[$ckey] >= 0.1 ){
									$cct_per[$t_category_name[$rkey]]+=$correct_incorrect[$ckey];
								}else if($oids[$ckey] == "0"){
									$cct_per[$t_category_name[$rkey]]+=0;
								}else{
									$cct_per[$t_category_name[$rkey]]+=$correct_incorrect[$ckey];
								}
								if(isset($correct_score[$ckey])){
									$cct_per_total[$t_category_name[$rkey]]+=$correct_score[$ckey];
								}else{
									$cct_per_total[$t_category_name[$rkey]]+=$correct_score['0'];
								}
							}
						}
					}
				}
				//print_r($cct_per_total);
				// getting the individual question time
				$oidss=explode(",",$data['result']->oids);
				$qtime=array();
				$ctime=array();
				$ctime[]=array('Subject','Time in Seconds');
				$qtime[]=array('Question Number','Time in Seconds');
				foreach(explode(",",$data['result']->time_spent_ind) as $key => $val){
					if($correct_incorrect[$key]>="0.1"){
						$qtime[]=array("Q ".($key+1).") - Correct/Partially Correct",intval($val));
					}else if($correct_incorrect[$key]==0 && $oidss[$key]!=0 ){
						$qtime[]=array("Q ".($key+1).") - Wrong ",intval($val));
					}else{
						$qtime[]=array("Q ".($key+1).") - UnAttempted ",intval($val));
					}
				}
				foreach($cct as $cck => $cckval){
					$ctime[]=array($cck.' - Score: '.number_format((float)(($cct_per[$cck]/$cct_per_total[$cck])*100), 2, '.', '')."%",intval($cckval));
				}
				$data['qtime']=json_encode($qtime);
				$data['ctime']=json_encode($ctime);
				$data['cct_per']=$cct_per;
				$data['cct_per_total']=$cct_per_total;
				$data['title1']='Result #'.$nomor;
				$nomor--;
				$this->load->view('result/detail_user',$data);
			}
			$last_ten_result = $this->result_model->last_ten_result('user',$id_s,$id_sk,$id_user);
			$value=array();$nom=1;
			$value[]=array('Quiz Name','Percentage (%)');
			foreach($last_ten_result as $val){
				$value[]=array('Result #'.$nom,intval($val['percentage']));
				$nom++;
			}
			$data['value']=json_encode($value);
			$this->load->view('result/grafik',$data);
		}else{
			$data['nama']=$result_quiz;
			$data['value']='Tidak ada data';
			$this->load->view('result/grafik',$data);
		}
		$this->load->view('footer',$data);
  }

  function remove($act,$rid){
		$result = $this->result_model->remove_result($act,$rid);
		$this->session->set_flashdata('result', $result);
		$red = ($act=='SPA')?'result':'result/user';
		redirect($red);
 	}
}
