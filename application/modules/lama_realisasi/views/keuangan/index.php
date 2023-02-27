<?php

/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 */
?>
<div class="mb-3 card">
    <div class="card-body">
        <div class="mt-3 row">

                    <div class="col-sm-12 col-md-2">
                        <div class="widget-content p-0">
                            <div class="widget-content-outer">
                                <div class="sub-label-left font-size-md">Belanja Operasi</div>
                                <div class="widget-content-wrapper">
                                    <div class="widget-content-left">
                                        <div class="widget-numbers text-dark"><?php echo $persen_bo ?> %</div>
                                    </div>
                                </div>
                                <div class="widget-progress-wrapper mt-1">
                                    <div class="progress-bar-xs progress-bar-animated-alt progress">
                                        <div class="progress-bar bg-info" role="progressbar" aria-valuenow="<?php echo $persen_bo; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $persen_bo ?>">%</div>
                                    </div>
                                    <div class="progress-sub-label">
                                        <div class="sub-label-right font-size-lg">
                                            <div class="text-success pl-2 text-dark"><?php echo "Rp. " . number_format($keu_bo, 0, '', '.'); ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <div class="widget-content p-0">
                            <div class="widget-content-outer">
                                <div class="sub-label-left font-size-md">Belanja Modal</div>
                                <div class="widget-content-wrapper">
                                    <div class="widget-content-left">
                                        <div class="widget-numbers text-dark"><?php echo $persen_bm ?> %</div>
                                    </div>
                                </div>
                                <div class="widget-progress-wrapper mt-1">
                                    <div class="progress-bar-xs progress-bar-animated-alt progress">
                                        <div class="progress-bar bg-info" role="progressbar" aria-valuenow="<?php echo $persen_bm?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $persen_bm?>">%</div>
                                    </div>
                                    <div class="progress-sub-label">
                                        <div class="sub-label-right font-size-lg">
                                            <div class="text-success pl-2 text-dark"><?php echo "Rp. " . number_format($keu_bm, 0, '', '.'); ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <div class="widget-content p-0">
                            <div class="widget-content-outer">
                                <div class="sub-label-left font-size-md">Belanja Tidak Terduga</div>
                                <div class="widget-content-wrapper">
                                    <div class="widget-content-left">
                                        <div class="widget-numbers text-dark"><?php echo $persen_btt ?> %</div>
                                    </div>
                                </div>
                                <div class="widget-progress-wrapper mt-1">
                                    <div class="progress-bar-xs progress-bar-animated-alt progress">
                                        <div class="progress-bar bg-info" role="progressbar" aria-valuenow="<?php echo $persen_btt ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $persen_btt ?>">%</div>
                                    </div>
                                    <div class="progress-sub-label">
                                        <div class="sub-label-right font-size-lg">
                                            <div class="text-success pl-2 text-dark"><?php echo "Rp. " . number_format($keu_btt, 0, '', '.'); ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-sm-12 col-md-2">
                        <div class="widget-content p-0">
                            <div class="widget-content-outer">
                                <div class="sub-label-left font-size-md">Belanja Transfer</div>
                                <div class="widget-content-wrapper">
                                    <div class="widget-content-left">
                                        <div class="widget-numbers text-dark"><?php echo $persen_bt ?> %</div>
                                    </div>
                                </div>
                                <div class="widget-progress-wrapper mt-1">
                                    <div class="progress-bar-xs progress-bar-animated-alt progress">
                                        <div class="progress-bar bg-info" role="progressbar" aria-valuenow="<?php echo $persen_bt ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $persen_bt ?>">%</div>
                                    </div>
                                    <div class="progress-sub-label">
                                        <div class="sub-label-right font-size-lg">
                                            <div class="text-success pl-2 text-dark"><?php echo "Rp. " . number_format($keu_bt, 0, '', '.'); ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 
                    <div class="col-sm-12 col-md-2">
                        <div class="widget-content p-0">
                            <div class="widget-content-outer">
                                <div class="sub-label-left font-size-md">Total Realisasi</div>
                                <div class="widget-content-wrapper">
                                    <div class="widget-content-left">
                                        <div class="widget-numbers text-dark"><?php echo $persen_total ?> %</div>
                                    </div>
                                </div>
                                <div class="widget-progress-wrapper mt-1">
                                    <div class="progress-bar-xs progress-bar-animated-alt progress">
                                        <div class="progress-bar bg-info" role="progressbar" aria-valuenow="<?php echo $persen_total ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $persen_total ?>">%</div>
                                    </div>
                                    <div class="progress-sub-label">
                                        <div class="sub-label-right font-size-lg">
                                            <div class="text-success pl-2 text-dark"><?php echo "Rp. " . number_format($keu_total, 0, '', '.'); ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 
                    <div class="col-sm-12 col-md-2">
                        <div class="widget-content p-0">
                            <div class="widget-content-outer">
                                <div class="sub-label-left font-size-md">Total Pagu</div>
                                <div class="widget-content-wrapper">
                                    <div class="widget-content-left">
                                        <div class="widget-numbers text-dark"><small><?php echo "Rp. " . number_format($total_anggaran, 0, '', '.'); ?></small></div>
                                    </div>
                                </div>
                                <div class="widget-progress-wrapper mt-1">
                                    <div class="progress-bar-xs progress-bar-animated-alt progress">
                                        <div class="progress-bar bg-info" role="progressbar" aria-valuenow="<?php echo 00?>" aria-valuemin="0" aria-valuemax="100" style="width: 00">%</div>
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
                    <table id="table-sub-kegiatan-instansi-gabungan" class="display table table-striped table-bordered" style="width:100%" >
                        <thead>
                            <tr>
                                <th valign="midle" rowspan="2" style="text-align: center;" width="1%">No</th>
                               <!--  <th valign="midle" rowspan="2" style="text-align: center;">Bidang Urusan</th>
                                <th valign="midle" rowspan="2" style="text-align: center;">Kode Program</th> -->
                                <th valign="midle" rowspan="2" style="text-align: center;">Sub Kegiatan</th>
                                <th valign="midle" style="text-align: center;" colspan="4">Realisasi Keuangan</th>
                              
                                <th valign="midle" rowspan="2" style="text-align: center;">Total</th>
                                <th valign="midle" rowspan="2" style="text-align: center;">Pagu</th>
                                <th valign="midle" rowspan="2" style="text-align: center;">Persentasi</th>
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