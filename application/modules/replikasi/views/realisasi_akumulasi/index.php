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
					<label for="id_opd"><strong>OPD</strong></label>
					<select name="id_opd" id="id_opd" class="form-control" onchange="bulan()">
						<?php if ($this->session->userdata('group_name') == "ADMIN" or $this->session->userdata('group_name') == "SUPER ADMIN") : ?>
							<option value=""></option>
						<?php endif; ?>
						<?php foreach ($opd->result() as $key => $value) : ?>
							<option value="<?= sbe_crypt($value->id_instansi, 'E'); ?>"><?= $value->nama_instansi; ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>
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
			<div class="col-md-2">
				<div class="form-group">
					<label for="kategori"><strong>Kategori</strong></label>
					<select name="kategori" id="kategori" class="form-control" onchange="bulan()">
						<option></option>
						<option value="akumulasi">Akumulasi</option>
						<option value="per_bulan">Per Bulan</option>
					</select>
				</div>
			</div>
			<div class="col-md-2">
				<div class="form-group">
					<label for="kategori_laporan"><strong>Data Yang Ditampilkan</strong></label>
					<select name="kategori_laporan" id="kategori_laporan" class="form-control" onchange="bulan()">
						<option></option>
						<?php 
						$kategori_laporan = [
							'realisasi_fisik_keuangan'=>'Realisasi Fisik Dan Keuangan Gabungan',
							'realisasi_keuangan_jenis_belanja'=>'Realisasi Keuangan Berdasarkan Jenis Belanja',
							'paket_pekerjaan'=>'Paket Pekerjaan',
							'kontrak_pekerjaan'=>'Kontrak Pekerjaan',
						];
						foreach ($kategori_laporan as $k => $v) { ?>
							<option value="<?php echo $k ?>"><?php echo $v ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="col-md-2">
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