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
                    <h5 class="card-title">Synchronize</h5>
                    <table class="mb-0 table table-hover">
                        <thead>
                            <tr>
                                <th width="1%">No</th>
                                <th>Request</th>
                                <th>Jumlah SIPKD</th>
                                <th>Jumlah Simbangda</th>
                                <th>Selisih</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>Master Urusan</td>
                               <td><?php echo $jurusan_sipkd ?></td>
                               <td><?php echo $jurusan_sbe ?></td>
                               <td><?php echo $jurusan_sipkd - $jurusan_sbe ?></td>
                               
                            </tr>
                            <tr>
                                <th scope="row">2</th>
                                <td>Master Program</td>
                               <td><?php echo $jprogram_sipkd ?></td>
                               <td><?php echo $jprogram_sbe ?></td>
                               <td><?php echo $jprogram_sipkd - $jprogram_sbe ?></td>
                                
                            </tr>
                            <tr>
                                <th scope="row">3</th>
                                <td>Master Kegiatan</td>
                               <td><?php echo $jkegiatan_sipkd ?></td>
                               <td><?php echo $jkegiatan_sbe ?></td>
                               <td><?php echo $jkegiatan_sipkd - $jkegiatan_sbe ?></td>
                               
                            </tr>
                            <tr>
                                <th scope="row">4</th>
                                <td>Kegiatan APBD (DPA Disahkan)</td>
                                <td><?php echo $jkegiatant2_sipkd ?></td>
                                <td><?php echo $jkegiatant2_sbe ?></td>
                                <td><?php echo $jkegiatant2_sipkd - $jkegiatant2_sbe ?></td>
                               
                            </tr>
                            <tr>
                                <th scope="row">5</th>
                                <td>Kegiatan APBD (DPA Perubahan)</td>
                                <td><?php echo $jkegiatant4_sipkd ?></td>
                                 <td><?php echo $jkegiatant4_sbe ?></td>
                                 <td><?php echo $jkegiatant4_sipkd - $jkegiatant4_sbe ?></td>
                               
                            </tr>
                            <tr>
                                <th scope="row">6</th>
                                <td>Realisasi Keuangan</td>
                                 <td></td>
                                <td></td>
                                <td></td>
                               
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
                    <h5 class="card-title">Kecocokan Data Per SKPD</h5>
                    <table class="mb-0 table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th width="1%" rowspan='3'>No</th>
                                <th rowspan='3'>Kode</th>
                                <th rowspan='3'>Nama Instansi</th>
                                <th colspan="15"><center>Jumlah Data</center></th>
                              
                            </tr>
                            <tr>
                             
                                <th colspan="3">Aliran Kas (Awal)</th>
                                <th colspan="3">Aliran Kas (Perubahan)</th>
                                <th colspan="3">Kegiatan APBD (Awal)</th>
                                <th colspan="3">Kegiatan APBD  (Perubahan)</th>
                                <th colspan="3">Realisasi Keuangan</th>
                                
                               
                            </tr>
                            <tr>
                             
                                <th>SIPKD</th>
                                <th>Simbangda</th>
                                <th>Selisih</th>
                                <th>SIPKD</th>
                                <th>Simbangda</th>
                                <th>Selisih</th>
                                <th>SIPKD</th>
                                <th>Simbangda</th>
                                <th>Selisih</th>
                                <th>SIPKD</th>
                                <th>Simbangda</th>
                                <th>Selisih</th>
                                <th>SIPKD</th>
                                <th>Simbangda</th>
                                <th>Selisih</th>
                                
                               
                            </tr>
                        </thead>
                      <tbody id="cek_syncronyze_perskpd">
                        </tbody>
                     </table>
                </div>
            </div>
        </div>
    </div>
</div>