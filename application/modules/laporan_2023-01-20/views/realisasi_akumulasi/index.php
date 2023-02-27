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
			<div class="col-md-2">
				<div class="form-group">
					<label for="tahun"><strong>Tahun Anggaran</strong></label>
					<select name="tahun" id="tahun" class="form-control" >
						<?php foreach ($config as $k => $v) { ?>
							<option value="<?php echo $v['tahun_anggaran'] ?>" <?php if($v['tahun_anggaran']==tahun_anggaran()){echo "selected";} ?>><?php echo $v['tahun_anggaran'] ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="col-md-2">
				<div class="form-group">
					<label for="tahap"><strong>Tahapan APBD</strong></label>
					<select name="tahap" id="tahap" class="form-control" >
						<?php foreach ($nama_tahap as $k_t => $v) { ?>
							<option value="<?php echo $k_t ?>" <?php if($k_t==tahapan_apbd()){echo "selected";} ?>><?php echo $v ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="col-md-2">
				<div class="form-group">
					<label for="kategori_laporan"><strong>Data Yang Ditampilkan</strong></label>
					<select name="kategori_laporan" id="kategori_laporan" class="form-control">
						<option></option>
						<?php 
						if ($this->session->userdata('id_group')==6) {
							
						$kategori_laporan = [
							'rfk_akumulasi'=>'Realisasi Fisik Dan Keuangan Akumulasi',
						];
						}else{
							
								$kategori_laporan = [
									'rfk_akumulasi'=>'Realisasi Fisik Dan Keuangan Akumulasi',
									'rfk_data_sumber_dana'=>'Sumber Dana Kegiatan SKPD',
									'rfk_akumulasi_data_paket_pekerjaan'=>'RFK Akumulasi dengan Data Paket Per Sub Kegiatan',
									'rfk_data_paket_pekerjaan'=>'Data Paket Per Sub Kegiatan',
									// 'paket_pekerjaan'=>'Paket Pekerjaan',
									// 'kontrak_pekerjaan'=>'Kontrak Pekerjaan',
									'rfk_berdasarakan_kelompok_jenis_belanja'=>'Realisasi Fisik Dan Keuangan Berdasarkan Kelompok Jenis Belanja',
									'rfk_berdasarakan_jenis_belanja_detail'=>'Realisasi Fisik Dan Keuangan Berdasarkan Detail Jenis Belanja',
								];
							
						}

						foreach ($kategori_laporan as $k => $v) { ?>
							<option value="<?php echo $k ?>" <?php if($k=='rfk_akumulasi'){echo "selected";} ?>><?php echo $v ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="col-md-2" id="f_kategori">
				<div class="form-group">
					<label for="kategori"><strong>Kategori</strong></label>
					<select name="kategori" id="kategori" class="form-control" >
						<option></option>
						<option value="akumulasi" selected>Akumulasi</option>
						<option value="per_bulan">Per Bulan</option>
					</select>
				</div>
			</div>
			
			<div class="col-md-2" id="f_bulan">
				<div class="form-group">
					<label for="bulan"><strong>Pilih Bulan</strong></label>
					<select name="bulan" id="bulan" class="form-control">
						<option></option>
						<?php for ($i = 1; $i <= 12; $i++) : ?>
							<option value="<?= $i; ?>" <?php if($i==bulan_aktif()){echo "selected";} ?>><?= bulan_global($i); ?></option>
						<?php endfor; ?>
					</select>
				</div>
			</div>

			<div class="col-md-12">
				<div class="btn-group btn-block">
                       <button type="button" class="btn-icon btn-shadow btn-outline-2x btn btn-outline-primary" onclick="show_laporan()"><i class="fa fa-search"> </i>  Tampilkan Laporan (PDF)</button>
                       <button type="button" class="btn-icon btn-shadow btn-outline-2x btn btn-outline-primary" onclick="download_laporan_excel()"><i class="fa fa-search"> </i> Tampilkan Laporan (Download Excel)</button>

                                </div> <br><br>		



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