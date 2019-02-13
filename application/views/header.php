<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title><?php if($title){ echo $title; } ?></title>
		<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
		<link rel="shortcut icon" href="<?php echo base_url();?>assets/img/logo.png">
		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/daterangepicker-bs3.css">
		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css">
		<link rel="stylesheet" href="<?php echo base_url();?>assets/iCheck/all.css">
		<link rel="stylesheet" href="<?php echo base_url();?>assets/select2/select2.min.css">
		<link href="<?php echo base_url();?>assets/css/font-awesome.min.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
		<link href="<?php echo base_url();?>assets/css/dataTables.bootstrap.min.css"/>
		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/AdminLTE.min.css">
		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/skin-blue-light.min.css">
		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/style.css" type="text/css" media="screen"/>
		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/pace.min.css">
		<link href="<?php echo base_url(); ?>assets/css/bootstrap-fileupload.min.css" rel="stylesheet" />
		<?php $jquery= ($this->uri->segment(2) == "kompetensi")?'jQuery-2.1.4':'jquery-3.1.0'; ?>
		<script src="<?php echo base_url(); ?>assets/js/<?php echo $jquery; ?>.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>assets/js/basic.js?rd=<?php echo time();?>"></script>
		<script src="<?php echo base_url(); ?>assets/js/Highcharts/highcharts.js"></script>
		<script src="<?php echo base_url(); ?>assets/js/Highcharts/highcharts-more.js"></script>
		<script src="<?php echo base_url(); ?>assets/js/Highcharts/exporting.js"></script>
		<style>
			input[readonly].rotext{background-color:transparent;border:1;font-size:1em;}
		</style>
		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
				<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
				<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
  <?php
	  if($this->session->userdata('logged_in')){
			$sidebar = ($this->uri->segment(2) != "attempt")?'mini':'collapse';
  ?>
	<body class="hold-transition skin-blue-light fixed sidebar-<?php echo $sidebar;?>">
		<div class="wrapper">
			<header class="main-header">
				<a href="<?php echo site_url('dashboard');?>" class="logo">
					<span class="logo-mini">
						<img class="img-rounded" src="<?php echo base_url();?>assets/img/logo.png" style="height:36px;" title="Logo">
					</span>
					<span class="logo-lg">
						<div class="pull-left"><img class="img-rounded" src="<?php echo base_url();?>assets/img/logo.png" style="height:36px;" title="Logo"></div>
						<b>SPPKTI</b>
					</span>
				</a>
				<nav class="navbar navbar-static-top" role="navigation">
					<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
						<span class="sr-only">Toggle navigation</span>
					</a>
					<div class="navbar-custom-menu">
						<ul class="nav navbar-nav">
							<li class="dropdown user user-menu">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									<img class="user-image" src="<?php echo base_url();?>assets/img/logo.png" title="Image" alt="User Image">
									<span class="hidden-xs"><?php echo $username;?></span>
								</a>
								<ul class="dropdown-menu">
									<li class="user-header">
										<img class="img-circle" src="<?php echo base_url();?>assets/img/logo.png" title="Image" alt="User Image">
										<p>
											<?php echo $username." - ".$user['first_name']." ".$user['last_name']; ?>
											<small><?php if($user['su']==0){echo $user['group_name'];}
												elseif($user['su']==1){echo "Administrator";}
												elseif($user['su']==2){echo "Pakar SKKNI";}
												elseif($user['su']==3){echo "Pakar MBTI";}?>
											</small>
										</p>
									</li>
									<li class="user-footer">
										<div class="pull-left">
											<a href="<?php echo site_url('users/form/profile');?>" class="btn btn-default btn-flat">Profile</a>
										</div>
										<div class="pull-right">
											<a href="<?php echo site_url('dashboard/logout');?>" class="btn btn-default btn-flat">Sign out</a>
										</div>
									</li>
								</ul>
							</li>
						</ul>
					</div>
				</nav>
			</header>
			<aside class="main-sidebar">
				<section class="sidebar">
					<ul class="sidebar-menu">
						<li><a href="<?php echo site_url('dashboard');?>"  ><i class="fa fa-dashboard fa-fw"></i><span>Dashboard</span></a></li>
						<?php if($user['su']=="1" && $user['gid']=="SPA"){ ?>
						<li class="treeview">
		          <a href="#"><i class="fa fa-users"></i><span>Master Management</span><i class="fa fa-angle-left pull-right"></i></a>
		          <ul class="treeview-menu">
								<li><a href="<?php echo site_url('users');?>" ><i class="fa fa-user fa-fw"></i><span>Users</span></a></li>
								<li><a href="<?php echo site_url('group');?>" ><i class="fa fa-users fa-fw"></i><span>Group</span></a></li>
						  </ul>
						</li>
						<?php }
						if(($user['su']=="1" && $user['gid']=="SPA")||($user['su']=="2" && $user['gid']=="ADM")){ ?>
						<li class="treeview">
		          <a href="#"><i class="fa fa-certificate fa-fw"></i><span>SKKNI Management</span><i class="fa fa-angle-left pull-right"></i></a>
		          <ul class="treeview-menu">
								<li><a href="<?php echo site_url('skkni/unit');?>"  ><i class="fa fa-certificate fa-fw"></i><span>Daftar Unit SKKNI</span></a></li>
								<li><a href="<?php echo site_url('skkni/skema');?>"  ><i class="fa fa-certificate fa-fw"></i><span>Daftar Skema SKKNI</span></a></li>
								<li><a href="<?php echo site_url('skkni/dataset');?>"  ><i class="fa fa-certificate fa-fw"></i><span>Dataset SKKNI</span></a></li>
						  </ul>
						</li>
						<?php }
						if(($user['su']=="1" && $user['gid']=="SPA")||($user['su']=="3" && $user['gid']=="ADM")){ ?>
						<li class="treeview">
		          <a href="#"><i class="fa fa-th-large fa-fw"></i><span>MBTI Management</span><i class="fa fa-angle-left pull-right"></i></a>
		          <ul class="treeview-menu">
								<li><a href="<?php echo site_url('mbti/tipe');?>"  ><i class="fa fa-th-large fa-fw"></i><span>Daftar Tipe MBTI</span></a></li>
								<li><a href="<?php echo site_url('mbti/pernyataan');?>"  ><i class="fa fa-th-large fa-fw"></i><span>Daftar Pernyataan MBTI</span></a></li>
								<li><a href="<?php echo site_url('mbti/kelas');?>"  ><i class="fa fa-th-large fa-fw"></i><span>Daftar Kelas MBTI</span></a></li>
								<li><a href="<?php echo site_url('mbti/dataset');?>"  ><i class="fa fa-th-large fa-fw"></i><span>Dataset MBTI</span></a></li>
						  </ul>
						</li>
						<?php }
						if(($user['su']=="1" && $user['gid']=="SPA")||($user['su']=="2" && $user['gid']=="ADM")){ ?>
						<li><a href="<?php echo site_url('rule');?>" ><i class="fa fa-chain fa-fw"></i><span>Rule Pengetahuan</span></a></li>
						<?php }
						if($user['su']=="1" && ($user['gid']=="SPA" || $user['gid']=="ADM")){ ?>
						<li class="treeview">
		          <a href="#"><i class="fa fa-stack-overflow fa-fw"></i><span>Simulasi Management</span><i class="fa fa-angle-left pull-right"></i></a>
		          <ul class="treeview-menu">
								<li><a href="<?php echo site_url('simulasi/soal');?>"  ><i class="fa fa-question fa-fw"></i><span>Daftar Soal</span></a></li>
								<li><a href="<?php echo site_url('simulasi/ujian');?>" ><i class="fa fa-check fa-fw"></i><span>Ujian Simulasi</span></a></li>
						  </ul>
						</li>
						<?php }
						if($user['su']=="0"){ ?>
						<li><a href="<?php echo site_url('konsultasi');?>" ><i class="fa fa-certificate fa-fw"></i><span>Konsultasi</span></a></li>
						<?php }
						if($user['su']=="0"){ ?>
						<li><a href="<?php echo site_url('simulasi');?>" ><i class="fa fa-check fa-fw"></i><span>Ujian Simulasi</span></a></li>
						<?php } ?>
						<li>
							<a href="<?php echo ($user['su']=="0")?site_url('result/user'):site_url('result');?>"  ><i class="fa fa-line-chart fa-fw"></i><span>Daftar Hasil Konsultasi</span></a>
							<?php /*if($user['su']=="1" && $user['gid']=="SPA"){ ?>
							<a href="#"><i class="fa fa-line-chart fa-fw"></i><span>Hasil</span><i class="fa fa-angle-left pull-right"></i></a>
							<ul class="treeview-menu">
								<li><a href="<?php echo site_url('result/');?>"  ><i class="fa fa-circle-o fa-fw"></i><span>Simulasi</span></a></li>
								<li><a href="<?php echo site_url('result/konsultasi');?>" ><i class="fa fa-circle-o fa-fw"></i><span>Konsultasi</span></a></li>
						  </ul>
							<?php }elseif($user['su']=="0"){ ?>
							<a href="<?php echo site_url('result/user');?>"  ><i class="fa fa-line-chart fa-fw"></i><span>Daftar Hasil Konsultasi</span></a>
							<?php }	*/?>
						</li>
					</ul>
				</section>
			</aside>
			<div class="content-wrapper">
				<section class="content">
	<?php } ?>
