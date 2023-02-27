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
				<div id="notifikasi">

				</div>
				
				<form id="form-register-kontrak">
								<input type="hidden" class="form-control" id="id_kontrak" name="id_kontrak" readonly="true">
								<input type="hidden" id="id_pptk" name="id_pptk">
								<input type="hidden" id="id_paket" name="id_paket">
							<label for="nama_pptk"><strong>Paket Pekerjaan</strong></label>
							<div class="input-group  mb-3">
								<input type="text" class="form-control" id="nama_paket" name="nama_paket" readonly="true" >
								
							</div>
					<div class="form-row register-kontrak" style="display: none;">
						
						<div class="col-md-12">
							<label for="nama_pptk"><strong>Nama PPTK</strong></label>
							<div class="input-group mb-3">
								<input type="text" class="form-control" id="nama_pptk" name="nama_pptk" readonly="true">
							</div>
						</div>
						<div class="col-md-12">
							<label for="nama_kegiatan"><strong>Nama Sub Kegiatan</strong></label>
							<input type="text" class="form-control" id="nama_kegiatan" name="nama_kegiatan" readonly="true">
						</div>
					</div>
					<br>
					<div class="form-row register-kontrak" style="display: none;">
						<div class="col-md-6">
							<label for="pagu_kegiatan"><strong>Pagu Sub Kegiatan</strong></label>
							<div class="input-group mb-3">
								<input type="text" class="form-control currency" id="pagu_kegiatan" name="pagu_kegiatan" readonly="true">
							</div>
						</div>
						<div class="col-md-6">
							<label for="pagu_paket"><strong>Pagu Paket</strong></label>
							<input type="text" class="form-control currency" id="pagu_paket" name="pagu_paket" readonly="true">
						</div>
					</div>
					<div class="form-row register-kontrak" style="display: none;">
						<div class="col-md-12">
							<label for="no_register_kontrak"><strong>No Kontrak Pekerjaan</strong></label>
							<small><i>Catatan : No Kontrak Pekerjaan</i></small>
							<div class="input-group mb-3">
								<input type="text" class="form-control" id="no_register_kontrak" name="no_register_kontrak" placeholder="No Kontrak Pekerjaan">
							</div>
						</div>
					</div>
					<div class="form-row register-kontrak" style="display: none;">
						<div class="col-md-12">
							<label for="pelaksana"><strong>Nama Penyedia Barang dan Jasa</strong></label>
							<div class="input-group mb-3">
								<input type="text" class="form-control" id="pelaksana" name="pelaksana" placeholder="Nama Penyedia Barang dan Jasa">
							</div>
						</div>
					</div>
					<div class="form-row register-kontrak" style="display: none;">
						<div class="col-md-6">
							<label for="tgl_awal_pelaksanaan"><strong>Tanggal Awal Pelaksanaan</strong></label>
							<div class="input-group mb-3">
								<input type="text" class="form-control" id="tgl_awal_pelaksanaan" name="tgl_awal_pelaksanaan" readonly="true">
							</div>
						</div>
						<div class="col-md-6">
							<label for="tgl_akhir_pelaksanaan"><strong>Tanggal Akhir Pelaksanaan</strong></label>
							<input type="text" class="form-control" id="tgl_akhir_pelaksanaan" name="tgl_akhir_pelaksanaan" readonly="true">
						</div>
						<div class="col-md-6">
							<label for="jenis_kontrak"><strong>Jenis Kontrak</strong></label>
							<select  id="jenis_kontrak" name="jenis_kontrak" class="form-control"  style="width: 100%">
								<option></option>
								<?php foreach ($jenis_kontrak as $k => $v) { ?>
								<option value="<?php echo $v['jenis_kontrak'] ?>"><?php echo $v['jenis_kontrak']  ?></option>
								<?php } ?>
								</select>
						</div>
						<div class="col-md-6">
							<label for="nilai_kontrak"><strong>Nilai Kontrak</strong></label>
							<div class="input-group mb-3">
								<input type="text" class="form-control currency" id="nilai_kontrak" name="nilai_kontrak" value="0">
							</div>
						</div>
					</div>
					
					<div class="form-row register-kontrak" style="display: none;">
						<hr>
						<div class="col-md-12">
							<label for=""><b>Domisili Pekerjaan</b></label>
						</div>
						<div class="col-md-4">
							<label for="lotitude_ok"><strong>Provinsi</strong></label>
							<div class="input-group mb-3">
								
								<input type="text" class="form-control" id="prov" name="prov" value="SUMATERA BARAT" readonly="true">
							</div>
						</div>
						<div class="col-md-4">
							<label for="langitude_ok"><strong>Kab / Kota</strong></label>
								<select  id="kab_kota" name="kab_kota" class="form-control"  style="width: 100%">
								</select>
						</div>
						<div class="col-md-4">
							<label for="langitude_ok"><strong>Kecamatan</strong></label>
								<select  id="kecamatan" name="kecamatan" class="form-control"  style="width: 100%">
								</select>
						</div>
					
					</div>
					
					<div class="form-row register-kontrak" style="display: none;">
						<div class="col-md-12">
								<input type="hidden" class="form-control" id="latitude_ok" name="latitude_ok" readonly="true">
							<input type="hidden" class="form-control" id="longitude_ok" name="longitude_ok" readonly="true">
						</div>
						
					
					</div>
				<div class="form-group register-kontrak" style="display: none;">



					<div class=" pull-right">
						<div class="d-inline-block dropdown">
                        <button type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn-shadow dropdown-toggle btn btn-info">
                            
                            Tambahkan GIS
                        </button>
                        <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-left">
                            <ul class="nav flex-column">
                                
                                <li class="nav-item">
                                    <a class="nav-link" onclick="input_lokasi('input')">
                                        <i class="nav-link-icon fa fa-bars"></i>
                                        <span>
                                           Via Input Koordinat
                                        </span>
                                        
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" onclick="input_lokasi('pilih')">
                                        <i class="nav-link-icon fa fa-bars"></i>
                                        <span>
                                           Via Pilih Koordinat
                                        </span>
                                        
                                    </a>
                                </li>
                                
                               
                            </ul>
                        </div>
                    </div>
					<button type="button" class="btn btn-info" id="btn-register-kontrak" onclick="saveedit_register_kontrak()">Simpan Perubahan</button>
					</div>
					
				</div>
				</form>
			</div>



			<div class="col-md-6">
				<div id="notifikasi">

				</div>					
					<div class="form-row" id="preview_maps" style="display:none">
						<div class="col-md-12">
							<label for="pagu_kegiatan"><strong>Preview Maps</strong></label>
						<div class="input-group mb-3">
							<div id="show_maps"></div>
							<div class="panel-body" style="width:100%; height:500px" id="googleMap"></div>
						</div>
					</div>
					
				</div>
			</div>
		</div>
	</div>
</div>