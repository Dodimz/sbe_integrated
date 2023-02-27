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
				<div id="ganti_struktur_instansi">
					
				</div>
				<button type="button" class="btn btn-primary" data-dismiss="modal" id="btn_tambah_sub_instansi" onclick="tambah_sub_instansi()">Tambah Sub Instansi</button>
			</div>
		</div>
	</div>
</div>





<div class="modal fade" id="modal-ganti-struktur" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="form_edit_struktur" method="post">
					<div class="form-group">
						<label for="nama_sub_instansi">Nama Jabatan</label>
						<input type="hidden" id="id_user" name="id_user">
						<input type="hidden" id="id_kedudukan" name="id_kedudukan">
						<input type="hidden" id="id_sub_instansi" name="id_sub_instansi">
						<input type="hidden" class="form-control" id="nama_sub_instansi_lama" name="nama_sub_instansi_lama">
						<input type="hidden" class="form-control" id="full_name_lama" name="full_name_lama">
						<input type="text" class="form-control" id="nama_sub_instansi" name="nama_sub_instansi">
					</div>
					<div class="form-group">
						<label for="nama_kedudukan">Kedudukan</label>
						<input type="text" name="nama_kedudukan" id="nama_kedudukan" class="form-control" readonly>
						</select>
					</div>
					<div class="form-group">
						<label for="full_name">Nama Lengkap</label>
						<input type="text" class="form-control" id="full_name" name="full_name">
					</div>
				
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary" onclick="warning_save_edit_sub_instansi()">Save</button>
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
				<div id="ganti_struktur_instansi">
					
				</div>
				<button type="button" class="btn btn-primary" data-dismiss="modal" id="btn_tambah_sub_instansi" onclick="tambah_sub_instansi()">Tambah Sub Instansi</button>
			</div>
		</div>
	</div>
</div>







<!-- Modal Sumber Dana -->
<div class="modal fade" id="modal_set_pptk" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tetapkan PPTK Sub Kegiatan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="data-target">
                <div class="row">
                    <div class="col-md-12">
                        <form id="form-sumber_dana">

                        <div class="form-group">
                            <table class="table">
                                <tr>
                                    <td>Kode</td>
                                    <td>:</td>
                                    <td class="kode_sub_kegiatan"></td>
                                </tr>
                                <tr>
                                    <td>Sub Kegiatan</td>
                                    <td>:</td>
                                    <td id="nama_sub_kegiatan"></td>
                                </tr>
                                <tr>
                                    <td>Tahapan</td>
                                    <td>:</td>
                                    <td id="nama_tahapan"></td>
                                </tr>
                             

                            </table>


                            <input type="hidden" class="form-control" id="pagu" readonly="true" value="">
                            <input type="hidden" name="kode_sub_kegiatan" id="kode_sub_kegiatan">
                            <input type="hidden" name="kode_kegiatan" id="kode_kegiatan">
                            <input type="hidden" name="kode_program" id="kode_program">
                            <input type="hidden" name="kode_bidang_urusan" id="kode_bidang_urusan">
                            <input type="hidden" name="tahap" id="tahap">
                            <input type="hidden" name="tahun" id="tahun">
                            <input type="hidden" id="status" name="status">
                        </div>
                         <div>	
                         	<label>PPTK Sub Kegiatan</label>
                            <table class="table">
                            	<thead>	
                            		<tr>
	                            		<th>No</th>
	                            		<th>Nama</th>
	                            		<th>Jabatan</th>
	                            		<th>Action</th>
	                            	</tr>
                            	</thead>
                            	<tbody id="list_pptk_kegiatan"></tbody>
                            </table>
                         </div>

                            <div class="form-group">
                                <label for="dak">Tambah PPTK Baru</label>
                               <select class="form-control" name="id_user" id="id_user_pptk" style="width: 100%">
                               	<?php foreach ($data_pptk as $k => $v) { ?>
                               		<option value="<?php echo $v['id_user'] ?>"><?php echo $v['full_name'].' ['.$v['nama_sub_instansi'] ?>]</option>
                               	<?php } ?>
                               </select>
                            </div>
                            
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="tambah_pptk_kegiatan()">Simpan PPTK Baru</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Sumber Dana  q 