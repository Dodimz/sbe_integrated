<?php

/**
 * Author     : Hamid Septian, M.Kom
 * Created By : Hamid Septian, M.Kom
 * E-Mail     : hamidseptian.name@gmail.com
 * No HP      : 081277337405
 */
?>
<div class="mb-3 card">
  <div class="card-body">
    <div class="row">
      <div class="col-md-4">
        <div class="form-group">
          <label for="provinsi"><strong>Pilih Provinsi</strong></label>
          <select name="provinsi" id="provinsi" class="form-control" onchange="list_kab_kota(this.value)">
            <option></option>
            <?php foreach ($provinsi as $k => $v) { ?>
              <option value="<?= sbe_crypt($v->id_provinsi, 'E'); ?>"><?= $v->nama_provinsi; ?></option>
            <?php } ?>
          </select>
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label for="kota"><strong>Pilih Kab. / Kota</strong></label>
          <select name="kota" id="kota" class="form-control" onchange="show_laporan(this.value)">
            <option></option>
            
          </select>
        </div>
      </div>
    </div>
    <div class="row">
      <iframe id="tampil_pdf" style="display: none;" src="" width="100%" height="768px"></iframe>
    </div>
  </div>
</div>