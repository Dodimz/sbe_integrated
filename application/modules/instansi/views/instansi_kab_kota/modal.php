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
<div class="modal fade" id="modal_tambah_instansi" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah OPD</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form_tambah_instansi">
                    <div class="form-group" >
                        <label for="kode">Kode OPD</label>
                        <input type="text" class="form-control" id="kode" name="kode">
                    </div>
                 
                    <div class="form-group" >
                        <label for="kode">Nama Instansi</label>
                        <input type="text" class="form-control" id="nama" name="nama">
                    </div>
                    <div class="form-group" >
                        <label for="kode">Alamat</label>
                        <input type="text" class="form-control" id="alamat" name="alamat">
                    </div>
                    <div class="form-group" >
                        <label for="kode">Email</label>
                        <input type="text" class="form-control" id="email" name="email">
                    </div>
                    <div class="form-group" >
                        <label for="kode">No HP</label>
                        <input type="text" class="form-control" id="telp" name="telp">
                    </div>
                    <div class="form-group" >
                        <label for="kode">Website</label>
                        <input type="text" class="form-control" id="web" name="web">
                    </div>

                    <div class="form-group">
                        <label for="kode">Bulan Mulai Realisasi</label>
                        <select name="bulan_mulai" id="bulan_mulai" class="form-control">
                            <?php foreach ($pilihan_bulan as $k => $v) { ?>
                                <option value="<?php echo $k ?>"><?php echo $v ?></option>
                            <?php } ?> ?>
                        </select>
                    </div>
                    <div class="form-group" >
                        <label for="kode">Bulan Akhir Realisasi</label>
                        <select name="bulan_selesai" id="bulan_selesai" class="form-control">
                            <?php foreach ($pilihan_bulan as $k => $v) { ?>
                                <option value="<?php echo $k ?>" <?php if($k==12){echo "selected";} ?>><?php echo $v ?></option>
                            <?php } ?> ?>
                        </select>
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
                    <button type="button" class="btn btn-primary" onclick="simpan_instansi()">Simpan</button>
            </div>
        </div>
    </div>
</div>





<div class="modal fade" id="modal_edit_instansi" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit OPD</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form_edit_instansi">
                    <div class="form-group" >
                        <label for="kode">Kode OPD</label>
                        <input type="text" class="form-control" id="kode" name="kode">
                        <input type="hidden" class="form-control" id="id_instansi" name="id_instansi">
                    </div>
                  
                    <div class="form-group" >
                        <label for="kode">Nama Instansi</label>
                        <input type="text" class="form-control" id="nama" name="nama" style="text-transform:uppercase">
                    </div>
                    <div class="form-group" >
                        <label for="kode">Alamat</label>
                        <input type="text" class="form-control" id="alamat" name="alamat">
                    </div>
                    <div class="form-group" >
                        <label for="kode">Email</label>
                        <input type="text" class="form-control" id="email" name="email">
                    </div>
                    <div class="form-group" >
                        <label for="kode">No HP</label>
                        <input type="text" class="form-control" id="telp" name="telp">
                    </div>
                    <div class="form-group" >
                        <label for="kode">Website</label>
                        <input type="text" class="form-control" id="web" name="web">
                    </div>

                    
                    <div class="form-group">
                        <label for="kode">Bulan Mulai Realisasi</label>
                        <select name="bulan_mulai" id="bulan_mulai" class="form-control">
                            <?php foreach ($pilihan_bulan as $k => $v) { ?>
                                <option value="<?php echo $k ?>"><?php echo $v ?></option>
                            <?php } ?> ?>
                        </select>
                    </div>
                    <div class="form-group" >
                        <label for="kode">Bulan Akhir Realisasi</label>
                        <select name="bulan_selesai" id="bulan_selesai" class="form-control">
                            <?php foreach ($pilihan_bulan as $k => $v) { ?>
                                <option value="<?php echo $k ?>"><?php echo $v ?></option>
                            <?php } ?> ?>
                        </select>
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
                    <button type="button" class="btn btn-primary" onclick="simpanedit_instansi()">Simpan</button>
            </div>
        </div>
    </div>
</div>