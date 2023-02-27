<div class="mb-3 card">
    <div class="card-body">
        <div class="mt-3 row">
            <div class="col-sm-12 col-md-3">
                <div class="widget-content p-0">
                    <div class="widget-content-outer">
                        <div class="sub-label-left font-size-md">Belanja Pegawai</div>
                        <div class="widget-content-wrapper">
                            <div class="widget-content-left">
                                <div class="widget-numbers text-dark"><?php echo $persen_bp; ?> %</div>
                            </div>
                        </div>
                        <div class="widget-progress-wrapper mt-1">
                            <div class="progress-bar-xs progress-bar-animated-alt progress">
                                <div class="progress-bar bg-info" role="progressbar" aria-valuenow="<?php echo $persen_bp; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $persen_bp; ?>">%</div>
                            </div>
                            <div class="progress-sub-label">
                                <div class="sub-label-right font-size-lg">
                                    <div class="text-success pl-2 text-dark"><?php echo "Rp. " . number_format($keu_bp, 0, '', '.'); ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-3">
                <div class="widget-content p-0">
                    <div class="widget-content-outer">
                        <div class="sub-label-left font-size-md">Belanja Barang dan Jasa</div>
                        <div class="widget-content-wrapper">
                            <div class="widget-content-left">
                                <div class="widget-numbers text-dark"><?php echo $persen_bbj; ?> %</div>
                            </div>
                        </div>
                        <div class="widget-progress-wrapper mt-1">
                            <div class="progress-bar-xs progress-bar-animated-alt progress">
                                <div class="progress-bar bg-info" role="progressbar" aria-valuenow="<?php echo $persen_bbj; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $persen_bbj; ?>">%</div>
                            </div>
                            <div class="progress-sub-label">
                                <div class="sub-label-right font-size-lg">
                                    <div class="text-success pl-2 text-dark"><?php echo "Rp. " . number_format($keu_bbj, 0, '', '.'); ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-3">
                <div class="widget-content p-0">
                    <div class="widget-content-outer">
                        <div class="sub-label-left font-size-md">Belanja Modal</div>
                        <div class="widget-content-wrapper">
                            <div class="widget-content-left">
                                <div class="widget-numbers text-dark"><?php echo $persen_bm; ?> %</div>
                            </div>
                        </div>
                        <div class="widget-progress-wrapper mt-1">
                            <div class="progress-bar-xs progress-bar-animated-alt progress">
                                <div class="progress-bar bg-info" role="progressbar" aria-valuenow="<?php echo $persen_bm; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $persen_bm; ?>">%</div>
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
            <div class="col-sm-12 col-md-3">
                <div class="widget-content p-0">
                    <div class="widget-content-outer">
                        <div class="sub-label-left font-size-md">Total Realisasi</div>
                        <div class="widget-content-wrapper">
                            <div class="widget-content-left">
                                <div class="widget-numbers text-dark"><?php echo "Rp. " . number_format($total, 0, '', '.'); ?></div>
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
                    <table id="table-realisasi-keuangan" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th rowspan="2" style="text-align: center;">Rekening</th>
                                <th rowspan="2" style="text-align: center;">Nama Kegiatan</th>
                                <th colspan="3" style="text-align: center;">Belanja</th>
                                <th rowspan="2" style="text-align: center;">Total</th>
                                <th rowspan="2">Realisasi</th>
                            </tr>
                            <tr>
                                <th width="1%">Pegawai</th>
                                <th width="1%">Barang/Jasa</th>
                                <th width="1%">Modal</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>