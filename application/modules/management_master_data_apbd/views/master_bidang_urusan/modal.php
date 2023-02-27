<?php
/**
	* Author     : Alfikri, M.Kom
	* Created By : Alfikri, M.Kom
	* E-Mail     : alfikri.name@gmail.com
	* No HP      : 081277337405
*/
?>
<!-- Modal Master User-->
<div class="modal fade" id="modal_master_bidang_urusan" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form_master_bidang_urusan">
                   
                    <div class="form-group">
                        <label for="">Kode bidang_urusan</label>
                        <input type="hidden" class="form-control" id="id" name="id">
                        <input type="text" class="form-control" id="kode" name="kode">
                    </div>
                    <div class="form-group">
                        <label for="">Nama bidang_urusan</label>
                        <input type="text" class="form-control" id="nama" name="nama">
                    </div>
                    
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="clodemodalmodal_master_bidang_urusan">Close</button>
                <button type="button" class="btn btn-primary" id="btnSave_master_bidang_urusan" onclick="save_master_bidang_urusan()">Save bidang_urusan</button>
                <button type="button" class="btn btn-primary" id="btnUpdate_master_bidang_urusan" onclick="update_master_bidang_urusan()">Save Perubahan</button>
            </div>
        </div>
    </div>
</div>