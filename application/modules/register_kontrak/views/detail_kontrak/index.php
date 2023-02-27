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
				<input type="hidden" name="id_paket" id="id_paket">
				<table class="table">
					<tr>
						<td colspan="3" style="background:#eeeefe">Sub Kegiatan</td>
					</tr>
					<tr>
						<td>Program</td>
						<td>:</td>
						<td id="nama_program"></td>
					</tr>
					<tr>
						<td>Kegiatan</td>
						<td>:</td>
						<td id="nama_kegiatan_master"></td>
					</tr>
				
					<tr>
						<td>Sub Kegiatan</td>
						<td>:</td>
						<td id="nama_kegiatan"></td>
					</tr>
					<tr>
						<td>Pagu Sub Kegiatan</td>
						<td>:</td>
						<td id="pagu_kegiatan"><span class="" id="pagu_kegiatan"></span></td>
					</tr>
					<tr>
						<td>PPTK</td>
						<td>:</td>
						<td id="nama_pptk"></td>
					</tr>
					<tr>
						<td colspan="3" style="background:#eeeefe">Paket Pekerjaan</td>
					</tr>
					<tr>
						<td>Nama Paket</td>
						<td>:</td>
						<td id="nama_paket"></td>
					</tr>
					<tr>
						<td>Jenis Paket</td>
						<td>:</td>
						<td id="jenis_paket"></td>
					</tr>
				
					<tr>
						<td>Metode</td>
						<td>:</td>
						<td id="metode"></td>
					</tr>
					<tr>
						<td>Pagu Paket</td>
						<td>:</td>
						<td id="pagu_paket"><span class=""></span></td>
					</tr>
					<tr>
						<td colspan="3" style="background:#eeeefe">Kontrak Pekerjaan</td>
					</tr>
					<tr>
						<td>Jenis Kontrak</td>
						<td>:</td>
						<td id="jenis_kontrak"></td>
					</tr>
					<tr>
						<td>Pelaksana</td>
						<td>:</td>
						<td id="pelaksana"></td>
					</tr>
					<tr>
						<td>Nomor Kontrak</td>
						<td>:</td>
						<td id="no_register_kontrak"></td>
					</tr>
					<tr>
						<td>Nilai Kontrak</td>
						<td>:</td>
						<td id="nilai_kontrak"></td>
					</tr>
				
					<tr>
						<td>Jadwal Kontrak</td>
						<td>:</td>
						<td> 
							<span id="tgl_awal_pelaksanaan"></span> s/d
							<span id="tgl_akhir_pelaksanaan"></span>
						</td>
					</tr>
					<tr>
						<td>Domisili Kontrak</td>
						<td>:</td>
						<td id="domisili"></td>
					</tr>
				</table>
				
			</div>



			<div class="col-md-6">
				<div id="notifikasi">

				</div>					
					<div class="form-row" id="preview_maps" style="display:none">
						<div class="col-md-12">
							<label for="pagu_kegiatan"><strong>Preview Maps</strong></label>
						<div class="input-group mb-3">
							<div id="show_maps"></div>
						</div>
					</div>
					
				</div>
			</div>
			<div class="col-md-12">
				<button class="btn btn-info" onclick="tambah_progress(<?php echo $id_paket_pekerjaan ?>)">Tambah Progress</button> <br><br>
				<table id="progress-pekerjaan" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th style="text-align: center;" width="1%">No</th>
                                <th style="text-align: center;">Progress</th>
                                <th style="text-align: center;">Keterangan</th>
                                <th style="text-align: center;">Tanggal</th>
                                <th style="text-align: center;">Foto</th>
                                <th style="text-align: center;">Option</th>
                            </tr>
                        </thead>
                    </table>
			</div>
		</div>
	</div>
</div>