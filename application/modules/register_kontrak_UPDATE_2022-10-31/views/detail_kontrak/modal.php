<?php
/**
	* Author     : Alfikri, M.Kom
	* Created By : Alfikri, M.Kom
	* E-Mail     : alfikri.name@gmail.com
	* No HP      : 081277337405
*/
?>

<div class="modal fade" id="modal-tambah-progress-pekerjaan" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Progress Pekerjaan <br>
                <span class="nama_paket_pekerjaan">Nama Paket</span> 
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="data-progress">
              <form id="form_add_progress">
                    <div class="col-lg-3" style="float:left">
                        
                    <input type="hidden" id="id_paket_pekerjaan" name="id_paket_pekerjaan">
                      <div class="form-group">
                        <label for="">Tanggal Pengerjaan</label>
                        <input type="date" class="form-control" id="tgl" name="tgl">
                      </div>
                    </div>
                    <div class="col-lg-2" style="float:left">
                      <div class="form-group">
                        <label for="">Progress</label>
                        <select name="persen" id="persen" class="form-control">
                        
                        </select>
                      </div>
                    </div>
                    <div class="col-lg-6" style="float:left">
                        <div class="form-group">
                            <label for="">Foto Progress Pengerjaan</label><br>
                            <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="upload-file" name="upload_file" aria-describedby="inputGroupFileAddon04" onchange="get_file_name(this)">
                                        <label class="custom-file-label" id="label-upload" for="upload-file">Choose File</label>
                                    </div>
                                   
                                </div>

                        </div>
                    </div>
                    <div class="col-lg-12" style="float:left">
                      <div class="form-group">
                        <label for="">Keterangan</label>
                        <textarea class="form-control" rows="6" name="keterangan" id="keterangan"></textarea>
                      </div>
                    </div>
                  
              </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-info  pull-left" id="btn_copy_progress_awal" onclick="simpan_progress_pekerjaan()">Simpan</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="closemodal_tambah_progress">Close</button>
            </div>
        </div>
    </div>
</div>