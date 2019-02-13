<!DOCTYPE html>
<html lang="en">
  <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="description" content="">
      <meta name="author" content="">
      <title>Sistem Pakar Penentuan Kompetensi Teknologi Informasi</title>
      <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/img/logo.png"/>
      <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">
      <link href="<?php echo base_url(); ?>assets/css/stylish-portfolio.css" rel="stylesheet">
      <link href="<?php echo base_url(); ?>assets/css/font-awesome.min.css" rel="stylesheet" type="text/css">
      <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">
      <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
      <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
      <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
      <![endif]-->
  </head>
  <body>
    <a id="menu-toggle" href="#" class="btn btn-dark btn-lg toggle"><i class="fa fa-bars"></i></a>
    <nav id="sidebar-wrapper">
        <ul class="sidebar-nav">
            <a id="menu-close" href="#" class="btn btn-light btn-lg pull-right toggle"><i class="fa fa-times"></i></a>
            <li class="sidebar-brand"><a href="#top" onclick=$("#menu-close").click();>SPPKTI</a></li>
            <li><a href="#top" onclick=$("#menu-close").click();>Home</a></li>
            <li><a href="#about" onclick=$("#menu-close").click();>Sekilas</a></li>
            <li><a href="#services" onclick=$("#menu-close").click();>Metode yang Digunakan</a></li>
            <li><a href="#portfolio" onclick=$("#menu-close").click();>Skema SKKNI</a></li>
            <li><a href="<?php echo base_url();?>login">Login / Register</a></li>
            <li><a href="#contact" onclick=$("#menu-close").click();>Kontak</a></li>
        </ul>
    </nav>
    <header id="top" class="header">
        <div class="text-vertical-center">
            <h1>SPPKTI</h1>
            <h3>Sistem Pakar Penentuan Kompetensi Teknologi Informasi</h3>
            <br>
            <a href="#about" class="btn btn-dark btn-lg">Find Out More</a>
            <a href="<?php echo base_url();?>login" class="btn btn-dark btn-lg">Login / Register</a>
        </div>
    </header>
    <section id="about" class="about">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2>Sistem pakar untuk menentukan kompetensi yang cocok untuk mahasiswa Teknologi Informasi berdasarkan Standar Kompetensi Kerja Nasional Indonesia (SKKNI) dan tipe kepribadian Myers Briggs Type Indicator (MBTI)</h2>
                </div>
            </div>
        </div>
    </section>
    <section id="services" class="services bg-primary">
        <div class="container">
            <div class="row text-center">
                <div class="col-lg-10 col-lg-offset-1">
                    <h2>Metode yang Digunakan</h2>
                    <hr class="small">
                    <div class="row">
                        <div class="col-md-3 col-sm-6">
                            <div class="service-item">
                                <span class="fa-stack fa-4x">
                                    <i class="fa fa-circle fa-stack-2x"></i>
                                    <i class="fa fa-cloud fa-stack-1x text-primary"></i>
                                </span>
                                <h4><strong>Sistem Pakar</strong></h4>
                                <p>Sistem berisi pengetahuan dari pakar yang dirancang untuk mengambil keputusan, dengan penalaran Forward Chaining.</p>
                                <a href="https://en.wikipedia.org/wiki/Expert_system" target="_blank" class="btn btn-light">Learn More</a>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="service-item">
                                <span class="fa-stack fa-4x">
                                    <i class="fa fa-circle fa-stack-2x"></i>
                                    <i class="fa fa-compass fa-stack-1x text-primary"></i>
                                </span>
                                <h4><strong>SKKNI</strong></h4>
                                <p>Standar kompetensi untuk profesi yang dikeluarkan oleh BNSP. Aplikasi ini menggunakan skema SKKNI pada LSP Telematika.</p>
                                <a href="http://lsp-telematika.or.id/" target="_blank" class="btn btn-light">Learn More</a>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="service-item">
                                <span class="fa-stack fa-4x">
                                    <i class="fa fa-circle fa-stack-2x"></i>
                                    <i class="fa fa-flask fa-stack-1x text-primary"></i>
                                </span>
                                <h4><strong>MBTI</strong></h4>
                                <p>Psikotes yang dirancang untuk mengukur preferensi psikologis seseorang dalam melihat dunia dan membuat keputusan.</p>
                                <a href="http://www.myersbriggs.org/my-mbti-personality-type/mbti-basics/" target="_blank" class="btn btn-light">Learn More</a>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="service-item">
                                <span class="fa-stack fa-4x">
                                    <i class="fa fa-circle fa-stack-2x"></i>
                                    <i class="fa fa-shield fa-stack-1x text-primary"></i>
                                </span>
                                <h4><strong>Naive Bayes Classifier</strong></h4>
                                <p>Metode klasifikasi yang berakar pada teorema Bayes yang menghasilkan prediksi dengan keakuratan tinggi.</p>
                                <a href="https://en.wikipedia.org/wiki/Naive_Bayes_classifier" target="_blank" class="btn btn-light">Learn More</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <aside class="callout">
        <div class="text-vertical-center">
            <h1>Saatnya Tunjukan Dirimu</h1>
        </div>
    </aside>
    <section id="portfolio" class="portfolio">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 col-lg-offset-1 text-center">
                    <h2>Skema SKKNI</h2>
                    <hr class="small">
                    <div class="row" id="content">
                      <?php if($result==false){ ?>
                        <div class="col-md-12">
                            <div class="portfolio-item">
                                <a href="#portfolioModal" ><img class="img-portfolio img-responsive" src="<?php echo base_url(); ?>assets/img/no_result.png" alt="No Record Found!"></a>
                            </div>
                        </div>
                      <?php }else{ foreach($result as $row){
                        $unit = $this->db->query("select A.* from skkni_unit A join relasi B on A.id_unit=B.id_unit
                        join skkni_skema C on B.id_skema=C.id_skema where C.id_skema='".$row->id_skema."'")->result();?>
                        <div class="col-md-3">
                            <div class="portfolio-item baris" kode="<?php echo $row->id_skema;?>">
                                <a href="#portfolioModal<?php echo $row->id_skema;?>" data-toggle="modal" title="Skema <?php echo $row->nama_skema;?>"><img class="img-portfolio img-responsive" src="<?php echo base_url(); ?>assets/img/skema/<?php echo $row->foto;?>" alt="<?php echo $row->nama_skema;?>"></a>
                            </div>
                        </div>
                        <div class="modal fade" id="portfolioModal<?php echo $row->id_skema;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                                      <h4 class="modal-title" id="myModalLabel"><?php echo $row->nama_skema;?></h4>
                                    </div>
                                    <div class="modal-body">
                                      <center>
                                        <?php echo $row->deskripsi;?>
                                        <?php if($unit!=false){ ?>
                                          <table id="tabel" class="table table-bordered table-striped">
                                            <thead>
                                              <tr><th>No</th><th>Kode Unit</th><th>Nama Kompetensi</th></tr>
                                            </thead>
                                            <tbody>
                                              <?php $n=1;foreach($unit as $row1){?>
                                                <tr>
                                                  <td><?php echo $n;?></td>
                                                  <td><?php echo $row1->kode_unit;?></td>
                                                  <td><?php echo $row1->nama_unit;?></td>
                                                </tr>
                                              <?php $n++;} ?>
                                            </tbody>
                                          </table>
                                        <?php } ?>
                                      </center>
                                    </div>
                                    <div class="modal-footer">
                                      <center><button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button></center>
                                    </div>
                                </div>
                            </div>
                        </div>
                      <?php }} ?>
                    </div>
                    <div style="display:none;"><center><img src="assets/img/loading.gif" /></center></div>
                    <br/>
                    <a id="lihat" class="btn btn-dark">View More Items</a>
                </div>
            </div>
        </div>
    </section>
    <aside class="call-to-action bg-primary">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h3>Perlihatkan Kemampuanmu Disini.</h3>
                    <a href="<?php echo base_url();?>overview" class="btn btn-lg btn-light">Overview dengan SKKNI</a>
                    <a href="<?php echo base_url();?>overview/v2" class="btn btn-lg btn-light">Overview dengan MBTI</a>
                    <a href="<?php echo base_url();?>login" class="btn btn-lg btn-dark">Login / Register</a>
                </div>
            </div>
        </div>
    </aside>
    <section id="contact" class="map">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3965.6723081735845!2d106.75397081356579!3d-6.306712695435626!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69efda2b18eeb1%3A0xe3bea9346241f122!2sUniversitas+Islam+Negeri+Syarif+Hidayatullah+-+Kampus+1!5e0!3m2!1sid!2s!4v1490176671663" width="100%" height="100%" frameborder="0" style="border:0" allowfullscreen></iframe>
    </section>
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-10 col-lg-offset-1 text-center">
                    <h4><strong>Start Bootstrap</strong></h4>
                    <p>3481 Melrose Place<br>Beverly Hills, CA 90210</p>
                    <ul class="list-unstyled">
                        <li><i class="fa fa-phone fa-fw"></i> (123) 456-7890</li>
                        <li><i class="fa fa-envelope-o fa-fw"></i> <a href="mailto:name@example.com">name@example.com</a></li>
                    </ul>
                    <br>
                    <ul class="list-inline">
                        <li><a href="#"><i class="fa fa-facebook fa-fw fa-3x"></i></a></li>
                        <li><a href="#"><i class="fa fa-twitter fa-fw fa-3x"></i></a></li>
                        <li><a href="#"><i class="fa fa-dribbble fa-fw fa-3x"></i></a></li>
                    </ul>
                    <hr class="small">
                    <p class="text-muted">Copyright &copy; SPPKTI 2017</p>
                </div>
            </div>
        </div>
        <a id="to-top" href="#top" class="btn btn-dark btn-lg"><i class="fa fa-chevron-up fa-fw fa-1x"></i></a>
    </footer>
    <script src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
    <script>
      // Closes the sidebar menu
      $("#menu-close").click(function(e) {
          e.preventDefault();
          $("#sidebar-wrapper").toggleClass("active");
      });
      // Opens the sidebar menu
      $("#menu-toggle").click(function(e) {
          e.preventDefault();
          $("#sidebar-wrapper").toggleClass("active");
      });
      // Scrolls to the selected menu item on the page
      $(function() {
          $('a[href*=#]:not([href=#],[data-toggle],[data-target],[data-slide])').click(function() {
              if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') || location.hostname == this.hostname) {
                  var target = $(this.hash);
                  target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                  if (target.length) {
                      $('html,body').animate({
                          scrollTop: target.offset().top
                      }, 1000);
                      return false;
                  }
              }
          });
      });
      //#to-top button appears after scrolling
      var fixed = false;
      $(document).scroll(function() {
          if ($(this).scrollTop() > 250) {
              if (!fixed) {
                  fixed = true;
                  // $('#to-top').css({position:'fixed', display:'block'});
                  $('#to-top').show("slow", function() {
                      $('#to-top').css({
                          position: 'fixed',
                          display: 'block'
                      });
                  });
              }
          } else {
              if (fixed) {
                  fixed = false;
                  $('#to-top').hide("slow", function() {
                      $('#to-top').css({
                          display: 'none'
                      });
                  });
              }
          }
      });
      // Disable Google Maps scrolling
      // See http://stackoverflow.com/a/25904582/1607849
      // Disable scroll zooming and bind back the click event
      var onMapMouseleaveHandler = function(event) {
          var that = $(this);
          that.on('click', onMapClickHandler);
          that.off('mouseleave', onMapMouseleaveHandler);
          that.find('iframe').css("pointer-events", "none");
      }
      var onMapClickHandler = function(event) {
              var that = $(this);
              // Disable the click handler until the user leaves the map area
              that.off('click', onMapClickHandler);
              // Enable scrolling zoom
              that.find('iframe').css("pointer-events", "auto");
              // Handle the mouse leave event
              that.on('mouseleave', onMapMouseleaveHandler);
          }
          // Enable map zooming with mouse scroll when the user clicks the map
      $('.map').on('click', onMapClickHandler);
      $(document).ready(function(){
  			$("#lihat").click(function (){
  		    	$('#lihat').html('<center><img src="assets/img/loading.gif" /></center>');
            var metode = $(".baris:last").attr("kode");
  				$.ajax({
  					url: "<?php base_url();?>home/skema",
            data: "id=" + metode,
  					success: function(html){
  						if(html){
  							$("#content").append(html);
  							$('#lihat').html('<center>View More Items</center>');
  						}else{
  							$('#lihat').replaceWith('<a id="lihat" class="btn btn-dark">No More Items</a>');
  						}
  					}
  				});
  		  });
  		});
    </script>
  </body>
</html>
