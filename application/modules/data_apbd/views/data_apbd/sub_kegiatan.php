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
                                        <li class="p-0 list-group-item">
                                            <div class="widget-content">
                                                <div class="row">
                                                    <div class="col-md-6 col-xl-3">
                                                        <div class="card mb-3 widget-content bg-arielle-smile">
                                                            <div class="widget-content-wrapper text-white">
                                                                <div class="widget-content-left">
                                                                    <div class="widget-subheading"><b>Tahapan Data APBD</b></div>
                                                                    <div class="widget-heading"> <?php echo nama_tahapan().' '.tahun_anggaran(); ?>  </div>
                                                                </div>
                                                                <div class="widget-content-right">
                                                                    <div class="widget-numbers text-white">
                                                                                       
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-xl-3">
                                                        <div class="card mb-3 widget-content bg-arielle-smile">
                                                            <div class="widget-content-wrapper text-white">
                                                                <div class="widget-content-left">
                                                                    <div class="widget-subheading"><b>Total Program</b></div>
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
                                                    <div class="col-md-6 col-xl-3">
                                                        <div class="card mb-3 widget-content bg-arielle-smile">
                                                            <div class="widget-content-wrapper text-white">
                                                                <div class="widget-content-left">
                                                                    <div class="widget-subheading"><b>Total Kegiatan</b></div>
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
                                                    <div class="col-md-6 col-xl-3">
                                                        <div class="card mb-3 widget-content bg-arielle-smile">
                                                            <div class="widget-content-wrapper text-white">
                                                                <div class="widget-content-left">
                                                                    <div class="widget-subheading"><b>Total Sub Kegiatan </b></div>
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
                    <table id="table-sub-kegiatan-instansi-gabungan" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th style="text-align: center;" width="1%">No</th>
                                <th style="text-align: center;">Tahapan APBD</th>
                                <th style="text-align: center;">Program</th>
                                <th style="text-align: center;">Kegiatan</th>
                                <th style="text-align: center;">Sub Kegiatan</th>
                                <th style="text-align: center;">Kategori</th>
                                <th style="text-align: center;">Pagu</th>
                                <th style="text-align: center;">Input By</th>
                                <th style="text-align: center;">Status</th>
                              
                                <th style="text-align: center;"  width="13%">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>