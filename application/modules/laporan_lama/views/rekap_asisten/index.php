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
    <div class="row">
      <div class="col-md-4">
        <div class="form-group">
          <label for="bulan"><strong>Pilih Bulan</strong></label>
          <select name="bulan" id="bulan" class="form-control" onchange="show_laporan(this.value)">
            <option></option>
            <?php for ($i = 1; $i <= 12; $i++) : ?>
              <option value="<?= $i; ?>"><?= bulan_global($i); ?></option>
            <?php endfor; ?>
          </select>
        </div>
      </div>
    </div>
    <div class="row">
      <iframe id="tampil_pdf" style="display: none;" src="" width="100%" height="768px"></iframe>
    </div>
  </div>
</div>