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
                    <label for="tahun"><strong>Tahun </strong></label>
                    <select name="tahun" id="tahun" class="form-control">
                        <?php foreach ($config as $k => $v) { ?>
                            <option value="<?php echo $v['tahun_anggaran'] ?>" <?php if($v['tahun_anggaran']==tahun_anggaran()){echo "selected";} ?>><?php echo $v['tahun_anggaran'] ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="tahap"><strong>Tahapan APBD</strong></label>
                    <select name="tahap" id="tahap" class="form-control">
                        <?php foreach ($nama_tahap as $k_t => $v) { ?>
                            <option value="<?php echo $k_t ?>" <?php if($k_t==tahapan_apbd()){echo "selected";} ?>><?php echo $v ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
             <div class="col-md-2">
                <div class="form-group">
                    <label for="asisten"><strong>Kelompok Asisten</strong></label>
                    <select name="asisten" id="asisten" class="form-control" >
                        <option></option>
                        <option value="semua" selected>Semua Data</option>
                        <option value="204">Asisten Pemerintahan Dan Kesra</option>
                        <option value="205">Asisten Perekonomian Dan Pembangunan</option>
                        <option value="206">Asisten Administrasi Umum</option>
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="realisasi"><strong>Perengkingan Berdasarkan</strong></label>
                    <select name="realisasi" id="realisasi" class="form-control">
                        <option></option>
                        <option value="tidak_ada" selected>Tanpa Perengkingan</option>
                        <option value="fisik">Berdasarkan Realisasi Fisik Tertinggi</option>
                        <option value="keu">Berdasarkan Realisasi Keuangan Tertinggi</option>
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="kategori"><strong>Kategori</strong></label>
                    <select name="kategori" id="kategori" class="form-control">
                        <option></option>
                        <option value="Akumulasi" selected>Akumulasi</option>
                        <option value="Bulanan">Per Bulan</option>
                    </select>
                </div>
            </div>

         <!--    <div class="col-md-2">
                <div class="form-group">
                    <label for="tahap"><strong>Bentuk Perhitungan</strong></label>
                    <select name="perhitungan" id="perhitungan" class="form-control" >
                      <option></option>
                      <option value="Akuntansi" >Secara Akuntansi</option>
                      <option value="Rata rata" selected>Secara Ratarata</option>
                    </select>
                </div>
            </div> -->
            <div class="col-md-2" style="display:none">
                <div class="form-group" >
                    <label for="kategori_laporan"><strong>Data Yang Ditampilkan</strong></label>
                    <select name="kategori_laporan" id="kategori_laporan" class="form-control">
                        <option></option>
                        <?php 
                        $kategori_laporan = [
                            'perengkingan_dengan_deviasi'=>'Perengkingan dengan deviasi ',
                            'pagu_dan_realisasi_skpd_per_jenis_belanja_bulanan'=>'Pagu Dan Realisasi Keuangan Berdasarkan Jenis Belanja [Bulanan]',
                            'pagu_dan_realisasi_skpd_per_jenis_belanja_akumulasi'=>'Pagu Dan Realisasi Keuangan Berdasarkan Jenis Belanja [Akumulasi]',
                        ];
                        foreach ($kategori_laporan as $k => $v) { ?>
                            <option value="<?php echo $k ?>" <?php if($k=='perengkingan_dengan_deviasi'){echo "selected";} ?>><?php echo $v ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>


            <div class="col-md-2">
                <div class="form-group">
                    <label for="bulan"><strong>Bulan</strong></label>
                    <select name="bulan" id="bulan" class="form-control">
                        <option></option>
                        <?php for ($i = 1; $i <= 12; $i++) : ?>
                            <option value="<?= $i; ?>"><?= bulan_global($i); ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <button class="btn btn-block btn-info" onclick="show_laporan()">Searching</button>
                </div>
            </div>
        </div>
        <div class="row">
            <iframe id="tampil_pdf" style="display: none;" src="" width="100%" height="768px"></iframe>
        </div>
    </div>
</div>