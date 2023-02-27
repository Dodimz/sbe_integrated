<div class="card-shadow-primary card-border mb-3 profile-responsive card">
                                   
                                    <ul class="list-group list-group-flush">

                                        <li class="bg-warm-flame list-group-item">
                                        <div class="widget-content p-0">
                                            <div class="widget-content-wrapper">
                                                <div class="widget-content-left">
                                                    <div class="widget-heading text-dark opacity-7">Penginputan Realisasi Fisik Dan Keuangan</div>
                                                    <div class="widget-subheading opacity-10">
                                                        
                                                        <span class="pr-2">
                                                            <b class="text-danger">
                                                            <?php echo jadwal_rfk_kab_kota()['info'] ?>
                                                                
                                                            </b>
                                                        </span>
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
                                                                        <?php echo "Rp. " . number_format($total_anggaran , 0, '', '.'); ?>                                                                  
                                                                    </div>
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
                                <th valign="midle" rowspan="3" style="text-align: center;" width="1%">No</th>
                               <!--  <th valign="midle" rowspan="3" style="text-align: center;">Bidang Urusan</th>
                                <th valign="midle" rowspan="3" style="text-align: center;">Kode Program</th> -->
                                <th valign="midle" rowspan="3" style="text-align: center;">Instansi</th>
                                <th valign="midle" style="text-align: center;" colspan="8">Realisasi</th>
                                <th valign="midle" style="text-align: center;" colspan="3">Total Realisasi</th>
                                <th valign="midle" style="text-align: center;" colspan="2">LRA</th>
                                <th valign="midle" rowspan="3" style="text-align: center;">Option</th>
                              
                              
                            </tr>
                            <tr>
                                <th valign="midle" style="text-align: center;" colspan="2">Belanja Operasi</th>
                                <th valign="midle" style="text-align: center;" colspan="2">Belanja Modal</th>
                                <th valign="midle" style="text-align: center;" colspan="2">Belanja Tidak Terduga</th>
                                <th valign="midle" style="text-align: center;" colspan="2">Belanja Transfer</th>
                                <th valign="midle" style="text-align: center;" colspan="2">Keuangan</th>
                                <th valign="midle" style="text-align: center;" rowspan="2">Fisik</th>
                                <th valign="midle" style="text-align: center;" rowspan="2">Rp</th>
                                <th valign="midle" style="text-align: center;" rowspan="2">%</th>
                            </tr>
                          
                            <tr>
                                <?php for ($i=1; $i <=5 ; $i++) { ?>
                               
                                <td>Rp</td>
                                <td>%</td>
                            <?php } ?>
                                <!-- <th valign="midle" style="text-align: center;" colspan="4">Belanja Operasi</th> -->
                            </tr>
                        
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>