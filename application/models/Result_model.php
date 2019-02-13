<?php
Class Result_model extends CI_Model
{
  function result_list($act,$user_id=''){
    if($act=='all'){
      $query = $this->db->query("SELECT * FROM quiz_result A JOIN result B ON A.urid = B.id
        JOIN quiz C ON A.quid = C.quid JOIN users D ON B.id_user = D.id order by A.rid desc"
      );
    }elseif ($act=='user') {  
      $addsql = ($user_id!='')?" and c.status not in ('RESET', 'DELETE') and c.id_user = '".$user_id."'":" and c.status <> 'DELETE' and c.id_user !=1";
      $query = $this->db->query("SELECT c.id,u.username,k.nama_kelas as 'kelas',d.nama_skema as 'skema',b.persentase as 'persentase',
        (select count(rd.id) from result r join result_detail rd on rd.id=r.id right join (select aa.*,bb.id_skema,
        max(aa.rid) maxrid from quiz_result aa join quiz bb on aa.quid=bb.quid where bb.`status` = 'ACTIVE'
        group by aa.urid,aa.quid) q on q.urid=rd.id and q.id_skema=rd.id_skema
        where rd.id=b.id and rd.id_skema=b.id_skema and r.status <> 'DELETE') as 'simulasi',
        ifnull((select ROUND(max(percentage), 4) from quiz_result aa join quiz bb on aa.quid=bb.quid
        where bb.`status` = 'ACTIVE' and urid=b.id and bb.id_skema=b.id_skema),'0') as 'maxnilai',
        c.status from result c join result_detail b on b.id=c.id left join (select aa.*,bb.id_skema from quiz_result aa
        join quiz bb on aa.quid=bb.quid where bb.`status` = 'ACTIVE' group by aa.urid,aa.quid) a on a.urid=b.id and a.id_skema=b.id_skema
        left join skkni_skema d on b.id_skema=d.id_skema join users u on u.id=c.id_user join mbti_hasil m on m.id_mbti_hasil=c.id_mbti_hasil
        join mbti_kelas k on k.id_mbti_kelas=m.id_mbti_kelas where 1=1".$addsql." order by c.id desc"
      );
    }elseif ($act=='quiz') {
      $query = $this->db->query("SELECT A.*,B.id_user,B.id_skema,D.nama_skema FROM quiz_result A JOIN result B ON A.urid = B.id
        join skkni_skema D on B.id_skema=D.id_skema where B.id = '".$user_id."' order by A.rid desc");
    }elseif ($act=='admin') {
      $query = $this->db->query("SELECT b.id,a.username,concat(a.first_name,' ',a.last_name) nama,
        (select group_concat(mk.nama_kelas ORDER BY mhd.persentase DESC SEPARATOR '<br>')
        from mbti_hasil_detail mhd join mbti_hasil mh on mhd.id_mbti_hasil=mh.id_mbti_hasil
        join mbti_kelas mk on mk.id_mbti_kelas=mhd.id_mbti_kelas join result r on mh.id_mbti_hasil=r.id_mbti_hasil
        where r.id=b.id group by mhd.id_mbti_hasil) posisi,
        (select group_concat(concat(mhd.persentase,'%') ORDER BY mhd.persentase DESC SEPARATOR '<br>')
        from mbti_hasil_detail mhd join mbti_hasil mh on mhd.id_mbti_hasil=mh.id_mbti_hasil
        join result r on mh.id_mbti_hasil=r.id_mbti_hasil where r.id=b.id group by mhd.id_mbti_hasil) persen_posisi,
        (select group_concat(ss.nama_skema ORDER BY rd.persentase DESC SEPARATOR '<br>')
        from result_detail rd join result r on rd.id=r.id join skkni_skema ss on ss.id_skema=rd.id_skema
        where r.id=b.id group by rd.id) skema,
        (select group_concat(concat(rd.persentase,'%') ORDER BY rd.persentase DESC SEPARATOR '<br>')
        from result_detail rd join result r on rd.id=r.id where r.id=b.id group by rd.id) persen_skema,
        (select ifnull(group_concat(concat(oke,'%') ORDER BY rd.persentase DESC SEPARATOR '<br>'),'0%')
        from result_detail rd join result r on rd.id=r.id left join (select aa.*,bb.id_skema,
        ROUND(max(percentage), 4) oke from quiz_result aa join quiz bb on aa.quid=bb.quid
        where bb.`status` = 'ACTIVE' group by urid,quid) qr on qr.urid=rd.id
        and rd.id_skema=qr.id_skema where r.id=b.id group by rd.id) hasil_simulasi, b.`status`
        from users a join result b on a.id=b.id_user where a.su=0 and b.status not in ('RESET', 'DELETE') order by 1 desc");
    }
    if($query -> num_rows() >= 1){
      return $query->result();
    }else{
      return false;
    }
  }

  function last_ten_result($act,$id,$skema='',$q=''){
    $this->db->join('quiz B','B.quid = A.quid');
    $this->db->join('result C','C.id = A.urid');
    $this->db->join('users D','D.id = C.id_user');
    if($act=='all'){
     	$this->db->where('B.quid',$id);
    }elseif($act=='user'){
      $this->db->where('C.id_user',$id);
      $this->db->where('C.id_skema',$skema);
      $this->db->where('C.id',$q);
    }
   	$this->db->order_by('A.rid','desc');
   	$this->db->limit('10');
   	$query = $this->db->get('quiz_result A');
   	$result = $query->result_array();
   	return $result;
  }

  function result_view($id,$user_id=''){
    $condi= ($user_id!="")?" and B.id_user='".$user_id."'":"";
    $query = $this->db->query("SELECT * FROM quiz_result A JOIN result B ON A.urid=B.id JOIN users C ON C.id = B.id_user JOIN quiz D ON A.quid = D.quid where A.rid='".$id."'".$condi);
    if($query->num_rows() >= 1){
      return $query->row();
    }else{
      return false;
    }
  }

  function get_percentile($quid,$uid,$score){
    $res=array();
    $this->db->join('result B','A.urid = B.id');
    $this->db->where("A.quid",$quid);
    $this->db->group_by("B.id_user");
    $this->db->order_by("A.score",'DESC');
    $query = $this->db->get('quiz_result A');
    $res[0]=$query->num_rows();
    $this->db->join('result B','A.urid = B.id');
    $this->db->where("A.quid",$quid);
    $this->db->where("B.id_user !=",$uid);
    $this->db->where("A.score <=",$score);
    $this->db->group_by("B.id_user");
    $this->db->order_by("A.score",'DESC');
    $querys = $this->db->get('quiz_result A');
    $res[1]=$querys->num_rows();
    return $res;
  }

  function remove_result($act,$rid){
    if($act=='SPA'){
      $result = $this->db->delete('quiz_result', array('rid' => $rid));
      $yes='Result removed successfully';$no="Unable to remove result";
    }elseif($act=='user'){
      $this->db->where('id', $rid);
  		$result = $this->db->update('result',array('status' => 'RESET'));
      $yes='Result removed successfully';$no="Unable to remove result";
    }elseif($act=='data'){
      $this->db->trans_start();
      $this->db->query("update mbti_hasil a set a.status='INACTIVE' where a.id_user='".$rid."'");
      $this->db->query("update result a set a.status ='RESET' where a.id_user='".$rid."'");
      $this->db->trans_complete();
      $result = $this->db->trans_status();
      $yes='Your all data has removed successfully';$no="Unable to remove all data";
    }
    if($result){
      return $yes;
    }else{
      return $no;
    }
  }
}
