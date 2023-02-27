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
			<div class="col-md-8">
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