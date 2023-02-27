<?php

/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 */

$pilihan_bulan = [
    1=>'Januari',
    'Februari',
    'Maret',
    'April',
    'Mei',
    'Juni',
    'Juli',
    'Agustus',
    'September',
    'Oktober',
    'November',
    'Desember'                                   
];

                             ?>
<!-- Modal Dokumen Realisasi -->
<div class="modal fade" id="modal_add_config" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Konfigurasi Aplikasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form_config">
                <div class="row">
                    <input type="hidden" name="id_config" id="id_config" class="form-control">
                    <div class="col-md-4 col-lg-4">
                        <div class="form-group">
                            <label>Tahun Anggaran</label>
                            <input type="text" name="tahun_anggaran" id="tahun_anggaran" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-4">
                        <div class="form-group">
                            <label>Tahapan APBD</label>
                             <select name="tahapan_apbd"  class="form-control" id="tahapan_apbd"  >
                                <?php 
                                $tahap = [2=>'APBD AWAL','APBD PERGESERAN','APBD PERUBAHAN'];
                                foreach ($tahap as $k => $v) { ?>
                                    <option value="<?php echo $k ?>"><?php echo $v ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-4">
                        <div class="form-group">
                            <label>Bulan Aktif</label>
                            <select name="bulan_aktif"  class="form-control" id="bulan_aktif">
                                <?php for ($i=1; $i <= 12; $i++) { ?>
                                    <option value="<?php echo $i ?>"><?php echo bulan_global($i) ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                   
                    <div class="col-md-12 col-lg-12" style="border:solid; border-width:0.5px; padding:10px">
                        <div class="form-group">
                            <label>Jadwal Input / Penguncian Input Pemerintah Provinsi</label>
                            <div class="row">
                                  <div class="col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label>Penginputan Provinsi</label>
                                         <select name="penginputan_provinsi"  class="form-control" id="penginputan_provinsi">
                                            <?php 
                                            $status = ['Kunci penginputan','Penginputan sesuai jadwal','Penginputan Bebas'];
                                            foreach ($status as $k => $v) { ?>
                                                <option value="<?php echo $k ?>"><?php echo $v ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            <div class="col-md-4 col-lg-4 form_jadwal_input_rfk_provinsi">
                                <div class="form-group">
                                    <label>Jadwal Input Data APBD dan Paket</label>
                                    <div class="row">
                                        <div class="col-md-6 col-lg-6">
                                            <input type="date" name="jadwal_input_data_dasar_awal" id="jadwal_input_data_dasar_awal" class="form-control">
                                        </div>
                                        <div class="col-md-6 col-lg-6">
                                            <input type="date" name="jadwal_input_data_dasar_akhir" id="jadwal_input_data_dasar_akhir" class="form-control">
                                        </div>

                                    </div>
                                   
                                </div>
                            </div>
                                <div class="col-md-4 col-lg-4 form_jadwal_input_rfk_provinsi">
                                    <label>Tanggal Input RFK </label>
                                    <div class="row">
                                        <div class="col-md-6 col-lg-6">
                                             <select name="tgl_input_rfk_mulai" id="tgl_input_rfk_mulai"  class="form-control">
                                        <?php for ($i=1; $i < 31; $i++) { ?>
                                            <option value="<?php echo $i ?>"><?php echo $i ?></option>
                                        <?php } ?>
                                    </select>
                                        </div>
                                        <div class="col-md-6 col-lg-6">
                                           <select name="tgl_input_rfk_akhir" id="tgl_input_rfk_akhir"  class="form-control">
                                <?php for ($i=1; $i < 31; $i++) { ?>
                                    <option value="<?php echo $i ?>"><?php echo $i ?></option>
                                <?php } ?>
                            </select>
                                        </div>

                                    </div>


                                  
                                </div>
                                <div class="col-md-4 col-lg-4 form_jadwal_input_rfk_provinsi">
                                    <label>Tanggal Validasi </label>
                                    <div class="row">
                                        <div class="col-md-6 col-lg-6">
                                             <select name="tgl_validasi_rfk_mulai" id="tgl_validasi_rfk_mulai"  class="form-control">
                                        <?php for ($i=1; $i < 31; $i++) { ?>
                                            <option value="<?php echo $i ?>"><?php echo $i ?></option>
                                        <?php } ?>
                                    </select>
                                        </div>
                                        <div class="col-md-6 col-lg-6">
                                           <select name="tgl_validasi_rfk_akhir" id="tgl_validasi_rfk_akhir"  class="form-control">
                                <?php for ($i=1; $i < 31; $i++) { ?>
                                    <option value="<?php echo $i ?>"><?php echo $i ?></option>
                                <?php } ?>
                            </select>
                                        </div>

                                    </div>


                                  
                                </div>
                               
                                <div class="col-md-6 col-lg-6 form_jadwal_input_rfk_provinsi">
                                    
                                    <label>Waktu Awal Penginputan</label>
                                    <input type="time" name="waktu_awal" id="waktu_awal" class="form-control">
                           
                                </div>
                                <div class="col-md-6 col-lg-6 form_jadwal_input_rfk_provinsi">
                                    
                                    <label>Waktu Akhir Penginputan</label>
                                    <input type="time" name="waktu_kunci" id="waktu_kunci" class="form-control">
                           
                                </div>

                            </div>
                           
                        </div>
                    </div>
                    
                  
                    <div class="col-md-12 col-lg-12">
                        <div class="form-group" style="margin-top:10px">
                            <label>Penginputan Kab Kota</label>
                             <select name="penginputan_kab_kota"  class="form-control" id="penginputan_kab_kota">
                                <?php 
                                $status = ['Kunci penginputan','Penginputan sesuai jadwal','Penginputan Bebas'];
                                foreach ($status as $k => $v) { ?>
                                    <option value="<?php echo $k ?>"><?php echo $v ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-4 form_jadwal_input_rfk_kota">
                        <div class="form-group">
                            <label>Jadwal Input RFK Pemerintah Kab / Kota</label>
                            <div class="row">
                                <div class="col-md-6 col-lg-6">
                                    <select name="tgl_input_rfk_kab_kota_awal" id="tgl_input_rfk_kab_kota_awal"  class="form-control">
                                <?php for ($i=1; $i < 31; $i++) { ?>
                                    <option value="<?php echo $i ?>"><?php echo $i ?></option>
                                <?php } ?>
                            </select>
                                </div>
                                <div class="col-md-6 col-lg-6">
                                    <select name="tgl_input_rfk_kab_kota_akhir" id="tgl_input_rfk_kab_kota_akhir"  class="form-control">
                                <?php for ($i=1; $i < 31; $i++) { ?>
                                    <option value="<?php echo $i ?>"><?php echo $i ?></option>
                                <?php } ?>
                            </select>
                                </div>

                            </div>
                           
                        </div>
                    </div>
                     <div class="col-md-4 col-lg-4 form_jadwal_input_rfk_provinsi">
                                    
                                    <label>Waktu Awal Penginputan</label>
                                    <input type="time" name="waktu_awal_kota" id="waktu_awal_kota" class="form-control" value="23:59:59">
                           
                                </div>
                     <div class="col-md-4 col-lg-4 form_jadwal_input_rfk_provinsi">
                                    
                                    <label>Waktu Akhir Penginputan</label>
                                    <input type="time" name="waktu_kunci_kota" id="waktu_kunci_kota" class="form-control" value="23:59:59">
                           
                                </div>
                   
                    
                </div>
            </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="simpan_config()" id="tombol_simpan_config" >Simpan</button>
                    <button type="button" class="btn btn-primary" onclick="simpanedit_config()" id="tombol_simpanedit_config" >Simpan Perubahan</button>
            </div>
        </div>
    </div>
</div>














<div class="modal fade" id="modal_izin_config" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel" id="tombol_tambah_konfig">Izin Konfigurasi Aplikasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form_izin_config">
                        <div class="form-group">
                            <label>OPD Provinsi</label>
                            <select name="izin" id="izin" class="form-control">
                                <option value="0" <?php if($izin_config['izin']==0){echo "selected";} ?>>Tidak Diizinkan</option>
                                <option value="1" <?php if($izin_config['izin']==1){echo "selected";} ?>>Di Izinkan</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>OPD Kab / kota</label>
                            <select name="izin_kab_kota" id="izin_kab_kota" class="form-control">
                                <option value="0" <?php if($izin_config['izin_kab_kota']==0){echo "selected";} ?>>Tidak Diizinkan</option>
                                <option value="1" <?php if($izin_config['izin_kab_kota']==1){echo "selected";} ?>>Di Izinkan</option>
                            </select>
                        </div>
                 
            </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="simpanedit_izin_config()">Simpan</button>
                 
            </div>
        </div>
    </div>
</div>


