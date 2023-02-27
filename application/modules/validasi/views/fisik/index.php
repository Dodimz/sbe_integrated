<?php
$id_group = $this->session->userdata('id_group');
?>
<div class="row">
    <div class="col-md-12 col-lg-12 col-xl-12">
                            <div class="card-shadow-primary profile-responsive card-border mb-3 card">
                                <div class="dropdown-menu-header">
                                    <div class="dropdown-menu-header-inner bg-focus">
                                        <div class="menu-header-image opacity-3" style="background: #e2faff;"></div>
                                        <div class="menu-header-content btn-pane-right">
                                           
                                            <div>
                                                <input type="hidden" name="id_instansi_terpilih" id="id_instansi_terpilih" value="<?php echo $id_instansi ?>">
                                                <input type="hidden" name="tahun_anggaran_terpilih" id="tahun_anggaran_terpilih">
                                                <h6 class="menu-header-subtitle" id="nama_skpd">nama SKPD</h6>
                                                <h5 class="menu-header-title" id="nama_helpdesk">NAMA Helpdesk</h5>
                                            </div>
                                            <?php if ($id_group!=5) { ?>
                                            <div class="menu-header-btn-pane">
                                            	 <button class="btn btn-info" type="button" onclick="show_all_statistika()">Lihat Gabungan Rekap Statistika</button>
                                                <button class="btn btn-primary" onclick="pilih_instansi(<?php echo $id_group ?>)"><span class="ladda-label">Ganti SKPD</span></button>
                                            </div>
                                        <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="bg-warm-flame list-group-item">
                                        <div class="widget-content p-0">
                                            <div class="widget-content-wrapper">
                                               
                                                <div class="widget-content-left">
                                                    <div class="widget-subheading opacity-10">
                                                        <span>Evidence yang di validasi saat ini adalah evidence Tahun Anggaran <b class="text-dark" id="tahun_anggaran">??</b></span>
                                                        <span id="jadwal_validasi"></span>
                                                    </div>
                                                </div>
                                                <div class="widget-content-right">
                                                    <button class="btn btn-info btn-sm" onclick="ganti_tahun_anggaran()">Ganti Tahun Anggaran</button>
                                                
                                                </div>
                                           
                                            </div>
                                        </div>
                                    </li>
                                    <li class="p-0 list-group-item">
                                        <div class="widget-content">
                                                <div class="row">
                                                    <div class="col-md-6 col-xl-3">
                                                        <div class="card mb-3 widget-content bg-arielle-smile">
                                                            <div class="widget-content-wrapper text-white">
                                                                <div class="widget-content-left">
                                                                    <div class="widget-subheading"><b>Total Paket</b></div>
                                                                    <div class="widget-heading">
                                                                        Semua Paket Pekerjaan  
                                                                    </div>
                                                                </div>
                                                                <div class="widget-content-right">
                                                                    <div class="widget-numbers text-white" id="semua_paket_skpd">
                                                                        <?php echo $total_paket; ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-xl-3">
                                                        <div class="card mb-3 widget-content bg-arielle-smile">
                                                            <div class="widget-content-wrapper text-white">
                                                                <div class="widget-content-left">
                                                                    <div class="widget-subheading"><b>Total Paket</b></div>
                                                                    <div class="widget-heading">
                                                                        Rutin
                                                                    </div>
                                                                </div>
                                                                <div class="widget-content-right">
                                                                    <div class="widget-numbers text-white" id="semua_paket_rutin_skpd">
                                                                        <?php echo $total_paket_rutin; ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-xl-3">
                                                        <div class="card mb-3 widget-content bg-arielle-smile">
                                                            <div class="widget-content-wrapper text-white">
                                                                <div class="widget-content-left">
                                                                    <div class="widget-subheading"><b>Total Paket</b></div>
                                                                    <div class="widget-heading">
                                                                        Swakelola  
                                                                    </div>
                                                                </div>
                                                                <div class="widget-content-right">
                                                                    <div class="widget-numbers text-white" id="semua_paket_swakelola_skpd">
                                                                        <?php echo $total_paket_swakelola; ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-xl-3">
                                                        <div class="card mb-3 widget-content bg-arielle-smile">
                                                            <div class="widget-content-wrapper text-white">
                                                                <div class="widget-content-left">
                                                                    <div class="widget-subheading"><b>Total Paket</b></div>
                                                                    <div class="widget-heading">
                                                                        Penyedia 
                                                                    </div>
                                                                </div>
                                                                <div class="widget-content-right">
                                                                    <div class="widget-numbers text-white" id="semua_paket_penyedia_skpd">
                                                                        <?php echo $total_paket_penyedia; ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    </li>
                                </ul>
                            </div>
                        
                        </div>
</div>



































































            
                    <div class="mb-3 card">
                        <div class="tabs-lg-alternate card-header">
                            <ul class="nav nav-justified">
                                <li class="nav-item">
                                    <a href="#swakelola" data-toggle="tab" class="nav-link active minimal-tab-btn-1">
                                        <div class="widget-number"><span id="total_evidence_swakelola">???</span></div>
                                        <div class="tab-subheading">
                                            <b>
                                            	
                                            <span class="pr-2 opactiy-6">
                                                <i class="fa fa-book"></i>
                                            </span>
                                            Evidence Paket Swakelola
                                            </b>
                                            <div class="widget-description text-success">
                                                        <span class="pl-1" id="total_evidence_swakelola_belum_validasi">0</span> Belum Di Validasi</div>
                                        </div>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#penyedia" data-toggle="tab" class="nav-link minimal-tab-btn-2">
                                        <div class="widget-number"><span id="total_evidence_penyedia">???</span></div>
                                        <div class="tab-subheading">
                                            <b>
                                            	
                                            <span class="pr-2 opactiy-6">
                                                <i class="fa fa-book"></i>
                                            </span>
                                            Evidence Paket Penyedia
                                            </b>
                                            <div class="widget-description text-success">
                                                        <span class="pl-1" id="total_evidence_penyedia_belum_validasi">0</span> Belum Di Validasi</div>
                                        </div>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#belum_diperiksa" data-toggle="tab" class="nav-link minimal-tab-btn-3">
                                        <div class="widget-number"><span id="total_evidence_belum_validasi">???</span></div>
                                        <div class="tab-subheading">
                                            <b>
                                            	
                                            <span class="pr-2 opactiy-6">
                                                <i class="fa fa-book"></i>
                                            </span>
                                            Evidence Belum Divalidasi
                                            </b>
                                             <div class="widget-description text-success">
                                                        <span class="pl-1" ><br></span> </div>
                                        </div>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#ditolak" data-toggle="tab" class="nav-link minimal-tab-btn-3">
                                        <div class="widget-number"><span id="total_evidence_ditolak">???</span></div>
                                        <div class="tab-subheading">
                                            <b>
                                            	
                                            <span class="pr-2 opactiy-6">
                                                <i class="fa fa-book"></i>
                                            </span>
                                            Evidence Ditolak
                                            </b>
                                            <div class="widget-description text-success">
                                                        <span class="pl-1" id=""><br></span> </div>
                                        </div>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#statistika" data-toggle="tab" class="nav-link minimal-tab-btn-3">
                                        <div class="widget-number"><i class="fa fa-book"></i></div>
                                        <div class="tab-subheading">
                                            <b>
                                            	
                                            <span class="pr-2 opactiy-6">
                                                <i class="fa fa-book"></i>
                                            </span>
                                            Statistika
                                            </b>  
                                            <div class="widget-description text-success">
                                                        <span class="pl-1" id=""><br></span> </div>
                                          
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-content">
                            <div class="tab-pane fade active show" id="swakelola">
                                <div class="card-body">
                                     <table id="table-paket-swakelola" class="display"  width="100%">
		                                <thead>
		                                    <tr>
		                                        <th rowspan="2" style="width:100px">No</th>
		                                 
		                                        <th rowspan="2" width="35%">Paket</th>
                                                <th colspan="4" width="35%"><center>Evidence</center></th>
		                                        <th rowspan="2" width="1%">Nilai</th>
		                                        <th rowspan="2" width="1%">Action</th>
		                                    </tr>
                                            <tr>
                                              
                                                <th width="35%"><center>Banyak Beban</center></th>
                                                <th width="35%"><center>Sudah Diupload</center></th>
                                                <th width="35%"><center>Belum Diupload</center></th>
                                                <th width="1%"><center>Belum DiValidasi</center></th>
                                            </tr>
		                                </thead>
		                            </table>
                                </div>
                            </div>
                            <div class="tab-pane " id="penyedia">
                                <div class="card-body">
                                   
                                     <table id="table-paket-penyedia" class="display" width="100%">
		                                  <thead>
                                            <tr>
                                                <th rowspan="2" style="width:100px">No</th>
                                                <th rowspan="2" width="35%">Paket</th>
                                                <th colspan="4" width="35%"><center>Evidence</center></th>
                                                <th rowspan="2" width="1%">Nilai</th>
                                                <th rowspan="2" width="1%">Action</th>
                                            </tr>
                                            <tr>
                                              
                                                <th width="35%"><center>Banyak Beban</center></th>
                                                <th width="35%"><center>Sudah Diupload</center></th>
                                                <th width="35%"><center>Belum Diupload</center></th>
                                                <th width="1%"><center>Belum DiValidasi</center></th>
                                            </tr>
                                        </thead>
		                            </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="statistika">
                              
                                <div class="card-body">
                                   
                                   <div class="table-responsive tables" style="overflow-x:scroll">
		                            <table id="table-statistika" class="table table-bordered" style="width:100%">
		                                <tr>
		                                    <td>Tahapan APBD</td>
		                                    <td id="nama_tahap"></td>
		                                </tr>
		                                <tr>
		                                    <td>SKPD</td>
		                                    <td id="nama_skpd"></td>
		                                </tr>
		                                <tr>
		                                    <td>Helpdesk</td>
		                                    <td id="helpdesk"></td>
		                                </tr>
		                               
		                                <tr>
		                                    <td>Total program</td>
		                                    <td id="jumlah_program"></td>
		                                </tr>
		                                <tr>
		                                    <td>Total kegiatan</td>
		                                    <td id="jumlah_kegiatan"></td>
		                                </tr>
		                                <tr>
		                                    <td>Total sub kegiatan</td>
		                                    <td id="jumlah_sub_kegiatan"></td>
		                                </tr>
		                                <tr>
		                                    <td>Total paket</td>
		                                    <td id="jumlah_paket"></td>
		                                </tr>
		                                <tr>
		                                    <td>Total evidence di upload</td>
		                                    <td id="jumlah_evidence_diupload"></td>
		                                </tr>
		                                <tr>
		                                    <td>Total evidence belum di periksa</td>
		                                    <td>
		                                            <!-- <span id="jumlah_evidence_belum_validasi"></span> <br> -->
		                                            <span id="jumlah_evidence_belum_validasi_swakelola"></span> <br>
		                                            <span id="jumlah_evidence_belum_validasi_penyedia"></span>
		                                    </td>
		                                </tr>
		                                <tr>
		                                    <td>Total evidence di setujui</td>
		                                    <td id="jumlah_evidence_approve"></td>
		                                </tr>
		                                <tr>
		                                    <td>Total evidence di tolak</td>
		                                    <td id="jumlah_evidence_reject"></td>
		                                </tr>
		                            </table>
		                        </div>
                                </div>
                              
                                
                            </div>

                            <div class="tab-pane fade" id="belum_diperiksa">
                                <div class="card-body">
                                   <table id="table-paket-belum-validasi" class="display" width="100%">
		                                <thead>
		                                    <tr>
		                                        <th style="width:100px">No</th>
		                                        <th width="35%">Paket</th>
		                                        <th width="1%">Jenis Paket</th>
		                                        <th width="1%">Belum Di Validasi</th>
		                                        <th width="1%">Nilai</th>
		                                        <th width="1%">Action</th>
		                                    </tr>
		                                </thead>
		                            </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="ditolak">
                                <div class="card-body">
                                     <table id="table-paket-evidence-ditolak" class="display" width="100%">
		                                <thead>
		                                    <tr>
		                                        <th style="width:100px">No</th>
		                                        <th width="35%">Paket</th>
		                                        <th width="1%">Jenis Paket</th>
		                                        <th width="1%">Banyak Ditolak</th>
		                                        <th width="1%">Nilai</th>
		                                        <th width="1%">Action</th>
		                                    </tr>
		                                </thead>
		                            </table>
                                </div>
                            </div>
                        </div>
                    </div>









































