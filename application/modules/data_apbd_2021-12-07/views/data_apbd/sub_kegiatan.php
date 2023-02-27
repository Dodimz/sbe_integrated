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
     <div class="col-md-6 col-lg-2">
        <div class="widget-chart widget-chart2 text-left mb-3 card-btm-border card-shadow-primary border-primary card">
            <div class="widget-chat-wrapper-outer">
                <div class="widget-chart-content">
                    <div class="widget-title opacity-5 text-uppercase">Tahap APBD</div>
                    <div class="widget-numbers mt-2 fsize-4 mb-0 w-100">
                        <div class="widget-chart-flex align-items-center">
                            <div>
                                
                               
                                <small> <?php echo nama_tahapan(); ?></small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-2">
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
   
    <div class="col-md-6 col-lg-2">
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
    <div class="col-md-6 col-lg-2">
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
        <div class="widget-chart widget-chart2 text-left mb-3 card-btm-border card-shadow-warning border-warning card">
            <div class="widget-chat-wrapper-outer">
                <div class="widget-chart-content">
                    <div class="widget-title opacity-5 text-uppercase">Input By</div>
                    <div class="widget-numbers mt-2 fsize-4 mb-0 w-100">
                        <div class="widget-chart-flex align-items-center">
                            <div>
                                
                                <small>
                                <?php 
                                    if ($input_by=="all") {
                                        echo "Data APBD Gabungan";
                                        $back = "data_apbd";
                                    }
                                    else if ($input_by=="excel") {
                                        echo "Export File Excel";
                                        $back = "data_apbd/setting";
                                    }
                                    else if ($input_by=="api") {
                                        echo "Web Service E-Planning";
                                        $back = "data_apbd/setting";
                                    }


                                    if (isset($input_by)) {
                                        $i = $input_by;
                                    }else{
                                        $i = "";

                                    }
                                 ?>
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 col-lg-1">
        <div class="widget-chart widget-chart2 text-left mb-3 card-btm-border card-shadow-success border-success card">
            <div class="widget-chat-wrapper-outer">
                <div class="widget-chart-content">
                    <div class="widget-title opacity-5 text-uppercase">Kembali </div>
                    <div class="widget-numbers mt-2 fsize-4 mb-0 w-100">
                        <div class="widget-chart-flex align-items-center">
                            <div>
                               
                              
                               <a class="btn btn-info btn-xs" href="<?php echo base_url($back) ?>" data-toggle="tooltip" title="Kembali"><i class="fa fa-arrow-left"></i></a>
                               <?php if (tahapan_apbd()==4){ 
                               	if ($tot_subkeg==0) { ?>
                                   
	                               <a class="btn btn-info btn-xs" href="#" data-toggle="tooltip" title="Copy Data APBD Awal"  onclick="copy_sub_kegiatan_apbd_awal()" id="tombol_copy_apbd_awal"><i class="fa fa-copy"></i></a>
                               <?php 	}

                                } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
</div>
<div class="mb-3 card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table id="table-sub-kegiatan-instansi-gabungan" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th style="text-align: center;" width="1%">No</th>
                                <th style="text-align: center;">Program</th>
                                <th style="text-align: center;">Kegiatan</th>
                                <th style="text-align: center;">Sub Kegiatan</th>
                                <th style="text-align: center;">Kategori</th>
                                <th style="text-align: center;">Pagu</th>
                                <th style="text-align: center;">Input By</th>
                              
                                <th style="text-align: center;"  width="13%">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>