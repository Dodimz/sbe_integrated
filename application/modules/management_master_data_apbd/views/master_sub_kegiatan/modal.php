<?php
/**
	* Author     : Alfikri, M.Kom
	* Created By : Alfikri, M.Kom
	* E-Mail     : alfikri.name@gmail.com
	* No HP      : 081277337405
*/
?>
<!-- Modal Master User-->
<div class="modal fade" id="modal_master_sub_kegiatan" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form_master_sub_kegiatan">
                   
                    <div class="form-group">
                        <label for="">Kode Sub Kegiatan</label>
                        <input type="hidden" class="form-control" id="id" name="id">
                        <input type="text" class="form-control" id="kode" name="kode">
                    </div>
                    <div class="form-group">
                        <label for="">Nama Sub Kegiatan</label>
                        <input type="text" class="form-control" id="nama" name="nama">
                    </div>
                    <div class="form-group">
                        <label for="">Pemaketan Dibolehkan</label>
                        <select class="form-control" id="pemaketan" name="pemaketan">
                            <option value="bebas">Bebas (Rutin, Swakelola, Penyedia)</option>
                            <option value="wajib_evidence">Wajib Memakai Evidence (Swakelola dan Penyedia)</option>
                        </select>
                    </div>
                    
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="clodemodalmodal_master_sub_kegiatan">Close</button>
                <button type="button" class="btn btn-primary" id="btnSave_master_sub_kegiatan" onclick="save_master_sub_kegiatan()">Save Sub Kegiatan</button>
                <button type="button" class="btn btn-primary" id="btnUpdate_master_sub_kegiatan" onclick="update_master_sub_kegiatan()">Save Perubahan</button>
            </div>
        </div>
    </div>
</div>





<div class="modal fade" id="modal_export_msk" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Export Master Sub Kegiatan Melalui Excel</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="data-target">
                <div class="row">
                        <div class="col-md-12">
                          
                            <div class="form-group">
                                <form id="form-export-program" method="post" enctype="multipart/form-data" action="<?php echo base_url('management_master_data_apbd/export_master_sub_kegiatan/') ?>">
                                  <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" name="upload_file">
                                        
                                    </div>
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="submit">Upload</button>
                                    </div>
                                    </div>
                                </form>
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




