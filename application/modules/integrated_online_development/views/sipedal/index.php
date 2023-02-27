<?php 
$nama_tahap = [
	2=>'APBD AWAL',4=>'APBD PERUBAHAN'
];
 ?>

<div class="mb-3 card">
	<div class="card-body">
		<div class="row">
			<form>	
			</form>
			<div class="col-md-3">
				<div class="form-group">
					<label for="id_opd"><strong>OPD</strong></label>
					<select name="id_opd" id="id_opd" class="form-control" >
						<?php if ($this->session->userdata('id_group')==5) { ?>
						<?php } ?>
						<?php foreach ($opd->result() as $key => $value) : ?>
							<option value="<?= sbe_crypt($value->integrasi_sipedal_id_instansi, 'E'); ?>"><?= $value->nama_instansi; ?></option>
						<?php endforeach; ?>
							<option value="semua_opd">Semua OPD</option>
					</select>
				</div>
			</div>
			<div class="col-md-3">
				<div class="form-group">
					<label for="tahun"><strong>Tahun Anggaran</strong></label>
					<select name="tahun" id="tahun" class="form-control" >
						<?php foreach ($konfigurasi as $k => $v) { ?>
							<option value="<?php echo $v['tahun_anggaran'] ?>" <?php if($v['tahun_anggaran']==tahun_anggaran()){echo "selected";} ?>><?php echo $v['tahun_anggaran'] ?></option>
						<?php } ?>
					</select>
				</div> 
			</div>
		<!-- 	<div class="col-md-3">
				<div class="form-group">
					<label for="tahap"><strong>Tahapan APBD</strong></label>
					<select name="tahap" id="tahap" class="form-control" >
						<?php foreach ($nama_tahap as $k_t => $v) { ?>
							<option value="<?php echo $k_t ?>" <?php if($k_t==tahapan_apbd()){echo "selected";} ?>><?php echo $v ?></option>
						<?php } ?>
					</select>
				</div>
			</div> -->
		
			<div class="col-md-12">
				<div class="form-group">
					<button class="btn btn-info btn-block" onclick="get_data_integrasi_sipedal()" type="button" id="searching_button">Searching</button>
				</div>
			</div>
		</div>

		<div class="row">

			<div class="col-md-12" style="border: solid; border-width: 1px">
				<div id="show_data_sipd">
					
				</div>
				
			</div>
			
		
		</div>
	</div>
</div>