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
        <div class="col-lg-12 col-xl-6">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <h5 class="card-title">Synchronize</h5>
                    <table class="mb-0 table table-hover">
                        <thead>
                            <tr>
                                <th width="1%">No</th>
                                <th>Request</th>
                                <th width="1%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>Master Urusan</td>
                                <td>
                                    <button class="btn btn-primary btn-sm" id="master_urusan" onclick="sync('master_urusan')">
                                        <i class="pe-7s-science btn-icon-wrapper"> </i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">2</th>
                                <td>Master Program</td>
                                <td>
                                    <button class="btn btn-primary btn-sm" id="master_program" onclick="sync('master_program')">
                                    <i class="pe-7s-science btn-icon-wrapper"> </i>
                                </button>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">3</th>
                                <td>Master Kegiatan</td>
                                <td>
                                    <button class="btn btn-primary btn-sm" id="master_kegiatan" onclick="sync('master_kegiatan')">
                                        <i class="pe-7s-science btn-icon-wrapper"> </i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">4</th>
                                <td>Kegiatan APBD (DPA Disahkan)</td>
                                <td>
                                    <button class="btn btn-primary btn-sm" id="kegiatan_apbd_dpa_awal" onclick="sync('kegiatan_apbd_dpa_awal')">
                                        <i class="pe-7s-science btn-icon-wrapper"> </i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">5</th>
                                <td>Kegiatan APBD (DPA Perubahan)</td>
                                <td>
                                    <button class="btn btn-primary btn-sm" id="kegiatan_apbd_dpa_perubahan" onclick="sync('kegiatan_apbd_dpa_perubahan')">
                                        <i class="pe-7s-science btn-icon-wrapper"> </i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">6</th>
                                <td>Realisasi Keuangan</td>
                                <td>
                                    <button class="btn btn-primary btn-sm" id="realisasi_keuangan" onclick="realisasi_sync('realisasi_keuangan')">
                                        <i class="pe-7s-science btn-icon-wrapper"> </i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">7</th>
                                <td>Aliran Kas (Awal)</td>
                                <td>
                                    <button class="btn btn-info btn-xs" onclick="all_tahap_2()">Awal</button>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">8</th>
                                <td>Aliran Kas (Perubahan)</td>
                                <td>
                                   <button class="btn btn-info btn-xs" onclick="all_tahap_4()">Perubahan</button>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">9</th>
                                <td>Aliran Kas (Akumulasi)</td>
                                <td>
                                   <button class="btn btn-info btn-xs" onclick="all_akumulasi()">Akumulasi</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-xl-12">
            <div class="main-card mb-3 card">
                <div class="card-body"  style="overflow-x: scroll;">
                    <h5 class="card-title">Aliran Kas</h5>
                    <table class="mb-0 table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th width="1%" rowspan='2'>No</th>
                                <th rowspan='2'>Kode</th>
                                <th rowspan='2'>Nama Instansi</th>
                                <th colspan="9"><center>Request Personal</center></th>
                              
                            </tr>
                            <tr>
                             
                                <th>Awal</th>
                                <th>Perubahan</th>
                                <th>Akumulasi</th>
                                <th>Master Program</th>
                                <th>Master Kegiatan</th>
                                <th>Master Urusan</th>
                                <th>Kegiatan APBD (DPA Disahkan)</th>
                                <th>Kegiatan APBD (DPA Perubahan)</th>
                                <th>Realisasi Keuangan</th>
                            </tr>
                        </thead>
                        <tbody id="aliran-kas-opd">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>