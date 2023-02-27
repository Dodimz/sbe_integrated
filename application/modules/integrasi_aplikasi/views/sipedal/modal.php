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


<div class="modal fade" id="edit_sub_kegiatan_import_sipedal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ganti Sub Kegiatan Paket</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form_edit_instansi">
                    <div class="form-group" >
                        <label for="kode">Ganti Sub Kegiatan</label>
                        <input type="hidden" class="form-control" id="kode_sub_kegiatan" name="kode_sub_kegiatan">
                        <input type="hidden" class="form-control" id="id_paket_pekerjaan" name="id_paket_pekerjaan">
                    </div>
                    <div class="form-group" >
                        <div class="row">
                            <div class="col-md-6">
                                  <table class="table">
                                     <tr>
                                        <td colspan="2"><b>Paket Pekerjaan</b></td>
                                    </tr>
                                    <tr>
                                        <td>Nama Paket</td>
                                        <td id="nama_paket"></td>
                                    </tr>
                                    <tr>
                                        <td>Jenis Paket</td>
                                        <td  id="jenis_paket"></td>
                                    </tr>
                                    <tr>
                                        <td>Pagu Paket</td>
                                        <td  id="pagu_paket"></td>
                                    </tr>
                                    <tr>
                                        <td>Metode</td>
                                        <td class="nama_metode"></td>
                                    </tr>
                                   
                                </table>
                            </div>
                            <div class="col-md-6">
                                  <table class="table">
                                    <tr>
                                        <td colspan="2"><b>Sub Kegiatan Saat Ini</b></td>
                                    </tr>
                                    <tr>
                                        <td>Kode Sub Kegiatan</td>
                                        <td class="kode_sub_kegiatan"></td>
                                    </tr>

                                    <tr>
                                        <td>Nama Sub Kegiatan</td>
                                        <td class="nama_sub_kegiatan"></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                       Pilih Sub Kegiatan Baru
                      
                    </div>
                    <div class="form-group" >
                        <table id="datatable_1" class="table datatable_1" width="100%">
                            <thead>
                                <tr>
                                    <td>no</td>
                                    <td>Kode Sub Kegiatan</td>
                                    <td>Nama Sub Kegiatan</td>
                                    <td>Kategori</td>
                                    <td>Pilih</td>
                                </tr>
                            </thead>

                            <tbody>
                                <?php foreach ($sub_kegiatan_instansi as $k => $v) { 
                                    $nama_sub_kegiatan = $v['kategori']=='Sub Kegiatan SKPD' ? $v['nama_sub_kegiatan'] : $v['nama_sub_kegiatan'].'<br>'.$v['jenis_sub_kegiatan'].' - '.$v['keterangan'];
                                    ?>
                                <tr>
                                    <td><?php echo $k+1 ?></td>
                                    <td><?php echo $v['kode_rekening_sub_kegiatan'] ?></td>
                                    <td><?php echo $nama_sub_kegiatan ?></td>
                                    <td><?php echo $v['kategori'] ?></td>
                                    
                                    <td>
                                        <button class="btn btn-info btn-sm" onclick="simpanedit_sub_kegiatan_import_sipedal('<?php echo $v['kode_rekening_sub_kegiatan'] ?>','<?php echo $v['kode_rekening_kegiatan'] ?>','<?php echo $v['kode_rekening_program'] ?>','<?php echo $v['kode_bidang_urusan'] ?>')" type="button"><i class="fas fa-check"></i></button>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                  
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="edit_kategori_import_sipedal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ganti Kategori Paket</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form_edit_instansi">
                        <input type="hidden" class="form-control" id="kode_sub_kegiatan" name="kode_sub_kegiatan">
                        <input type="hidden" class="form-control" id="id_paket_pekerjaan" name="id_paket_pekerjaan">
                    <div class="form-group" >
                        <label for="kode">Identitas Paket</label>
                        <table class="table">
                             <tr>
                                <td colspan="2">Paket Pekerjaan</td>
                            </tr>
                            <tr>
                                <td>Nama Paket</td>
                                <td id="nama_paket"></td>
                            </tr>
                            <tr>
                                <td>Jenis Paket</td>
                                <td  id="jenis_paket"></td>
                            </tr>
                            <tr>
                                <td>Pagu Paket</td>
                                <td  id="pagu_paket"></td>
                            </tr>
                            <tr>
                                <td>Kategori Saat Ini</td>
                                <td id="kategori"></td>
                            </tr>
                         
                        </table>
                    </div>
                    <div class="form-group">
                        <label>Kategori</label>
                        <select class="form-control" name="option_kategori" id="option_kategori">
                            <option value="NON KONTRUKSI" >NON KONTRUKSI</option>
                            <option value="KONTRUKSI" >KONTRUKSI</option>
                        </select>
                    </div>
                
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                <button type="button" class="btn btn-primary" id="btnSaveMasterPaket" onclick="simpanedit_kategori_import_sipedal()">Save changes</button>
            </div>
        </div>
    </div>
</div>






   <script type="text/javascript">
$(document).ready( function () {
    $('.datatable_1').DataTable();
} );
   </script>

