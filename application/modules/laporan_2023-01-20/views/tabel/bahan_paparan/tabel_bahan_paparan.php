<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo $title; ?> - <?php echo $this->template->settings('app_name'); ?></title>
    <!-- Favico -->
    <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/sbe/favicon.ico" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" />
    <meta name="author" content="Alfikri" />
    <meta name="description" content="SIMBANGDA Based Evidence, simbangda based evidence, SIMBANGDA berbasis pembuktian, simbangda berbasis pembuktian, SIMBANGDA SUMBAR, simbangda sumbar, Sistem Informasi Manajemen Pembangunan Daerah, Sistem Informasi Manajemen Pembangunan Daerah Sumbar, Sumatera Barat" />
    <meta name="keywords" content="Simbangda based evidence, Sistem Informasi Manajemen Pembangunan Daerah, simbangda berbasis pembuktian, simbangda sumbar, Sumbar, Sumatera Barat, Pemprov Sumbar, Pemerintah Provinsi Sumatera Barat, Alfikri, Al, Fikri, alfikri, alfikri, alfikridotname" />
    <meta name="msapplication-tap-highlight" content="no">
    <!-- Bootstrap 4.3.1 -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- Architectui HTML FREE -->
    <link href="<?php echo base_url() ?>assets/architectui-html-pro/main.87c0748b313a1dda75f5.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?php echo base_url() ?>assets/fontawesome/css/all.css" rel="stylesheet">

    <script src="<?php echo base_url() ?>assets/sweetalert/dist/sweetalert2.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url() ?>assets/sweetalert/dist/sweetalert2.min.css">
    <?php echo $extra_css; ?>
</head>



<div style="margin:15px">
    


    <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3 card">
                                        <div class="tabs-lg-alternate card-header">
                                            <ul class="nav nav-justified">
                                                <li class="nav-item">
                                                    <a data-toggle="tab" href="#capaian_prov_sumbar" class="nav-link  active show">
                                                       <h5 class="card-title">Capaian Provinsi Sumatera Barat</h5>
                                                    </a></li>
                                                <li class="nav-item">
                                                    <a data-toggle="tab" href="#pdf_rekap_asisten" class="nav-link show">
                                                      <h5 class="card-title">Laporan Realisasi Semua OPD</h5>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a data-toggle="tab" href="#statistika_deviasi" class="nav-link">
                                                         <h5 class="card-title">Statistika Deviasi</h5>
                                                    </a>
                                                </li>

                                                <li class="nav-item">
                                                    <a data-toggle="tab" href="#perengkingan_opd" class="nav-link show">
                                                      <h5 class="card-title">Perengkingan</h5>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="tab-content">
                                            <div class="tab-pane active show" id="capaian_prov_sumbar" role="tabpanel">
                                                <div class="card-body">
                                                  <table class="table table-bordered">
                                                      <tr>
                                                          <th align="center">Sumber Dana</th>
                                                          <th align="center" colspan="3">Fisik</th>
                                                          <th align="center" colspan="3">Keuangan</th>
                                                      </tr>
                                                      <tr>
                                                          <th align="center" rowspan="2">APBD Provinsi</th>
                                                          <td>Target</td>
                                                          <td>Realisasi</td>
                                                          <td>Deviasi</td>
                                                          <td>Target</td>
                                                          <td>Realisasi</td>
                                                          <td>Deviasi</td>
                                                      </tr>
                                                      <tr>
                                                          <td><?php echo $capaian_provinsi_sumbar['tf'] ?></td>
                                                          <td><?php echo $capaian_provinsi_sumbar['rf'] ?></td>
                                                          <td><?php echo $capaian_provinsi_sumbar['df'] ?></td>
                                                          <td><?php echo $capaian_provinsi_sumbar['tk'] ?></td>
                                                          <td><?php echo $capaian_provinsi_sumbar['rk'] ?></td>
                                                          <td><?php echo $capaian_provinsi_sumbar['dk'] ?></td>
                                                      </tr>
                                                  </table>

                                                </div>
                                            </div>
                                            <div class="tab-pane show" id="pdf_rekap_asisten" role="tabpanel">
                                                <div class="card-body">

                                                    <iframe src="<?php echo base_url() ?>laporan/pdf_laporan_rekap_asisten?bulan=<?php echo $bulan ?>&tahun=<?php echo $tahun ?>&tahap=<?php echo $tahap ?>&kategori=Akumulasi" width="100%" height="600px"></iframe>
                                                </div>
                                            </div>
                                            <div class="tab-pane " id="statistika_deviasi" role="tabpanel">
                                                <div class="card-body">























                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3 card">
                                        <div class="card-body">
                                            Disini grafik deviasi fisik






<!-- bagian grafik fisik -->
  <div id="grafik_deviasi_fisik"></div>
<?php 
$persentasi_dev_f_hijau = ($grafik_deviasi['statistika_fisik']['hijau']/$grafik_deviasi['total_opd']) * 100; 
$persentasi_dev_f_kuning = ($grafik_deviasi['statistika_fisik']['kuning']/$grafik_deviasi['total_opd']) * 100; 
$persentasi_dev_f_merah = ($grafik_deviasi['statistika_fisik']['merah']/$grafik_deviasi['total_opd']) * 100; 
?>

<table class="table">
    <tr>
        <td>Keterangan</td>
        <td>Banyak OPD</td>
        <td>Persentasi</td>
    </tr>
    <tr>
        <td>Deviasi dibawah -5%</td>
        <td><?php echo $grafik_deviasi['statistika_fisik']['hijau'] ?> OPD</td>
        <td><?php echo round($persentasi_dev_f_hijau,1) ?></td>
    </tr>
    <tr>
        <td>Deviasi antara -5% s/d -10%</td>
        <td><?php echo $grafik_deviasi['statistika_fisik']['kuning'] ?> OPD</td>
        <td><?php echo round($persentasi_dev_f_kuning,1) ?></td>
    </tr>
    <tr>
        <td>Deviasi diatas -10%</td>
        <td><?php echo $grafik_deviasi['statistika_fisik']['merah'] ?> OPD</td>
        <td><?php echo round($persentasi_dev_f_merah,1) ?></td>
    </tr>
</table>
<!-- bagian grafik fisik -->
 

d5f5e3
fcf3cf
f8b2b2

                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="col-md-8">
                                    <div class="mb-3 card">
                                        <div class="card-header card-header-tab-animation">
                                            <ul class="nav nav-justified">
                                                <li class="nav-item" style="background:#f8b2b2"><a data-toggle="tab" href="#dev_f_merah" class="nav-link active show">Deviasi Fisik Diatas -10%</a></li>
                                                <li class="nav-item" style="background:#fcf3cf"><a data-toggle="tab" href="#dev_f_kuning" class="nav-link show">Deviasi Fisik Antara -5% s/d -10%</a></li>
                                                <li class="nav-item" style="background:#d5f5e3"><a data-toggle="tab" href="#dev_f_hijau" class="nav-link">Deviasi Fisik Dibawah -5%</a></li>
                                            </ul>
                                        </div>
                                        <div class="card-body">
                                            <div class="tab-content">
                                                <div class="tab-pane active show" id="dev_f_merah" role="tabpanel">
                                                    <?php 
                                                    if ($grafik_deviasi['statistika_fisik']['merah']==0) {
                                                       echo "Tidak ada data";
                                                    }else{
                                                     ?>
                                                   
                                                    <div style="overflow-y: scroll; height: 540px">
                                                        Data deviasi fisik diatas 10 %
                                                        <table class="table">
                                                            <tr>
                                                                <td>No</td>
                                                                <td>SKPD</td>
                                                                <td>T</td>
                                                                <td>R</td>
                                                                <td>D</td>
                                                            </tr>
                                                            <?php 
                                                            $no_f_merah =1;
                                                            foreach ($grafik_deviasi['f_merah'] as $k_f_merah => $v_f_merah) { ?>
                                                                <tr>
                                                                    <td><?php echo $no_f_merah++ ?></td>
                                                                    <td><?php echo $v_f_merah['skpd'] ?></td>
                                                                    <td><?php echo $v_f_merah['tf'] ?></td>
                                                                    <td><?php echo $v_f_merah['rf'] ?></td>
                                                                    <td><?php echo $v_f_merah['df'] ?></td>
                                                                
                                                                </tr>
                                                            <?php } ?>
                                                        </table>
                                                    </div>
                                                <?php } ?>
                                                </div>
                                                <div class="tab-pane show" id="dev_f_kuning" role="tabpanel">
                                                      <?php 
                                                    if ($grafik_deviasi['statistika_fisik']['kuning']==0) {
                                                       echo "Tidak ada data";
                                                    }else{
                                                     ?>
                                                   
                                                    <div style="overflow-y: scroll; height: 540px">
                                                        Data deviasi fisik antara -5 s/d -10 %
                                                        <table class="table">
                                                            <tr>
                                                                <td>No</td>
                                                                <td>SKPD</td>
                                                                <td>T</td>
                                                                <td>R</td>
                                                                <td>D</td>
                                                            </tr>
                                                            <?php 
                                                            $no_f_kuning =1;
                                                            foreach ($grafik_deviasi['f_kuning'] as $k_f_kuning => $v_f_kuning) { ?>
                                                                <tr>
                                                                    <td><?php echo $no_f_kuning++ ?></td>
                                                                    <td><?php echo $v_f_kuning['skpd'] ?></td>
                                                                    <td><?php echo $v_f_kuning['tf'] ?></td>
                                                                    <td><?php echo $v_f_kuning['rf'] ?></td>
                                                                    <td><?php echo $v_f_kuning['df'] ?></td>
                                                                
                                                                </tr>
                                                            <?php } ?>
                                                        </table>
                                                    </div>
                                                <?php } ?>


                                                </div>
                                                <div class="tab-pane" id="dev_f_hijau" role="tabpanel">
                                                   



                                                      <?php 
                                                    if ($grafik_deviasi['statistika_fisik']['hijau']==0) {
                                                       echo "Tidak ada data";
                                                    }else{
                                                     ?>
                                                   
                                                    <div style="overflow-y: scroll; height: 540px">
                                                        Data deviasi fisik dibawah -5 %
                                                        <table class="table">
                                                            <tr>
                                                                <td>No</td>
                                                                <td>SKPD</td>
                                                                <td>T</td>
                                                                <td>R</td>
                                                                <td>D</td>
                                                            </tr>
                                                            <?php 
                                                            $no_f_hijau =1;
                                                            foreach ($grafik_deviasi['f_hijau'] as $k_f_hijau => $v_f_hijau) { ?>
                                                                <tr>
                                                                    <td><?php echo $no_f_hijau++ ?></td>
                                                                    <td><?php echo $v_f_hijau['skpd'] ?></td>
                                                                    <td><?php echo $v_f_hijau['tf'] ?></td>
                                                                    <td><?php echo $v_f_hijau['rf'] ?></td>
                                                                    <td><?php echo $v_f_hijau['df'] ?></td>
                                                                
                                                                </tr>
                                                            <?php } ?>
                                                        </table>
                                                    </div>
                                                <?php } ?>




                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>


                                <div class="col-md-12">
                                    <div class="mb-3 card">
                                        <div class="card-body">
                                            Disini grafik realisasi fisik 

                                            <div id="grafik_realisasi_fisik"></div>
                                            <button onclick="lihat_realisasi_fisik()" class="btn btn-info btn-xs"> Lihat Data Realisasi Fisik</button>

                                        </div>
                                    </div>
                                    
                                </div>
                            </div>








                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3 card">
                                        <div class="card-body">
                                            Disini grafik deviasi Keuangan











<!-- bagian grafik keuangasn -->
  <div id="grafik_deviasi_keuangan"></div>
<?php 
$persentasi_dev_k_hijau = ($grafik_deviasi['statistika_keuangan']['hijau']/$grafik_deviasi['total_opd']) * 100; 
$persentasi_dev_k_kuning = ($grafik_deviasi['statistika_keuangan']['kuning']/$grafik_deviasi['total_opd']) * 100; 
$persentasi_dev_k_merah = ($grafik_deviasi['statistika_keuangan']['merah']/$grafik_deviasi['total_opd']) * 100; 
?>

<table class="table">
    <tr>
        <td>Keterangan</td>
        <td>Banyak OPD</td>
        <td>Persentasi</td>
    </tr>
    <tr>
        <td>Deviasi dibawah -5%</td>
        <td><?php echo $grafik_deviasi['statistika_keuangan']['hijau'] ?> OPD</td>
        <td><?php echo round($persentasi_dev_k_hijau,1) ?></td>
    </tr>
    <tr>
        <td>Deviasi antara -5% s/d -10%</td>
        <td><?php echo $grafik_deviasi['statistika_keuangan']['kuning'] ?> OPD</td>
        <td><?php echo round($persentasi_dev_k_kuning,1) ?></td>
    </tr>
    <tr>
        <td>Deviasi diatas -10%</td>
        <td><?php echo $grafik_deviasi['statistika_keuangan']['merah'] ?> OPD</td>
        <td><?php echo round($persentasi_dev_k_merah,1) ?></td>
    </tr>
</table>
<!-- bagian grafik keuangasn -->



                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="col-md-8">
                                    <div class="mb-3 card">
                                        <div class="card-header card-header-tab-animation">
                                            <ul class="nav nav-justified">
                                                <li class="nav-item" style="background:#f8b2b2"><a data-toggle="tab" href="#dev_k_merah" class="nav-link active show">Deviasi keuangan Diatas -10%</a></li>
                                                <li class="nav-item" style="background:#fcf3cf"><a data-toggle="tab" href="#dev_k_kuning" class="nav-link show">Deviasi keuangan Antara -5% s/d -10%</a></li>
                                                <li class="nav-item" style="background:#d5f5e3"><a data-toggle="tab" href="#dev_k_hijau" class="nav-link">Deviasi keuangan Dibawah -5%</a></li>
                                            </ul>
                                        </div>
                                        <div class="card-body">
                                            <div class="tab-content">
                                                <div class="tab-pane active show" id="dev_k_merah" role="tabpanel">
                                                    <?php 
                                                    if ($grafik_deviasi['statistika_keuangan']['merah']==0) {
                                                       echo "Tidak ada data";
                                                    }else{
                                                     ?>
                                                   
                                                    <div style="overflow-y: scroll; height: 540px">
                                                        Data deviasi keuangan diatas 10 %
                                                        <table class="table">
                                                            <tr>
                                                                <td>No</td>
                                                                <td>SKPD</td>
                                                                <td>T</td>
                                                                <td>R</td>
                                                                <td>D</td>
                                                            </tr>
                                                            <?php 
                                                            $no_k_merah =1;
                                                            foreach ($grafik_deviasi['k_merah'] as $k_k_merah => $v_k_merah) { ?>
                                                                <tr>
                                                                    <td><?php echo $no_k_merah++ ?></td>
                                                                    <td><?php echo $v_k_merah['skpd'] ?></td>
                                                                    <td><?php echo $v_k_merah['tf'] ?></td>
                                                                    <td><?php echo $v_k_merah['rf'] ?></td>
                                                                    <td><?php echo $v_k_merah['df'] ?></td>
                                                                
                                                                </tr>
                                                            <?php } ?>
                                                        </table>
                                                    </div>
                                                <?php } ?>
                                                </div>
                                                <div class="tab-pane show" id="dev_k_kuning" role="tabpanel">
                                                      <?php 
                                                    if ($grafik_deviasi['statistika_keuangan']['kuning']==0) {
                                                       echo "Tidak ada data";
                                                    }else{
                                                     ?>
                                                   
                                                    <div style="overflow-y: scroll; height: 540px">
                                                        Data deviasi keuangan antara -5 s/d -10 %
                                                        <table class="table">
                                                            <tr>
                                                                <td>No</td>
                                                                <td>SKPD</td>
                                                                <td>T</td>
                                                                <td>R</td>
                                                                <td>D</td>
                                                            </tr>
                                                            <?php 
                                                            $no_k_kuning =1;
                                                            foreach ($grafik_deviasi['k_kuning'] as $k_k_kuning => $v_k_kuning) { ?>
                                                                <tr>
                                                                    <td><?php echo $no_k_kuning++ ?></td>
                                                                    <td><?php echo $v_k_kuning['skpd'] ?></td>
                                                                    <td><?php echo $v_k_kuning['tf'] ?></td>
                                                                    <td><?php echo $v_k_kuning['rf'] ?></td>
                                                                    <td><?php echo $v_k_kuning['df'] ?></td>
                                                                
                                                                </tr>
                                                            <?php } ?>
                                                        </table>
                                                    </div>
                                                <?php } ?>


                                                </div>
                                                <div class="tab-pane" id="dev_k_hijau" role="tabpanel">
                                                   



                                                      <?php 
                                                    if ($grafik_deviasi['statistika_keuangan']['hijau']==0) {
                                                       echo "Tidak ada data";
                                                    }else{
                                                     ?>
                                                   
                                                    <div style="overflow-y: scroll; height: 540px">
                                                        Data deviasi keuangan dibawah -5 %
                                                        <table class="table">
                                                            <tr>
                                                                <td>No</td>
                                                                <td>SKPD</td>
                                                                <td>T</td>
                                                                <td>R</td>
                                                                <td>D</td>
                                                            </tr>
                                                            <?php 
                                                            $no_k_hijau =1;
                                                            foreach ($grafik_deviasi['k_hijau'] as $k_k_hijau => $v_k_hijau) { ?>
                                                                <tr>
                                                                    <td><?php echo $no_k_hijau++ ?></td>
                                                                    <td><?php echo $v_k_hijau['skpd'] ?></td>
                                                                    <td><?php echo $v_k_hijau['tf'] ?></td>
                                                                    <td><?php echo $v_k_hijau['rf'] ?></td>
                                                                    <td><?php echo $v_k_hijau['df'] ?></td>
                                                                
                                                                </tr>
                                                            <?php } ?>
                                                        </table>
                                                    </div>
                                                <?php } ?>




                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>







                                <div class="col-md-12">
                                    <div class="mb-3 card">
                                        <div class="card-body">
                                            Disini grafik realisasi keuangan 
                                            <div id="grafik_realisasi_keuangan"></div>
                                            <button onclick="lihat_realisasi_keuangan()" class="btn btn-info btn-xs"> Lihat Data Realisasi keuangan</button>

                                        </div>
                                    </div>
                                    
                                </div>


                            </div>
                            



                        </div>
                                            </div>

                                            <div class="tab-pane show" id="perengkingan_opd" role="tabpanel">
                                                <div class="row">
                                                 <div class="col-md-6">
                                                    <div class="mb-3 card">
                                                        <div class="card-body">
                                                          Perengkingan Realisasi Fisik Tertinggi
                                                          <table class="table">
                                                              <tr>
                                                                  <th>No</th>
                                                                  <th>SKPD</th>
                                                                  <th>Capaian</th>
                                                              </tr>
                                                              <?php 
                                                              $no_fisik_tertinggi = 1;
                                                              foreach ($perengkingan_fisik_tertinggi as $k => $v) { ?>
                                                                    <tr>
                                                                        <td><?php echo $no_fisik_tertinggi++ ?></td>
                                                                        <td><?php echo $v->nama_instansi ?></td>
                                                                        <td><?php echo $v->realisasi_fisik ?></td>
                                                                    </tr>
                                                              <?php } ?>
                                                          </table>

                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                                 <div class="col-md-6">
                                                    <div class="mb-3 card">
                                                        <div class="card-body">
                                                          Perengkingan Realisasi Fisik Terendah
                                                           <table class="table">
                                                              <tr>
                                                                  <th>No</th>
                                                                  <th>SKPD</th>
                                                                  <th>Capaian</th>
                                                              </tr>
                                                              <?php 
                                                              $no_fisik_terendah = 1;
                                                              foreach ($perengkingan_fisik_terendah as $k => $v) { ?>
                                                                    <tr>
                                                                        <td><?php echo $no_fisik_terendah++ ?></td>
                                                                        <td><?php echo $v->nama_instansi ?></td>
                                                                        <td><?php echo $v->realisasi_fisik ?></td>
                                                                    </tr>
                                                              <?php } ?>
                                                          </table>

                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                                 <div class="col-md-6">
                                                    <div class="mb-3 card">
                                                        <div class="card-body">
                                                          Perengkingan Realisasi Keuangan Tertinggi
                                                              <table class="table">
                                                              <tr>
                                                                  <th>No</th>
                                                                  <th>SKPD</th>
                                                                  <th>Capaian</th>
                                                              </tr>
                                                              <?php 
                                                              $no_keuangan_tertinggi = 1;
                                                              foreach ($perengkingan_keuangan_tertinggi as $k => $v) { ?>
                                                                    <tr>
                                                                        <td><?php echo $no_keuangan_tertinggi++ ?></td>
                                                                        <td><?php echo $v->nama_instansi ?></td>
                                                                        <td><?php echo $v->realisasi_keuangan ?></td>
                                                                    </tr>
                                                              <?php } ?>
                                                          </table>

                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                                 <div class="col-md-6">
                                                    <div class="mb-3 card">
                                                        <div class="card-body">
                                                          Perengkingan Realisasi Keuangan Terendah
                                                            <table class="table">
                                                              <tr>
                                                                  <th>No</th>
                                                                  <th>SKPD</th>
                                                                  <th>Capaian</th>
                                                              </tr>
                                                              <?php 
                                                              $no_keuangan_terendah = 1;
                                                              foreach ($perengkingan_keuangan_terendah as $k => $v) { ?>
                                                                    <tr>
                                                                        <td><?php echo $no_keuangan_terendah++ ?></td>
                                                                        <td><?php echo $v->nama_instansi ?></td>
                                                                        <td><?php echo $v->realisasi_keuangan ?></td>
                                                                    </tr>
                                                              <?php } ?>
                                                          </table>

                                                        </div>
                                                    </div>
                                                    
                                                </div>

                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                              
                               
                            </div>
   

</div>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous"></script>
    <!-- Bootstrap 4.3.1 -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>assets/architectui-html-pro/assets/scripts/main.87c0748b313a1dda75f5.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>assets/jquery-ajax-progress/jquery.ajax-progress.js"></script>
    <script>
        function baseUrl(link = '') {
            let alamat = "<?php echo base_url(); ?>" + link;
            return alamat;
        }
    </script>
    <script type="text/javascript" src="<?php echo base_url() ?>assets/sbe/fungsi.js"></script>
    <script src="<?php echo base_url(); ?>assets/jquery_number/jquery.number.js"></script>
    <?php echo $extra_js; ?>
    <?php echo $extra_js_tambahan; ?>
    <?php echo $modal; ?>

<script type="text/javascript">

    // Make monochrome colors
// var pieColors = (function () {
//   var colors = [],
//     base = Highcharts.getOptions().colors[0],
//     i;

//   for (i = 0; i < 10; i += 1) {
//     // Start out with a darkened base color (negative brighten), and end
//     // up with a much brighter color
//     colors.push(Highcharts.color(base).brighten((i - 3) / 7).get());
//   }
//   return colors;
// }());

// Build the chart
Highcharts.chart('grafik_deviasi_fisik', {
  chart: {
    plotBackgroundColor: null,
    plotBorderWidth: null,
    plotShadow: false,
    type: 'pie'
  },
  title: {
    text: ''
  },
  tooltip: {
    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
  },
  accessibility: {
    point: {
      valueSuffix: '%'
    }
  },
  plotOptions: {
    pie: {
      allowPointSelect: true,
      cursor: 'pointer',
      // colors: pieColors,
      dataLabels: {
        enabled: true,
        format: '<b>{point.name}</b><br>{point.percentage:.1f} %',
        distance: -50,
        filter: {
          property: 'percentage',
          operator: '>',
          value: 4
        }
      }
    }
  },
  series: [{
    name: 'Share',
    data: [
      { 
            name: '', y: <?php echo $grafik_deviasi['statistika_fisik']['hijau'] ?>, 
            color: '#d5f5e3',
       },
      { 
            name: '', y: <?php echo $grafik_deviasi['statistika_fisik']['kuning'] ?>, 
            color: '#fcf3cf',
       },
      { 
            name: '', y: <?php echo $grafik_deviasi['statistika_fisik']['merah'] ?>, 
            color: '#f8b2b2',
       },
    
    
    ]
  }]
});






Highcharts.chart('grafik_deviasi_keuangan', {
  chart: {
    plotBackgroundColor: null,
    plotBorderWidth: null,
    plotShadow: false,
    type: 'pie'
  },
  title: {
    text: ''
  },
  tooltip: {
    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
  },
  accessibility: {
    point: {
      valueSuffix: '%'
    }
  },
  plotOptions: {
    pie: {
      allowPointSelect: true,
      cursor: 'pointer',
      // colors: pieColors,
      dataLabels: {
        enabled: true,
        format: '<b>{point.name}</b><br>{point.percentage:.1f} %',
        distance: -50,
        filter: {
          property: 'percentage',
          operator: '>',
          value: 4
        }
      }
    }
  },
  series: [{
    name: 'Share',
    data: [
      { 
            name: '', y: <?php echo $grafik_deviasi['statistika_keuangan']['hijau'] ?>, 
            color: '#d5f5e3',
       },
      { 
            name: '', y: <?php echo $grafik_deviasi['statistika_keuangan']['kuning'] ?>, 
            color: '#fcf3cf',
       },
      { 
            name: '', y: <?php echo $grafik_deviasi['statistika_keuangan']['merah'] ?>, 
            color: '#f8b2b2',
       },
    
    
    ]
  }]
});




// Create the chart
Highcharts.chart('grafik_realisasi_fisik', {
  chart: {
    type: 'column'
  },
  title: {
    align: 'left',
    text: ''
  },
  subtitle: {
    align: 'left',
    text: ''
  },
  accessibility: {
    announceNewData: {
      enabled: true
    }
  },
  xAxis: {
    type: 'category'
  },
  yAxis: {
    title: {
      text: 'Realisasi Fisik'
    }

  },
  legend: {
    enabled: false
  },
  plotOptions: {
    series: {
      borderWidth: 0,
      dataLabels: {
        enabled: true,
          rotation: 270,
        format: '{point.y:.1f}%'
      }
    }
  },

  tooltip: {
    headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
    pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
  },

  series: [
    {
      name: "Realisasi Fisik",
      colorByPoint: true,
      data: [
      <?php foreach ($grafik_realisasi_fisik as $key => $value) { 
        $urutan = $key+1;
        if ($urutan==count($grafik_realisasi_fisik)) {
            $warna = 'red';
        }
        elseif ($urutan==1) {
            $warna = 'green';
        }else{
            $warna = 'yellow';

        }
        ?>
          
        {
          name: "<?php echo $value['singkatan_skpd'] ?>",
          y: <?php echo $value['rf'] ?>,

          drilldown: "Chrome",
          color :'<?php echo $warna ?>'
        },
      <?php } ?>
       
      ]
    }
  ],
  
});


// Create the chart
Highcharts.chart('grafik_realisasi_keuangan', {
  chart: {
    type: 'column'
  },
  title: {
    align: 'left',
    text: ''
  },
  subtitle: {
    align: 'left',
    text: ''
  },
  accessibility: {
    announceNewData: {
      enabled: true
    }
  },
  xAxis: {
    type: 'category'
  },
  yAxis: {
    title: {
      text: 'Realisasi Keuangan'
    }

  },
  legend: {
    enabled: false
  },
  plotOptions: {
    series: {
      borderWidth: 0,
      dataLabels: {
        enabled: true,

          rotation: 270,
               y: -15,
        format: '{point.y:.1f}%'
      }
    }
  },

  tooltip: {
    headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
    pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
  },

  series: [
    {
      name: "Realisasi Keuangan",
      colorByPoint: true,
      data: [
      <?php foreach ($grafik_realisasi_keuangan as $key => $value) { 
        $urutan = $key+1;
        if ($urutan==count($grafik_realisasi_keuangan)) {
            $warna = 'red';
        }
        elseif ($urutan==1) {
            $warna = 'green';
        }else{
            $warna = 'yellow';

        }
        ?>
          
        {
          name: "<?php echo $value['singkatan_skpd'] ?>",
          y: <?php echo $value['rk'] ?>,
          drilldown: "Chrome",
          color :'<?php echo $warna ?>'
        },
      <?php } ?>
       
      ]
    }
  ],
  
});


function lihat_realisasi_fisik(){
    $('#data_realisasi_fisik').modal('show');
}
function lihat_realisasi_keuangan(){
    $('#data_realisasi_keuangan').modal('show');
}
</script>