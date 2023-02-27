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
$tahap = [2=>'APBD AWAL', 4=>'APBD PERUBAHAN'];
                             ?>
<!-- Modal Dokumen Realisasi -->
<div class="modal fade" id="modal_config_kab_kota" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Konfigurasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form_config_kab_kota">
                    <div class="form-group" >
                        <label for="kode">Tahun Anggaran</label>
                        <?php if (izin_konfigurasi()->izin_kab_kota==0) { ?>
                           <select class="form-control" id="id_config" name="id_config">
                               <option value="<?php echo tahun_anggaran() ?>" selected><?php echo tahun_anggaran()?></option>
                        </select>
                        <?php }else{ ?>
                        <select class="form-control" id="id_config" name="id_config">
                            <option value=""></option>
                             <?php 
                             
                            foreach ($data_config as $k => $v) { ?>
                                <option value="<?php echo $v['id_config'] ?>" <?php if($data->id_config==$v['id_config']){echo "selected";} ?>><?php echo $v['tahun_anggaran'] ?></option>
                            <?php } ?>
                        </select>
                    <?php } ?>
                    </div>

                    <div class="form-group" >
                        <label for="kode">Tahapan APBD</label>
                        <?php if (izin_konfigurasi()->izin_kab_kota==0) { ?>
                           <select class="form-control" id="tahap" name="tahap">
                               <option value="<?php echo tahapan_apbd() ?>" selected><?php echo $tahap[tahapan_apbd()] ?></option>
                        </select>
                        <?php }else{ ?>
                        <select class="form-control" id="tahap" name="tahap">
                            <option value=""></option>
                             <?php 
                             
                            foreach ($tahap as $k => $v) { ?>
                                <option value="<?php echo $k ?>" <?php if($data->tahapan_apbd==$k){echo "selected";} ?>><?php echo $v ?></option>
                            <?php } ?>
                        </select>
                    <?php } ?>
                    </div>
                    

                    <?php 
                    $ptm = explode(' ', $data->realisasi_fisik_mulai);
                    $pts = explode(' ', $data->realisasi_fisik_selesai);
                     ?>
                  
                    <div class="form-group">
                        <label for="kode">Penanggung Jawab</label>
                        <select class="form-control" name="pj" id="pj">
                            <option></option>
                            <?php 
                            foreach ($pj as $k => $v) { ?>
                              <option value="<?php echo $v['id_pj'] ?>" <?php if($v['id_pj']==$data->id_pj){echo "selected";} ?>><?php echo $v['nama'] ?></option>
                          <?php } ?>
                          </select>
                    </div>
                    <div class="form-group" >
                        <label for="kode">Ibu Kota </label>
                        <input type="text" class="form-control" id="ibukota" name="ibukota" value="<?php echo $data->ibukota_kab_kota ?>">
                    </div>
                 
                    
                   
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="simpan_config()">Simpan</button>
            </div>
        </div>
    </div>
</div>








<div class="modal fade" id="modal_add_pj" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambahkan Pj Pelaporan </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form_add_pj">
                        <input type="hidden" class="form-control" id="id_pj" name="id_pj">
                    <div class="form-group" >
                        <label for="kode">Instansi penanggung jawab</label>
                      <select class="form-control" name="id_instansi" id="id_instansi">
                        <option></option>
                        <?php 
                        foreach ($data_instansi as $k => $v) { ?>
                          <option value="<?php echo $v['id_instansi'] ?>"><?php echo $v['nama_instansi'] ?></option>
                      <?php } ?>
                      </select>
                    </div>
                  
                    <div class="form-group" >
                        <label for="kode">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama">
                    </div>
                    <div class="form-group" >
                        <label for="kode">NIP</label>
                        <input type="text" class="form-control" id="nip" name="nip">
                    </div>
                    <div class="form-group" >
                        <label for="kode">Jabatan</label>
                        <input type="text" class="form-control" id="jabatan" name="jabatan">
                    </div>
                    <div class="form-group" >
                        <label for="kode">Mulai PJ</label>
                        <input type="date" class="form-control" id="mulai_pj" name="mulai_pj">
                    </div>
                    <div class="form-group" >
                        <label for="kode">Akhir PJ</label>
                        <input type="date" class="form-control" id="akhir_pj" name="akhir_pj">
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="simpan_pj_pelaporan_kab_kota()" id="tbl_simpan">Simpan</button>
                    <button type="button" class="btn btn-primary" onclick="simpanedit_pj_pelaporan_kab_kota()" id="tbl_simpanedit">Simpan Perubahan</button>
            </div>
        </div>
    </div>
</div>