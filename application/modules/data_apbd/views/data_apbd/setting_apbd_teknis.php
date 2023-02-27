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


<div class="card-shadow-primary card-border mb-3 profile-responsive card">
                                    


                                    <ul class="list-group list-group-flush">
                                        <li class="bg-warm-flame list-group-item">
                                        <div class="widget-content p-0">
                                            <div class="widget-content-wrapper">
                                                <div class="widget-content-left">
                                                    <div class="widget-heading text-dark opacity-7">
                                                        Penetapan Sub Kegiatan Unit Pelaksana <br>    
                                                    </div>
                                                    <div class="widget-subheading opacity-10">
                                                        
                                                            <b class="text-danger">
                                                               <?php echo jadwal_input_data_dasar()['pesan'] ?>                                                           
                                                            </b>
                                                    </div>
                                                </div>
                                                <div class="widget-content-right">
                                                        <div class="widget-chart-content">
                                                            <div class="widget-chart-flex">
                                                                <span class="pl-1"><b>Jumlah Instansi Pembantu Teknis</b></span>
                                                                <div class="widget-numbers text-dark">
                                                                    <span class="pull-right"><?php echo $banyak_instansi_teknis ?> Instansi</span>
                                                                </div>
                                                                <div class="widget-description ml-auto text-info">
                                                                    </div>
                                                            </div>
                                                        </div>
                                                </div>

                                               
                                            </div>
                                        </div>
                                    </li>
                                        <li class="p-0 list-group-item">
                                            <div class="widget-content">
                                                <div class="row">
                                                    <div class="col-md-6 col-xl-2">
                                                        <div class="card mb-3 widget-content bg-arielle-smile">
                                                            <div class="widget-content-wrapper text-white">
                                                                <div class="widget-content-left">
                                                                    <div class="widget-subheading" style="color:black"><b>Tahapan Data APBD</b></div>
                                                                    <div class="widget-heading"> <?php echo nama_tahapan().' '.tahun_anggaran(); ?>  </div>
                                                                </div>
                                                                <div class="widget-content-right">
                                                                    <div class="widget-numbers text-white">
                                                                                       
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-xl-2">
                                                        <div class="card mb-3 widget-content bg-arielle-smile">
                                                            <div class="widget-content-wrapper text-white">
                                                                <div class="widget-content-left">
                                                                    <div class="widget-subheading" style="color:black"><b>Total Program</b></div>
                                                                    <div class="widget-heading">
                                                                        
                                                                    </div>
                                                                </div>

                                                                <div class="widget-content-right">
                                                                    <div class="widget-numbers text-white">
                                                                        <?php echo $tot_program; ?>
                                                                    </div>
                                                                </div>

                                                               



                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-xl-2">
                                                        <div class="card mb-3 widget-content bg-arielle-smile">
                                                            <div class="widget-content-wrapper text-white">
                                                                <div class="widget-content-left">
                                                                    <div class="widget-subheading" style="color:black"><b>Total Kegiatan</b></div>
                                                                    <div class="widget-heading"></div>
                                                                </div>
                                                                <div class="widget-content-right">
                                                                    <div class="widget-numbers text-white">
                                                                        <?php echo $tot_kegiatan ?>  
                                                                    </div>
                                                                </div>
                                                           
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 col-xl-2">
                                                        <div class="card mb-3 widget-content bg-arielle-smile">
                                                            <div class="widget-content-wrapper text-white">
                                                                <div class="widget-content-left">
                                                                    <div class="widget-subheading" style="color:black"><b>Total Sub Kegiatan <br>   SKPD </b></div>
                                                                    <div class="widget-heading">
                                                                    </div>
                                                                </div>
                                                                 <div class="widget-content-right">
                                                                    <div class="widget-numbers text-white">
                                                                        <?php echo $tot_subkeg ?>                   
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-xl-2">
                                                        <div class="card mb-3 widget-content bg-arielle-smile">
                                                            <div class="widget-content-wrapper text-white">
                                                                <div class="widget-content-left">
                                                                    <div class="widget-subheading" style="color:black"><b>Total Sub Kegiatan Teknis </b></div>
                                                                    <div class="widget-heading">
                                                                    </div>
                                                                </div>
                                                                 <div class="widget-content-right">
                                                                    <div class="widget-numbers text-white">
                                                                       <?php echo $tot_subkeg_teknis ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-xl-2">
                                                        <div class="card mb-3 widget-content bg-arielle-smile">
                                                            <div class="widget-content-wrapper text-white">
                                                                <div class="widget-content-left">
                                                                    <div class="widget-subheading" style="color:black"><b>Total Semua Sub Kegiatan </b></div>
                                                                    <div class="widget-heading">
                                                                    </div>
                                                                </div>
                                                                 <div class="widget-content-right">
                                                                    <div class="widget-numbers text-white">
                                                                        
                                                                       <?php echo $tot_subkeg_semua ?>                
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















<div class="mb-3 card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table id="table-pilihan-sub-kegiatan-apbd" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th style="text-align: center;" width="1%">No</th>
                                <th style="text-align: center;">Program</th>
                                <th style="text-align: center;">Kegiatan</th>
                                <th style="text-align: center;">Sub Kegiatan</th>
                                <th style="text-align: center;">Banyak Sub Kegiatan Teknis</th>
                                <th style="text-align: center;"  width="10%">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>