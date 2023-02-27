<?php
$nama_tahap = [
    2=>'APBD AWAL',4=>'APBD PERUBAHAN'
];
?>
<div class="mb-3 card">
  <div class="card-body">
    <div class="row">
      <div class="col-md-2">
                <div class="form-group">
                    <label for="tahun"><strong>Tahun Anggaran</strong></label>
                    <select name="tahun" id="tahun" class="form-control" onchange="bulan()">
                        <?php foreach ($config as $k => $v) { ?>
                            <option value="<?php echo $v['tahun_anggaran'] ?>" <?php if($v['tahun_anggaran']==tahun_anggaran()){echo "selected";} ?>><?php echo $v['tahun_anggaran'] ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="tahap"><strong>Tahapan APBD</strong></label>
                    <select name="tahap" id="tahap" class="form-control" onchange="bulan()">
                        <?php foreach ($nama_tahap as $k_t => $v) { ?>
                            <option value="<?php echo $k_t ?>" <?php if($k_t==tahapan_apbd()){echo "selected";} ?>><?php echo $v ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
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