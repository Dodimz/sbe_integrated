
<div class="row">
    <div class="col-md-12 col-lg-12">
        <div class="widget-chart widget-chart2 text-left mb-3 card-btm-border card-shadow-success border-success card">
            <div class="widget-chat-wrapper-outer">
                <div class="widget-chart-content">
                    <div class="widget-title opacity-5 text-uppercase">Option </div>
                        <div class="widget-chart-flex align-items-center mt-2  mb-0 w-100">
                            <div id="tempat_tombol_option_config">
                            <?php   if ($j_data_config==0) { ?>
                               <button class="btn btn-info" id="tombol_add_config" onclick="tambah_config()">Tambah Konfigurasi</button>
                            <?php }else{ ?>
                                    <div class="alert alert-info">Data konfigurasi ditambahkan. <br>Anda tidak bisa lagi menambahkan konfigurasi untuk tahun ini dan bisa ditambahkan kembali di tahun selanjutnya</div>
                            <?php } ?>
                              
                            </div> <hr>  
                            <div style="float:right">
                                <button class="btn btn-info" id="tombol_add_config" onclick="izin_config()">Izin Konfigurasi User</button>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                </div>
            </div>
        </div>
    <?php echo  $this->session->flashdata('pesan') ?>
    </div>
</div>






















<div class="row">
    <?php 
    $status = ['Tidak Aktif','Aktif'];
    $izin_konfigurasi = ['Tidak Diizinkan','Diizinkan'];
    $apbd = [2=>'APBD AWAL','APBD PERGESERAN','APBD PERUBAHAN'];
    $penginputan = ['Di Kunci','Sesuai Jadwal','Bebas'];
    $style = ['danger','warning','success'];
    $style_izin = ['danger','success'];
    foreach ($data_config as $k => $v) { 

    $onclick_edit = 'edit_config('."'".sbe_crypt($v['id_config'], 'E')."'".')';
    $onclick_belum_aktif = "Swal.fire('Error','Belum Aktif','error')";

    $edit   = '<button class="btn btn-focus mr-1"  title="Edit konfigurasi aplikasi '.$v['tahun_anggaran'].'"  onclick="'.$onclick_edit.'"><i class="fas fa-edit"></i></button>';

                ?>
<div class="col-md-12 col-lg-6 col-xl-6">
                            
        <div class="card-shadow-primary profile-responsive card-border mb-3 card">
            <div class="dropdown-menu-header">
                <div class="dropdown-menu-header-inner bg-info">
                    <div class="menu-header-image opacity-2" style="background-image: url('assets/images/dropdown-header/abstract1.jpg')"></div>
                    <div class="menu-header-content btn-pane-right">
                        <div class="avatar-icon-wrapper mr-2 avatar-icon-xl">
                            
                        </div>
                         <div>
                            <h5 class="menu-header-title">Tahun Anggaran <?php echo $v['tahun_anggaran'] ?></h5>
                            <h6 class="menu-header-subtitle">Status Konfigurasi : <?php echo $status[$v['status']]; ?></h6>
                        </div>
                        <div class="menu-header-btn-pane">
                            <div>
                                <div role="group" class="btn-group text-center">
                                    <div class="nav">
                                        <a href="#info_<?php echo $v['id_config'] ?>" data-toggle="tab" class="btn btn-focus mr-1 active"><i class="fas fa-info"></i></a>
                                        <a href="#data_config_<?php echo $v['id_config'] ?>" data-toggle="tab" class="btn btn-focus mr-1"><i class="fas fa-bars"></i></a>
                                        <?php echo  $edit ?>
                                       
                                       
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-content">
                <div class="tab-pane show active" id="info_<?php echo $v['id_config'] ?>">
                    <ul class="list-group list-group-flush">
               <!--  <li class="bg-warm-flame list-group-item">
                    <div class="widget-content p-0">
                        <div class="widget-content-wrapper">
                           
                            <div class="widget-content-left">
                                <div class="widget-heading text-dark opacity-7">Tahapan APBD</div>
                                <div class="widget-subheading opacity-10"><span class="pr-2">
                                    <b class="text-dark">APBD AWAL</b></span>
                                </div>
                            </div>
                          
                        </div>
                    </div>
                </li> -->
                <li class="p-0 list-group-item">
                    <div class="grid-menu grid-menu-2col">
                        <div class="no-gutters row">
                            <div class="col-sm-6">
                                <div class="widget-content">
                                    <div class="text-center">
                                        <h5 class="widget-heading">Tahapan APBD Berjalan</h5>
                                        <h5>
                                        <span><b class="text-dark"><?php echo $apbd[$v['tahapan_apbd']] ?></b></span></h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="widget-content">
                                    <div class="text-center">
                                        <h5 class="widget-heading">Bulan Pelaporan Berjalan</h5>
                                        <h5>
                                        <span><b class="text-dark"><?php echo bulan_global($v['bulan_aktif']) ?></b></span></h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
            <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <div class="widget-content">
                                <div class="text-center">
                                    <h5 class="widget-heading">Jadwal Penginputan Data Awal</h5>
                                    
                                    <h6>
                                    <span>Program, Kegiatan, Sub Kegiatan, Pagu, Target, Sumber Dana</span></h6>
                                    <h5>
                                    <span><b class="text-success"><?php echo$v['jadwal_input_data_dasar_awal'] ?></b> sampai <b class="text-danger"><?php echo$v['jadwal_input_data_dasar_akhir'] ?></b></span></h5>
                                </div>
                            </div>
                        </li>
                        <li class="p-0 list-group-item">
                            <div class="grid-menu grid-menu-3col">
                                <div class="no-gutters row">
                                    <div class="col-sm-4">
                                        <div class="widget-content">
                                            <div class="text-center">
                                                <h5 class="widget-heading">Jadwal Penginputan RFK <br> Lingkup Provinsi</h5>
                                               <h5>
                                                    <span><b class="text-success"><?php echo$v['tgl_input_rfk_mulai'] ?></b> - <b class="text-danger"><?php echo $v['tgl_input_rfk_akhir']; ?></b> <?php echo bulan_global(date('n')).' '.$v['tahun_anggaran']   ?></span>
                                                </h5>
                                            </div>
                                        </div>
                                    </div>
                                     <div class="col-sm-4">
                                        <div class="widget-content">
                                            <div class="text-center">
                                                <h5 class="widget-heading">Jadwal Valisasi Fisik <br> Lingkup Provinsi</h5>
                                                 <h5>
                                                    <span><b class="text-success"><?php echo$v['tgl_validasi_rfk_mulai'] ?></b> - <b class="text-danger"><?php echo $v['tgl_validasi_rfk_akhir']; ?></b> <?php echo bulan_global(date('n')).' '.$v['tahun_anggaran']   ?></span>
                                                </h5>
                                            </div>
                                        </div>
                                    </div>
                                     <div class="col-sm-4">
                                        <div class="widget-content">
                                            <div class="text-center">
                                                <h5 class="widget-heading">Jadwal Penginputan RFK <br> Lingkup Kab / Kota</h5>
                                                 <h5>
                                                    <span><b class="text-success"><?php echo$v['tgl_input_rfk_kab_kota_awal'] ?></b> - <b class="text-danger"><?php echo $v['tgl_input_rfk_kab_kota_akhir']; ?></b> <?php echo bulan_global(date('n')).' '.$v['tahun_anggaran']   ?></span>
                                                </h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="p-0 list-group-item">
                            <div class="grid-menu grid-menu-3col">
                                <div class="no-gutters row">
                                    <div class="col-sm-6">
                                        <div class="widget-content">
                                            <div class="text-center">
                                                <h5 class="widget-heading">Izin Penginputan <br> Lingkup Provinsi</h5>
                                                <h5><span class="pr-2"> <b class="text-<?php echo $style[$v['penginputan']] ?>"><?php echo $penginputan[$v['penginputan']] ?></b> </h5>
                                            </div>
                                        </div>
                                    </div>
                                     <div class="col-sm-6">
                                        <div class="widget-content">
                                            <div class="text-center">
                                                <h5 class="widget-heading">Izin Penginputan <br> Lingkup Kab / Kota</h5>
                                                <h5><span class="pr-2"> <b class="text-<?php echo $style[$v['penginputan_kab_kota']] ?>"><?php echo $penginputan[$v['penginputan_kab_kota']] ?></b> </h5>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="tab-pane" id="data_config_<?php echo $v['id_config'] ?>">
                    















                    <div class="main-card mb-3 card">
                        <div class="card-header">
                            <i class="header-icon lnr-gift icon-gradient bg-grow-early"> </i>INSTANSI YANG BERADA PADA TAHUN <?php echo $v['tahun_anggaran'] ?>
                            <div class="btn-actions-pane-right">
                                <div class="nav">
                                    <a data-toggle="tab" href="#skpd_pemprov_<?php echo $v['id_config'] ?>" class="border-0 btn-transition btn btn-outline-primary active">SKPD Provinsi</a>
                                    <a data-toggle="tab" href="#skpd_kab_kota_<?php echo $v['id_config'] ?>" class="mr-1 ml-1 border-0 btn-transition btn btn-outline-primary">SKPD Kab Kota</a>
                                   
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="skpd_pemprov_<?php echo $v['id_config'] ?>" role="tabpanel">
                                   












                                        <div style="height:360px; overflow-y:scroll">   
                                                
                                            <ul class="todo-list-wrapper list-group list-group-flush" id="list_skpd_pemprov_<?php echo $v['id_config'];?>">
                                               
                                            </ul>
                                        </div>

                                </div>
                                <div class="tab-pane" id="skpd_kab_kota_<?php echo $v['id_config'] ?>" role="tabpanel">
                                    
                                        <div style="height:360px; overflow-y:scroll">   
                                                
                                            <ul class="todo-list-wrapper list-group list-group-flush" id="list_skpd_kab_kota_<?php echo $v['id_config'];?>">
                                               
                                            </ul>
                                        </div>
                                </div>
                            </div>
                        </div>
                      
                    </div>





                </div>



            </div>
        </div>
    </div>
<?php } ?>
</div>


























<!-- 
<div class="mb-3 card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table id="table-config" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th style="text-align: center;" width="1%">No</th>
                                <th style="text-align: center;">APBD</th>
                                <th style="text-align: center;">Jadwal Input Data Dasar</th>
                                <th style="text-align: center;">Jadwal Input Realisasi Fisik Dan Keuangan Pemerintah Provinsi</th>
                                <th style="text-align: center;">Jadwal Validasi Fisik</th>
                                <th style="text-align: center;">Jadwal Input Realisasi Fisik Dan Keuangan Pemerintah Kab / Kota</th>
                                <th style="text-align: center;">Penginputan ke dalam aplikasi</th>
                                <th style="text-align: center;">Status Konfigurasi</th>
                                <th style="text-align: center;"  width="10%">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div> -->