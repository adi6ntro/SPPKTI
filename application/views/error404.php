<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>404 Page Not Found</title>
		<link rel="shortcut icon" href="<?php echo base_url(); ?>assets/img/logo.png"/>
		<link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">
	</head>
	<body>
		<div class="container">
		  <div class="row"  style="padding-top:10%;" >
				<div class="well text-center">
					<h1><font face="Tahoma" color="red">404 Halaman Tidak Ditemukan</font></small></h1>
					<br />
					<p>Maaf halaman yang anda cari tidak ada. Silahkan kembali</p>
					<p><b>Atau kembali ke menu home dengan menekan tombol home</b></p>
					<a href="<?php echo base_url();?>" class="btn btn-large btn-info"><span class="glyphicon glyphicon-home"></span> Take Me Home</a>
				</div>
		  </div>
		</div>
		<script src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
		<script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
	</body>
</html>
