<?php 
$nama_tahap = [
	2=>'APBD AWAL',4=>'APBD PERUBAHAN'
];
 ?>

<div class="mb-3 card">
	<div class="card-body">
		<div class="row">
			<div class="col-md-3">
				<div class="form-group">
					<label for="id_opd"><strong>OPD</strong></label>
					<select name="id_opd" id="id_opd" class="form-control" >
						<?php if ($this->session->userdata('group_name') == "ADMIN" or $this->session->userdata('group_name') == "SUPER ADMIN") : ?>
							<option value=""></option>
						<?php endif; ?>
						<?php foreach ($opd->result() as $key => $value) : ?>
							<option value="<?= sbe_crypt($value->id_instansi, 'E'); ?>"><?= $value->nama_instansi; ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>
			<div class="col-md-3">
				<div class="form-group">
					<label for="tahun"><strong>Tahun Anggaran</strong></label>
					<select name="tahun" id="tahun" class="form-control" >
						<?php foreach ($config as $k => $v) { ?>
							<option value="<?php echo $v['tahun_anggaran'] ?>" <?php if($v['tahun_anggaran']==tahun_anggaran()){echo "selected";} ?>><?php echo $v['tahun_anggaran'] ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="col-md-3">
				<div class="form-group">
					<label for="tahap"><strong>Tahapan APBD</strong></label>
					<select name="tahap" id="tahap" class="form-control" >
						<?php foreach ($nama_tahap as $k_t => $v) { ?>
							<option value="<?php echo $k_t ?>" <?php if($k_t==tahapan_apbd()){echo "selected";} ?>><?php echo $v ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="col-md-3" id="f_kategori">
				<div class="form-group">
					<label for="kategori"><strong>Penampilan Data</strong></label>
					<select name="kategori" id="kategori" class="form-control" >
						<option></option>
						<option value="pagu_total" selected>Hanya Pagu Total</option>
						<option value="pagu_jenis_belanja">Pagu per Jenis Belanja</option>
					</select>
				</div>
			</div>
			
			<div class="col-md-12">
				<div class="form-group">
					<button class="btn btn-info btn-block" onclick="show_laporan()" type="button">Searching</button>
				</div>
			</div>
		</div>
		<div class="row">
			<div id="loading"  style="display: none;">
				
				<div class="font-icon-wrapper float-left mr-3 mb-3">
				    <div class="loader-wrapper d-flex justify-content-center align-items-center">
				        <div class="loader">
				            <div class="ball-rotate">
				                <div></div>
				            </div>
				        </div>
				    </div>
				 
				</div>
			</div>
			<iframe id="tampil_pdf" style="display: none;" src="" width="100%" height="768px"></iframe>
		</div>
	</div>
</div>