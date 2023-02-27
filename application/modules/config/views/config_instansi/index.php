<?php 
 $status = ['Tidak Aktif','Aktif'];
    $izin_konfigurasi = ['Tidak Diizinkan','Diizinkan'];
    $apbd = [2=>'APBD AWAL','APBD PERGESERAN','APBD PERUBAHAN'];
    $penginputan = ['Di Kunci','Sesuai Jadwal','Bebas'];
    $style = ['danger','warning','success'];
    $style_izin = ['danger','success'];

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
                            <h5 class="menu-header-title">Tahun Anggaran <?php echo $config['tahun_anggaran'] ?></h5>
                            <h6 class="menu-header-subtitle">Status Konfigurasi : <?php echo $status[$config['status']]; ?></h6>
                        </div>
                        <div class="menu-header-btn-pane">
                            <div>
                                <div role="group" class="btn-group text-center">
                                    <div class="nav">
                                        <?php if ($izin_config==1) { ?>
                                            <a href="#" data-toggle="tab" class="btn btn-focus mr-1 active"  onclick="edit_config_kab_kota()"><i class="fas fa-edit"></i></a>
                                        <?php }else{ ?>
                                            <a href="#" data-toggle="tab" class="btn btn-focus mr-1 active"  onclick="Swal.fire('Tidak Di Izinkan','Anda tidak di izinkan mengubah konfigurasi sistem','warning')"><i class="fas fa-edit"></i></a>
                                        <?php } ?>
                                       
                                     
                                       
                                       
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-content">
                <div class="tab-pane show active" id="info_<?php echo $config['id_config'] ?>">
                    <ul class="list-group list-group-flush">
             
                <li class="p-0 list-group-item">
                    <div class="grid-menu grid-menu-2col">
                        <div class="no-gutters row">
                            <div class="col-sm-6">
                                <div class="widget-content">
                                    <div class="text-center">
                                        <h5 class="widget-heading">Tahapan APBD Berjalan</h5>
                                        <h5>
                                        <span><b class="text-dark"><?php echo $apbd[tahapan_apbd()] ?></b></span></h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="widget-content">
                                    <div class="text-center">
                                        <h5 class="widget-heading">Bulan Pelaporan Berjalan</h5>
                                        <h5>
                                        <span><b class="text-dark"><?php echo bulan_global($config['bulan_aktif']) ?></b></span></h5>
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
                                    <span><b class="text-success">
                                             <?php 
                                $pjiddm = explode('-', $config['jadwal_input_data_dasar_awal']);
                                $pjidds = explode('-', $config['jadwal_input_data_dasar_akhir']);
                                $mulai = $pjiddm[2].' '.nama_bulan($pjiddm[1]).' '.$pjiddm[0];
                                $selesai = $pjidds[2].' '.nama_bulan($pjidds[1]).' '.$pjidds[0];
                               
                               
                                ?>

                                <?php  echo $mulai; ?></b> sampai <b class="text-danger"><?php  echo $selesai; ?></b></span></h5>
                                </div>
                            </div>
                        </li>
                        <li class="p-0 list-group-item">
                            <div class="grid-menu grid-menu-3col">
                                <div class="no-gutters row">
                                    <div class="col-sm-4">
                                        <div class="widget-content">
                                            <div class="text-center">
                                                <h5 class="widget-heading">Jadwal Penginputan RFK</h5>
                                               <h5>
                                                    <span><b class="text-success"><?php echo$config['tgl_input_rfk_mulai'] ?></b> - <b class="text-danger"><?php echo $config['tgl_input_rfk_akhir']; ?></b> <?php echo bulan_global(date('n')).' '.$config['tahun_anggaran']   ?></span>
                                                </h5>
                                            </div>
                                        </div>
                                    </div>
                                     <div class="col-sm-4">
                                        <div class="widget-content">
                                            <div class="text-center">
                                                <h5 class="widget-heading">Jadwal Valisasi Fisik</h5>
                                                 <h5>
                                                    <span><b class="text-success"><?php echo$config['tgl_validasi_rfk_mulai'] ?></b> - <b class="text-danger"><?php echo $config['tgl_validasi_rfk_akhir']; ?></b> <?php echo bulan_global(date('n')).' '.$config['tahun_anggaran']   ?></span>
                                                </h5>
                                            </div>
                                        </div>
                                    </div>
                                     <div class="col-sm-4">
                                        <div class="widget-content">
                                             <div class="text-center">
                                                <h5 class="widget-heading">Izin Penginputan</h5>
                                                <h5><span class="pr-2"> <b class="text-<?php echo $style[$config['penginputan']] ?>"><?php echo $penginputan[$config['penginputan']] ?></b> </h5>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </li>
                      
                    </ul>
                </div>
                <div class="tab-pane" id="data_config_<?php echo $config['id_config'] ?>">
                    















                    




                </div>



            </div>
        </div>
    </div>

