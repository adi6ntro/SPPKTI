<?php
Class Simulasi_model extends CI_Model
{
  function question_list($cid=''){
		if($cid>="1"){
			$extrap="and A.id_unit='".$cid."'";
		}else{
			$extrap="";
		}
		$query = $this->db->query("select A.qid, A.question, B.id_unit, B.nama_unit from qbank A, skkni_unit B
      where A.id_unit=B.id_unit ".$extrap." order by A.qid desc");
		if($query -> num_rows() >= 1){
			return $query->result();
		}else{
			return false;
		}
	}

  function insert_soal(){
		$data = array(
			'id_unit' => $this->input->post('cid'),
			'question' => $this->input->post('question'),
			'description' => $this->input->post('description')
		);
		if($this->db->insert('qbank',$data)){
			$qid=$this->db->insert_id();
			foreach($this->input->post('option') as $key => $value){
				$score=($key==($this->input->post('score')))?"1":"0";
  			$data = array(
  				'qid' => $qid,
  				'option_value' => $value,
  				'score'=> $score
  			);
  			$this->db->insert('q_options',$data);
      }
			return "Question added successfully";
		}else{
			return "Unable to add question";
		}
	}

  function get_soal($id){
		$query = $this->db->query("SELECT * FROM qbank A JOIN skkni_unit B ON A.id_unit = B.id_unit WHERE A.qid='".$id."'");
		$questions=$query->row_array();
		$query = $this->db->query("SELECT * FROM q_options WHERE qid='".$id."'");
		$options=$query->result_array();
		$dataarr=array($questions,$options);
		return $dataarr;
	}

  function update_soal($id){
		$data = array(
      'id_unit' => $this->input->post('cid'),
			'question' => $this->input->post('question'),
			'description' => $this->input->post('description')
		);
		$this->db->where('qid',$id);
		if($this->db->update('qbank',$data)){
			foreach($this->input->post('option') as $key => $value){
				$score=($key==($this->input->post('score')))?"1":"0";
				$data = array(
					'option_value' => $value,
					'score'=> $score
				);
        $this->db->where('oid',$this->input->post('oids')[$key]);
				$this->db->update('q_options',$data);
			}
			return "Question updated successfully";
		}else{
			return "Unable to update question";
		}
	}

  function remove_soal($id){
		if($this->db->delete('q_options', array('qid' => $id))){
			$this->db->delete('qbank', array('qid' => $id));
			return "Question deleted successfully";
		}else{
			return "Unable to delete question";
		}
	}

	function remove_qids(){
    $no=0;
		foreach($this->input->post('qid') as $qid){
			if($this->db->delete('q_options', array('qid' => $qid))){
				$this->db->delete('qbank', array('qid' => $qid));
			}
      $no++;
		}
		return $no." Question deleted successfully";
	}

  function quiz_list(){
		$query = $this->db->query("SELECT a.quid,a.quiz_name,concat(a.id_skema,' - ',b.nama_skema) as id_skema ,a.duration,a.qids_static,a.`status` from quiz a
      join skkni_skema b on a.id_skema=b.id_skema order by quid desc");
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return false;
		}
  }

  function insert_quiz(){
		$data = array(
			'quiz_name' => $this->input->post('quiz_name'),
			'description' => $this->input->post('description'),
			'duration' => $this->input->post('quiz_time_duration'),
			'pass_percentage' => $this->input->post('pass_percentage'),
			'qselect' => $this->input->post('qselect'),
			'view_answer' => $this->input->post('view_answer'),
			'correct_score' => $this->input->post('correct_answer_score'),
			'incorrect_score' => $this->input->post('incorrect_answer_score'),
      'id_skema' => $this->input->post('assigned_groups')
		);
		$qselect=$this->input->post('qselect');
		if($this->db->insert('quiz',$data)){
			if($qselect=="1"){
				$noq=$this->input->post('no_of_questions');
				$insert_data = array(
					'quid'	=>	$quid,
					'cid'	=>	$this->input->post('cid'),
					'did'	=>	$this->input->post('did'),
					'no_of_questions'	=>	$noq['0']
				);
				$this->db->insert('quiz_qids',$insert_data);
			}
			return $quid;
		}else{
			return "Unable to add quiz";
		}
	}

  function get_quiz($id){
    if(ctype_digit(strval($id))){
      $query = $this->db->query("select * from quiz where quid='".$id."'");
    }else{
      $query = $this->db->query("select A.*,B.nama_skema from quiz A join skkni_skema B on A.id_skema=B.id_skema where A.id_skema='".$id."' and A.status='ACTIVE'");
    }
    if($query->num_rows() >= 1){
      return $query->row_array();
    }else{
      return false;
    }
  }

  function get_quiz2($id){
    $quiz=array();
    foreach ($id as $key => $value) {
      $query = $this->db->query("select A.*,B.nama_skema from quiz A join skkni_skema B on A.id_skema=B.id_skema where B.nama_skema='".$value."' and A.status='ACTIVE'");
      if($query->num_rows() >= 1){
        $quiz[$key] = $query->row_array();
      }else{
        return false;
      }
    }
    return $quiz;
  }

  function assigned_questions($quid){
   	$this->db->where('quid',$quid);
   	$query=$this->db->get('quiz');
   	$result=$query->row_array();
   	$qids=$result['qids_static'];
   	if($qids!=""){
   	  $qrr="SELECT A.*,B.* FROM qbank A JOIN skkni_unit B ON A.id_unit = B.id_unit where A.qid in (".$qids.") ORDER BY FIELD(A.qid,".$qids.")";
   		$query = $this -> db -> query($qrr);
  	  return $query->result();
  	}else{
  	   return false;
  	}
  }

  function move($act,$quid,$qid){
   	$this->db->where('quid',$quid);
   	$query=$this->db->get('quiz');
   	$result=$query->row_array();
   	$qids=$result['qids_static'];
   	if($qids==""){
   	  $qids=array();
   	}else{
   	  $qids=explode(",",$qids);
   	}
   	$qids_new=array();
    if($act=='add'){
      	$qids[]=$qid;
    }else if($act=='up'){
     	foreach($qids as $k => $qval){
     	  if($qval == $qid){
         	$qids_new[$k-1]=$qval;
        	$qids_new[$k]=$qids[$k-1];
   	    }else{
          $qids_new[$k]=$qval;
        }
      }
    }else if($act=='down'){
      foreach($qids as $k => $qval){
       	if($qval == $qid){
         	$qids_new[$k]=$qids[$k+1];
          $kk=$k+1;
        	$kv=$qval;
       	}else{
      	   $qids_new[$k]=$qval;
      	}
      }
     	$qids_new[$kk]=$kv;
    }else if($act=='remove'){
      foreach($qids as $k => $qval){
       	if($qval != $qid){
       	  $qids_new[]=$qval;
       	}
     	}
    }
   	$qids=array_filter(array_unique(($act=='add')?$qids:$qids_new));
   	$qids=implode(",",$qids);
   	$userdata=array('qids_static'=>$qids);
   	$this->db->where('quid',$quid);
  	$this->db->update('quiz',$userdata);
  }

  function status_quiz($id){
    $cek_soal = $this->get_quiz($id);
    if(is_null($cek_soal['qids_static']) || $cek_soal['qids_static']==''){
      return "Empty Question. Quiz unable to active";
    }else{
      $this->db->where('id_skema',$cek_soal['id_skema']);
  		$this->db->update('quiz',array('status'=>'INACTIVE'));
      $this->db->where('quid',$id);
  		$this->db->update('quiz',array('status'=>'ACTIVE'));
      return substr($cek_soal['quiz_name'],0,10)." is active";
    }
  }

  function update_quiz($id){
    $data = array(
			'quiz_name' => $this->input->post('quiz_name'),
			'description' => $this->input->post('description'),
			'duration' => $this->input->post('quiz_time_duration'),
			'pass_percentage' => $this->input->post('pass_percentage'),
			'qselect' => $this->input->post('qselect'),
			'view_answer' => $this->input->post('view_answer'),
			'correct_score' => $this->input->post('correct_answer_score'),
			'incorrect_score' => $this->input->post('incorrect_answer_score'),
      'id_skema' => $this->input->post('assigned_groups')
		);
		$this->db->where('quid',$id);
		if($this->db->update('quiz',$data)){
      $this->status_quiz($id,$this->input->post('status'));
 			return "Quiz added successfully";
		}else{
 			return "Unable to add quiz";
		}
 	}

  function remove_quiz($id){
    if($this->db->delete('quiz', array('quid' => $id))){
      return "Quiz deleted successfully";
		}else{
			return "Unable to delete quiz";
		}
  }

  public function cek($id){
    $id_user = $this->db->query('select * from result where id_user='.$this->db->escape($id).' and status="CURRENT"');
    if($id_user->num_rows() >= 1){
      return $id_user->row_array();
    }else{
      return false;
    }
  }

  function verify($skema,$id){
    if($this->input->cookie('rid', TRUE)){
      //check if there is any test already started
      $rid=$this->input->cookie('rid', TRUE);
      $query = $this->db->query("select * from quiz_result where rid='".$rid."'");
      $row=$query->row_array();$time_spent=$row['time_spent'];$quid=$row['quid'];
      $query = $this->db->query("select * from quiz where quid='".$quid."'");
      $row=$query->row_array();$duration=$row['duration'];
      // check quiz end time
      if($time_spent >= ($duration * 60 )){
        return "Time over";
      }else{
        return "1";
      }
    }else{
      // check for new test attempt
      $query = $this->db->query("select * from quiz where id_skema='".$skema."' and status='ACTIVE'");
      $row =$query->row_array();
      if($row['qselect']=="0"){
        $qids=array();$unit=array();$qids_range=array();$rng=array();
        $query = $this->db->query("SELECT A.*,B.* FROM qbank A JOIN skkni_unit B ON A.id_unit = B.id_unit where qid in (".$row['qids_static'].") ORDER BY FIELD(A.qid, ".$row['qids_static']." ) ");
        $qidarr=$query->result_array();
        foreach($qidarr as $key => $qid){
          $qids[]=$qid['qid'];//qid dikumpulin jadi array baru
          $unit[]=$qid['id_unit'];//nama_unit dikumpulin jadi array baru
        }
        $rngarr=array();$cateselected=array();
        foreach($unit as $key => $cval){
          if(in_array($cval,$cateselected)){
            $rngarr[$cval]+=1;
          }else{
            $cateselected[]=$cval;
            $rngarr[$cval]=1;
          }
          //digunakan untuk memetakan kategori dari soal yg ada pada quiz
        }
        $category_names=array();$ii=0;
        foreach($rngarr as $rk => $rval){
          $category_names[]=$rk;
          $rng[]=$ii."-".($ii+$rval-1);
          $ii+=$rval;
        }
        $qids_range=$rng;
      }else{return 'error';}
      $time_Spent_ind=array();$roids=array();
      for($x=1; $x <=count($qids); $x++){
        $time_Spent_ind[]="0";
        $roids[]="0";
      }
      $time_Spent_ind=implode(",",$time_Spent_ind);
      $qids=implode(",",$qids);
      $roids=implode(",",$roids);
      $category_names=implode(",",$category_names);
      $qids_range=implode(",",$qids_range);
      $data = array(
        'urid' => $id,
        'quid' => $row['quid'],
        'oids' => $roids,
        'qids' => $qids,
        'id_unit' => $category_names,
        'qids_range' => $qids_range,
        'start_time' => time(),
        'last_response' => time(),
        'time_spent' => '0',
        'time_spent_ind' => $time_Spent_ind
      );
      if($this->db->insert('quiz_result',$data)){
        $rid=$this->db->insert_id();
        $cookie = array(
          'name'   => 'rid',
          'value'  => $rid,
          'expire' => '86500'
        );
        $this->input->set_cookie($cookie);
        return "1";
      }
    }
  }

  function get_access($act,$rid){
    if ($act=='question') {
      $query = $this -> db -> query("select * from quiz_result where rid='".$rid."'");
      $row=$query->row_array();$qids=$row['qids'];
      $query = $this -> db -> query("SELECT * FROM qbank A JOIN skkni_unit B ON A.id_unit = B.id_unit WHERE A.qid IN ( ".$qids." ) ORDER BY FIELD(qid, ".$qids." )");
      $questions=$query->result_array();
      $query = $this -> db -> query("SELECT * FROM  q_options WHERE qid IN ( ".$qids." )");
      $options=$query->result_array();
      $dataarr=array($questions,$options);
      return $dataarr;
    }elseif ($act=='time_info') {
      $current_time=time();
      $this->db->query("update quiz_result set time_spent=(".$current_time."-start_time) where rid='".$rid."'");
      $query = $this -> db -> query("select * from quiz_result where rid='".$rid."'");
      return $query->row_array();
    }
  }

  function attempt_update($act,$id,$data){
    $rid=$this->input->cookie('rid', TRUE);
    $query = $this -> db -> query("select * from quiz_result where rid='".$rid."'");
    $row=$query->row_array();
    if ($act=='time') {
     	$x='time_spent_ind';
    }elseif ($act=='answer') {
      $x='oids';
    }
    $array=explode(",",$row[$x]);
    foreach($array as $key => $val){
      if($key==$id){
        $array[$key]=$data;
      }
    }
    $array=implode(",",$array);
    $this->db->query("update quiz_result set ".$x."='".$array."' where rid='".$rid."'");
  }

  function quiz_submit($id){
    $rid=$this->input->cookie('rid', TRUE);
    $this->db->where('rid',$rid);
    $query=$this->db->get('quiz_result');
    $result=$query->row_array();
    $r_qids=$result['qids'];
    $fillups=array();
    $match_options=array();
    $question_option_val[]=array();
    $ans_val[]=array();
    $noq=$this->input->post('noq');
    $oids=array();
    for($x=0; $x<=$noq; $x++){
      if($_POST['answers'.$x]){
        $oids[$x]=$_POST['answers'.$x];
      }else{
        $oids[$x]=0;
      }
    }
    //  implode array of selected option ids
    $oid=implode(",",$oids);
    // fetch quiz detail
    $query = $this -> db -> query("select quiz.* from quiz where quid='".$id."'");
    $quiz=$query->row_array();
    $correct_score=explode(",",$quiz['correct_score']);
    $incorrect_score=explode(",",$quiz['incorrect_score']);
    $min_percentage=$quiz['pass_percentage'];
    // fetch options score
    $oid_r=str_replace('-',',',$oid);
    $query=$this->db->query("SELECT A.*, B.* FROM q_options A, qbank B WHERE A.oid IN (".$oid_r.") and A.qid=B.qid order by field(A.qid,".$r_qids.")");
    $options=$query->result_array();
    $flip_r_qids=array_flip(explode(",",$r_qids));
    $score=0;
    // calculate score
    $fill=0;
    $match_column=0;
    $score_ind=array();
    $fliped_oidr=array();
    foreach(explode(",",$r_qids) as $xord => $xvord){
      $score_ind[$xord]=0;
      $fliped_oidr[$xvord]=$xord;
    }
    foreach($options as $value){
      if(!isset($pre_qid)){
        $score_ind_i=0;
      }else{
        if($pre_qid != $value['qid']){
          $score_ind[$fliped_oidr[$oid_pre_qid]]=$score_ind_i;
          $score_ind_i=0;
        }
      }
      if($value['score'] > "0"){
        if(isset($correct_score[$flip_r_qids[$value['qid']]])){
          $score+=$value['score'] * $correct_score[$flip_r_qids[$value['qid']]];
          $score_ind_i+=$value['score'] * $correct_score[$flip_r_qids[$value['qid']]];
        }else{
          $score+=$value['score'] * $correct_score['0'];
          $score_ind_i+=$value['score'] * $correct_score['0'];
        }
      }else{
        if(isset($incorrect_score[$flip_r_qids[$value['qid']]])){
          $score+=$incorrect_score[$flip_r_qids[$value['qid']]];
          $score_ind_i+=$incorrect_score[$flip_r_qids[$value['qid']]];
        }else{
          $score+=$incorrect_score['0'];
          $score_ind_i+=$incorrect_score['0'];
        }
      }
      $pre_qid=$value['qid'];
      $oid_pre_qid=$value['qid'];
    }
    $score_ind[$fliped_oidr[$value['qid']]]=$score_ind_i;
    // calculate percentage
    $query = $this->db->query("select * from quiz_result where rid='".$rid."'");
    $qr=$query->row_array();
    //( obtained score /(number of question * correct score) )*100
    if(count($correct_score) >= "2"){
      $percentage=($score / (	array_sum($correct_score) ))* 100;
    }else{
      $percentage=($score / (count(explode(",",$qr['qids'])) * 	$correct_score['0'] ))* 100;
    }
    // user pass or fail
    if($percentage >= $min_percentage){
      $q_result="1";
    }else{
      $q_result="0";
    }
    $time_spent=time()-$qr['start_time'];
    $score_ind=implode(",",$score_ind);
    $insert_data = array(
      'oids'=>$oid,
      'end_time'=>time(),
      'score'=>$score,
      'percentage'=>$percentage,
      'q_result'=>$q_result,
      'time_spent'=>$time_spent,
      'score_ind'=>$score_ind,
      'status' => '1'
    );
    $this->db->where('rid', $rid);
    if($this->db->update('quiz_result',$insert_data)){
      delete_cookie("rid");
      return "Simulasi submitted successfully. <a href='".site_url('result/view_user/'.$result['urid'])."'>Click here</a> to view result";
    }else{
      return "Unable to submit simulasi";
    }
  }
}
