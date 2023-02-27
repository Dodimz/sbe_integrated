<?php

/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 */

$pilihan_bulan = [
    1=>'Januari',
    'Februari',
    'Maret',
    'April',
    'Mei',
    'Juni',
    'Juli',
    'Agustus',
    'September',
    'Oktober',
    'November',
    'Desember'                                   
];

                             ?>
<!-- Modal Dokumen Realisasi -->
<div class="modal fade" id="modal_tambah_tutorial" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Tutorial</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form_tambah_tutorial">
                        <input type="hidden" class="form-control" id="id_tutorial" name="id_tutorial">
                   
                    <div class="form-group" >
                        <label for="kode">Akses</label>
                        <select class="form-control" id="akses" name="akses">
                            <option value=""></option>
                            <?php 
                            foreach ($group as $k => $v) { ?>
                                <option value="<?php echo $v['id_group'] ?>"><?php echo $v['group_name'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group" >
                        <label for="kode">Urutan</label>
                        <input type="text" class="form-control" id="urutan" name="urutan">
                    </div>
                    <div class="form-group" >
                        <label for="kode">Judul</label>
                        <input type="text" class="form-control" id="judul" name="judul">
                    </div>
                    <div class="form-group" >
                        <label for="kode">Keterangan</label>
                        <textarea class="form-control" id="keterangan" name="keterangan"></textarea>
                    </div>
                    <div class="form-group" >
                        <label for="kode">Tipe</label>
                           <select class="form-control" id="tipe" name="tipe">
                            <option value=""></option>
                                <option value="Video" selected>Video</option>
                                <option value="Artikel">Artikel</option>
                           
                        </select>
                    </div>
                    <div class="form-group" >
                        <label for="kode">Link Tutorial</label>
                        <input type="text" class="form-control" id="link" name="link">
                    </div>
                
                    <div class="form-group" >
                        <label for="kode">Status</label>
                        <select class="form-control" id="status" name="status">
                            <option value=""></option>
                             <?php $status = ['Tidak Aktif','Aktif'];
                            foreach ($status as $k => $v) { ?>
                                <option value="<?php echo $k ?>"><?php echo $v ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    
                   
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="simpan_tutorial()" id="simpan">Simpan</button>
                    <button type="button" class="btn btn-primary" onclick="simpanedit_tutorial()" id="simpanedit">Simpan Perubahan</button>
            </div>
        </div>
    </div>
</div>



<!-- Modal Dokumen Realisasi -->
<div class="modal fade" id="modal_lihat_video_tutorial" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Lihat Turotial</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <label class="judul"></label> <br>
                <div class="video_yt"></div>
               
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
               
            </div>
        </div>
    </div>
</div>


