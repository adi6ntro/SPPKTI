<?php
Class Login_model extends CI_Model
{
  function login($username, $password){
    $que = "SELECT * FROM users
            WHERE (username = ".$this->db->escape($username)." OR email = ".$this->db->escape($username).")
            AND password = ".$this->db->escape($password)." ORDER BY id DESC LIMIT 1";
		$query = $this->db->query($que);
		if($query -> num_rows() == 1){
      $this->db->where('username', $username);
  		$this->db->update('users', array('last_login' => date('Y-m-d H:i:s')));
			return $query->result();
		}else{
			return false;
		}
	}

  function register_user(){
		$insert_data = array(
			'username' => $this->input->post('username'),
			'password' => md5($this->input->post('user_password')),
			'first_name' => ucwords($this->input->post('first_name')),
			'last_name' => ucwords($this->input->post('last_name')),
			'email' => $this->input->post('user_email'),
			'gid' => $this->input->post('user_group'),
      'prop' => $this->input->post('prop'),
			'su' => '0',
      'date_created' => date('Y-m-d H:i:s')
		);
		if($this->db->insert('users',$insert_data)){
			return "Account Registered successfully";
		}else{
			return "Unable to register";
		}
	}

  function reset_password($toemail){
		$this->db->where("email",$toemail);
		$queryr=$this->db->get('users');
		$userInfo = $queryr->row();
		if($queryr->num_rows() != "1"){
			return "0";
		}
		//build token
		$token = $this->insertToken($userInfo->id);
		$url = site_url() . 'reset_password/token/' . $token;
		$link = '<a href="' . $url . '">' . $url . '</a>';
		$message = '';
		$message .= '<strong>Hai, Anda menerima email ini karena ada permintaan untuk memperbaharui
		password anda.</strong><br>';
		$message .= '<strong>Silakan klik link ini:</strong> ' . $link;

		$fromemail="adiguntoro30@gmail.com";
		$fromname="Admin SPPKTI";
		$subject="Password Changed";
		$this->load->helper('email');
		$config = array(
			'protocol'  => 'smtp',
      'smtp_host' => 'ssl://smtp.gmail.com',
      'smtp_port' => 465,
      'smtp_user' => 'adiguntoro30@gmail.com',
      'smtp_pass' => 'google12345oke',
			'mailtype'  => 'html',
      'charset'	=> 'utf-8',
      'wordwrap'	=> TRUE
		);
		$this->load->library('email', $config);
    $this->email->set_newline("\r\n");
		$this->email->from($fromemail, $fromname);
		$this->email->to($toemail);
		$this->email->subject($subject);
		$this->email->message($message);
		if(!$this->email->send()){
			return "Mailer Error. Slahkan klik link ini, ".$link;
		}else{
			return "Password reset and an email sent with new password!";
		}
	}

  public function insertToken($user_id){
		$token = substr(sha1(rand()), 0, 30);
		$date = date('Y-m-d');
		$string = array(
      'token'=> $token,
			'user_id'=>$user_id,
			'created'=>$date
		);
    $query = $this->db->insert_string('tokens',$string);
		$this->db->query($query);
		$data = $token . $user_id;
		return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
	}

	public function isTokenValid($data)  {
		$token = base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
		$tkn = substr($token,0,30);
		$uid = substr($token,30);
    $q = $this->db->get_where('tokens', array(
			'token' => $tkn,
			'user_id' => $uid), 1);
		if($this->db->affected_rows() > 0){
			$row = $q->row();
			$created = $row->created;
			$createdTS = strtotime($created);
			$today = date('Y-m-d');
			$todayTS = strtotime($today);
			if($createdTS != $todayTS){
				return false;
			}
			$user_info = $this->getUserInfo($row->user_id);
			return $user_info;
		}else{
			return false;
		}
	}

  public function getUserInfo($id){
    $q = $this->db->get_where('users', array('id' => $id), 1);
		if($this->db->affected_rows() > 0){
			$row = $q->row();
			return $row;
		}else{
			error_log('no user found getUserInfo('.$id.')');
			return false;
		}
	}

  public function updatePassword($post){
    $this->db->delete('tokens', array('user_id' => $post));
		$this->db->where('id', $post);
		$this->db->update('users', array('password' => md5($this->input->post('user_password'))));
		return true;
	}

  function kirim_email_mbti($toemail,$nama,$mbti){
    switch ($mbti) {
    	case "ISTP":
    		$mbti_hasil = '<div class="row" id="ISTP">
    	<div class="col-lg-8 col-lg-offset-2">
    		<h2 class="text-center">ISTP</h2>
    		<hr class="star-primary">
    		<h3>Dikenal Sebagai</h3>
    		<p>"The Mechanics" (Mekanik) &amp; "Crafter" (Pengrajin) </p>
    		<h3>Penjelasan Singkat</h3>
    		<p>Bersikap toleran, dan fleksibel, pengamat yang tenang sampai masalah tampak, kemudian bertindak cepat untuk menemukan solusi yang terbaik. Menganalisis apa yang membuat sesuatu bekerja, dan mampu dengan segera menemukan berbagai data untuk mengisolasi inti dari masalah. Tertarik dengan sebab dan akibat, mengolah fakta menggunakan prinsip masuk akal, dan efisien.</p>
    		<h3>Ciri-ciri</h3>
    		<ul>
    			<li>Tenang, pendiam, cenderung kaku, dingin, hati-hati, penuh pertimbangan.</li>
    			<li>Logis, rasional, kritis, obyektif, mampu mengesampingkan perasaan.</li>
    			<li>Mampu menghadapi perubahan mendadak dengan cepat dan tenang.</li>
    			<li>Percaya diri, tegas dan mampu menghadapi perbedaan maupun kritik.</li>
    			<li>Mampu menganalisa, mengorganisir, &amp; mendelegasikan.</li>
    			<li>Problem solver yang baik terutama untuk masalah teknis &amp; keadaan mendadak.</li>
    		</ul>
    		<h3>Saran Pengembangan</h3>
    		<ul>
    			<li>Observasilah kehidupan sosial, apa yang membuat orang marah, cinta, senang, termotivasi &amp; terapkan pada hubungan Anda.</li>
    			<li>Belajarlah untuk mengenali perasaan Anda dan mengekspresikannya.</li>
    			<li>Jadilah orang yang lebih terbuka, keluar dari zona nyaman, eksplorasi ide baru, dan berdiskusi dengan orang lain.</li>
    			<li>Jangan mencari-cari kesalahan orang hanya untuk menyelesaikan masalahnya.</li>
    			<li>Jangan menyimpan informasi yang harusnya dibagi dan belajarlah mempercayakan tanggungjawab pada orang lain.</li>
    		</ul>
    		<h3>Profesi yang Cocok</h3>
    		<p>Polisi, Ahli Forensik, Programmer, Ahli Komputer, System Analyst, Teknisi, Insinyur, Mekanik, Pilot, Atlit, Entrepreneur</p>
    		<h3>Partner Alami</h3>
    		<p>ESTJ atau ENTJ</p>
    		<h3>Tokoh Terkenal dengan Kepribadian ISTP</h3>
    		<ul>
    			<li>Tom Cruise, actor</li>
    			<li>Keith Richards, musician</li>
    			<li>James Dean, actor</li>
    			<li>Clint Eastwood, actor</li>
    			<li>Zachary Taylor, U.S. President</li>
    			<li>Chuck Yeager, U.S. Air Force officer</li>
    			<li>Alan Shepherd, astronaut</li>
    			<li>Amelia Earhart, aviator</li>
    			<li>Frida Kahlo, artist</li>
    			<li>Tiger Woods, golfer</li>
    		</ul>
    	</div>
    </div>
    ';
    		break;
    	case "ISTJ":
    		$mbti_hasil = '<div class="row" id="ISTJ">
    	<div class="col-lg-8 col-lg-offset-2">
    		<h2 class="text-center">ISTJ</h2>
    		<hr class="star-primary">
    		<h3>Dikenal Sebagai</h3>
    		<p>"The Duty Fulfillers" (Pekerja Keras) &amp; "Inspector" (Pengawas)</p>
    		<h3>Penjelasan Singkat</h3>
    		<p>Tenang, serius, meraih kesuksesannya dengan ketelitian dan kehandalannya dalam bekerja. Praktis, orienatsi pada fakta, realistis, dan bertanggung jawab. Memutuskan apa yang harus dilakukan dengan logis, dan bekerja dengan tekun pada satu hal, tanpa mempedulikan gangguan. Mereka merasa senang dengan segala sesuatu yang tertib dan teratur pada pekerjaan mereka, rumah mereka, dan kehidupan mereka. Memegang nilai-nilai tradisi dan loyalitas.</p>
    		<h3>Ciri-ciri</h3>
    		<ul>
    			<li>Serius, tenang, stabil &amp; damai.</li>
    			<li>Senang pada fakta, logis, obyektif, praktis &amp; realistis.</li>
    			<li>Task oriented, tekun, teratur, menepati janji, dapat diandalkan &amp; bertanggung jawab.</li>
    			<li>Pendengar yang baik, setia, hanya mau berbagi dengan orang dekat.</li>
    			<li>Memegang aturan, standar &amp; prosedur dengan teguh.</li>
    		</ul>
    		<h3>Saran Pengembangan</h3>
    		<ul>
    			<li>Belajarlah memahami perasaan &amp; kebutuhan orang lain.</li>
    			<li>Kurangi keinginan untuk mengontrol orang lain atau memerintah mereka untuk menegakkan aturan.</li>
    			<li>Lihatlah lebih banyak sisi positif pada orang lain atau hal lainnya.</li>
    			<li>Terbukalah terhadap perubahan.</li>
    		</ul>
    		<h3>Profesi yang Cocok</h3>
    		<p>Bidang Manajemen, Polisi, Intelijen, Hakim, Pengacara, Dokter, Akuntan (Staf Keuangan), Programmer atau yang berhubungan dengan IT, System Analys, Pemimpin Militer</p>
    		<h3>Partner Alami</h3>
    		<p>ESFP atau ESTP</p>
    		<h3>Tokoh Terkenal dengan Kepribadian ISTJ</h3>
    		<ul>
    			<li>George Washington, U.S. President</li>
    			<li>Henry Ford, inventor</li>
    			<li>Johnny Carson, entertainer</li>
    			<li>Elizabeth II, Queen of England</li>
    			<li>Calvin Coolidge, U.S. President</li>
    			<li>Evander Holyfield, boxer</li>
    			<li>Warren Buffett, businessman</li>
    		</ul>
    	</div>
    </div>
    ';
    		break;
    	case "ISFP":
    		$mbti_hasil = '<div class="row" id="ISFP">
    	<div class="col-lg-8 col-lg-offset-2">
    		<h2 class="text-center">ISFP</h2>
    		<hr class="star-primary">
    		<h3>Dikenal Sebagai</h3>
    		<p>"The Artist" (Seniman) &amp; "Composer" (Pengarang)</p>
    		<h3>Penjelasan Singkat</h3>
    		<p>Tenang, ramah, sensitif, dan baik hati. Menikmati apa yang sedang terjadi saat ini, apa yang terjadi di sekitar mereka. Ingin memiliki ruang mereka sendiri dan bekerja dalam rentang waktu mereka sendiri. Loyal dan berkomitmen untuk prinsip yang mereka genggam serta orang-orang yang penting bagi mereka. Tidak menyukai perselisihan dan konflik, tidak memaksakan pendapat atau prinsip mereka pada orang lain.</p>
    		<h3>Ciri-ciri</h3>
    		<ul>
    			<li>Berpikiran simpel &amp; praktis, fleksibel, sensitif, ramah, tidak menonjolkan diri, rendah hati pada kemampuannya.</li>
    			<li>Menghindari konflik, tidak memaksakan pendapat atau nilai-nilainya pada orang lain.</li>
    			<li>Biasanya tidak mau memimpin tetapi menjadi pengikut dan pelaksana yang setia.</li>
    			<li>Seringkali santai menyelesaikan sesuatu, karena sangat menikmati apa yang terjadi saat ini.</li>
    			<li>Menunjukkan perhatian lebih banyak melalui tindakan dibandingkan kata-kata.</li>
    		</ul>
    		<h3>Saran Pengembangan</h3>
    		<ul>
    			<li>Jangan takut pada penolakan dan konflik. Anda tidak perlu menyenangkan semua orang.</li>
    			<li>Cobalah untuk mulai memikirkan dampak jangka panjang dari keputusan-keputusan kecil di hari ini.</li>
    			<li>Asah dan kembangkan sisi kreatifitas dan seni dalam diri Anda sebagai modal bagus dalam diri Anda.</li>
    			<li>Cobalah untuk lebih terbuka dan mengekspresikan perasaan Anda.</li>
    		</ul>
    		<h3>Profesi yang Cocok</h3>
    		<p>Seniman, Designer, Pekerja Sosial, Konselor, Psikolog, Guru, Aktor, Bidang Hospitality</p>
    		<h3>Partner Alami</h3>
    		<p>ESFJ atau ENFJ</p>
    		<h3>Tokoh Terkenal dengan Kepribadian ISFP</h3>
    		<ul>
    			<li>Fred Astaire, dancer</li>
    			<li>Marilyn Monroe, actress</li>
    			<li>Marie Antoinette, queen of France</li>
    			<li>Elizabeth Taylor, actress</li>
    			<li>Barbara Streisand, singer</li>
    			<li>Paul McCartney, musician</li>
    			<li>Auguste Rodin, sculptor</li>
    			<li>Wolfgang Amadeus Mozart, composer</li>
    		</ul>
    	</div>
    </div>
    ';
    		break;
    	case "ISFJ":
    		$mbti_hasil = '<div class="row" id="ISFJ">
    	<div class="col-lg-8 col-lg-offset-2">
    		<h2 class="text-center">ISFJ</h2>
    		<hr class="star-primary">
    		<h3>Dikenal Sebagai</h3>
    		<p>"The Nurturers" (Pengasuh) &amp; "Protector" (Pelindung)</p>
    		<h3>Penjelasan Singkat</h3>
    		<p>Tenang, ramah, bertanggung jawab, dan teliti. Berkomitmen dan bersungguh-sungguh dalam memenuhi kewajibannya. Cermat, telaten, dan akurat. Loyal, baik hati, perhatian dan selalu mengingat secara spesifik tentang orang-orang yang penting bagi mereka, peduli dengan perasaan orang lain. Berupaya untuk menciptakan lingkungan yang tertib dan harmonis di tempat kerja maupun di rumah.</p>
    		<h3>Ciri-ciri</h3>
    		<ul>
    			<li>Penuh pertimbangan, hati-hati, teliti dan akurat.</li>
    			<li>Serius, tenang, stabil namun sensitif.</li>
    			<li>Ramah, perhatian pada perasaan &amp; kebutuhan orang lain, setia, kooperatif, pendengar yang baik.</li>
    			<li>Punya kemampuan mengorganisasi, detail, teliti, sangat bertanggungjawab &amp; bisa diandalkan.</li>
    		</ul>
    		<h3>Saran Pengembangan</h3>
    		<ul>
    			<li>Lihat lebih dalam, lebih antusias, &amp; lebih semangat.</li>
    			<li>Belajarlah mengatakan ?tidak?. Jangan menyenangkan semua orang atau Anda dianggap plin plan.</li>
    			<li>Jangan terjebak zona nyaman dan rutinitas. Cobalah hal baru. Ada banyak hal menyenangkan yang mungkin belum pernah Anda coba.</li>
    		</ul>
    		<h3>Profesi yang Cocok</h3>
    		<p>Architect, Interior Designer, Perawat, Administratif, Designer, Child Care, Konselor, Back Office Manager, Penjaga Toko / Perpustakaan, Dunia Perhotelan.</p>
    		<h3>Partner Alami</h3>
    		<p>ESFP atau ESTP</p>
    		<h3>Tokoh Terkenal dengan Kepribadian ISFJ</h3>
    		<ul>
    			<li>Mother Teresa, nun and humanitarian</li>
    			<li>Louisa May Alcott, author</li>
    			<li>Elizabeth II, Queen of England</li>
    			<li>Robert E. Lee, general</li>
    			<li>Mary I, Queen of England</li>
    			<li>Kristi Yamaguchi, figure skater</li>
    			<li>Michael Caine, actor</li>
    			<li>Alfred, Lord Tennyson, poet</li>
    		</ul>
    	</div>
    </div>
    ';
    		break;
    	case "INTP":
    		$mbti_hasil = '<div class="row" id="INTP">
    	<div class="col-lg-8 col-lg-offset-2">
    		<h2 class="text-center">INTP</h2>
    		<hr class="star-primary">
    		<h3>Dikenal Sebagai</h3>
    		<p>"The Thinkers" (Pemikir) &amp; "Architect" (Arsitek)</p>
    		<h3>Penjelasan Singkat</h3>
    		<p>Berusaha membangun penjelasan yang masuk akal untuk segala sesuatu yang menarik bagi mereka. Teoritis dan abstrak, lebih tertarik pada ide-ide daripada interaksi sosial. Tenang, cerdas, fleksibel, dan mudah beradaptasi. Memiliki kemampuan yang tidak biasa untuk fokus dan mendalami pemecahan masalah pada bidang yang menjadi minat mereka. Skeptis, terkadang kritis, dan selalu analitis. </p>
    		<h3>Ciri-ciri</h3>
    		<ul>
    			<li>Sangat menghargai intelektualitas dan pengetahuan. Menikmati hal-hal teoritis dan ilmiah. Senang memecahkan masalah dengan logika dan analisa.</li>
    			<li>Diam dan menahan diri. Lebih suka bekerja sendiri.</li>
    			<li>Cenderung kritis, skeptis, mudah curiga dan pesimis.</li>
    			<li>Tidak suka memimpin dan bisa menjadi pengikut yang tidak banyak menuntut.</li>
    			<li>Cenderung memiliki minat yang jelas. Membutuhkan karir dimana minatnya bisa berkembang dan bermanfaat. Jika menemukan sesuatu yang menarik minatnya, ia akan sangat serius dan antusias menekuninya.</li>
    		</ul>
    		<h3>Saran Pengembangan</h3>
    		<ul>
    			<li>Belajarlah membangun hubungan dengan orang lain. Belajar berempati, mendengar aktif, memberi perhatian dan bertukar pendapat.</li>
    			<li>Relaks. Jangan terlalu banyak berfikir. Nikmati hidup Anda tanpa harus bertanya mengapa dan bagaimana.</li>
    			<li>Cobalah menemukan satu ide, merencanakan dan mewujudkannya. Jangan terlalu sering berganti-ganti ide tetapi tidak satupun yang terwujud.</li>
    		</ul>
    		<h3>Profesi yang Cocok</h3>
    		<p>Ilmuwan, Fotografer, Programmer, Ahli komputer, System Analyst, Penulis Buku Teknis, Ahli Forensik, Jaksa, Pengacara, Teknisi</p>
    		<h3>Partner Alami</h3>
    		<p>ENTJ atau ESTJ</p>
    		<h3>Tokoh Terkenal dengan Kepribadian INTP</h3>
    		<ul>
    			<li>Albert Einstein, scientist</li>
    			<li>Charles Darwin, naturalist</li>
    			<li>William James, psychologist and philosopher</li>
    			<li>Dwight D. Eisenhower, U.S. President</li>
    			<li>C. G. Jung, psychiatrist</li>
    			<li>Socrates, philosopher</li>
    			<li>Sir Isaac Newton, mathematician, physicist and astronomer</li>
    			<li>J.K. Rowling, author</li>
    			<li>Abraham Lincoln, U.S. President</li>
    		</ul>
    	</div>
    </div>
    ';
    		break;
    	case "INTJ":
    		$mbti_hasil = '<div class="row" id="INTJ">
    	<div class="col-lg-8 col-lg-offset-2">
    		<h2 class="text-center">INTJ</h2>
    		<hr class="star-primary">
    		<h3>Dikenal Sebagai</h3>
    		<p>"The Scientists" (Ahli Keilmuan) &amp; "Mastermind" (Pengatur)</p>
    		<h3>Penjelasan Singkat</h3>
    		<p>Memiliki pemikiran yang orisinil dan motivasi yang kuat untuk menerapkan ide-ide mereka hingga mencapai tujuan. Cepat melihat pola dalam peristiwa yang terjadi disekitar mereka, dan mampu menyusun perspektif jangka panjang yang jelas. Bila hendak melakukan sesuatu, ia akan mengorganisir lalu segera melaksanakannya. Sering kali bersifat skeptis namun mandiri, memiliki standar kompetensi dan kinerja yang tinggi untuk diri mereka sendiri maupun orang lain.</p>
    		<h3>Ciri-ciri</h3>
    		<ul>
    			<li>Visioner, punya perencanaan praktis, &amp; biasanya memiliki ide-ide original serta dorongan kuat untuk mencapainya.</li>
    			<li>Mandiri dan percaya diri.</li>
    			<li>Punya kemampuan analisa yang bagus serta menyederhanakan sesuatu yang rumit dan abstrak menjadi sesuatu yang praktis, mudah difahami &amp; dipraktekkan.</li>
    			<li>Skeptis, kritis, logis, menentukan (determinatif) dan kadang keras kepala.</li>
    			<li>Punya keinginan untuk berkembang serta selalu ingin lebih maju dari orang lain.</li>
    			<li>Kritik &amp; konflik tidak menjadi masalah berarti.</li>
    		</ul>
    		<h3>Saran Pengembangan</h3>
    		<ul>
    			<li>Belajarlah mengungkapkan emosi &amp; perasaan Anda.</li>
    			<li>Cobalah untuk lebih terbuka pada dunia luar, banyak bergaul, banyak belajar, banyak membaca, mengunjungi banyak tempat, eksplorasi hal baru, &amp; memperluas wawasan.</li>
    			<li>Hindari perdebatan tidak penting.</li>
    			<li>Belajarlah untuk berempati, memberi perhatian dan lebih peka terhadap orang lain.</li>
    		</ul>
    		<h3>Profesi yang Cocok</h3>
    		<p>Peneliti, Ilmuwan, Insinyur, Teknisi, Pengajar, Profesor, Dokter, Research &amp; Development, Business Analyst, System Analyst, Pengacara, Hakim, Programmers, Posisi Strategis dalam organisasi.</p>
    		<h3>Partner Alami</h3>
    		<p>ENFP atau ENTP</p>
    		<h3>Tokoh Terkenal dengan Kepribadian INTJ</h3>
    		<ul>
    			<li>Thomas Jefferson, U.S. President</li>
    			<li>John F. Kennedy, U.S. President</li>
    			<li>C. S. Lewis, author</li>
    			<li>Jane Austen, author</li>
    			<li>Susan B. Anthony, civil rights leader</li>
    			<li>Arthur Ashe, tennis player</li>
    			<li>Emily Bronte, author</li>
    		</ul>
    	</div>
    </div>
    ';
    		break;
    	case "INFP":
    		$mbti_hasil = '<div class="row" id="INFP">
    	<div class="col-lg-8 col-lg-offset-2">
    		<h2 class="text-center">INFP</h2>
    		<hr class="star-primary">
    		<h3>Dikenal Sebagai</h3>
    		<p>"The Idealist" (Idealis) &amp; "Healer" (Penyembuh)</p>
    		<h3>Penjelasan Singkat</h3>
    		<p>Idealis, setia kepada prinsip yang mereka genggam serta orang-orang yang penting bagi mereka. Ingin kehidupan yang selaras dengan prinsip yang mereka genggam. Ingin tahu, mudah untuk melihat kemungkinan, bisa menjadi pemicu untuk memulai mewujudkan ide-ide. Berusaha untuk memahami orang lain, dan membantu mereka untuk mencapai potensi mereka. Mudah beradaptasi, fleksibel, dan mudah menerima, kecuali jika itu bertentangan dengan prinsip-prinsip mereka.</p>
    		<h3>Ciri-ciri</h3>
    		<ul>
    			<li>Sangat perhatian dan peka dengan perasaan orang lain.</li>
    			<li>Penuh dengan antusiasme dan kesetiaan, tapi biasanya hanya untuk orang dekat.</li>
    			<li>Peduli pada banyak hal. Cenderung mengambil terlalu banyak dan menyelesaikan sebagian.</li>
    			<li>Cenderung idealis dan perfeksionis.</li>
    			<li>Berpikir win-win solution, mempercayai dan mengoptimalkan orang lain.</li>
    		</ul>
    		<h3>Saran Pengembangan</h3>
    		<ul>
    			<li>Belajarlah menghadapi kritik. Jika baik maka kritik itu bisa membangun Anda, namun jika tidak abaikan saja. Jangan ragu pula untuk bertanya dan minta saran.</li>
    			<li>Belajarlah untuk bersikap tegas. Jangan selalu berperasaan dan menyenangkan orang dengan tindakan baik. Bertindak baik itu berbeda dengan bertindak benar.</li>
    			<li>Jangan terlalu menyalahkan diri dan bersikap terlalu keras pada diri sendiri. Kegagalan adalah hal biasa dan semua orang pernah mengalaminya.</li>
    			<li>Jangan terlalu baik pada orang lain tapi melupakan diri sendiri. Anda juga punya tanggungjawab untuk berbuat baik pada diri sendiri.</li>
    		</ul>
    		<h3>Profesi yang Cocok</h3>
    		<p>Penulis, Sastrawan, Konselor, Psikolog, Pengajar, Seniman, Rohaniawan, Bidang Hospitality</p>
    		<h3>Partner Alami</h3>
    		<p>ENFJ atau ESFJ</p>
    		<h3>Tokoh Terkenal dengan Kepribadian INFP</h3>
    		<ul>
    			<li>Aldous Huxley, author</li>
    			<li>Audrey Hepburn, actress</li>
    			<li>Helen Keller, activist and author</li>
    			<li>Isabel Myers Briggs, creator of the Myers-Briggs Type Inventory</li>
    			<li>J. R. R. Tolkien, author</li>
    			<li>Laura Ingalls Wilder, author</li>
    			<li>Princess Diana, Princess of Wales</li>
    			<li>Peter Jackson, filmmaker</li>
    			<li>William Shakespeare, playwright</li>
    		</ul>
    	</div>
    </div>
    ';
    		break;
    	case "INFJ":
    		$mbti_hasil = '<div class="row" id="INFJ">
    	<div class="col-lg-8 col-lg-offset-2">
    		<h2 class="text-center">INFJ</h2>
    		<hr class="star-primary">
    		<h3>Dikenal Sebagai</h3>
    		<p>"The Protectors" (Pelindung) &amp; "Counselor" (Penasihat)</p>
    		<h3>Penjelasan Singkat</h3>
    		<p>Pencari makna dan hubungannya dengan ide-ide, hubungan sosial, dan pekerjaan. Selalu ingin memahami tentang pola pikir orang lain, dan belajar tentang apa yang memotivasi seseorang dalam kehidupan. Seorang yang bersungguh-sungguh dan berkomitmen dengan apa yang mereka kerjakan. Memiliki misi yang jelas tentang bagaimana cara terbaik untuk melayani kepentingan umum. Terorganisir dan Tegas dalam melaksanakan visi mereka.</p>
    		<h3>Ciri-ciri</h3>
    		<ul>
    			<li>Perhatian, empati, sensitif &amp; berkomitmen terhadap sebuah hubungan.</li>
    			<li>Sukses karena ketekunan, originalitas dan keinginan kuat untuk melakukan apa saja yang diperlukan termasuk memberikan yg terbaik dalam pekerjaan.</li>
    			<li>Idealis, perfeksionis, memegang teguh prinsip.</li>
    			<li>Visioner, penuh ide, kreatif, suka merenung dan inspiring.</li>
    			<li>Biasanya diikuti dan dihormati karena kejelasan visi serta dedikasi pada hal-hal baik.</li>
    		</ul>
    		<h3>Saran Pengembangan</h3>
    		<ul>
    			<li>Seimbangkan cara pandang Anda. Jangan hanya melihat sisi negatif &amp; resiko. Namun, lihatlah sisi positif dan peluangnya.</li>
    			<li>Bersabarlah, jangan mudah marah dan menyalahkan orang lain atau situasi.</li>
    			<li>Rileks dan jangan terus menerus berfikir atau menyelesaikan tanggungjawab.</li>
    		</ul>
    		<h3>Profesi yang Cocok</h3>
    		<p>Pengajar, Psikolog, Dokter, Konselor, Pekerja Sosial, Fotografer, Seniman, Designer, Child Care.</p>
    		<h3>Partner Alami</h3>
    		<p>ESFP atau ESTP</p>
    		<h3>Tokoh Terkenal dengan Kepribadian INFJ</h3>
    		<ul>
    			<li>Billy Crystal, actor</li>
    			<li>Plato, Tokoh Filsafat Yunani</li>
    			<li>Carl Gustav Jung, Psychiatrist</li>
    			<li>Niels Bohr, Physicist</li>
    			<li>Mary Wollstonecraft, Philosopher</li>
    			<li>Adolf Hitler, Nazi</li>
    			<li>George Harrison(The Beatles)</li>
    			<li>Chaucer, poet</li>
    			<li>Gillian Anderson, actress</li>
    			<li>Nathaniel Hawthorne, author</li>
    			<li>Robert Burns, poet</li>
    			<li>Nicole Kidman, actress</li>
    			<li>Nelson Mandela, former President of South Africa</li>
    			<li>Johann Wolfgang von Goethe, writer</li>
    			<li>Robert Burns, poet</li>
    			<li>Martin Luther King, Jr., civil rights leader</li>
    		</ul>
    	</div>
    </div>
    ';
    		break;
    	case "ESTP":
    		$mbti_hasil = '<div class="row" id="ESTP">
    	<div class="col-lg-8 col-lg-offset-2">
    		<h2 class="text-center">ESTP</h2>
    		<hr class="star-primary">
    		<h3>Dikenal Sebagai</h3>
    		<p>"The Doers" (Pelaku) &amp; "Promoter" (Promotor)</p>
    		<h3>Penjelasan Singkat</h3>
    		<p>Fleksibel dan Toleran, mereka mengambil pendekatan praktis yang berfokus pada hasil yang langsung. Teori dan penjelasan konseptual membosankan bagi mereka ? mereka biasanya bertindak energik untuk memecahkan masalah. Berfokus pada dimana mereka saat ini, dan sekarang, bersifat sponta, menikmati saat-saat dimana mereka bisa aktif berinteraksi dengan orang lain. Menikmati kenyamanan material dan gaya. Mereka belajar sangat baik belajar dengan melakukan sesuatu.</p>
    		<h3>Ciri-ciri</h3>
    		<ul>
    			<li>Spontan, Aktif, Enerjik, Cekatan, Cepat, Sigap, Antusias, Fun dan penuh variasi.</li>
    			<li>Komunikator, asertif, to the point, ceplas-ceplos, berkarisma, punya interpersonal skill yang baik.</li>
    			<li>Baik dalam pemecahan masalah langsung di tempat. Mampu menghadapi masalah, konflik dan kritik. Tidak khawatir, menikmati apapun yang terjadi.</li>
    			<li>Cenderung untuk menyukai sesuatu yang mekanistis, kegiatan bersama dan olahraga.</li>
    			<li>Mudah beradaptasi, toleran, pada umumnya konservatif tentang nilai-nilai. Tidak suka penjelasan terlalu panjang. Paling baik dalam hal-hal nyata yang dapat dilakukan.</li>
    		</ul>
    		<h3>Saran Pengembangan</h3>
    		<ul>
    			<li>Belajarlah memahami perasaan dan pemikiran orang lain terutama saat bicara dengan mereka.</li>
    			<li>Belajarlah untuk sabar, menikmati proses, tidak semua hal bisa dicapai dengan cepat.</li>
    			<li>Sesekali luangkan waktu untuk merenung dan merencanakan masa depan Anda.</li>
    			<li>Cobalah untuk mencatat pengamatan-pengamatan Anda termasuk detailnya.</li>
    		</ul>
    		<h3>Profesi yang Cocok</h3>
    		<p>Marketing, Sales, Polisi, Entrepreneur, Pialang Saham, Technical Support</p>
    		<h3>Partner Alami</h3>
    		<p>ISFJ atau ISTJ</p>
    		<h3>Tokoh Terkenal dengan Kepribadian ESTP</h3>
    		<ul>
    			<li>James Buchanan, U.S. President</li>
    			<li>Madonna, singer</li>
    			<li>Chuck Yeager, U.S. Air Force General and pilot</li>
    			<li>Donald Trump, businessman</li>
    			<li>Lucille Ball, actress</li>
    		</ul>
    	</div>
    </div>
    ';
    		break;
    	case "ESTJ":
    		$mbti_hasil = '<div class="row" id="ESTJ">
    	<div class="col-lg-8 col-lg-offset-2">
    		<h2 class="text-center">ESTJ</h2>
    		<hr class="star-primary">
    		<h3>Dikenal Sebagai</h3>
    		<p>"The Guardians" (Pelindung) &amp; "Supervisor" (Pengawas)</p>
    		<h3>Penjelasan Singkat</h3>
    		<p>Praktis, realistis, berpegang pada fakta. Tegas, dengan cepat mengimplementasikan keputusan. Untuk menyelesaikan sesuatu mereka mampu mengatur pekerjaan, dan orang lain, terfokus untuk mendapatkan hasil dengan cara yang memungkinkan dan paling efisien. Selalu menjaga detail rutinitas. Memiliki standart logika yang jelas, yang secara sistematis menuntun mereka, dan mereka ingin orang-oranglain juga menggunakan standart logika itu. Terkadang memaksa agar rencana mereka dapat terimplementasikan.</p>
    		<h3>Ciri-ciri</h3>
    		<ul>
    			<li>Praktis, realistis, berpegang pada fakta, dengan dorongan alamiah untuk bisnis dan mekanistis.</li>
    			<li>Sangat sistematis, procedural dan terencana.</li>
    			<li>Disiplin, on time dan pekerja keras.</li>
    			<li>Konservatif dan cenderung kaku.</li>
    			<li>Tidak tertarik pada subject yang tidak berguna baginya, tapi dapat menyesuaikan diri jika diperlukan.</li>
    			<li>Senang mengorganisir sesuatu. Bisa menjadi administrator yang baik jika mereka ingat untuk memperhatikan perasaan dan perspektif orang lain.</li>
    		</ul>
    		<h3>Saran Pengembangan</h3>
    		<ul>
    			<li>Kurangi keinginan untuk mengontrol dan memaksa orang lain.</li>
    			<li>Belajarlah untuk mengontrol emosi dan amarah Anda.</li>
    			<li>Cobalah untuk introspeksi diri dan meluangkan waktu sejenak untuk merenung.</li>
    			<li>Belajarlah untuk lebih sabar dan low profile</li>
    			<li>Belajarlah untuk memahami orang lain.</li>
    		</ul>
    		<h3>Profesi yang Cocok</h3>
    		<p>Militer, Manajer, Polisi, Hakim, Pengacara, Guru, Sales, Auditor, Akuntan, System Analyst</p>
    		<h3>Partner Alami</h3>
    		<p>ISTP atau INTP</p>
    		<h3>Tokoh Terkenal dengan Kepribadian ESTJ</h3>
    		<ul>
    			<li>James Monroe, U.S. President</li>
    			<li>Harry S.Truman, U.S. President</li>
    			<li>George W. Bush, U.S. President</li>
    			<li>Sam Walton, businessman</li>
    			<li>John D. Rockefeller, philanthropist and industrialist</li>
    			<li>Billy Graham, evangelist</li>
    			<li>Bette Davis, actress</li>
    		</ul>
    	</div>
    </div>
    ';
    		break;
    	case "ESFP":
    		$mbti_hasil = '<div class="row" id="ESFP">
    	<div class="col-lg-8 col-lg-offset-2">
    		<h2 class="text-center">ESFP</h2>
    		<hr class="star-primary">
    		<h3>Dikenal Sebagai</h3>
    		<p>"The Performers" (Pemain) &amp; "Performer" (Pemain)</p>
    		<h3>Penjelasan Singkat</h3>
    		<p>Ramah, bersahabat, dan menerima. Sosok yang mencintai  kehidupan, orang, dan kenyamanan materi. Senang bekerja dengan orang lain dalam menyelesaikan sesuatu. menggunakan akal sehat dan pendekatan realistis dalam pekerjaan, dan menjadikan pekerjaan sebagai sebuah kesenangan. Fleksibel dan spontan, beradaptasi dengan mudah ke orang-orang dan lingkungan baru . Cara belajar terbaik mereka adalah dengan mencoba keterampilan baru bersama orang lain.</p>
    		<h3>Ciri-ciri</h3>
    		<ul>
    			<li>Outgoing, easygoing, mudah berteman, bersahabat, sangat sosial, ramah, hangat, &amp; menyenangkan.</li>
    			<li>Optimis, ceria, antusias, fun, menghibur, suka menjadi perhatian.</li>
    			<li>Punya interpersonal skill yang baik, murah hati, mudah simpatik dan mengenali perasaan orang lain. Menghindari konflik dan menjaga keharmonisan suatu hubungan.</li>
    			<li>Mengetahui apa yang terjadi di sekelilingnya dan ikut serta dalam kegiatan tersebut.</li>
    			<li>Sangat baik dalam keadaan yang membutuhkan common sense, tindakan cepat dan ketrampilan praktis.</li>
    		</ul>
    		<h3>Saran Pengembangan</h3>
    		<ul>
    			<li>Jangan terburu-buru dalam mengambil keputusan. Belajarlah untuk fokus dan tidak mudah berubah-ubah terutama untuk hal yang penting.</li>
    			<li>Jangan menyenangkan semua orang. Begitu pula sebaliknya, tidak semua orang bisa menyenangkan Anda.</li>
    			<li>Belajarlah menghadapi kritik dan konflik. Jangan lari.</li>
    			<li>Anda punya kecenderungan meterialistis. Hati-hati, tidak semua hal bisa diukur dengan materi ataupun uang.</li>
    		</ul>
    		<h3>Profesi yang Cocok</h3>
    		<p>Entertainer, Seniman, Marketing, Konselor, Designer, Tour Guide, Bidang Anak-anak, Bidang Hospitality</p>
    		<h3>Partner Alami</h3>
    		<p>ISTJ atau ISFJ</p>
    		<h3>Tokoh Terkenal dengan Kepribadian ESFP</h3>
    		<ul>
    			<li>Bill Clinton, U.S. President</li>
    			<li>Ronald Reagan, U.S. President</li>
    			<li>Bob Hope, actor</li>
    			<li>Marilyn Monroe, actress</li>
    			<li>Pablo Picasso, artist</li>
    			<li>Woody Harrelson, actor</li>
    			<li>Goldie Hawn, actress</li>
    			<li>Saint Mark, apostle</li>
    		</ul>
    	</div>
    </div>
    ';
    		break;
    	case "ESFJ":
    		$mbti_hasil = '<div class="row" id="ESFJ">
    	<div class="col-lg-8 col-lg-offset-2">
    		<h2 class="text-center">ESFJ</h2>
    		<hr class="star-primary">
    		<h3>Dikenal Sebagai</h3>
    		<p>"The Caregivers" (Pengasuh) &amp; "Provider" (Pemberi)</p>
    		<h3>Penjelasan Singkat</h3>
    		<p>Bersahabat, bersungguh-sungguh, dan dapat bekerja sama. Menginginkan keharmonisan dalam lingkungan mereka, mereka bekerja dengan kebulatan tekad. Senang bekerja dengan orang lain untuk menyelesaikan tugas-tugas dengan teliti, dan tepat waktu. Loyal, melaksanakan tugas hingga hal-hal kecil sekalipun. Memperhatikan apa yang menjadi kebutuhan orang lain dalam keseharian mereka dan, mencoba untuk memenuhi itu semua. Ingin dihargai untuk siapa diri mereka dan segala kontribusi mereka.</p>
    		<h3>Ciri-ciri</h3>
    		<ul>
    			<li>Hangat, banyak bicara, populer, dilahirkan untuk bekerjasama, suportif dan anggota kelompok yang aktif.</li>
    			<li>Membutuhkan keseimbangan dan baik dalam menciptakan harmoni.</li>
    			<li>Selalu melakukan sesuatu yang manis bagi orang lain. Kerja dengan baik dalam situasi yang mendukung dan memujinya.</li>
    			<li>Santai, easy going, sederhana, tidak berfikir panjang.</li>
    			<li>Teliti dan rajin merawat apa yang ia miliki.</li>
    		</ul>
    		<h3>Saran Pengembangan</h3>
    		<ul>
    			<li>Jangan mengorbankan diri hanya untuk menyenangkan orang lain.</li>
    			<li>Jangan mengukur harga diri Anda dari perlakuan, penghargaan dan pujian orang lain.</li>
    			<li>Mintalah pertimbangan orang lain dalam mengambil keputusan. Belajarlah untuk lebih tegas.</li>
    			<li>Terima tanggungjawab hidup dan belajarlah untuk lebih dewasa. Jangan mengasihani diri sendiri.</li>
    			<li>Hadapi kritik dan konflik, jangan lari.</li>
    		</ul>
    		<h3>Profesi yang Cocok</h3>
    		<p> Perencana Keuangan, Perawat, Guru, Bidang anak-anak, Konselor, Administratif, Hospitality</p>
    		<h3>Partner Alami</h3>
    		<p>ISFP atau INFP</p>
    		<h3>Tokoh Terkenal dengan Kepribadian ESFJ</h3>
    		<ul>
    			<li>Terry Bradshaw, football player</li>
    			<li>Sally Field, actress</li>
    			<li>Bill Clinton, U.S. President</li>
    			<li>William McKinley, U.S. President</li>
    			<li>Nancy Kerrigan, figure skater</li>
    		</ul>
    	</div>
    </div>
    ';
    		break;
    	case "ENTP":
    		$mbti_hasil = '<div class="row" id="ENTP">
    	<div class="col-lg-8 col-lg-offset-2">
    		<h2 class="text-center">ENTP</h2>
    		<hr class="star-primary">
    		<h3>Dikenal Sebagai</h3>
    		<p>"The Visionaries" (Visioner) &amp; "Inventor" (Penemu) </p>
    		<h3>Penjelasan Singkat</h3>
    		<p>Cepat, berbakat, pendorong, siaga, and blak-blakan. Sanggup untuk memecahkan masalah yang menantang. Dapat menganalisa kemungkinan secara strategis. Mampu membaca orang lain. Jenuh dengan rutinitas, tidak tertarik melakukan hal yg sama berulang-ulang, lalu mencoba hal yang menarik minatnya. Good at reading other people.</p>
    		<h3>Ciri-ciri</h3>
    		<ul>
    			<li>Gesit, kreatif, inovatif, cerdik, logis, baik dalam banyak hal.</li>
    			<li>Banyak bicara dan punya kemampuan debat yang baik. Bisa berargumentasi untuk senang-senang saja tanpa merasa bersalah.</li>
    			<li>Fleksibel. Punya banyak cara untuk memecahkan masalah dan tantangan.</li>
    			<li>Kurang konsisten. Cenderung untuk melakukan hal baru yang menarik hati setelah melakukan sesuatu yang lain.</li>
    			<li>Punya keinginan kuat untuk mengembangkan diri.</li>
    		</ul>
    		<h3>Saran Pengembangan</h3>
    		<ul>
    			<li>Cobalah untuk win-win solution. Jangan ingin menang sendiri.</li>
    			<li>Belajarlah untuk disiplin dan konsisten.</li>
    			<li>Hindari perdebatan tidak penting.</li>
    			<li>Belajarlah untuk sedikit waspada. Seimbangkan cara pandang Anda agar tidak terlalu optimis dan mengambil resiko yang tidak realistis.</li>
    			<li>Belajarlah untuk memberi perhatian pada perasaan orang lain.</li>
    		</ul>
    		<h3>Profesi yang Cocok</h3>
    		<p>Pengacara, Psikolog, Konsultan, Ilmuwan, Aktor,Marketing, Programmer, Fotografer</p>
    		<h3>Partner Alami</h3>
    		<p>INFJ atau INTJ</p>
    		<h3>Tokoh Terkenal dengan Kepribadian ENTP</h3>
    		<ul>
    			<li>Thomas Edison, inventor</li>
    			<li>John Adams, U.S. president</li>
    			<li>Theodore Roosevelt, U.S. president</li>
    			<li>Alexander the Great, king and military leader</li>
    			<li>Lewis Carroll, author</li>
    			<li>Julia Child, cook</li>
    			<li>Alfred Hitchcock, director</li>
    			<li>Walt Disney, filmmaker</li>
    		</ul>
    	</div>
    </div>
    ';
    		break;
    	case "ENTJ":
    		$mbti_hasil = '<div class="row" id="ENTJ">
    	<div class="col-lg-8 col-lg-offset-2">
    		<h2 class="text-center">ENTJ</h2>
    		<hr class="star-primary">
    		<h3>Dikenal Sebagai</h3>
    		<p>"The Executives" (Pelaksana) &amp; "Fieldmarshal" (Panglima)</p>
    		<h3>Penjelasan Singkat</h3>
    		<p>Berterus terang, menentukan, siap memikul kepemimpinan. Dengan mudah melihat prosedur atau kebijakan yang tidak efisien dan tidak logis, mampu mengembangkan dan mengimplementasikan sistem yang luas untuk menyelesaikan masalah-masalah organisasi. Menyukai rencana jangka panjang, dan penetappan tujuan. Biasanya berpengetahuan luas, pembaca yang baik, senang mengembangkan pengetahuan mereka dan menyampaikannya kepada orang lain. Terkadang memaksa dalam menyajikan ide-ide mereka.</p>
    		<h3>Ciri-ciri</h3>
    		<ul>
    			<li>Tegas, asertif, to the point, jujur terus terang, obyektif, kritis, &amp; punya standard tinggi.</li>
    			<li>Dominan, kuat kemauannya, perfeksionis dan kompetitif.</li>
    			<li>Tangguh, disiplin, dan sangat menghargai komitmen.</li>
    			<li>Cenderung menutupi perasaan dan menyembunyikan kelemahan.</li>
    			<li>Berkarisma, komunikasi baik, mampu menggerakkan orang.</li>
    			<li>Berbakat pemimpin.</li>
    		</ul>
    		<h3>Saran Pengembangan</h3>
    		<ul>
    		<li>Belajarlah untuk relaks. Tidak perlu perfeksionis dan selalu kompetitif dengan semua orang.</li>
    		<li>Ungkapkan perasaan Anda. Menyatakan perasaan bukanlah kelemahan.</li>
    		<li>Belajarlah mengelola emosi Anda. Jangan mudah marah.</li>
    		<li>Belajarlah untuk menghargai dan mengapresiasi orang lain.</li>
    		<li>Jangan terlalu arogan dan menganggap remeh orang lain. Lihat sisi positifnya. Jangan hanya melihat benar dan salah saja.Berkarisma, komunikasi baik, mampu menggerakkan orang.</li>
    		</ul>
    		<h3>Profesi yang Cocok</h3>
    		<p>Entrepreneur, Pengacara, Hakim, Konsultan, Pemimpin Organisasi, Business analyst, Bidang Finansial</p>
    		<h3>Partner Alami</h3>
    		<p>INTP atau ISTP</p>
    		<h3>Tokoh Terkenal dengan Kepribadian ENTJ</h3>
    		<ul>
    			<li>Aristoteles (Tokoh Filsafat Yunani)</li>
    			<li>Margaret Thatcher, former British Prime Minister</li>
    			<li>Franklin D. Roosevelt, former U.S. President</li>
    			<li>Candace Bergen, actress</li>
    			<li>Al Gore, former U.S. Vice President</li>
    			<li>Harrison Ford, actor</li>
    			<li>David Letterman, television host</li>
    			<li>Richard M. Nixon, former U.S. President</li>
    			<li>Patrick Stewart, actor</li>
    		</ul>
    	</div>
    </div>
    ';
    		break;
    	case "ENFP":
    		$mbti_hasil = '<div class="row" id="ENFP">
    	<div class="col-lg-8 col-lg-offset-2">
    		<h2 class="text-center">ENFP</h2>
    		<hr class="star-primary">
    		<h3>Dikenal Sebagai</h3>
    		<p>"The Inspirers" (Penjiwa) &amp; "Champion" (Juara)</p>
    		<h3>Penjelasan Singkat</h3>
    		<p>Sosok hangat yang memiliki ansuiasme dan imaginatif. Melihat kehidupan sebagai sesuatu yang penuh kemungkinan. Mampu memahami hubungan antara kejadian dan informasi dengan sangat mudah, dan percaya diri melakukan sesuatu berdasarkan pola yang mereka lihat. Menginginkan banyak pengakuan dari orang lain, dan siap memberikan apresiasi dan dukungan. Spontan dan fleksibel, seringkali mengandalkan kemampuan mereka dalam berimprovisasi dan kefasihan lisan mereka.</p>
    		<h3>Ciri-ciri</h3>
    		<ul>
    			<li>Ramah, hangat, enerjik, optimis, antusias, semangat tinggi, fun.</li>
    			<li>Imaginatif, penuh ide, kreatif, inovatif.</li>
    			<li>Pandai berkomunikasi, senang bersosialisasi &amp; membawa suasana positif.</li>
    			<li>Mudah membaca perasaan dan kebutuhan orang lain.</li>
    		</ul>
    		<h3>Saran Pengembangan</h3>
    		<ul>
    			<li>Belajarlah untuk fokus, disiplin, tegas dan konsisten</li>
    			<li>Belajarlah untuk menghadapi konflik dan kritik.</li>
    			<li>Pikirkan kebutuhan diri sendiri. Jangan melupakannya karena terlalu peduli pada kebutuhan orang lain.</li>
    			<li>Jangan terlalu boros. Belajarlah untuk mengelola keuangan sedikit demi sedikit.</li>
    		</ul>
    		<h3>Profesi yang Cocok</h3>
    		<p>Konselor, Psikolog, Entertainer, Pengajar, Motivator, Presenter, Reporter, MC, Seniman, Hospitality</p>
    		<h3>Partner Alami</h3>
    		<p>INTJ atau INFJ</p>
    		<h3>Tokoh Terkenal dengan Kepribadian ENFP</h3>
    		<ul>
    			<li>Andy Kaufmann, comedian</li>
    			<li>Bob Dylan, singer/songwriter</li>
    			<li>Charles Dickins, author</li>
    			<li>Dr. Seuss, children?s author</li>
    			<li>Robin Williams, actor</li>
    			<li>Will Smith, actor</li>
    			<li>Charlotte Bronte, author</li>
    		</ul>
    	</div>
    </div>
    ';
    		break;
    	case "ENFJ":
    		$mbti_hasil = '<div class="row" id="ENFJ">
    	<div class="col-lg-8 col-lg-offset-2">
    		<h2 class="text-center">ENFJ</h2>
    		<hr class="star-primary">
    		<h3>Dikenal Sebagai</h3>
    		<p>"The Givers" (Pemberi) &amp; "Teacher" (Pengajar)</p>
    		<h3>Penjelasan Singkat</h3>
    		<p>Bersifat hangat, berempati, pendengar yang baik, dan bertanggung jawab. Sangat menyesuaikan diri dengan emosi, kebutuhan, dan motivasi dari orang lain. Mereka melihat potensi pada setiap orang, dan ingin membantu mereka untuk mencapai potensi mereka. Dapat bertindak sebagai pendorong untuk pertumbuhan individu dan kelompok. Loyal, mau mendengarkan pujian ataupun kritik. Suka bergaul, memudahkan orang lain dalam kelompok mereka, dan menghadirkan kepemimpinan yang bersemangat.</p>
    		<h3>Ciri-ciri</h3>
    		<ul>
    			<li>Kreatif, imajinatif, peka, sensitive, loyal.</li>
    			<li>Pada umumnya peduli pada apa kata orang atau apa yang orang lain inginkan dan cenderung melakukan sesuatu dengan memperhatikan perasaan orang lain.</li>
    			<li>Pandai bergaul, meyakinkan, ramah, fun, populer, simpatik. Responsif pada kritik dan pujian.</li>
    			<li>Menyukai variasi dan tantangan baru.</li>
    			<li>Butuh apresiasi dan penerimaan.</li>
    		</ul>
    		<h3>Saran Pengembangan</h3>
    		<ul>
    			<li>Jangan mengorbankan diri hanya untuk menyenangkan orang lain.</li>
    			<li>Jangan mengukur harga diri Anda dari perlakuan orang lain. Jangan mudah kecewa jika mereka tidak seperti yang Anda inginkan.</li>
    			<li>Belajarlah untuk tegas dan mengambil keputusan. Menghadapi kritik dan konflik.</li>
    			<li>Jangan terlalu bersikap keras terhadap diri sendiri.</li>
    		</ul>
    		<h3>Profesi yang Cocok</h3>
    		<p>Konsultan, Psikolog, Konselor, Pengajar, Marketing, HRD, Event Coordinator, Entertainer, Penulis, Motivator</p>
    		<h3>Partner Alami</h3>
    		<p>INFP atau ISFP</p>
    		<h3>Tokoh Terkenal dengan Kepribadian ENFJ</h3>
    		<ul>
    			<li>Abraham Lincoln, U.S. president</li>
    			<li>Sean Connery, actor</li>
    			<li>Dennis Hopper, actor</li>
    			<li>Diane Sawyer, journalist</li>
    			<li>Johnny Depp, actor</li>
    			<li>Oprah Winfrey, TV personality</li>
    			<li>Abraham Maslow, psychologist</li>
    			<li>Ronald Reagan, U.S. president</li>
    			<li>Peyton Manning, football player</li>
    			<li>Barack Obama, U.S. president</li>
    		</ul>
    	</div>
    </div>';
    		break;
    	default:
    		echo "This is your MBTI";
    		break;
    }

		$message = '<div id=":17b" class="ii gt adP adO">
      <div id=":17w" class="a3s aXjCH m15f437995a97468a">
        <div bgcolor="#fff" style="font-family:Roboto,Helvetica,Arial,sans-serif;margin:0;padding:0;height:100%;width:100%">
          <table border="0" cellpadding="0" cellspacing="0" style="margin:0;text-align:center;background-color:rgb(103,58,183)" width="100%" role="presentation">
            <tbody>
              <tr height="32px"></tr>
              <tr><td><img alt="Google Forms" height="26px" style="display:inline-block;margin:0;vertical-align:middle" width="143px" src="https://ci4.googleusercontent.com/proxy/o6g8V_tptE5foOsmoFUIJUwD5Ij8YfDqFOFxCyk9JhB6fMFdgeNfcFUi7VeO-496vHWo-g27LZXVkycqj4WlQpFCY94k6eIY1wd2IHvhxhHIZPJx95hm5qpvzkWViA=s0-d-e1-ft#https://www.gstatic.com/docs/forms/google_forms_logo_lockup_white_2x.png" class="CToWUd"></td></tr>
              <tr height="16px"></tr>
              <tr><td><div style="color:#fff;font-size:24px;font-weight:400">Here is your response</div></td></tr>
              <tr height="32px"></tr>
            </tbody>
          </table>
          <div style="padding:0 48px" width="100%">
            <table align="center" cellpadding="0" cellspacing="0" style="max-width:528px;min-width:154px" width="100%" role="presentation">
              <tbody>
                <tr height="48px"></tr>
                <tr><td style="color:#333;font-size:20px;font-weight:300">Hi, '.$nama.'</td></tr>
                <tr height="24px"></tr>
                <tr>
                  <td style="color:#333;font-size:13px;font-weight:400">
                    Terima kasih telah berpartisipasi dalam mengisi <a href="https://goo.gl/forms/Esa1XvC9o087cKsp2" target="_blank">Kuisioner Penelitian</a>.<br>
                    Dibawah ini adalah respon pengisian kuisioner Anda.</td>
                </tr>
                <tr height="24px"></tr>
                <tr>
                  <td>
                    <table align="center" cellpadding="0" cellspacing="0" style="max-width:528px;min-width:154px;background-color:#fafafa;padding-left:24px" width="100%" role="presentation">
                      <tbody>
                        <tr height="32px"><td></td></tr>
                        <tr><td>'.$mbti_hasil.'</td></tr>
                        <tr height="48px"></tr>
                      </tbody>
                    </table>
                  </td>
                </tr>
                <tr height="48px"></tr>
                <tr height="24px"><td style="border-top:1px solid #bdbdbd"></td></tr>
                <tr>
                  <td style="text-align:center">
                    <img alt="Google logo" height="24px" src="https://ci6.googleusercontent.com/proxy/nXYhPtgjdmEmfZ9FPIOL_WP6oviDOz09Bvsl8ZXLSnUOR8UxkBOzfAfPkbo-VFomAjyFxBR2lRtpyV9DyeMMNBVa2CQHsXWgkXb8DKc=s0-d-e1-ft#https://www.gstatic.com/classroom/email/google_logo.png" width="71px" class="CToWUd">
                  </td>
                </tr>
                <tr height="8px"></tr>
                <tr>
                  <td style="color:#bcbcbc;font-size:10px;text-align:center">
                    Google Inc.<br><a href="https://maps.google.com/?q=1600+Amphitheatre+Pkwy+Mountain+View,+CA+94043+USA&amp;entry=gmail&amp;source=g">1600 Amphitheatre Pkwy</a>
                    <br><a href="https://maps.google.com/?q=1600+Amphitheatre+Pkwy+Mountain+View,+CA+94043+USA&amp;entry=gmail&amp;source=g">Mountain View, CA 94043 USA</a>
                  </td>
                </tr>
                <tr height="96px"></tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="yj6qo"></div>
    </div>
';

		$fromemail="adiguntoro30@gmail.com";
		$fromname="Adi Guntoro";
		$subject="Respon Pengisian Data Kuisioner";
		$this->load->helper('email');
		$config = array(
			'protocol'  => 'smtp',
      'smtp_host' => 'ssl://smtp.gmail.com',
      'smtp_port' => 465,
      'smtp_user' => 'adiguntoro30@gmail.com',
      'smtp_pass' => 'google12345oke',
			'mailtype'  => 'html',
      'charset'	=> 'utf-8',
      'wordwrap'	=> TRUE
		);
		$this->load->library('email', $config);
    $this->email->set_newline("\r\n");
		$this->email->from($fromemail, $fromname);
		$this->email->to($toemail);
		$this->email->subject($subject);
		$this->email->message($message);
		if(!$this->email->send()){
			return "Mailer Error. Slahkan klik link ini, ".$link;
		}else{
			return "Password reset and an email sent with new password!";
		}
	}
}
