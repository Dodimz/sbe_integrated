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
                                                <h6 class="menu-header-subtitle" id="">Pantau  SKPD</h6>
                                                <h5 class="menu-header-title" id="nama_skpd">SKPD</h5>
                                            </div>
                                            <?php if ($id_group!=5) { ?>
                                            <div class="menu-header-btn-pane">
                                            	 
                                                <button class="btn btn-primary" onclick="pilih_instansi(<?php echo $id_group ?>)"><span class="ladda-label">Ganti SKPD</span></button>
                                            </div>
                                        <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        
                        </div>
</div>






















































<div class="main-card mb-3 card">
                                        <div class="card-body">
                                            <div class="mb-3 text-center">
                                                <div role="group" class="btn-group-sm nav btn-group">
                                                    <a data-toggle="tab" href="#dashboard" class="btn-shadow btn btn-outline-info active">Dashboard</a>
                                                    <a data-toggle="tab" href="#data_apbd" class="btn-shadow  btn btn-outline-info">Data APBD</a>
                                                    <a data-toggle="tab" href="#struktur_instansi" class="btn-shadow btn btn-outline-info">Struktur Instansi</a>
                                                    <a data-toggle="tab" href="#master_paket_rf" class="btn-shadow btn btn-outline-info">Master Paket & Realisasi Fisik</a>
                                                    <a data-toggle="tab" href="#rk" class="btn-shadow btn btn-outline-info">Realisasi Keuangan</a>
                                                    <a data-toggle="tab" href="#kontrak" class="btn-shadow btn btn-outline-info">Daftar Kontrak</a>
                                                    <a data-toggle="tab" href="#gis" class="btn-shadow btn btn-outline-info">GIS</a>
                                                    <a data-toggle="tab" href="#bantuan" class="btn-shadow btn btn-outline-info">Bantuan</a>
                                                </div>
                                            </div>
                                            <div class="tab-content">
                                                <div class="tab-pane fade active show" id="dashboard">
                                                    
                                                         Bagian yang isinya grafik2 
                                                </div>
                                                <div class="tab-pane fade show" id="data_apbd">
                                                    
                                                         berisi data APBD  (langsung ke sub kegiatan instansi gabungan ) dan ada tombol untuk melihat permasalahan dan solusi
                                                         serta per sub kegiatan bisa juga mengubah / mengedit target, pagu, dan sumber dana
                                                </div>
                                                <div class="tab-pane fade show" id="struktur_instansi">
                                                    
                                                         menampilkan struktur instansi dan sub kegiatan PPTK
                                                </div>
                                                <div class="tab-pane fade show" id="master_paket_rf">
                                                    
                                                         menampilkan paket pekerjaan sekaligus untuk tombol realisasi fisiknya
                                                </div>
                                                <div class="tab-pane fade show" id="rk">
                                                    
                                                         menampilkan info tentang realisasi keuangan
                                                </div>
                                                <div class="tab-pane fade show" id="kontrak">
                                                    
                                                         menampilkan daftar kontrak 
                                                </div>
                                                <div class="tab-pane fade show" id="gis">
                                                    
                                                         menampilkan GIS yang ada pada SKPD
                                                </div>
                                                <div class="tab-pane fade show" id="bantuan">
                                                    
                                                        manampilkan bantuna yang diusulkan SKPD
                                                </div>
                                              
                                            </div>  
                                        </div>
                                    </div>












            