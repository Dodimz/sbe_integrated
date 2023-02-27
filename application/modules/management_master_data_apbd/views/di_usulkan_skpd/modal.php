
<div class="modal fade" id="modal_reject_master_program" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form_master_program">
                   
                    <div class="form-group">
                        <label for="">Kode Program</label>
                        <input type="hidden" class="form-control" id="id" name="id">
                        <input type="text" class="form-control" id="kode" name="kode" readonly>
                    </div>
                    <div class="form-group">
                        <label for="">Nama Program</label>
                        <input type="text" class="form-control" id="nama" name="nama" readonly>
                    </div>
                    <div class="form-group">
                        <label for="">Alasan Penolakan</label>
                        <textarea class="form-control" name="alasan" id="alasan"></textarea>
                    </div>
                    
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="clodemodalmodal_master_program">Close</button>
              
                <button type="button" class="btn btn-primary" id="btnUpdate_master_program" onclick="reject_usulan_master_program()">Tolak</button>
            </div>
        </div>
    </div>
</div>









<div class="modal fade" id="modal_reject_master_kegiatan" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form_master_kegiatan">
                   
                    <div class="form-group">
                        <label for="">Kode kegiatan</label>
                        <input type="hidden" class="form-control" id="id" name="id">
                        <input type="text" class="form-control" id="kode" name="kode" readonly>
                    </div>
                    <div class="form-group">
                        <label for="">Nama kegiatan</label>
                        <input type="text" class="form-control" id="nama" name="nama" readonly>
                    </div>
                    <div class="form-group">
                        <label for="">Alasan Penolakan</label>
                        <textarea class="form-control" name="alasan" id="alasan"></textarea>
                    </div>
                    
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="clodemodalmodal_master_kegiatan">Close</button>
              
                <button type="button" class="btn btn-primary" id="btnUpdate_master_kegiatan" onclick="reject_usulan_master_kegiatan()">Tolak</button>
            </div>
        </div>
    </div>
</div>









<div class="modal fade" id="modal_reject_master_sub_kegiatan" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        <label for="">Kode sub_kegiatan</label>
                        <input type="hidden" class="form-control" id="id" name="id">
                        <input type="text" class="form-control" id="kode" name="kode" readonly>
                    </div>
                    <div class="form-group">
                        <label for="">Nama sub_kegiatan</label>
                        <input type="text" class="form-control" id="nama" name="nama" readonly>
                    </div>
                    <div class="form-group">
                        <label for="">Alasan Penolakan</label>
                        <textarea class="form-control" name="alasan" id="alasan"></textarea>
                    </div>
                    
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="clodemodalmodal_master_sub_kegiatan">Close</button>
              
                <button type="button" class="btn btn-primary" id="btnUpdate_master_sub_kegiatan" onclick="reject_usulan_master_sub_kegiatan()">Tolak</button>
            </div>
        </div>
    </div>
</div>