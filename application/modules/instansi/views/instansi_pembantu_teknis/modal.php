
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
                    <input type="hidden" class="form-control" id="id_instansi_pembantu_teknis" name="id_instansi_pembantu_teknis">
                    <div class="form-group" >
                        <label for="kode">Kode</label>
                        <input type="text" class="form-control" id="kode" name="kode">
                    </div>
                    <div class="form-group" >
                        <label for="kode">Jenis Teknis</label>
                        <select class="form-control" id="jenis" name="jenis">
                            <option value=""></option>
                            <?php $jenis = [
                                'UPTD','Cabang Dinas','Panti Sosial','Satuan Pendidikan'
                            ];
                            foreach ($jenis as $k => $v) { ?>
                                <option value="<?php echo $v ?>"><?php echo $v ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group" >
                        <label for="kode">Nama Instansi Teknis</label>
                        <input type="text" class="form-control" id="nama" name="nama">
                    </div>
                      <div class="form-group" >
                        <label for="kode">Berlokasi Di</label>
                        <select class="form-control" id="kota" name="kota">
                            <option value=""></option>
                             <?php $status = ['Tidak Aktif','Aktif'];
                            foreach ($kota as $k => $v) { ?>
                                <option value="<?php echo $v['id_kota'] ?>"><?php echo $v['nama_kota'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                  
                    <div class="form-group" >
                        <label for="kode">Status</label>
                        <select class="form-control" id="status" name="status">
                            <option value=""></option>
                             <?php $status = ['Tidak Aktif','Aktif'];
                            foreach ($status as $k => $v) { ?>
                                <option value="<?php echo $k ?>" <?php  if ($k==1) { echo "selected";} ?>><?php echo $v ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    
                   
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="simpan_instansi_teknis()"  id="tombol_simpan">Simpan</button>
                    <button type="button" class="btn btn-primary" onclick="simpanedit_instansi_teknis()" id="tombol_simpanedit">Simpan Perubahan</button>
            </div>
        </div>
    </div>
</div>



