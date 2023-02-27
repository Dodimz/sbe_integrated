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
    <div class="col-md-6 col-lg-12">
        <div class="widget-chart widget-chart2 text-left mb-3 card-btm-border card-shadow-success border-success card">
            <div class="widget-chat-wrapper-outer">
                <div class="widget-chart-content">
                    <div class="widget-title opacity-5 text-uppercase">Option </div>
                    <div class="widget-numbers mt-2 fsize-4 mb-0 w-100">
                        <div class="widget-chart-flex align-items-center">
                            <div>
                               
                              
                               <button class="btn btn-info" onclick="show_laporan('<?php echo sbe_crypt(id_instansi(), 'E') ?>')" data-toggle="tooltip" title="Permasalahan pada pelaksanaan Sub Kegiatan">Lihat laporan realisasi hingga bulan <?php echo    bulan_global(bulan_aktif()) ?></button>
                               <a href="<?php echo base_url() ?>data_apbd" class="btn btn-info">Kembali</a>
                              
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="mb-3 card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table id="table-permasalahan-sub-kegiatan-instansi" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th style="text-align: center;" width="1%">No</th>
                                <th style="text-align: center;">Sub Kegiatan</th>
                                <th style="text-align: center;">Permasalahan</th>
                                <th style="text-align: center;">Usulan Solusi</th>
                              
                                <th style="text-align: center;"  width="10%">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>