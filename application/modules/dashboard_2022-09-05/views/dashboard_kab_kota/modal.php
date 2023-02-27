<?php
/**
	* Author     : Alfikri, M.Kom
	* Created By : Alfikri, M.Kom
	* E-Mail     : alfikri.name@gmail.com
	* No HP      : 081277337405
*/
?>
<!-- Modal input-->
<div class="modal fade" id="modal_ganti_password" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Perbaharui Password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
               
                <form id="form_edit_password">
                	
                
					<div class="form-group">
                        <label for="">Masukan Password Lama Anda</label>
                        <input type="password" class="form-control" name="pass_lama" id="pass_lama">
                    </div>
                    <div class="form-group">
                        <label for="">Masukan password baru</label>
                        <input type="password" class="form-control" name="pass_baru" id="pass_baru">
                    </div>      <div class="form-group">
                        <label for="">Konfirmasi Password</label>
                        <input type="password" class="form-control" name="pass_confirm" id="pass_confirm">
                    </div>
                   
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btn_save_anggaran_sub_kegiatan" onclick="simpan_perubahan_password()">Save changes</button>
                
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_edit_user" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
               
                <form id="form_edit_user">
                    
                
                     <div class="form-group">
                        <label>Nama PJ</label>
                        <input type="text" class="form-control" value="<?php echo $data_user->full_name ?>" id="full_name" name="full_name">
                    </div>
                     <div class="form-group">
                        <label>No HP</label>
                        <input type="text" class="form-control" value="<?php echo $data_user->nohp ?>" id="nohp" name="nohp">
                    </div>
                  
                   
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="" onclick="simpan_edit_user()">Save changes</button>
                
            </div>
        </div>
    </div>
</div>
