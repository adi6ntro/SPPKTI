<section class="content-header">
  <h1><?php if($title){ echo $title; } ?></h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Konsultasi</li>
  </ol>
</section>
<section class="content">
<div class="row">
  <?php
  if($this->session->flashdata('result')!=''){
    echo "<div class='col-md-12'>
    <div class='alert alert-".$this->session->flashdata('type')." alert-dismissible'>
    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>".
    $this->session->flashdata('result')."</div></div>";
  }
  ?>
  <div class='col-md-12'>
    <div class="callout callout-info">
      <h4>Perhatikan!</h4>
      <p>1. Wajib untuk menyelesaikan konsultasi MBTI dahulu dan hanya dapat diakses 1 kali setelah mendapatkan hasil.<br/>
      2. Konsultasi SKKNI dapat diakses berulang setelah menyelesaikan konsultasi MBTI.<br/>
      3. Simulasi dapat diakses setelah menyelesaikan konsultasi SKKNI dan disesuaikan dengan hasil konsultasi SKKNI terakhir.</p>
    </div>
  </div>
  <div class="colm col-sm-4">
    <div class="thumbnailok">
      <div class="captionok">
        <h4>MBTI - Tes Tipe Kepribadian</h4>
        <p>Tes untuk menentukan kepribadian anda.</p>
        <p>Tes ini hanya dapat diakses satu kali.</p>
        <p><a href="<?php echo site_url('konsultasi/mbti');?>" class="label lg label-default">Mulai Tes</a></p>
      </div>
      <img src="<?php echo base_url()."assets/img/mbti.jpg";?>" width="300" height="300" title="MBTI - Tes Tipe Kepribadian">
    </div>
  </div>
  <div class="colm col-sm-4">
    <div class="thumbnailok">
      <div class="captionok">
        <h4>SKKNI - Tes Kompetensi</h4>
        <p>Tes yang menggunakan standar dari BNSP untuk profesi.</p>
        <p>Tes ini dapat diakses berulang kali.</p>
        <p><a href="<?php echo site_url('konsultasi/kompetensi');?>" class="label lg label-default">Mulai Tes</a></p>
      </div>
      <img src="<?php echo base_url()."assets/img/skkni.jpg";?>" width="300" height="300" title="SKKNI - Tes Kompetensi">
    </div>
  </div>
  <div class="colm col-sm-4">
    <div class="thumbnailok">
      <div class="captionok">
        <h4>Simulasi</h4>
        <p>Simulasi ujian yang memuat soal dengan kompetensi yang telah didapat saat Tes Kompetensi.</p>
        <p>Tes ini hanya dapat diakses sesuai hasil dari Tes Kompetensi.</p>
        <p><a href="<?php echo site_url('simulasi');?>" class="label lg label-default">Mulai Tes</a></p>
      </div>
      <img src="<?php echo base_url()."assets/img/simulasi.png";?>" width="300" height="300" title="Simulasi">
    </div>
  </div>
</div>
<style>
  [class*="colm"] {
    padding-top: 15px; padding-bottom: 15px; background-color: #eee; border: 1px solid #ddd;
    background-color: rgba(86, 61, 124, .15); border: 1px solid rgba(86, 61, 124, .2);
  }
  .thumbnailok { position: relative; overflow: hidden; }
  .captionok {
    position: absolute; top: 0; right: 0; background: rgba(66, 139, 202, 0.75); width: 100%;
    height: 100%; padding: 2%; display: none; text-align: center; color: #fff !important; z-index: 2;
  }
</style>
