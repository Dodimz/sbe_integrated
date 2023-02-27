

<div class="mb-3 alert alert-primary alert-dismissible fade show" role="alert">
    <!-- <span class="pr-2">
        <i class="fa fa-question-circle"></i>
    </span> -->
    <?php echo jadwal_rfk_kab_kota()['aktif'] ?>
    Selamat datang di aplikasi Simbangda Based Evidence V.4! <br>
    Silahkan lihat tutorial penggunaan aplikasi Simbangda Based Evidence <a href="<?php echo base_url() ?>dashboard/tutorial" class="btn btn-outline-info btn-xs">Disini</a>  

</div>



<div class="tabs-animation">
 
    <div class="row">
        
        <div class="col-lg-12 col-xl-12">
            <div class="main-card mb-3 card">
                <div class="card-body">
                  <div class="mt-3 row">
                    <div class="col-sm-12 col-md-3">
                        <div class="widget-content p-0">
                            <div class="widget-content-outer">
                                <div class="sub-label-left font-size-md">Belanja Operasi</div>
                                <div class="widget-content-wrapper">
                                    <div class="widget-content-left">
                                        <div class="widget-numbers text-dark"><?php echo $persen_bo; ?> %</div>
                                    </div>
                                </div>
                                <div class="widget-progress-wrapper mt-1">
                                    <div class="progress-bar-xs progress-bar-animated-alt progress">
                                        <div class="progress-bar bg-info" role="progressbar" aria-valuenow="<?php echo $persen_bo; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $persen_bo; ?>">%</div>
                                    </div>
                                    <div class="progress-sub-label">
                                        <div class="sub-label-right font-size-lg">
                                            <div class="text-success pl-2 text-dark"><?php echo "Rp. " . number_format($bo, 0, '', '.'); ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-3">
                        <div class="widget-content p-0">
                            <div class="widget-content-outer">
                                <div class="sub-label-left font-size-md">Belanja Modal</div>
                                <div class="widget-content-wrapper">
                                    <div class="widget-content-left">
                                        <div class="widget-numbers text-dark"><?php echo $persen_bm; ?> %</div>
                                    </div>
                                </div>
                                <div class="widget-progress-wrapper mt-1">
                                    <div class="progress-bar-xs progress-bar-animated-alt progress">
                                        <div class="progress-bar bg-info" role="progressbar" aria-valuenow="<?php echo $persen_bm; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $persen_bm; ?>">%</div>
                                    </div>
                                    <div class="progress-sub-label">
                                        <div class="sub-label-right font-size-lg">
                                            <div class="text-success pl-2 text-dark"><?php echo "Rp. " . number_format($bm, 0, '', '.'); ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-3">
                        <div class="widget-content p-0">
                            <div class="widget-content-outer">
                                <div class="sub-label-left font-size-md">Belanja Tidak Terduga</div>
                                <div class="widget-content-wrapper">
                                    <div class="widget-content-left">
                                        <div class="widget-numbers text-dark"><?php echo $persen_btt; ?> %</div>
                                    </div>
                                </div>
                                <div class="widget-progress-wrapper mt-1">
                                    <div class="progress-bar-xs progress-bar-animated-alt progress">
                                        <div class="progress-bar bg-info" role="progressbar" aria-valuenow="<?php echo $persen_btt; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $persen_btt; ?>">%</div>
                                    </div>
                                    <div class="progress-sub-label">
                                        <div class="sub-label-right font-size-lg">
                                            <div class="text-success pl-2 text-dark"><?php echo "Rp. " . number_format($btt, 0, '', '.'); ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-3">
                        <div class="widget-content p-0">
                            <div class="widget-content-outer">
                                <div class="sub-label-left font-size-md">Belanja Transfer</div>
                                <div class="widget-content-wrapper">
                                    <div class="widget-content-left">
                                        <div class="widget-numbers text-dark"><?php echo $persen_bt; ?> %</div>
                                    </div>
                                </div>
                                <div class="widget-progress-wrapper mt-1">
                                    <div class="progress-bar-xs progress-bar-animated-alt progress">
                                        <div class="progress-bar bg-info" role="progressbar" aria-valuenow="<?php echo $persen_bt; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $persen_bt; ?>">%</div>
                                    </div>
                                    <div class="progress-sub-label">
                                        <div class="sub-label-right font-size-lg">
                                            <div class="text-success pl-2 text-dark"><?php echo "Rp. " . number_format($bt, 0, '', '.'); ?></div>
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
        
    </div>
</div>

















<div class="tabs-animation">
 
    <div class="row">
        <div class="col-lg-12 col-xl-4">
            <div class="main-card mb-3 card">
                <div class="card-body">
                        <table class="table">
                           
                            <tr>
                                <td><i class="fa fa-users"></i></td>
                                <td>Akses</td>
                                <td><?php  echo $this->session->userdata('group_name'); ?> </td>
                            </tr>
                            <tr>
                                <td><i class="fa fa-users"></i></td>
                                <td>Penanggung Jawab</td>
                                <td><?php echo $this->session->userdata('full_name'); ?></td>
                            </tr>
                            <tr>
                                <td><i class="fa fa-calendar"></i></td>
                                <td>Bulan Aktif</td>
                                <td><?php echo konversi_bulan($bulan_aktif) . ' ' . tahun_anggaran(); ?></td>
                            </tr>
                            <tr>
                                <td><i class="lnr-store btn-icon-wrapper"></i></td>
                                <td>Tahap APBD Aktif</td>
                                <td><?php echo $nama_tahap_apbd; ?></td>
                            </tr>
                            <tr>
                                <td><i class="fa fa-money-bill"></i></td>
                                <td>Pagu </td>
                                <td><?php echo "Rp. " . number_format($anggaran_apbd, 0, '', '.'); ?></td>
                            </tr>
                            <tr>
                                <td colspan="3">

                                    <?php if ($this->session->userdata('group_name') == 'OPERATOR') : ?>
                                                <button class="btn btn-info btn-sm" onclick="sync(<?php echo $this->session->userdata('id_instansi'); ?>)" style="background:blue; width:100%" id="tombol_sync"><i class="fas fa-refresh "></i>Synchronize</button>
                                        <?php endif; ?>
                                </td>
                            </tr>
                        </table>
                  
            
                    
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-xl-8">
            <div class="main-card mb-3 card">
                <div style="padding:10px">
                    <?php if ($jumlah_pengumuman==0) { ?>
                         <div class="alert alert-info">Tidak ada pengumuman</div>
                    <?php }else{ ?>
                         <div class="alert alert-info"><u><b>Pengumuman Terbaru</b></u>
                        <h5><?php echo $data_pengumuman->judul ?></h5>
                        <?php echo substr($data_pengumuman->keterangan, 0,380) ?>.... <br>
                        <button class="btn btn-info btn-sm" onclick="detail_pengumuman('<?php echo sbe_crypt($data_pengumuman->id_pengumuman,"E") ?>')">Lihat Detail Pengumuman</button>
                        </div>
                        
                    <?php } ?>
                      
                </div>                
                   
                    

            </div>
        </div>
        
    </div>
</div>






<div class="tabs-animation" style="display:none">
 <input type="hidden" class="form-control" id="id_instansi_grafik" value="<?php echo id_instansi() ?>">
    <div class="row">
        <div class="col-lg-12 col-xl-6">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <h5 class="card-title">Grafik Realisasi Fisik</h5>
                    <div id="fisik" name="fisik"></div>
                    <h5 class="card-title">Table Realisasi Fisik</h5>
                    <div class="mt-3 row">
                        <div class="table-responsive">
                            <table id="tfisik_rfisik" class="table table-striped table-bordered dt-responsive">
                                <thead style="background-color: rgb(60, 141, 188);color:white;">
                                    <th colspan="13" class="text-center">Fisik</th>
                                </thead>
                                <thead>
                                    <th>F</th>
                                    <th>Jan</th>
                                    <th>Feb</th>
                                    <th>Mar</th>
                                    <th>Apr</th>
                                    <th>Mei</th>
                                    <th>Jun</th>
                                    <th>Jul</th>
                                    <th>Agu</th>
                                    <th>Sep</th>
                                    <th>Okt</th>
                                    <th>Nov</th>
                                    <th>Des</th>
                                </thead>
                                <tbody>
                                    <tr id="tfisik">
                                    </tr>
                                    <tr id="rfisik">
                                    </tr>
                                    <tr id="dfisik">
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-xl-6">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <h5 class="card-title">Grafik Realisasi Keuangan</h5>
                    <div id="keuangan" name="keuangan"></div>
                    <h5 class="card-title">Table Realisasi Keuangan</h5>
                    <div class="mt-3 row">
                        <div class="table-responsive">
                            <table id="tkeu_rkeu" class="table table-striped table-bordered dt-responsive">
                                <thead style="background-color: rgb(60, 141, 188);color:white;">
                                    <th colspan="13" class="text-center">Keuangan</th>
                                </thead>
                                <thead>
                                    <th>K</th>
                                    <th>Jan</th>
                                    <th>Feb</th>
                                    <th>Mar</th>
                                    <th>Apr</th>
                                    <th>Mei</th>
                                    <th>Jun</th>
                                    <th>Jul</th>
                                    <th>Agu</th>
                                    <th>Sep</th>
                                    <th>Okt</th>
                                    <th>Nov</th>
                                    <th>Des</th>
                                </thead>
                                <tbody>
                                    <tr id="tkeu">
                                    </tr>
                                    <tr id="rkeu">
                                    </tr>
                                    <tr id="dkeu">
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo $extra_js2 ?>