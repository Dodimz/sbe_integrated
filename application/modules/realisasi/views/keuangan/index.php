<?php

/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 */
?>

<div class="card-shadow-primary card-border mb-3 profile-responsive card">
                                    


                                    <ul class="list-group list-group-flush">
                                        <li class="bg-warm-flame list-group-item">
                                        <div class="widget-content p-0">
                                            <div class="widget-content-wrapper">
                                                <div class="widget-content-left">
                                                    <div class="widget-heading text-dark opacity-7"><span class="timer_kunci_lrfk"></span></div>
                                                    <div class="widget-subheading opacity-10">
                                                        <b class="pesan_penginputan" style="color: #ffffff ">
                                                             
                                                        </b>
                                                        
                                                    
                                                    </div>
                                                </div>
                                                <div class="widget-content-right">
                                                        <div class="widget-chart-content">
                                                            <div class="widget-chart-flex">
                                                                <span class="pl-1">Persentasi Realisasi Tercapai</span>
                                                                <div class="widget-numbers text-dark">
                                                                    <span class="pull-right"> <?php echo $persen_total ?> %</span></div>
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
                                                    <div class="col-md-6 col-xl-3">
                                                        <div class="card mb-3 widget-content bg-arielle-smile">
                                                            <div class="widget-content-wrapper text-white">
                                                                <div class="widget-content-left">
                                                                    <div class="widget-subheading"><b>Belanja Operasi</b></div>
                                                                    <div class="widget-heading">
                                                                        <?php echo "Rp. " . number_format($keu_bo, 0, '', '.'); ?>                                                                  </div>
                                                                </div>

                                                                <div class="widget-content-right">
                                                                    <div class="widget-numbers text-white">
                                                                        <?php echo $persen_bo ?> %
                                                                    </div>
                                                                </div>

                                                               



                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-xl-3">
                                                        <div class="card mb-3 widget-content bg-arielle-smile">
                                                            <div class="widget-content-wrapper text-white">
                                                                <div class="widget-content-left">
                                                                    <div class="widget-subheading"><b>Belanja Modal</b></div>
                                                                    <div class="widget-heading"><?php echo "Rp. " . number_format($keu_bm, 0, '', '.'); ?></div>
                                                                </div>
                                                                <div class="widget-content-right">
                                                                    <div class="widget-numbers text-white">
                                                                        <?php echo $persen_bm ?> %
                                                                    </div>
                                                                </div>
                                                           
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-xl-3">
                                                        <div class="card mb-3 widget-content bg-arielle-smile">
                                                            <div class="widget-content-wrapper text-white">
                                                                <div class="widget-content-left">
                                                                    <div class="widget-subheading"><b>Belanja Tidak Terduga</b></div>
                                                                    <div class="widget-heading">
                                                                        <?php echo "Rp. " . number_format($keu_btt, 0, '', '.'); ?>
                                                                    </div>
                                                                </div>
                                                                 <div class="widget-content-right">
                                                                    <div class="widget-numbers text-white">
                                                                        <?php echo $persen_btt ?> %                                                                  
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-xl-3">
                                                        <div class="card mb-3 widget-content bg-arielle-smile">
                                                            <div class="widget-content-wrapper text-white">
                                                                <div class="widget-content-left">
                                                                    <div class="widget-subheading"><b>Belanja Transfer</b></div>
                                                                    <div class="widget-heading">
                                                                        <?php echo "Rp. " . number_format($keu_bt, 0, '', '.'); ?>
                                                                    </div>
                                                                </div>
                                                                <div class="widget-content-right">
                                                                    <div class="widget-numbers text-white">
                                                                        <?php echo $persen_bt ?> %                                                                  
                                                                    </div>
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
                                                    <div class="col-md-6 col-xl-4">
                                                        <div class="card mb-3 widget-content bg-night-fade">
                                                            <div class="widget-content-wrapper text-white">
                                                                <div class="widget-content-left">
                                                                    <div class="widget-subheading"><b>Toal Anggaran</b></div>
                                                                    <div class="widget-heading">
                                                                        <?php echo "Rp. " . number_format($total_anggaran , 0, '', '.'); ?>                                                                  </div>
                                                                </div>

                                                                <div class="widget-content-right">
                                                                    <div class="widget-numbers text-white">
                                                                        100 %
                                                                    </div>
                                                                </div>

                                                               



                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-xl-4">
                                                        <div class="card mb-3 widget-content  bg-night-fade">
                                                            <div class="widget-content-wrapper text-white">
                                                                <div class="widget-content-left">
                                                                    <div class="widget-subheading"><b>Direalisasikan</b></div>
                                                                    <div class="widget-heading"><?php echo "Rp. " . number_format($keu_total, 0, '', '.'); ?></div>
                                                                </div>
                                                                <div class="widget-content-right">
                                                                    <div class="widget-numbers text-white">
                                                                        <?php echo $persen_total ?> %

                                                                    </div>
                                                                </div>
                                                           
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-xl-4">
                                                        <div class="card mb-3 widget-content bg-night-fade">
                                                            <div class="widget-content-wrapper text-white">
                                                                <div class="widget-content-left">
                                                                    <div class="widget-subheading"><b>Sisa Anggaran</b></div>
                                                                    <div class="widget-heading">
                                                                        <?php 
                                                                            $sisa_uang = $total_anggaran - $keu_total;
                                                                            $sisa_persen = 100 -  $persen_total ; 
                                                                         ?>
                                                                        <?php echo "Rp. " . number_format($sisa_uang, 0, '', '.'); ?>
                                                                    </div>
                                                                </div>
                                                                 <div class="widget-content-right">
                                                                    <div class="widget-numbers text-white">
                                                                        <?php echo $sisa_persen ?> %                                                                  
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
                    <table id="table-sub-kegiatan-instansi-gabungan" class="display table table-striped table-bordered" style="width:100%" >
                        <thead>
                            <tr>
                                <th valign="midle" rowspan="2" style="text-align: center;" width="1%">No</th>
                               <!--  <th valign="midle" rowspan="2" style="text-align: center;">Bidang Urusan</th>
                                <th valign="midle" rowspan="2" style="text-align: center;">Kode Program</th> -->
                                <th valign="midle" rowspan="2" style="text-align: center;">Tahapan APBD</th>
                                <th valign="midle" rowspan="2" style="text-align: center;">Sub Kegiatan</th>
                                <th valign="midle" style="text-align: center;" colspan="4">Realisasi Keuangan</th>
                              
                                <th valign="midle" rowspan="2" style="text-align: center;">Total</th>
                                <th valign="midle" rowspan="2" style="text-align: center;">Pagu</th>
                                <th valign="midle" rowspan="2" style="text-align: center;">Persentasi</th>
                                <th valign="midle" rowspan="2" style="text-align: center;">Option</th>
                            </tr>
                            <tr>
                                <th valign="midle" style="text-align: center;">Belanja Operasi</th>
                                <th valign="midle" style="text-align: center;">Belanja Modal</th>
                                <th valign="midle" style="text-align: center;">Belanja Tidak Terduga</th>
                                <th valign="midle" style="text-align: center;">Belanja Transfer</th>
                            </tr>
                           
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>