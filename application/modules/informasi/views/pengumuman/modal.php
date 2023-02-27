<?php
/**
	* Author     : Alfikri, M.Kom
	* Created By : Alfikri, M.Kom
	* E-Mail     : alfikri.name@gmail.com
	* No HP      : 081277337405
*/

?>
<!-- Modal Master User-->
<form id="form-export-program" method="post" enctype="multipart/form-data" action="<?php echo base_url('informasi/simpanedit_pengumuman/') ?>">
<div class="modal fade" id="modal-edit-pengumuman" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Pengumuman</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                    <div class="form-group">
                        <label for="masalah">Judul</label>
                        <input type="hidden" class="form-control" id="id_pengumuman" name="id_pengumuman" >
                        <input type="text" class="form-control" id="judul" name="judul" required>
                    </div>
                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <textarea class="form-control" id="keterangan" name="keterangan" rows="8" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="masalah">Tanggal Pelaksanaan</label>
                        <input type="date" class="form-control" id="tgl" name="tgl">
                    </div>
                    <div class="form-group">
                        <label for="masalah">Jam Pelaksanaan</label>
                        <input type="time" class="form-control" id="jam" name="jam">
                    </div>
                    <div class="form-group">
                        <label for="masalah">File Pendukung</label>
                        <input type="hidden" class="form-control" id="filelama" name="filelama">
                        <div class="custom-file">
                                        <input type="file" name="upload_file">
                                        
                                    </div>
                    </div>
                    
                    
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="clodemodal_add_bantuan">Close</button>
                <button type="submit" class="btn btn-primary">Simpan Pengumuman</button>
               
            </div>
        </div>
    </div>
</div>
                </form>







<form id="form-export-program" method="post" enctype="multipart/form-data" action="<?php echo base_url('informasi/simpan_pengumuman/') ?>">
<div class="modal fade" id="modal-tambah-pengumuman" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Input Pengumuman</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                    <div class="form-group">
                        <label for="masalah">Judul</label>
                        <input type="text" class="form-control" id="judul" name="judul" required>
                    </div>
                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <textarea class="form-control" id="keterangan" name="keterangan" rows="8" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="masalah">Tanggal Pelaksanaan</label>
                        <input type="date" class="form-control" id="tgl" name="tgl">
                    </div>
                    <div class="form-group">
                        <label for="masalah">Jam Pelaksanaan</label>
                        <input type="time" class="form-control" id="jam" name="jam">
                    </div>
                    <div class="form-group">
                        <label for="masalah">File Pendukung</label>
                        <div class="custom-file">
                                        <input type="file" name="upload_file">
                                        
                                    </div>
                    </div>
                    
                    
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="clodemodal_add_bantuan">Close</button>
                <button type="submit" class="btn btn-primary">Simpan Pengumuman</button>
               
            </div>
        </div>
    </div>
</div>
                </form>
<!-- Modal Master User-->
<form id="form-export-program" method="post" enctype="multipart/form-data" action="<?php echo base_url('informasi/simpan_pengumuman/') ?>">
<div class="modal fade" id="modal-detail-pengumuman" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Pengumuman</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                    <div class="form-group">
                        <table class="table">
                          <tr>
                            <td valign="top" style="text-align: left">Judul</td>
                            <td valign="top">:</td>
                            <td valign="top" id="judul" style="text-align: left"></td>
                          </tr>
                          <tr>
                            <td valign="top" style="text-align: left">keterangan</td>
                            <td valign="top">:</td>
                            <td valign="top" id="keterangan" style="text-align: left"></td>
                          </tr>
                          <tr>
                            <td valign="top" style="text-align: left">Waktu Pelaksanaan</td>
                            <td valign="top">:</td>
                            <td valign="top" id="waktu" style="text-align: left"></td>
                          </tr>
                        </table>
                    </div>
                   
                    <div class="form-group" id="show_file_pengumuman">
                        <iframe src="" width="100%" frameborder="0" height="600px"></iframe>
                    </div>
                    
                    
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                
               
            </div>
        </div>
    </div>
</div>
                </form>
<!-- Modal Master User-->