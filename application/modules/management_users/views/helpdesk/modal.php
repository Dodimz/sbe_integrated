
<div class="modal fade" id="modal_helpdesk_skpd" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Helpdesk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formMasterUser">
                    <input type="hidden" id="idUser" class="idUser" name="idUser">
                    <div class="form-group">
                       





                       <div class="position-relative form-group" id="tambah-instansi">
	                    <div class="form-row">
	                        <div class="col-md-12">
	                                <table class="table">	
	                                	<tr>
	                                		<td>Nama Helpdesk</td>
	                                		<td></td>
	                                		<td class="nama_helpdesk"></td>
	                                	</tr>
	                                	<tr>
	                                		<td>Username</td>
	                                		<td></td>
	                                		<td class="username"></td>
	                                	</tr>
	                                </table>
	                            <label for="">Tambah Instansi</label>
	                            <div class="input-group">
	                                <div class="custom-file">
	                                    <input type="hidden" id="id_user" name="id_user">
	                                    <select name="id_instansi" id="id_instansi" class="form-control">
	                                    </select>
	                                </div>
	                                <div class="input-group-append">
	                                    <button class="btn btn-primary" type="button" id="btn-tambah" onclick="tambah()">Tambah</button>
	                                </div>
	                            </div>
	                        </div>
	                    </div>
	                </div>
	                <div class="divider"></div>
	                <table id="table-opd" class="display" style="width:100%">
	                    <thead>
	                        <tr>
	                            <th>No</th>
	                            <th>Instansi</th>
	                            <th>Action</th>
	                        </tr>
	                    </thead>
	                </table>




                    </div>
				
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="clodemodalmodalMasterUser">Close</button>
            
            </div>
        </div>
    </div>
</div>