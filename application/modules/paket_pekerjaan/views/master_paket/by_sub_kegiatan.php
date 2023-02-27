<?php

/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 */
?>
<div class="row">
     <div class="col-md-12 col-lg-12">
        <?php echo $this->session->flashdata('pesan') ?>
    </div>
</div>

<div class="row">
    <div class="col-md-12 col-lg-12 col-xl-12">
                            <div class="card-shadow-primary profile-responsive card-border mb-3 card">
                                 <ul class="list-group list-group-flush">
                                     <li class="bg-warm-flame list-group-item">
                                        <div class="widget-content p-0">
                                            <div class="widget-content-wrapper">
                                                <div class="widget-content-left">
                                                    <div class="widget-heading text-dark opacity-7"><?php echo jadwal_input_data_dasar()['penginputan'] ?></div>
                                                    <div class="widget-subheading opacity-10">
                                                        
                                                        
                                                            <b class="text-danger">
                                                               <?php echo jadwal_input_data_dasar()['pesan'] ?>                                                           
                                                            </b>
                                                        
                                                    </div>
                                                </div>
                                               
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                                <div class="dropdown-menu-header">
                                    <div class="dropdown-menu-header-inner bg-focus">
                                        <div class="menu-header-image opacity-3" style="background: #e2faff;"></div>
                                        <div class="menu-header-content btn-pane-right">
                                            <div>
                                                <h6 class="menu-header-subtitle">TOTAL PAKET PEKERJAAN <?php echo nama_instansi() ?></h6>
                                                <h5 class="menu-header-title"><?php echo $tot_paket_pekerjaan; ?> Paket</h5>
                                            </div>
                                      
                                        </div>
                                    </div>
                                </div>
                                <ul class="list-group list-group-flush">
                                    
                                    <li class="p-0 list-group-item">
                                        <div class="widget-content">
                                                <div class="row">
                                                    <div class="col-md-6 col-xl-3">
                                                        <div class="card mb-3 widget-content bg-arielle-smile">
                                                            <div class="widget-content-wrapper text-white">
                                                                <div class="widget-content-left">
                                                                    <div class="widget-subheading"><b>Total Paket</b></div>
                                                                    <div class="widget-heading">
                                                                        Non Urusan  
                                                                    </div>
                                                                </div>
                                                                <div class="widget-content-right">
                                                                    <div class="widget-numbers text-white">
                                                                        <?php echo $tot_paket_pekerjaan_rutin; ?>
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
                                                                    <div class="widget-numbers text-white">
                                                                        <?php echo $tot_paket_pekerjaan_swa; ?>
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
                                                                    <div class="widget-numbers text-white">
                                                                        <?php echo $tot_paket_pekerjaan_pen; ?>
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
                                                                        Penyedia - Konstruksi
                                                                    </div>
                                                                </div>
                                                                <div class="widget-content-right">
                                                                    <div class="widget-numbers text-white">
                                                                        <?php echo $tot_paket_kontruksi; ?>
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
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">

                    <table id="list-sub-kegiatan" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th style="text-align: center;" width="1%">No</th>
                                <th style="text-align: center;"  width="1%">Action</th>
                                <th style="text-align: center;"  width="1%">Tahapan APBD</th>
                                <th style="text-align:">Sub Kegiatan</th>
                                <th style="text-align: ;">Pagu</th>
                                <th style="text-align:">PPTK</th>
                                <th style="text-align: center;">Jumlah Paket</th>
                              
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>