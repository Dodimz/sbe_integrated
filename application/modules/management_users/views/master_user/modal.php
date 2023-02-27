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
                     <?php if ($id_group==5) { ?>
                        <input type="hidden" name="idInstansi" class="form-control" id="idInstansi" value="<?php echo encrypt($id_instansi) ?>">
                                    
                        <?php }else{ ?>
                            <div class="form-group">
                                <label for="idInstansi">Instansi Name</label>
                                <select name="idInstansi" class="form-control" id="idInstansi">
        								<option value=""></option>
                                    <?php foreach($master_instansi->result() as $rows => $value): ?>
                                    	<option value="<?php echo encrypt($value->id_instansi); ?>"><?php echo $value->nama_instansi; ?></option>
        							<?php endforeach; ?>
                                </select>
                            </div>
                                    
                        <?php } ?>


					<!-- <div class="form-group">
                        <label for="idParent">User Parent</label>
                        <select name="idParent" class="form-control" id="idParent" style="width: 100%;" onchange="showGroup(this.value)">
                        </select>
                    </div> -->
                    <div class="form-group">
                        <label for="fullName">Full Name</label>
                        <input type="text" class="form-control" id="fullName" name="fullName">
                    </div>
                    <div class="form-group">
                        <label for="fullName">No HP</label>
                        <input type="text" class="form-control" id="nohp" name="nohp">
                    </div>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username">
                    </div>
                    <div class="form-group">
                        <label for="email">E-Mail</label>
                        <input type="text" class="form-control" id="email" name="email">
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
                                <?php if ($id_group==5) { ?>
                                    <option value="5" selected>Operator</option>
                                <?php }else{ ?>
                                    <option value=""></option>
                                <?php foreach($master_group->result() as $rows => $value): ?>
                                    <option value="<?php echo $value->id_group; ?>" <?php if($value->id_group==7){echo "hidden='true'";} ?>><?php echo $value->group_name  ; ?></option>
                                <?php endforeach; ?>
                            <?php } ?>
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
                <button type="button" class="btn btn-primary" id="btnSaveMasterUser" onclick="saveMasterUser()">Simpan</button>
                <button type="button" class="btn btn-primary" id="btnUpdateMasterUser" onclick="updateMasterUser()">Simpan Perubahan</button>
            </div>
        </div>
    </div>
</div>