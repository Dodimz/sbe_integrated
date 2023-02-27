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
					<select name="id_opd" id="id_opd" class="form-control">
						<?php if ($this->session->userdata('group_name') == "ADMIN" or $this->session->userdata('group_name') == "SUPER ADMIN") : ?>
							<option value=""></option>
							<option value="<?= sbe_crypt('semua_opd', 'E'); ?>">Semua OPD</option>
							<option value="<?= sbe_crypt('204', 'E'); ?>">OPD Linkup Asisten Pemerintahan Dan Kesra</option>
							<option value="<?= sbe_crypt('205', 'E'); ?>">OPD Linkup Asisten Pembangunan Dan Perekonomian</option>
							<option value="<?= sbe_crypt('206', 'E'); ?>">OPD Linkup Asisten Administrasi Umum</option>
						<?php endif; ?>
						<?php foreach ($opd->result() as $key => $value) : ?>
							<option value="<?= sbe_crypt($value->id_instansi, 'E'); ?>"><?= $value->nama_instansi; ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>
			<div class="col-md-2">
				<div class="form-group">
					<label for="id_opd"><strong>Tahun</strong></label>
					<select name="tahun" id="tahun" class="form-control">
						
						<?php foreach ($tahun as $k => $v) : ?>
							<option value="<?= $v['tahun_anggaran'] ?>" <?php if($v['tahun_anggaran']==tahun_anggaran()){echo "selected";} ?>><?= $v['tahun_anggaran']; ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>
			<div class="col-md-2">
				<div class="form-group">
					<label for="id_opd"><strong>Tahapan APBD</strong></label>
					<select name="kode_tahap" id="kode_tahap" class="form-control">
							<option value="2"  <?php if(tahapan_apbd()==2){echo "selected";} ?> >APBD AWAL</option>
							<option value="4"  <?php if(tahapan_apbd()==4){echo "selected";} ?> >APBD PERUBAHAN</option>
					</select>
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group">
					<button class="btn btn-block btn-info" type="button" onclick="show_laporan_permasalahan()">Searching</button>
				</div>
			</div>
		
		</div>
		<div class="row">
			<iframe id="tampil_pdf" style="display: none;" src="" width="100%" height="768px"></iframe>
		</div>
	</div>
</div>