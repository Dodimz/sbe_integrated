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
			<div class="col-md-6">
				<div class="form-group">
					<label for="kode_rekening_program"><strong>Kode Rekening Program</strong></label>
					<select name="kode_rekening_program" id="kode_rekening_program" class="form-control" onchange="showKegiatanApbd(this.value)">
						<option value=""></option>
						<?php foreach ($kode_rekening_program->result() as $key => $value) : ?>
							<option value="<?php echo $value->kode_rekening_program; ?>"><?php echo $value->nama_program; ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>
		</div>
		<div class="divider"></div>
		<div class="row">
			<div class="col-md-12">
				<div class="table-responsive">
					<table id="table-kegiatan-apbd" class="display" style="width:100%">
						<thead>
							<tr>
								<th rowspan="2" style="text-align: center;">Rekening</th>
								<th rowspan="2" style="text-align: center;">Nama Kegiatan</th>
								<th colspan="3" style="text-align: center;">Belanja</th>
								<th rowspan="2" style="text-align: center;">Total</th>
								<th rowspan="2">Target</th>
								<th rowspan="2">Sumber</th>
							</tr>
							<tr>
								<th width="1%">Pegawai</th>
								<th width="1%">Barang/Jasa</th>
								<th width="1%">Modal</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>