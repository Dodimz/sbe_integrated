<?php

/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 */
// var_dump($this->session->userdata());
// $id_group = $this->session->userdata('id_group');
$id_user = $this->session->userdata('íd_user');
$id_instansi = $this->session->userdata('id_intansi');

?>

<div class="row">
    <div class="col-md-6 col-lg-3">
        <div class="widget-chart widget-chart2 text-left mb-3 card-btm-border card-shadow-primary border-primary card">
            <div class="widget-chat-wrapper-outer">
                <div class="widget-chart-content">
                    <div class="widget-title opacity-5 text-uppercase">Total Program</div>
                    <div class="widget-numbers mt-2 fsize-4 mb-0 w-100">
                        <div class="widget-chart-flex align-items-center">
                            <div>
                                <span class="opacity-10 text-success pr-2">
                                    <i class="fa fa-angle-up"></i>
                                </span>
                                 <?php echo $tot_program; ?>
                                <small>Data</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="widget-chart widget-chart2 text-left mb-3 card-btm-border card-shadow-warning border-warning card">
            <div class="widget-chat-wrapper-outer">
                <div class="widget-chart-content">
                    <div class="widget-title opacity-5 text-uppercase">Kegiatan</div>
                    <div class="widget-numbers mt-2 fsize-4 mb-0 w-100">
                        <div class="widget-chart-flex align-items-center">
                            <div>
                                <span class="opacity-10 text-danger pr-2">
                                    <i class="fa fa-angle-down"></i>
                                </span>
                                <?php echo $tot_kegiatan; ?>
                                <small>Data</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="widget-chart widget-chart2 text-left mb-3 card-btm-border card-shadow-warning border-warning card">
            <div class="widget-chat-wrapper-outer">
                <div class="widget-chart-content">
                    <div class="widget-title opacity-5 text-uppercase">Sub Kegiatan</div>
                    <div class="widget-numbers mt-2 fsize-4 mb-0 w-100">
                        <div class="widget-chart-flex align-items-center">
                            <div>
                                <span class="opacity-10 text-danger pr-2">
                                    <i class="fa fa-angle-down"></i>
                                </span>
                                <?php echo $tot_subkeg; ?>
                                <small>Data</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 col-lg-3">
        <div class="widget-chart widget-chart2 text-left mb-3 card-btm-border card-shadow-success border-success card">
            <div class="widget-chat-wrapper-outer">
                <div class="widget-chart-content">
                    <div class="widget-title opacity-5 text-uppercase">Setting</div>
                    <div class="widget-numbers mt-2 fsize-4 mb-0 w-100">
                        <div class="widget-chart-flex align-items-center">
                            <div>

                               <a class="btn btn-info btn-xs" href="<?php echo base_url() ?>data_apbd" data-toggle="tooltip" title="Kembali"><i class="fa fa-arrow-left"></i></a>
                               <a class="btn btn-info btn-xs" href="<?php echo base_url() ?>data_apbd/usulkan_data_apbd" data-toggle="tooltip" title="Usulkan Data APBD"><i class="fa fa-book"></i></a>
                             
                                <div style="display:none">
                                    
                                   <button class="btn btn-info btn-xs" onclick="export_excel_apbd()" data-toggle="tooltip" title="Upload Dokumen APBD"><i class="fa fa-upload"></i></button>
                                   <button class="btn btn-warning btn-xs" onclick="sub_kegiatan_instansi_gabungan('excel')" data-toggle="tooltip" title="Cek dan kelola data export excel"><i class="metismenu-icon fa fa-list-ul"></i></button>
                                   <button class="btn btn-danger btn-xs" onclick="hapus_all_apbd_instansi('Export Excel')" data-toggle="tooltip" title="Hapus semua data APBD inputan type Export Excel"><i class="fa fa-trash"></i></button>

                                   <button class="btn btn-info btn-xs" onclick="get_apbd_instansi()" data-toggle="tooltip" title="Ambil data APBD Melalui Web Service" id="get_apbd_instansi"><i class="fa fa-download"></i></button>
                                   <button class="btn btn-warning btn-xs" onclick="sub_kegiatan_instansi_gabungan('api')" data-toggle="tooltip" title="Cek dan kelola data sub kegiatan melalui web service"><i class="metismenu-icon fa fa-list-ul"></i></button>
                                   <button class="btn btn-danger btn-xs" onclick="hapus_all_apbd_instansi('Web Service')" data-toggle="tooltip" title="Hapus semua data APBD inputan type Web Services" ><i class="fa fa-trash"></i></button>
                                </div>   
                               
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
     <div class="col-md-12 col-lg-12">
        <?php echo $this->session->flashdata('pesan') ?>
    </div>
</div>
<div class="mb-3 card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table id="table-apbd-all" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th style="text-align: center;" width="1%">No</th>
                                
                                <th style="text-align: center;">Bidang Urusan</th>
                                <th style="text-align: center;">Kode Program</th>
                                <th style="text-align: center;">Nama Program</th>
                                
                              
                                <th style="text-align: center;"></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

