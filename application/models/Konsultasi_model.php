<?php
Class Konsultasi_model extends CI_Model
{
  public function cek($id){
    $id_user = $this->db->query('select * from mbti_hasil where id_user='.$this->db->escape($id).' and status="ACTIVE"');
    if($id_user->num_rows() >= 1){
      return true;
    }else{
      return false;
    }
  }

  public function cek_kompetensi($id){
    $id_user = $this->db->query('select * from result where id_user='.$this->db->escape($id).' and status="CURRENT"');
    if($id_user->num_rows() >= 1){
      $urid=$id_user->row_array();
      $simulasi = $this->db->query('select * from quiz_result where urid='.$urid['id']);
      if($simulasi->num_rows() >= 1){
        return true;
      }else{
        return false;
      }
    }else{
      return true;
    }
  }

  function insert_mbti($mbti_list)
	{
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
    $hasil = $this->mbti_bayes($id_mbti);$bayes=explode('|',$hasil);
		$data = array(
			"tipe_mbti" => $id_mbti,"Extrovert" => $extrovert,"Introvert" => $introvert,"Sensing" => $sensing,
			"Intuition" => $intuition,"Thinking" => $thinking,"Feeling" => $feeling,"Judging" => $judging,
			"Perceiving" => $perceiving,"id_user" => $this->session->userdata('logged_in')['id'],'id_mbti_kelas' => $bayes[0],
      'presentase' => $bayes[1],'persenmax' => $bayes[2],'presentase_detil_max' => $bayes[3],'presentase_detil_full' => $bayes[4],'status' => 'ACTIVE'
		);
		if($this->db->insert('mbti_hasil',$data)){
      $hasil = $this->db->insert_id();
      $result_detail=explode(", ",$bayes[3]);
      foreach ($result_detail as $key) {
        $result_detail1 = explode(":",$key);
        $query_kelas2 = $this->db->query("SELECT id_mbti_kelas from mbti_kelas where nama_kelas='".$result_detail1[0]."'")->row_array()['id_mbti_kelas'];
        $data_detail = array(
    			"id_mbti_hasil" => $hasil,
    			"id_mbti_kelas" => $query_kelas2,
    			"persentase" => $result_detail1[1]
    		);
     		$this->db->insert('mbti_hasil_detail',$data_detail);
      }
      $result = array(
        "result"=>"Tes MBTI berhasil direkam",
        "type"=>"success"
      );
		}else{
      $result = array(
        "result"=>"Tidak bisa merekam data",
        "type"=>"error"
      );
		}
    return $result;
	}

  function mbti_bayes($mbti)
  {
    #$id = $this->input->post('mbti');
    $class = array();//different classes
  	$allclass = array();//total individual classes
  	$nama_kelas = array();//nama individual classes
  	$temp = array();
    $hasil ="";

  	$hasil .= "<strong>Tahap 1: Daftar Kelas</strong> <br>";
  	//Finding different class attributes
  	$i = $this->db->query("SELECT distinct(id_mbti_kelas) from mbti_hasil order by id_mbti_kelas asc");
  	foreach($i->result_array() as $j){
  		$temp[] = $j;
    }
  	foreach($temp as $t){
  		$query_kelas = $this->db->query("SELECT * from mbti_kelas where id_mbti_kelas='".$t['id_mbti_kelas']."'");
  		$class[] = $t['id_mbti_kelas'];
      foreach($query_kelas->result_array() as $kelas){
  		  $hasil .= $t['id_mbti_kelas']." - ".$kelas['nama_kelas']."<br>";
      }
  	}

  	$hasil .= "<br><strong>Tahap 2: Menghitung Total Seluruh Data</strong> <br>";
  	//Finding total number of training classes
  	$nc = $this->db->query("SELECT count(id_mbti_kelas) as num from mbti_hasil");
  	foreach ($nc->result_array() as $p){
    	$C = $p["num"];
    	$hasil .= "Total Record: ".$C."<br>";
    }

  	$hasil .= "<br><strong>Tahap 3: Menghitung Jumlah Kelas</strong> <br>";
  	//Finding total number of individual classes
  	foreach($class as $c)
  	{
  		$nc = $this->db->query("SELECT count(*) as num from mbti_hasil where id_mbti_kelas= '".$c."'");
  		foreach($nc->result_array() as $m){
    		$query_kelas2 = $this->db->query("SELECT * from mbti_kelas where id_mbti_kelas='".$c."'");
    		foreach($query_kelas2->result_array() as $kelas2){
      		$nama_kelas[$c] = $kelas2['nama_kelas'];
        }
    		$allclass[$c] = $m["num"];
    		$hasil .= "jumlah kelas \"".$nama_kelas[$c]."\" : ".$allclass[$c]."<br>";
      }
  	}

  	$hasil .= "<br><strong>Tahap 4: Probabilitas Tiap Kelas</strong> <br>";
  	//Finding Prob of each class
  	foreach($allclass as $c=>$p)
  	{
  		$Pc[$c] = round($p/$C,4);
  		$argmax[$c] = 1;
  		$hasil .= "P(Y=".$nama_kelas[$c].") = ". $p."/".$C." = ".$Pc[$c]."<br>";
  	}

  	$hasil .= "<br><strong>Tahap 5: Menghitung Probabilitas Tiap Atribut Per Kelas</strong> <br>";
  	//var_dump($allclass);
  	foreach($allclass as $c=>$p)
  	{
      $i = $this->db->query("SELECT count(*) as num from mbti_hasil where id_mbti_kelas= '".$c."' AND tipe_mbti='".$mbti."'");
      $query_atribut = $this->db->query("SELECT * from mbti where tipe_mbti='".$mbti."'");
      $atribut = $query_atribut->row_array();
			foreach ($i->result_array() as $j) {
  			$P[$c][$mbti] = round($j["num"]/$allclass[$c],4);
  			//Exception: P(data/class) might be 0 in some cases, ignore 0 for now
  			//if($P[$c][$x] != 0){
				$argmax[$c] *= $P[$c][$mbti];
				$hasil .= "P(".$atribut['tipe_mbti']." | Y=".$nama_kelas[$c].") = ". $j['num']."/".$allclass[$c]." = ".$P[$c][$mbti]."<br>";
  			//}
      }
  		$argmax[$c] *= $Pc[$c];
  	}

  	$jumlah = 0;
  	$hasil .= "<br><strong>Tahap 6: Hasil Perhitungan Akhir</strong> <br>";
  	foreach ($argmax as $c=>$n) {
  		$hasil .= "P(Y=".$nama_kelas[$c].") = ".$n."<br>";
  		$jumlah += $n;
  	}

  	$hasil .= "<br><strong>Tahap 7: Hasil Prediksi</strong> <br>";
    $ss="";$ssmax=array();
  	foreach ($argmax as $c=>$n) {
  		$persen[$c] = round(($n/$jumlah)*100,4);
  		$hasil .= "Presentase P(Y=".$nama_kelas[$c].") = ".$persen[$c]."%<br>";
      $ssmax[$nama_kelas[$c]] = $persen[$c];
      $ss .= $nama_kelas[$c].":".$persen[$c].",";
  	}
    arsort($ssmax);$ssno=0;
    foreach ($ssmax as $sskey=>$ssval) {
      if($ssno>2)
        unset($ssmax[$sskey]);
      $ssno++;
  	}
    $ssmax_persen = round((max($ssmax)/array_sum($ssmax))*100,4);
    $ssmax = implode(', ', array_map(
    	function ($v, $k) { return sprintf("%s:%s", $k, $v); },
        $ssmax,
        array_keys($ssmax)
    ));
    $ss = rtrim($ss,", ");
  	$max = array_keys($argmax,max($argmax));
  	$query_kelasmax = $this->db->query("SELECT * from mbti_kelas where id_mbti_kelas='".$max[0]."'");
    $query_mbtimax = $this->db->query("SELECT tipe_mbti from mbti where tipe_mbti='".$mbti."'");
  	$kelasmax = $query_kelasmax->row_array();$mbtimax = $query_mbtimax->row_array();
    $hasil .= "<br>Kesimpulannya adalah jika MBTI = <strong>".$mbtimax['tipe_mbti']."</strong>,
    maka Posisi yang Tepat yaitu <strong>".$kelasmax['nama_kelas']."</strong> dengan Presentase <strong>"
    .max($persen)."%</strong>.<br>catatan: dihitung dan dibandingkan dengan keseluruhan posisi.";

    return $kelasmax['id_mbti_kelas'].'|'.max($persen).'|'.$ssmax_persen.'|'.$ssmax.'|'.$ss;
  }

  function get_mbti()
  {
  		$cari="select id_mbti_hasil from mbti_hasil where id_user ='".$this->session->userdata('logged_in')['id']."' and status = 'ACTIVE'";
  		$query1 = $this->db->query($cari);
      return $query1->row_object();
  }

  function insert_skkni(){
    $unit = $this->input->post('unit');
    $nilai = $this->input->post('nilai');
    $hasil1 = $this->skkni_bayesKBK($unit,$nilai);$bayes=explode('|',$hasil1);
    $mbti = $this->get_mbti();
    if(isset(array_count_values($nilai)['K']) && array_count_values($nilai)['K']>=10){
      $data = array(
  			"id_user" => $this->session->userdata('logged_in')['id'],
  			"id_skema" => $bayes[0],
  			"id_mbti_hasil" => $mbti->id_mbti_hasil,
        "presentase" => $bayes[1],'persenmax' => $bayes[2],
        'presentase_detil_max' => $bayes[3],'presentase_detil_full' => $bayes[4],
        "status" => 'CURRENT',
  		);
      $this->db->query("update result set status='PAST' where id_user='".$this->session->userdata('logged_in')['id']."' and status not in ('RESET','DELETE')");
   		$this->db->insert('result',$data);
  		$hasil = $this->db->insert_id();
      $result_detail=explode(", ",$bayes[3]);
      foreach ($result_detail as $key) {
        $result_detail1 = explode(":",$key);
        $query_kelas2 = $this->db->query("SELECT id_skema from skkni_skema where nama_skema='".$result_detail1[0]."'")->row_array()['id_skema'];
        $data_detail = array(
    			"id" => $hasil,
    			"id_skema" => $query_kelas2,
    			"persentase" => $result_detail1[1]
    		);
     		$this->db->insert('result_detail',$data_detail);
      }
   		$nm = $this->input->post('unit');
  		$result = array();
  		foreach($nm AS $key => $val){
  			$result[] = array(
  				"id_hasil" => $hasil,
  				"id_unit"  => $unit[$key],
  				"nilai"  => $nilai[$key]
  			);
  		}
  		if($this->db->insert_batch('skkni_dataset', $result)){
        $result = array(
          "result"=>"Tes Kompetensi berhasil direkam",
          "type"=>"success"
        );
      }else{
        $result = array(
          "result"=>"Tidak bisa merekam data",
          "type"=>"error"
        );
      }
    }else{
      $result = array(
        "result"=>"Minimal berkompeten di 10 unit kerja SKKNI",
        "type"=>"error"
      );
    }
    return $result;
	}

  function skkni_bayes($unit,$nilai)
  {
    $id = array_combine($unit, $nilai);
    $class = array();//different classes
  	$allclass = array();//total individual classes
  	$nama_kelas = array();//nama individual classes
  	$temp = array();
    $hasil ="";

  	$hasil .= "<strong>Tahap 1: Daftar Kelas</strong> <br>";
  	//Finding different class attributes
  	$i = $this->db->query("SELECT distinct(id_skema) from result where status <> 'delete' order by id_skema asc");
  	foreach($i->result_array() as $j){
  		$temp[] = $j;
    }
  	foreach($temp as $t){
  		$query_kelas = $this->db->query("SELECT * from skkni_skema where id_skema='".$t['id_skema']."'");
  		$class[] = $t['id_skema'];
      foreach($query_kelas->result_array() as $kelas){
  		  $hasil .= $t['id_skema']." - ".$kelas['nama_skema']."<br>";
      }
  	}

  	$hasil .= "<br><strong>Tahap 2: Menghitung Total Seluruh Data</strong> <br>";
  	//Finding total number of training classes
  	$nc = $this->db->query("SELECT count(id_skema) as num from result where status <> 'delete'");
  	foreach ($nc->result_array() as $p){
    	$C = $p["num"];
    	$hasil .= "Total Record: ".$C."<br>";
    }

  	$hasil .= "<br><strong>Tahap 3: Menghitung Jumlah Kelas</strong> <br>";
  	//Finding total number of individual classes
  	foreach($class as $c)
  	{
  		$nc = $this->db->query("SELECT count(*) as num from result where status <> 'delete' and id_skema= '".$c."'");
  		foreach($nc->result_array() as $m){
    		$query_kelas2 = $this->db->query("SELECT * from skkni_skema where id_skema='".$c."'");
    		foreach($query_kelas2->result_array() as $kelas2){
      		$nama_kelas[$c] = $kelas2['nama_skema'];
        }
    		$allclass[$c] = $m["num"];
    		$hasil .= "jumlah kelas \"".$nama_kelas[$c]."\" : ".$allclass[$c]."<br>";
      }
  	}

  	$hasil .= "<br><strong>Tahap 4: Probabilitas Tiap Kelas</strong> <br>";
  	//Finding Prob of each class
  	foreach($allclass as $c=>$p)
  	{
  		$Pc[$c] = round($p/$C,4);
  		$argmax[$c] = 1;
  		$hasil .= "P(Y=".$nama_kelas[$c].") = ". $p."/".$C." = ".$Pc[$c]."<br>";
  	}

  	$hasil .= "<br><strong>Tahap 5: Menghitung Probabilitas Tiap Atribut Per Kelas</strong> <br>";
  	//var_dump($allclass);
    // $hasil .= "<table>";
    // foreach($allclass as $c=>$p)
  	// {
    //   $hasil .= "<tr><td>".$nama_kelas[$c]."<td>";
    //   foreach($id as $x=>$y)
  	// 	{
    //     $hasil .= "<td>".$y."<td>";
    //   }
    //   $hasil .= "</tr>";
  	// }
    // $hasil .= "</table>";
  	foreach($allclass as $c=>$p)
  	{
      foreach($id as $x=>$y)
  		{
        $i = $this->db->query("SELECT sum(A.nilai) as num, count(A.id_unit) as total from skkni_dataset A, result B
          where A.id_hasil=B.id and B.status <> 'delete' and A.id_unit= '".$x."' and B.id_skema='".$c."'");
  			foreach ($i->result_array() as $j) {
          $rata = $j["num"]/$j["total"];
          $i2 = $this->db->query("SELECT * from skkni_dataset A, result B
            where A.id_hasil=B.id and B.status <> 'delete' and A.id_unit= '".$x."' and B.id_skema='".$c."'");
          $simpang=0;
          foreach ($i2->result() as $j2) {
            $bilang = $j2->nilai-$rata;
            $pangkat = pow($bilang,2);
            $simpang += $pangkat;
          }
          if($simpang!=0){
          $simpangkuadrat = $simpang/($j['total']-1);
          $simpangakar = sqrt($simpangkuadrat);
          $hitung1 = sqrt(2*3.14159265359) * $simpangakar;
          $hitungatas = pow(($y-$rata),2);
          $hitungbawah = 2 * $simpangkuadrat;
          $hitungpangkat = $hitungatas/$hitungbawah;
          $hitung2 = pow(2.71828182846,$hitungpangkat);
          $hitungakhir = 1/($hitung1 * $hitung2);
          $P[$c][$x] = $hitungakhir;
    			//Exception: P(data/class) might be 0 in some cases, ignore 0 for now
    			//if($P[$c][$x] != 0){
    				$argmax[$c] *= $P[$c][$x];
          //}
        }else{
          $P[$c][$x] = 0;
        }
  				$hasil .= "P(".$x." = ".$y." | Y=".$nama_kelas[$c].") = ". $j['num']."/".$allclass[$c]." = ".$P[$c][$x]."<br>";
        }
    		$argmax[$c] *= $Pc[$c];
      }
  	}

  	$jumlah = 0;
  	$hasil .= "<br><strong>Tahap 6: Hasil Perhitungan Akhir</strong> <br>";
  	foreach ($argmax as $c=>$n) {
  		$hasil .= "P(Y=".$nama_kelas[$c].") = ".$n."<br>";
  		$jumlah += $n;
  	}

  	$hasil .= "<br><strong>Tahap 7: Hasil Prediksi</strong> <br>";
  	foreach ($argmax as $c=>$n) {
  		$persen[$c] = ($n/$jumlah)*100;
  		$hasil .= "Presentase P(Y=".$nama_kelas[$c].") = ".$persen[$c]."%<br>";
  	}
    $hasil .= "<br><strong>Tahap 8: Urutan Hasil Prediksi dari yang Tertinggi ".$jumlah."</strong> <br>";
    arsort($persen);
    foreach ($persen as $key => $value) {
      $query_urutmax = $this->db->query("SELECT * from skkni_skema where id_skema='".$key."'");
    	$urutmax = $query_urutmax->row_array();
      $hasil .= "Presentase P(Y=".$urutmax['nama_skema'].") = ".$value."%<br>";
    }
  	$max = array_keys($argmax,max($argmax));
  	$query_kelasmax = $this->db->query("SELECT * from skkni_skema where id_skema='".$max[0]."'");
  	$kelasmax = $query_kelasmax->row_array();
    $hasil .= "<br>Dari Kompetensi yang dimiliki, didapatkan skema yang tepat berdasarkan SKKNI yaitu Skema <strong>".$kelasmax['nama_skema']."</strong>
    dengan Presentase <strong>".max($persen)."%</strong>.";

    return $kelasmax['id_skema'].'|'.max($persen);
  }

  function skkni_bayesKBK($unit,$nilai)
  {
    $id = array_combine($unit, $nilai);
    $class = array();//different classes
  	$allclass = array();//total individual classes
  	$nama_kelas = array();//nama individual classes
  	$temp = array();
    $hasil ="";

  	$hasil .= "<strong>Tahap 1: Daftar Kelas</strong> <br>";
  	//Finding different class attributes
  	$i = $this->db->query("SELECT distinct(id_skema) from result where status <> 'delete' order by id_skema asc");
  	foreach($i->result_array() as $j){
  		$temp[] = $j;
    }
  	foreach($temp as $t){
      $query_kelas = $this->db->query("SELECT * from skkni_skema where id_skema='".$t['id_skema']."'");
  		$class[] = $t['id_skema'];
      foreach($query_kelas->result_array() as $kelas){
  		  $hasil .= $t['id_skema']." - ".$kelas['nama_skema']."<br>";
      }
  	}

  	$hasil .= "<br><strong>Tahap 2: Menghitung Total Seluruh Data</strong> <br>";
  	//Finding total number of training classes
  	$nc = $this->db->query("SELECT count(id_skema) as num from result where status <> 'delete'");
  	foreach ($nc->result_array() as $p){
    	$C = $p["num"];
    	$hasil .= "Total Record: ".$C."<br>";
    }

  	$hasil .= "<br><strong>Tahap 3: Menghitung Jumlah Kelas</strong> <br>";
  	//Finding total number of individual classes
  	foreach($class as $c)
  	{
      $nc = $this->db->query("SELECT count(*) as num from result where status <> 'delete' and id_skema= '".$c."'");
  		foreach($nc->result_array() as $m){
    		$query_kelas2 = $this->db->query("SELECT * from skkni_skema where id_skema='".$c."'");
    		foreach($query_kelas2->result_array() as $kelas2){
      		$nama_kelas[$c] = $kelas2['nama_skema'];
        }
    		$allclass[$c] = $m["num"];
    		$hasil .= "jumlah kelas \"".$nama_kelas[$c]."\" : ".$allclass[$c]."<br>";
      }
  	}

  	$hasil .= "<br><strong>Tahap 4: Probabilitas Tiap Kelas</strong> <br>";
  	//Finding Prob of each class
  	foreach($allclass as $c=>$p)
  	{
  		$Pc[$c] = round($p/$C,4);
  		$argmax[$c] = 1;
  		$hasil .= "P(Y=".$nama_kelas[$c].") = ". $p."/".$C." = ".$Pc[$c]."<br>";
  	}

  	$hasil .= "<br><strong>Tahap 5: Menghitung Probabilitas Tiap Atribut Per Kelas</strong> <br>";
  	//var_dump($allclass);
  	foreach($allclass as $c=>$p)
  	{
      foreach($id as $x=>$y)
  		{
        $i = $this->db->query("SELECT count(A.id_unit) as num from skkni_dataset A, result B
  			where A.id_hasil=B.id and B.status <> 'delete' and A.id_unit= '".$x."' and B.id_skema='".$c."' and A.nilai='".$y."'");
  			foreach ($i->result_array() as $j) {
    			$P[$c][$x] = $j["num"]/$allclass[$c];
    			//Exception: P(data/class) might be 0 in some cases, ignore 0 for now
    			//if($P[$c][$x] != 0){
  				$argmax[$c] *= $P[$c][$x];
          $hasil .= "P(".$x." = ".$y." | Y=".$nama_kelas[$c].") = ". $j['num']."/".$allclass[$c]." = ".$P[$c][$x]."<br>";
    			//}
        }
      }
  		$argmax[$c] *= $Pc[$c];
  	}

  	$jumlah = 0;
  	$hasil .= "<br><strong>Tahap 6: Hasil Perhitungan Akhir</strong> <br>";
  	foreach ($argmax as $c=>$n) {
  		$hasil .= "P(Y=".$nama_kelas[$c].") = ".$n."<br>";
  		$jumlah += $n;
  	}

    $hasil .= "<br><strong>Tahap 7: Hasil Prediksi</strong> <br>";
    $ss="";$ssmax=array();
  	foreach ($argmax as $c=>$n) {
      $persen[$c] = round(($n/$jumlah)*100,4);
  		$hasil .= "Presentase P(Y=".$nama_kelas[$c].") = ".$persen[$c]."%<br>";
      $ssmax[$nama_kelas[$c]] = $persen[$c];
      $ss .= $nama_kelas[$c].":".$persen[$c].",";
  	}
    $hasil .= "<br><strong>Tahap 8: Urutan Hasil Prediksi dari yang Tertinggi ".$jumlah."</strong> <br>";
    arsort($ssmax);$ssno=0;
    foreach ($ssmax as $key => $value) {
      $query_urutmax = $this->db->query("SELECT * from skkni_skema where id_skema='".$key."'");
    	$urutmax = $query_urutmax->row_array();
      $hasil .= "Presentase P(Y=".$urutmax['nama_skema'].") = ".$value."%<br>";
    }
    foreach ($ssmax as $sskey=>$ssval) {
      if($ssno>2)
        unset($ssmax[$sskey]);
      $ssno++;
  	}
    $ssmax_persen = round((max($ssmax)/array_sum($ssmax))*100,4);
    $ssmax = implode(', ', array_map(
    	function ($v, $k) { return sprintf("%s:%s", $k, $v); },
        $ssmax,
        array_keys($ssmax)
    ));
    $ss = rtrim($ss,", ");
  	$max = array_keys($argmax,max($argmax));
  	$query_kelasmax = $this->db->query("SELECT * from skkni_skema where id_skema='".$max[0]."'");
  	$kelasmax = $query_kelasmax->row_array();
    $hasil .= "<br>Dari Kompetensi yang dimiliki, didapatkan skema yang tepat berdasarkan SKKNI yaitu Skema <strong>".$kelasmax['nama_skema']."</strong>
    dengan Presentase <strong>".max($persen)."%</strong>.";

    return $kelasmax['id_skema'].'|'.max($persen).'|'.$ssmax_persen.'|'.$ssmax.'|'.$ss;
  }
}
