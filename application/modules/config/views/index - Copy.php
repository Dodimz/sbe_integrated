
<div class="row">
    <div class="col-md-6 col-lg-12">
        <div class="widget-chart widget-chart2 text-left mb-3 card-btm-border card-shadow-success border-success card">
            <div class="widget-chat-wrapper-outer">
                <div class="widget-chart-content">
                    <div class="widget-title opacity-5 text-uppercase">Option </div>
                        <div class="widget-chart-flex align-items-center mt-2  mb-0 w-100">
                            <div id="tempat_tombol_option_config">
                            <?php   if ($j_data_config==0) { ?>
                               <button class="btn btn-info" id="tombol_add_config" onclick="tambah_config()">Tambah Konfigurasi</button>
                            <?php }else{ ?>
                                    <div class="alert alert-info">Data konfigurasi ditambahkan. <br>Anda tidak bisa lagi menambahkan konfigurasi untuk tahun ini dan bisa ditambahkan kembali di tahun selanjutnya</div>
                            <?php } ?>
                              
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
                    <table id="table-config" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th style="text-align: center;" width="1%">No</th>
                                <th style="text-align: center;">APBD</th>
                                <th style="text-align: center;">Jadwal Input Data Dasar</th>
                                <th style="text-align: center;">Jadwal Input Realisasi Fisik Dan Keuangan Pemerintah Provinsi</th>
                                <th style="text-align: center;">Jadwal Validasi Fisik</th>
                                <th style="text-align: center;">Jadwal Input Realisasi Fisik Dan Keuangan Pemerintah Kab / Kota</th>
                                <th style="text-align: center;">Penginputan ke dalam aplikasi</th>
                                <th style="text-align: center;">Status Konfigurasi</th>
                                <th style="text-align: center;"  width="10%">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>