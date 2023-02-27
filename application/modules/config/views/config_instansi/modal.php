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
<div class="modal fade" id="modal_config_kab_kota" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<form id="config_instansi" method="post" action="<?php echo base_url() ?>config/simpanedit_config_instansi">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ganti Konfigurasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                    
                    <div class="form-group">
                        <label>Tahun Anggaran</label>
                        <select class="form-control" name="id_config">
                            <?php   foreach ($data_config as $k => $v) { ?>
                                <option value="<?php echo $v['id_config'] ?>" <?php if($v['id_config']==$config['id_config']){echo "selected";} ?>><?php echo $v['tahun_anggaran'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Tahapan apbd</label>
                        <select class="form-control" name="tahap">
                            <?php   
                            $tahap = [2=>'APBD AWAL',4=>'APBD PERUBAHAN'];
                            foreach ($tahap as $k => $v) { ?>
                                <option value="<?php echo $k ?>"  <?php if($k==$config['kode_tahap']){echo "selected";} ?>><?php echo $v ?></option>
                            <?php } ?>
                        </select>
                    </div>
                  
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-info">Simpan</button>
                 
            </div>
        </div>
    </div>
</form>
</div>



