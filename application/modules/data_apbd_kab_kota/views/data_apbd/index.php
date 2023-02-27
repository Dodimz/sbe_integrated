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
    
    
</div>
<div class="mb-3 card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table id="table-apbd-instansi" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th style="text-align: center;" width="1%">No</th>
                                <th style="text-align: center;">Bidang Urusan</th>
                                <th style="text-align: center;">Kode Program</th>
                                <th style="text-align: center;">Nama Program</th>
                                <th style="text-align: center;">Pagu</th>
                              
                                <th style="text-align: center;"></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>