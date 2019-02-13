<?php
Class Home_model extends CI_Model
{
  function SkemaList($id=0)
  {
    $query = $this->db->query("select * from skkni_skema where id_skema > '".$id."' order by id_skema asc limit 0, 4");
		if($query -> num_rows() >= 1){
			return $query->result();
		}else{
			return false;
		}
  }

  public function grafik($act){
    if($act=='mbti'){
      $id_user = $this->db->query("select count(a.id_mbti_hasil) as jml,b.id_mbti_kelas as id,b.nama_kelas as nama from mbti_hasil a
        right join mbti_kelas b on a.id_mbti_kelas=b.id_mbti_kelas group by a.id_mbti_kelas order by b.id_mbti_kelas"
      );
    }elseif($act=='skkni'){
      $id_user = $this->db->query("select a.id_skema as id,a.nama_skema as nama,count(*) jml from skkni_skema a
      join result r on a.id_skema=r.id_skema group by a.id_skema");
    }elseif($act=='result'){
      $id_user = $this->db->query("select A.tipe_mbti, A.presentase, B.id_skema, B.presentase, C.username from mbti_hasil A
        join result B on A.id_mbti_hasil=B.id_mbti_hasil join users C on C.id=A.id_user and C.id=B.id_user
        where C.id='".$id."' and B.status='CURRENT'"
      );
    }
    if($id_user->num_rows() >= 1){
      return $id_user->result_array();
    }else{
      return false;
    }
  }

  public function cek($act,$id){
    if($act=='mbti'){
      $id_user = $this->db->query("select A.tipe_mbti,B.gambar,B.keterangan,A.Introvert,A.Extrovert,A.Sensing,
        A.Intuition,A.Thinking,A.Feeling,A.Perceiving,A.Judging,D.nama_kelas,A.presentase,A.presentase_detil_max,A.persenmax,B.keterangan,D.saran from mbti_hasil A
        join mbti B on A.tipe_mbti=B.tipe_mbti join mbti_kelas D on D.id_mbti_kelas=A.id_mbti_kelas
        where A.id_user='".$id."' and A.status='ACTIVE'"
      );
    }elseif($act=='skkni'){
      $id_user = $this->db->query("select * from result A
        join skkni_skema B on A.id_skema=B.id_skema where A.id_user='".$id."' and A.status='CURRENT'");
    }elseif($act=='result'){
      $id_user = $this->db->query("select A.tipe_mbti, A.presentase, B.id_skema, B.presentase, C.username from mbti_hasil A
        join result B on A.id_mbti_hasil=B.id_mbti_hasil join users C on C.id=A.id_user and C.id=B.id_user
        where C.id='".$id."' and B.status='CURRENT'"
      );
    }
    if($id_user->num_rows() >= 1){
      return $id_user->row_array();
    }else{
      return false;
    }
  }

  function Penjelasan($id=0)
  {
    $query = $this->db->query("select * from skkni_skema where id_skema > '".$id."' order by id_skema asc limit 0, 4");
		if($query -> num_rows() >= 1){
			return $query->result();
		}else{
			return false;
		}
  }

  public function num_of($act){
    if($act=='users'){
      $return = $this->db->query("select count(*) as jml from users a where a.su = 0");
    }elseif($act=='mbti'){
      $return = $this->db->query("select count(*) as jml from mbti_hasil");
    }elseif($act=='skkni'){
      $return = $this->db->query("select count(*) as jml from result where status <> 'delete'");
    }elseif($act=='qbank'){
      $return = $this->db->query("select count(*) as jml from qbank");
    }
    $cons = $return->row_array();
    return $cons['jml'];
  }

  function hasil($unit,$nilai){
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

    return $hasil; #$kelasmax['id_skema'].'|'.max($persen);
  }

  function hasilv2($mbti)
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
    $ss="";
  	foreach ($argmax as $c=>$n) {
  		$persen[$c] = round(($n/$jumlah)*100,4);
  		$hasil .= "Presentase P(Y=".$nama_kelas[$c].") = ".$persen[$c]."%<br>";
      $ss .= $nama_kelas[$c].":".$persen[$c].",";
  	}
    $ss = rtrim($ss,", ");
  	$max = array_keys($argmax,max($argmax));
  	$query_kelasmax = $this->db->query("SELECT * from mbti_kelas where id_mbti_kelas='".$max[0]."'");
    $query_mbtimax = $this->db->query("SELECT tipe_mbti from mbti where tipe_mbti='".$mbti."'");
  	$kelasmax = $query_kelasmax->row_array();$mbtimax = $query_mbtimax->row_array();
    $hasil .= "<br>Kesimpulannya adalah jika MBTI = <strong>".$mbtimax['tipe_mbti']."</strong>,
    maka Posisi yang Tepat yaitu <strong>".$kelasmax['nama_kelas']."</strong> dengan Presentase <strong>"
    .max($persen)."%</strong>.<br>catatan: dihitung dan dibandingkan dengan keseluruhan posisi.";

    return $hasil;//$kelasmax['id_mbti_kelas'].'|'.max($persen).'|'.$ss;
  }

  function hasilKBK($unit,$nilai)
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

    return $hasil;//$kelasmax['id_mbti_kelas'].'|'.max($persen).'|'.$ss;
  }
}
