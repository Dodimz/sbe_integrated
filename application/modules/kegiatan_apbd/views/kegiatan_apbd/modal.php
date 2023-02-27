<?php

/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 */
?>
<!-- Modal Target Fisik dan Keuangan -->
<div class="modal fade" id="modal-target" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
							<label>Pagu</label>
							<input type="text" class="form-control" id="pagu" readonly="true" value="">
						</div>
						<table class="table" id="table-target">
							<thead>
								<tr>
									<th rowspan="2" width="1%">No</th>
									<th rowspan="2">Bulan</th>
									<th colspan="2" style="text-align: center;">Target</th>
									<th rowspan="2" style="text-align: center;">Keuangan</th>
								</tr>
								<tr>
									<th width="1%">Fisik</th>
									<th width="1%">Keu</th>
								</tr>
							</thead>
							<tbody id="target-apbd">

							</tbody>
						</table>
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