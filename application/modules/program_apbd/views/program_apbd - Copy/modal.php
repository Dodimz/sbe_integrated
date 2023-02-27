<?php

/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 */
?>
<!-- Modal Target Fisik dan Keuangan -->
<div class="modal fade" id="modal-export-program" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" id="data-target">
				<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								 Untuk export program harus menggunakan format yang telah di tentukan <br>
								 Silahkan download dahulu <a href="https://drive.google.com/file/d/1N9nXH8rgEv0dsAVlc9gxWvIg6lsAUagb/view?usp=sharing" onclick="download_format_excel_program()" target="_blank">Disini</a>
								

							</div>
							<div class="form-group">
								<form id="form-export-program">
								  <div class="input-group">
	                                <div class="custom-file">
	                                    <input type="file" class="custom-file-input" id="upload-file" name="upload_file" aria-describedby="inputGroupFileAddon04" onchange="get_file_name(this)">
	                                    <label class="custom-file-label" id="label-upload" for="upload-file">Choose File</label>
	                                </div>
	                                <div class="input-group-append">
	                                    <button class="btn btn-primary" type="button" id="btn-upload-export-program" onclick="simpan_export_program()" >Upload</button>
	                                </div>
								</form>
	                            </div>
							</div>
							
						</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<!-- Modal Sumber Dana -->
<div class="modal fade" id="modal-sumber-dana" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" id="data-target">
				<div class="row">
					<div class="col-md-12">
						<form id="form-sumber-dana">
							<div class="form-group">
								<label for="anggaran">Pagu</label>
								<input type="text" id="anggaran" name="anggaran" class="form-control currency" readonly="readonly">
							</div>
							<div class="form-group">
								<label for="dau">DAU</label>
								<input type="hidden" id="kode_rekening_kegiatan" name="kode_rekening_kegiatan">
								<input type="hidden" id="kode_urusan" name="kode_urusan">
								<input type="hidden" id="status" name="status">
								<input type="text" class="form-control currency" id="dau" name="dau" style="text-align: right;" value="0" onblur="if(value==''){value='0'}">
							</div>
							<div class="form-group">
								<label for="dak">DAK</label>
								<input type="text" class="form-control currency" id="dak" name="dak" style="text-align: right;" value="0" onblur="if(value==''){value='0'}">
							</div>
							<div class="form-group">
								<label for="dbh">DBH</label>
								<input type="text" class="form-control currency" id="dbh" name="dbh" style="text-align: right;" value="0" name="dbh" onblur="if(value==''){value='0'}">
							</div>
							<div class="form-group">
								<label for="lainnya">Lainnya</label>
								<input type="text" class="form-control currency" id="lainnya" style="text-align: right;" name="lainnya" value="0" onblur="if(value==''){value='0'}">
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" onclick="save_sumber_dana()">Save</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>