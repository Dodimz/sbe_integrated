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
					<select name="id_opd" id="id_opd" class="form-control">
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
					<select name="tahap" id="tahap" class="form-control" onchange="bulan()">
						<?php foreach ($nama_tahap as $k_t => $v) { ?>
							<option value="<?php echo $k_t ?>" <?php if($k_t==tahapan_apbd()){echo "selected";} ?>><?php echo $v ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="col-md-2">
				<div class="form-group">
					<label for="tahap"><strong>Jenis Paket</strong></label>
					<select name="jenis_paket" id="jenis_paket" class="form-control" onchange="metode()">
						<option></option>
						<?php foreach ($jenis_paket as $k_t => $v) { ?>
							<option value="<?php echo $v ?>"><?php echo $v ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="col-md-2" id="f_metode" style="display:none">
				<div class="form-group">
					<label for="metode"><strong>Metode</strong></label>
					<select name="metode" id="metode" class="form-control">
						
					</select>
				</div>
			</div>
			<div class="col-md-2" id="f_kategori" style="display:none">
				<div class="form-group">
					<label for="kategori"><strong>Kategori</strong></label>
					<select name="kategori" id="kategori" class="form-control">
						<option value="semua">SEMUA KATEGORI</option>
						<option value="KONTRUKSI">KONTRUKSI</option>
						<option value="NON KONTRUKSI">NON KONTRUKSI</option>
						
					</select>
				</div>
			</div>
			<div class="col-md-12">
				<div class="btn-group btn-block">
                       <button type="button" class="btn-icon btn-shadow btn-outline-2x btn btn-outline-primary"  onclick="show_paket()"><i class="fa fa-search"> </i>Searching (Show PDF)</button>
                       <button type="button" class="btn-icon btn-shadow btn-outline-2x btn btn-outline-primary" onclick="export_excel_paket()"><i class="fa fa-search"> </i> Searching (Downlad Excel)</button>

                                </div>



			</div>
		</div>
		<div class="row">
			<iframe id="tampil_pdf" style="display: none;" src="" width="100%" height="768px"></iframe>
		</div>
	</div>
</div>

