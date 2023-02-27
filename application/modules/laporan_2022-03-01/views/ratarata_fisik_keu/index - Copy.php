<?php
/**
	* Author     : Alfikri, M.Kom
	* Created By : Alfikri, M.Kom
	* E-Mail     : alfikri.name@gmail.com
	* No HP      : 081277337405
*/
?>
<div class="tabs-animation">

    <div class="row">
        <div class="col-lg-12 col-xl-12">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <div style="float:left">
                        <h5 class="card-title">LAPORAN FISIK DAN KEUANGAN SUMATERA BARAT TAHUN 2021 <br>Berdasarkan Realisasi <span id="realisasi_aktif">Fisik</span> Tertinggi</h5>
                    </div>
                    <div style="float:right">
                        <!-- <a href="#" class="btn btn-info" id="sync_all">Syncronyze All</a> -->
                        <a href="#" class="btn btn-info" id="urutkan_keuangan" onclick="urutkan_berdasarkan('keuangan')" disabled >Urutkan Berdasarkan Realisasi Keuangan Tertinggi</a>
                        <a href="#" class="btn btn-info" id="urutkan_fisik" onclick="urutkan_berdasarkan('fisik')">Urutkan Berdasarkan Realisasi Fisik Tertinggi</a>
                    </div>
                    <div class="clearfix"></div>
                    <hr>    
                   <table class="mb-0 table table-hover table-striped table-bordered">
                        <thead style="background:#ebedef; color: black; border-color: red">
                            <tr>
                                <th rowspan="2" style="text-align: center;">No</th>
                                <th rowspan="2" style="text-align: center;">SKPD</th>
                                <th rowspan="2" style="text-align: center;">Pagu</th>
                                 <th colspan="3" style="text-align: center;">Fisik</th>
                                 <th colspan="3" style="text-align: center;">Keuangan</th>
                              
                            </tr>
                            <tr>
                                <th>Target</th>
                                <th>Realisasi</th>
                                <th>Deviasi</th>
                                <th>Target</th>
                                <th>Realisasi</th>
                                <th>Deviasi</th>
                            </tr>
                        </thead>
                        <tbody id="data_fisik_keu">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>