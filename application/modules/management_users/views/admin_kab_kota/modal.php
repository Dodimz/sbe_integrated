<?php
/**
	* Author     : Alfikri, M.Kom
	* Created By : Alfikri, M.Kom
	* E-Mail     : alfikri.name@gmail.com
	* No HP      : 081277337405
*/
?>
<!-- Modal Master User-->
<div class="modal fade" id="modalMasterUser" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formMasterUser">
                    <input type="hidden" id="idUser" class="idUser" name="idUser">
                    <div class="form-group">
                        <label for="id_kota">Kab  / Kota</label>
                        <select name="id_kota" class="form-control" id="id_kota" style="width: 100%;">
								<option value=""></option>
                            <?php foreach($daftar_kota->result() as $rows => $value): ?>
                            	<option value="<?php echo encrypt($value->id_kota); ?>"><?php echo $value->nama_kota; ?></option>
							<?php endforeach; ?>
                        </select>
                    </div>
					
                    <div class="form-group">
                        <label for="fullName">Full Name</label>
                        <input type="text" class="form-control" id="fullName" name="fullName">
                    </div>
                    <div class="form-group">
                        <label for="fullName">No HP</label>
                        <input type="text" class="form-control" id="nohp" name="nohp">
                    </div>
                    <div class="form-group">
                        <label for="email">E-Mail</label>
                        <input type="text" class="form-control" id="email" name="email">
                    </div>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <div class="form-group">
                        <label for="passwordConfirm">Password Confirm</label>
                        <input type="password" class="form-control" id="passwordConfirm" name="passwordConfirm">
                    </div>

                     <div class="form-group">
                        <label for="group">Group</label> <br>
                        <!--  <?php //foreach($master_group->result() as $rows => $value): ?>
                                <input type="radio" name="group" value="<?php echo $value->id_group; ?>" id="group" style="margin-right: 20px"><?php echo $value->group_name  ; ?> <br>
                            <?php //endforeach; ?> -->



                              <select name="group" class="form-control" id="group" style="width: 100%;">
                                <option value=""></option>
                            <?php foreach($master_group->result() as $rows => $value): ?>
                                <option value="<?php echo $value->id_group; ?>" <?php if($value->id_group!=7){echo "hidden='true'";} ?>><?php echo $value->group_name  ; ?></option>
                            <?php endforeach; ?>
                        </select>
                      
                    </div>
                    
                    <br>
                    <div class="form-group">
                        <label for="isActive">Active</label>
                        <select name="isActive" class="custom-select" id="isActive">
                            <option value="1">Active</option>
                            <option value="0">Not Active</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="clodemodalmodalMasterUser">Close</button>
                <button type="button" class="btn btn-primary" id="btnSaveMasterUser" onclick="saveMasterUserKabKota()">Save changes</button>
                <button type="button" class="btn btn-primary" id="btnUpdateMasterUser" onclick="updateMasterUser()">Save changes</button>
            </div>
        </div>
    </div>
</div>