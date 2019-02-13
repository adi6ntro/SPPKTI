<style media="screen">
.bar-hitam {background-color: black;}
.bar-hitam2 {background-color: #feffd0;color: black;}
.bar-biru {background-color: blue;}
.bar-kuning {background-color: yellow;color: black;}
.bar-merah {background-color: red;}
.bar-pink {background-color: pink;color: black;}
.bar-hijau {background-color: green;}
.bar-coklat {background-color: brown;}
img{margin: 0 auto;}
</style>
<section class="content-header">
  <h1>
    Dashboard
    <small>Control panel</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Dashboard</li>
  </ol>
</section>
<script type="text/javascript">
// Radialize the colors
Highcharts.setOptions({
    colors: Highcharts.map(Highcharts.getOptions().colors, function (color) {
        return {
            radialGradient: {
                cx: 0.5,
                cy: 0.3,
                r: 0.7
            },
            stops: [
                [0, color],
                [1, Highcharts.Color(color).brighten(-0.3).get('rgb')] // darken
            ]
        };
    })
});

</script>
<section class="content">
    <div class="box">
        <div class="box-header"><h3 class="box-title">Hasil Konsultasi Terakhir</h3></div>
        <?php if($mbti==false){?>
          <div class="box-body"><div class="text-center"><strong><h3>Belum Ada Catatan<h3></strong>
            <a href="<?php echo site_url('konsultasi');?>" class="btn btn-primary">Ayo mulai konsultasi</a>
          </div>
          </div>
        <?php }else{?>
          <div class="box-body">
            <div class="box box-danger">
              <div class="box-header with-border text-center">
                <h3 class="box-title"><strong>Hasil Tipe Kepribadian MBTI</strong></h3>
                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div>
              </div>
              <div class="box-body">
                <div class="row">
                  <div class="col-md-6">
                    <img class="img-responsive" src="<?php echo base_url()."assets/img/mbti/".$mbti['gambar'];?>" alt="">
                  </div>
                  <div class="col-md-6">
                    <table class="table table-bordered">
                      <thead><tr><th colspan="3" style="text-align:center">Detail</th></tr></thead>
                      <tbody>
                        <tr>
                          <td><?php echo ($mbti['Introvert']>$mbti['Extrovert'])?"<b>Introvert</b>":"Introvert"; ?></td>
                          <td width="60%">
                            <div class="progress">
                              <div class="progress-bar bar-hitam2" role="progressbar" aria-valuenow="<?php echo $mbti['Introvert'];?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $mbti['Introvert'];?>%"><?php echo $mbti['Introvert'];?>%</div>
                              <div class="progress-bar bar-hitam" role="progressbar" aria-valuenow="<?php echo $mbti['Extrovert'];?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $mbti['Extrovert'];?>%"><?php echo $mbti['Extrovert'];?>%</div>
                            </div>
                          </td>
                          <td style="text-align:right"><?php echo ($mbti['Introvert']<$mbti['Extrovert'])?"<b>Extrovert</b>":"Extrovert"; ?></td>
                        </tr>
                        <tr>
                          <td><?php echo ($mbti['Sensing']>$mbti['Intuition'])?"<b>Sensing</b>":"Sensing"; ?></td>
                          <td width="60%">
                            <div class="progress">
                              <div class="progress-bar bar-biru" role="progressbar" aria-valuenow="<?php echo $mbti['Sensing'];?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $mbti['Sensing'];?>%"><?php echo $mbti['Sensing'];?>%</div>
                              <div class="progress-bar bar-kuning" role="progressbar" aria-valuenow="<?php echo $mbti['Intuition'];?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $mbti['Intuition'];?>%"><?php echo $mbti['Intuition'];?>%</div>
                            </div>
                          </td>
                          <td style="text-align:right"><?php echo ($mbti['Sensing']<$mbti['Intuition'])?"<b>Intuition</b>":"Intuition"; ?></td>
                        </tr>
                        <tr>
                          <td><?php echo ($mbti['Thinking']>$mbti['Feeling'])?"<b>Thinking</b>":"Thinking"; ?></td>
                          <td width="60%">
                            <div class="progress">
                              <div class="progress-bar bar-merah" role="progressbar" aria-valuenow="<?php echo $mbti['Thinking'];?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $mbti['Thinking'];?>%"><?php echo $mbti['Thinking'];?>%</div>
                              <div class="progress-bar bar-pink" role="progressbar" aria-valuenow="<?php echo $mbti['Feeling'];?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $mbti['Feeling'];?>%"><?php echo $mbti['Feeling'];?>%</div>
                            </div>
                          </td>
                          <td style="text-align:right"><?php echo ($mbti['Thinking']<$mbti['Feeling'])?"<b>Feeling</b>":"Feeling"; ?></td>
                        </tr>
                        <tr>
                          <td><?php echo ($mbti['Perceiving']>$mbti['Judging'])?"<b>Perceiving</b>":"Perceiving"; ?></td>
                          <td width="60%">
                            <div class="progress">
                              <div class="progress-bar bar-hijau" role="progressbar" aria-valuenow="<?php echo $mbti['Perceiving'];?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $mbti['Perceiving'];?>%"><?php echo $mbti['Perceiving'];?>%</div>
                              <div class="progress-bar bar-coklat" role="progressbar" aria-valuenow="<?php echo $mbti['Judging'];?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $mbti['Judging'];?>%"><?php echo $mbti['Judging'];?>%</div>
                            </div>
                          </td>
                          <td style="text-align:right"><?php echo ($mbti['Perceiving']<$mbti['Judging'])?"<b>Judging</b>":"Judging"; ?></td>
                        </tr>
                      </tbody>
                    </table>
                    <div class="text-center">
                      <a href="#PenjelasanMBTI"class="btn btn-info" data-toggle="modal" title="Penjelasan dan Saran Pengembangan">Penjelasan</a>
                    </div>
                    <div class="modal fade" id="PenjelasanMBTI" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                                  <h4 class="modal-title" id="myModalLabel">Penjelasan dan Saran Pengembangan</h4>
                                </div>
                                <div class="modal-body">
                                  <?php echo '<h2>'.$mbti['nama_kelas'].'</h2>'.$mbti['saran'];
                                  echo '<hr>'.$mbti['keterangan'];?>
                                </div>
                                <div class="modal-footer">
                                  <center><button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button></center>
                                </div>
                            </div>
                        </div>
                    </div>
                  </div>
                </div><br>
                <div class="row">
                  <div class="col-md-12">
                    <div class="chart-responsive">
                      <div id="mbti_hasil"></div>
                      <?php //<canvas id="mbti_hasil"></canvas>?>
                    </div>
                    <script type="text/javascript">
                    // Build the chart
                    <?php $tes = explode(',',$mbti['presentase_detil_max']); ?>
                    Highcharts.chart('mbti_hasil', {
                        chart: {
                            plotBackgroundColor: null,
                            plotBorderWidth: null,
                            plotShadow: false,
                            type: 'pie'
                        },
                        title: {
                            text: "Anda cocok untuk mengisi role position sebagai <strong><?php echo $mbti['nama_kelas']; ?></strong> dengan presentase <strong><?php echo $mbti['persenmax']; ?>%</strong>"
                        },
                        tooltip: {
                            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                        },
                        plotOptions: {
                            pie: {
                                allowPointSelect: true,
                                cursor: 'pointer',
                                dataLabels: {
                                  enabled: true,
                                  format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                                  style: {
                                      color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                                  },
                                  connectorColor: 'silver'
                                }
                            }
                        },
                        series: [{
                            name: 'Persentase',
                            data: [
                              <?php
                              foreach ($tes as $key) {
                                $value = explode(':',$key);
                                echo "{ name: '".$value[0]."', y: ".$value[1]." },";
                              }
                              ?>
                            ]
                        }]
                    });
                    </script>
                  </div>
                </div>
              </div>
            </div>
            <?php if($skkni==false){?>
            <div class="col-md-12 text-center">
              <a href="<?php echo site_url('konsultasi/kompetensi');?>" class="btn btn-primary">Mulai Tes Kompetensi</a>
            </div>
            <?php }else{?>
            <div class="box box-success">
              <div class="box-header with-border text-center">
                <h3 class="box-title"><strong>Hasil Kompetensi SKKNI</strong></h3>
                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div>
              </div>
              <div class="box-body">
                <div class="row">
                  <div class="col-md-6 text-center">
                    Anda cocok untuk mengikuti sertifikasi profesi sebagai <strong><?php echo $skkni['nama_skema']; ?></strong> dengan presentase <strong><?php echo $skkni['presentase']; ?>%</strong>
                    <br><br>
                    <img class="skkni img-responsive" src="<?php echo base_url()."assets/img/skema/".$skkni['foto'];?>" alt=""><br/>
                    <div class="text-center">
                      <a href="#PenjelasanSKKNI"class="btn btn-info" data-toggle="modal" title="Penjelasan dan Saran Pengembangan">Penjelasan</a>
                    </div>
                    <div class="modal fade" id="PenjelasanSKKNI" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                                  <h4 class="modal-title" id="myModalLabel">Penjelasan dan Saran Pengembangan</h4>
                                </div>
                                <div class="modal-body">
                                  <h4>Tingkatkan skill anda sesuai unit kerja dibawah ini.<br>Perbanyak latihan dan belajar untuk memperoleh sertifikasi sesuai yang disarankan.</h4>
                                  <?php
                                  $unit = $this->db->query("select A.* from skkni_unit A join relasi B on A.id_unit=B.id_unit
                                  join skkni_skema C on B.id_skema=C.id_skema where C.id_skema='".$skkni['id_skema']."'")->result();?>
                                  <?php if($unit!=false){ ?>
                                    <table class="table table-bordered table-striped">
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
                                </div>
                                <div class="modal-footer">
                                  <center><button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button></center>
                                </div>
                            </div>
                        </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <?php echo $skkni['deskripsi']; ?>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="chart-responsive">
                      <div id="result_hasil"></div>
                      <?php //<canvas id="mbti_hasil"></canvas>?>
                    </div>
                    <script type="text/javascript">
                    // Build the chart
                    <?php $tes2 = explode(',',$skkni['presentase_detil_max']); ?>
                    Highcharts.chart('result_hasil', {
                        chart: {
                            plotBackgroundColor: null,
                            plotBorderWidth: null,
                            plotShadow: false,
                            type: 'pie'
                        },
                        title: {
                            text: "Anda cocok untuk mengisi role position sebagai <strong><?php echo $skkni['nama_skema']; ?></strong> dengan presentase <strong><?php echo $skkni['persenmax']; ?>%</strong>"
                        },
                        tooltip: {
                            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                        },
                        plotOptions: {
                            pie: {
                                allowPointSelect: true,
                                cursor: 'pointer',
                                dataLabels: {
                                  enabled: true,
                                  format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                                  style: {
                                      color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                                  },
                                  connectorColor: 'silver'
                                }
                            }
                        },
                        series: [{
                            name: 'Persentase',
                            data: [
                              <?php
                              foreach ($tes2 as $key) {
                                $value = explode(':',$key);
                                echo "{ name: '".$value[0]."', y: ".$value[1]." },";
                              }
                              ?>
                            ]
                        }]
                    });
                    </script>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-12 text-center">
              <a href="<?php echo site_url('simulasi');?>" class="btn btn-primary">Mulai Ujian Simulasi SKKNI</a>
            </div>
            <?php }?>
          </div>
        <?php }?>
    </div>
</div>
</div>
