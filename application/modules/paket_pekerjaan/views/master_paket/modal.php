<?php
/**
	* Author     : Alfikri, M.Kom
	* Created By : Alfikri, M.Kom
	* E-Mail     : alfikri.name@gmail.com
	* No HP      : 081277337405
*/
?>
<!-- Modal Master Paket-->
<div class="modal fade" id="modalMasterPaket" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
             <!--   <div class="form-group">
                    <table class="table">
                        <tr>
                            <td>Kode Rekening</td>
                            <td>:</td>
                            <td class="kode_rekening"></td>
                        </tr>
                        <tr>
                            <td>Kegiatan</td>
                            <td>:</td>
                            <td class="nama_sub_kegiatan"></td>
                        </tr>
                        <tr>
                            <td>Pagu Kegiatan</td>
                            <td>:</td>
                            <td class="pagu_sub_kegiatan"></td>
                        </tr>
                        <tr>
                            <td>Pagu Tersedia</td>
                            <td>:</td>
                            <td class="pagu_anggaran_tersedia"></td>
                        </tr>
                    </table>
                </div> -->
                <div id="pesan_mnodal_paket">
                </div>
                <form id="formMasterPaket">
                	<input type="hidden" name="input_type" id="input_type">
                    <input type="hidden" name="anggaran_tersedia" id="anggaran_tersedia">
                    <input type="hidden" name="id_pptk" id="id_pptk">
                	<input type="hidden" name="kode_program" id="kode_program">
                    <input type="hidden" name="kode_rekening_kegiatan" id="kode_rekening_kegiatan">
                    <input type="hidden" name="kode_rekening_sub_kegiatan" id="kode_rekening_sub_kegiatan">
                    <input type="hidden" name="kode_bidang_urusan" id="kode_bidang_urusan">
                    <input type="hidden" name="id_paket_pekerjaan" id="id_paket_pekerjaan">
                    <input type="hidden" name="anggaran_sebelumnya" id="anggaran_sebelumnya">
                    <input type="hidden" name="pemaketan" id="pemaketan">
					<div class="form-group">
                      <!--   <table class="table">
                            <tr>
                                <td>Ditambahkan ini berada Pada</td>
                                <td>:</td>
                                <td><span class="nama_tahapan_paket"></span></td>
                            </tr>
                        </table> -->
                    </div>
                    <hr>
                    <div class="form-group">
                        <label for="nama_paket">Nama Paket</label>
                        <input type="text" class="form-control" id="nama_paket" name="nama_paket">
                    </div>
                    <div class="form-group">
                        <label for="jenis_paket">Jenis Paket</label>
                        <select name="jenis_paket" id="jenis_paket" class="custom-select" onchange="list_metode(this.value)">
                            
                        </select>
                    </div>
                    <div class="form-group" id="penyedia">
                    </div>
                    <div class="form-group" id="switch-metode">
                        <label for="id_metode">Metode</label>
                        <select name="id_metode" id="id_metode" class="custom-select">
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="pagu">Pagu</label>
                        <input type="text" class="form-control currency" style="text-align: right;" id="pagu" name="pagu" onblur="if(value==''){value='0'}" value="0">
                    </div>
                    <div class="form-group">
                        <label for="pagu">ID RUP (Optional)</label>
                        <input type="text" class="form-control" id="id_rup" name="id_rup">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btnSaveMasterPaket" onclick="saveMasterPaket()">Save changes</button>
                <button type="button" class="btn btn-primary" style="display:none;" id="btnUpdateMasterPaket" onclick="updateMasterPaket()">Update Data</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Volume Paket-->
<div class="modal fade" id="modal-volume-paket" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Kelola Volume Pelaksanaan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="hidden" id="id_paket_volume">
                                <input type="hidden" id="input_type" name="input_type">
                                <input type="text" id="nama_pelaksanaan" name="nama_pelaksanaan" class="form-control">
                            </div>
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button" onclick="tambah_vol()">Tambah</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="divider"></div>
                <table id="table-vol" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th width="1%">Ke</th>
                            <th>Nama Pelaksanaan</th>
                            <th></th>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Lokasi Paket-->
<div class="modal fade" id="modal-lokasi-paket" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Kelola Lokasi Paket</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="id_provinsi"><strong>Provinsi</strong></label>
                            <div class="custom-file">
                                <input type="hidden" id="id_paket">
                                <input type="hidden" id="input_type">
                                <select name="id_provinsi" id="id_provinsi" class="form-control" style="width: 100%" onchange="list_kab_kota(this.value)">
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="id_kab_kota"><strong>Kab / Kota</strong></label>
                            <div class="custom-file">
                                <select name="id_kab_kota" id="id_kab_kota" class="form-control" style="width: 100%" onchange="list_kecamatan(this.value)">
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="id_kecamatan"><strong>Kecamatan</strong></label>
                            <div class="custom-file">
                                <select name="id_kecamatan" id="id_kecamatan" class="form-control" style="width: 100%">
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                             <button class="btn btn-primary btn-block" type="button" onclick="tambah_lokasi()">Tambah</button>
                        </div>
                    </div>
                      
                </div>
                <div class="divider"></div>
                <table id="table-lokasi" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th width="1%">No</th>
                            <th>Kab/Kota</th>
                            <th>Kecamatan</th>
                            
                            <th></th>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-export-paket" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="data-target">
                <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                 Untuk export program harus menggunakan format yang telah di tentukan <br>
                                 Silahkan download dahulu <a href="javascript:void(0)" onclick="download_format_excel_program()" target="_blank">Disini</a>
                                

                            </div>
                            <div class="form-group">
                                <form id="form-export-program" method="post" enctype="multipart/form-data" action="<?php echo base_url('paket_pekerjaan/export_paket/') ?>">
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