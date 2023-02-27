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
					<label for="wilayah"><strong>Wilayah</strong></label>
					<select name="wilayah" id="wilayah" class="form-control" >
						<option></option>
						<option value="semua">Semua Wilayah</option>
						<option value="1">Wilayah 1</option>
						<option value="2">Wilayah 2</option>
						<option value="3">Wilayah 3</option>
						
					</select>
				</div>
			</div>

			<div class="col-md-3">
				<div class="form-group">
					<label for="tahun"><strong>Tahun</strong></label>
					<select name="tahun" id="tahun" class="form-control" >
						<?php foreach ($tahun as $k => $v) { ?>
							<option value="<?php echo $v['tahun_anggaran'] ?>"><?php echo $v['tahun_anggaran'] ?></option>
						<?php } ?>
						
					</select>
				</div>
			</div>
			<div class="col-md-2">
				<div class="form-group">
					<label for="tahap"><strong>Tahapan APBD</strong></label>
					<select name="tahap" id="tahap" class="form-control">
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
					<select name="kategori" id="kategori" class="form-control">
						<option></option>
						<option value="akumulasi">Akumulasi</option>
						<option value="per_bulan">Per Bulan</option>
					</select>
				</div>
			</div>
			<div class="col-md-2">
				<div class="form-group">
					<label for="bulan"><strong>Pilih Bulan</strong></label>
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