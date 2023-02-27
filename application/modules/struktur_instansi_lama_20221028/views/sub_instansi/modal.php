<?php

/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 */
?>
<!-- Modal Tambah Sub Instansi-->
<div class="modal fade" id="modal-tambah-sub-instansi" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="form-tambah-sub-instansi">
					<div class="form-group">
						<label for="nama_sub_instansi">Nama Jabatan</label>
						<input type="hidden" id="idx" name="idx" value="0">
						<input type="hidden" id="id_kpa" name="id_kpa" value="0">
						<input type="text" class="form-control" id="nama_sub_instansi" name="nama_sub_instansi">
					</div>
					<div class="form-group">
						<label for="id_kedudukan">Kedudukan</label>
						<select name="id_kedudukan" id="id_kedudukan" class="form-control" style="width: 100%">
						</select>
					</div>
					<div class="form-group">
						<label for="full_name">Nama Lengkap</label>
						<input type="text" class="form-control" id="full_name" name="full_name">
					</div>
					<div class="form-group">
						<label for="username">Username</label>
						<input type="text" class="form-control" id="username" name="username">
					</div>
					<div class="form-group">
						<label for="email">E-Mail</label>
						<input type="text" class="form-control" id="email" name="email">
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary" onclick="save_sub_instansi('form-tambah-sub-instansi')">Save</button>
			</div>
		</div>
	</div>
</div>
<!-- Modal Informasi Detail Sub Instansi-->
<div class="modal fade" id="modal-informasi-detail" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="card-body">
					<h5 class="card-title">Data User</h5>
					<div class="table-responsive">
						<table class="mb-0 table" id="detail-user">

						</table>
					</div>
					<div class="divider list-kegiatan"></div>
					<h5 class="card-title list-kegiatan">Daftar Sub Kegiatan</h5>
					<div class="divider list-kegiatan"></div>
					<div class="position-relative form-group list-kegiatan select-kegiatan" style="display: none;">
						<div class="form-row">
							<div class="col-md-12">
								<div class="input-group">
									<div class="custom-file">
										<input type="hidden" name="id_user" id="id_user">
										<select name="sub_kegiatan" id="sub_kegiatan" class="form-control">
										</select>
									</div>
									<div class="input-group-append">
										<button class="btn btn-primary list-kegiatan" type="button" onclick="tambah_sub_kegiatan()">Tambah</button>
										<?php if (tahapan_apbd()==4) { ?>
										<button class="btn btn-info copy_sub_kegiatan" type="button" onclick="copy_sub_kegiatan()">Copy Sub Kegiatan APBD Awal</button>
										<?php } ?>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="table-responsive list-kegiatan">
						<hr>
						<b>
							Daftar Sub Kegiatan PPTK <br>
						Tahun Anggaran <?php echo tahun_anggaran() ?>
						</b>
						<br><br>
						<table id="table-list-sub-kegiatan" class="display" style="width:100%">
							<thead>
								<tr>
									<th width="1%">No</th>
									<th width="1%">Rekening</th>
									<th>Sub Kegiatan</th>
									<th>Tahapan APBD</th>
									<th>Status Sub Kegiatan</th>
									<th width="1%">Action</th>
								</tr>
							</thead>
						</table>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-danger" onclick="konfirmasi_hapus_sub_instansi()" id="hapus_sub_instansi">Hapus Sub Instansi</button>
				<button type="button" class="btn btn-primary" data-dismiss="modal" id="btn_tambah_sub_instansi" onclick="tambah_sub_instansi()">Tambah Sub Instansi</button>
			</div>
		</div>
	</div>
</div>