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
			<div class="col-md-3">
				<div class="form-group">
					<label for="provinsi"><strong>Provinsi</strong></label>
					<select name="provinsi" id="provinsi" class="form-control" onchange="bulan()">
						<option value="13" selected>SUMATERA BARAT</option>
						
					</select>
				</div>
			</div>
			<div class="col-md-3">
				<div class="form-group">
					<label for="kota"><strong>Kota</strong></label>
					<select name="kota" id="kota" class="form-control" onchange="bulan()">
						<option></option>
						<?php foreach ($kota->result() as $key => $value) : ?>
							<option value="<?= sbe_crypt($value->id_kota, 'E'); ?>"><?= $value->nama_kota; ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>
			<div class="col-md-2">
				<div class="form-group">
					<label for="tahap"><strong>Tahapan APBD</strong></label>
					<select name="tahap" id="tahap" class="form-control" onchange="bulan()">
						<option></option>
						<option value="2" <?php if(tahapan_apbd()==2){echo "selected";} ?>>APBD Awal</option>
						<?php if (tahapan_apbd()==4) { ?>
							<option value="4" <?php if(tahapan_apbd()==4){echo "selected";} ?>>APBD Perubahan</option>
						<?php 	} ?>
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