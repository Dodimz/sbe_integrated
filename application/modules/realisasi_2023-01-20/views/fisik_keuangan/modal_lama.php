<?php
/**
	* Author     : Alfikri, M.Kom
	* Created By : Alfikri, M.Kom
	* E-Mail     : alfikri.name@gmail.com
	* No HP      : 081277337405
*/
?>
<!-- Modal input-->
<div class="modal fade" id="modal_input_anggaran" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
               
                <form id="form_anggaran_sub_kegiatan">
                	<input type="hidden" name="pengelompokan" id="pengelompokan">
                    <input type="hidden" name="kode_sub_kegiatan" id="kode_sub_kegiatan">
                    <input type="hidden" name="kode_kegiatan" id="kode_kegiatan">
                    <input type="hidden" name="kode_program" id="kode_program">
                    <input type="hidden" name="kode_bidang_urusan" id="kode_bidang_urusan">
                    <input type="hidden" name="tahap" id="tahap">
                
					<div class="form-group">
                        <table class="table">
                            <tr>
                                <td><b>Belanja Operasi</b></td>
                                <td><b>Belanja Modal</b></td>
                                <td><b>Belanja Tidak Terduga</b></td>
                                <td><b>Belanja Transfer</b></td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="">Belanja Pegawai</label>
                                     <input type="text" class="form-control currency" style="text-align: right;" id="bo_bp" name="bo_bp" onblur="if(value==''){value='0'}" value="0">
                                </td>
                                <td>
                                    <label for="">Belanja Modal Tanah</label>
                                     <input type="text" class="form-control currency" style="text-align: right;" id="bm_bmt" name="bm_bmt" onblur="if(value==''){value='0'}" value="0">
                                </td>
                                <td>
                                    <label for="">Belanja Tidak Terduga</label>
                                     <input type="text" class="form-control currency" style="text-align: right;" id="btt" name="btt" onblur="if(value==''){value='0'}" value="0">
                                </td>
                                 <td>
                                    <label for="">Belanja Bagi Hasil</label>
                                     <input type="text" class="form-control currency" style="text-align: right;" id="bt_bbh" name="bt_bbh" onblur="if(value==''){value='0'}" value="0">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="">Belanja Barang Jasa</label>
                                     <input type="text" class="form-control currency" style="text-align: right;" id="bo_bbj" name="bo_bbj" onblur="if(value==''){value='0'}" value="0">
                                </td>
                                <td>
                                    <label for="">Belanja Modal Peralatan Dan Mesin</label>
                                     <input type="text" class="form-control currency" style="text-align: right;" id="bm_bmpm" name="bm_bmpm" onblur="if(value==''){value='0'}" value="0">
                                </td>
                                <td></td>
                                 <td>
                                    <label for="">Belanja Bantuan Keuangan</label>
                                     <input type="text" class="form-control currency" style="text-align: right;" id="bt_bbk" name="bt_bbk" onblur="if(value==''){value='0'}" value="0">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="">Belanja Subsidi</label>
                                     <input type="text" class="form-control currency" style="text-align: right;" id="bo_bs" name="bo_bs" onblur="if(value==''){value='0'}" value="0">
                                </td>
                                <td>
                                    <label for="">Belanja Modal Gedung dan Bangunan</label>
                                     <input type="text" class="form-control currency" style="text-align: right;" id="bm_bmgb" name="bm_bmgb" onblur="if(value==''){value='0'}" value="0">
                                </td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="">Belanja Hibah</label>
                                     <input type="text" class="form-control currency" style="text-align: right;" id="bo_bh" name="bo_bh" onblur="if(value==''){value='0'}" value="0">
                                </td>
                                <td>
                                    <label for="">Belanja Modal Jalan, Jaringan, dan Irigasi</label>
                                     <input type="text" class="form-control currency" style="text-align: right;" id="bm_bmjji" name="bm_bmjji" onblur="if(value==''){value='0'}" value="0">
                                </td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <label for="">Belanja Modal dan Aset Tetap Lainnya</label>
                                     <input type="text" class="form-control currency" style="text-align: right;" id="bm_bmatl" name="bm_bmatl" onblur="if(value==''){value='0'}" value="0">
                                </td>
                                <td></td>
                                <td></td>
                            </tr>
                        </table>
                    </div>
                   
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btn_save_anggaran_sub_kegiatan" onclick="save_anggaran_sub_kegiatan()">Save changes</button>
                
            </div>
        </div>
    </div>
</div>



<!-- Modal Target Fisik dan Keuangan -->
<div class="modal fade" id="modal-target" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                            <table class="table">
                                <tr>
                                    <td>Kode</td>
                                    <td>:</td>
                                    <td id="kode_sub_kegiatan"></td>
                                </tr>
                                <tr>
                                    <td>Sub Kegiatan</td>
                                    <td>:</td>
                                    <td id="nama_sub_kegiatan"></td>
                                </tr>
                                <tr>
                                    <td>Tahapan</td>
                                    <td>:</td>
                                    <td id="nama_tahapan"></td>
                                </tr>
                                <tr>
                                    <td>Pagu</td>
                                    <td>:</td>
                                    <td id="pagu_sub_kegiatan"></td>
                                </tr>
                            </table>
                            <input type="hidden" class="form-control" id="pagu" readonly="true" value="">
                            <input type="hidden" name="kode_sub_kegiatan" id="kode_sub_kegiatan">
                            <input type="hidden" name="kode_kegiatan" id="kode_kegiatan">
                            <input type="hidden" name="kode_program" id="kode_program">
                            <input type="hidden" name="kode_bidang_urusan" id="kode_bidang_urusan">
                            <input type="hidden" name="tahap" id="tahap">
                        </div>
                        <table class="table" id="table-target">
                            <thead>
                                <tr>
                                    <th rowspan="2" width="1%">No</th>
                                    <th rowspan="2">Bulan</th>
                                    <th colspan="2" style="text-align: center;" id="td_targ">
                                        Target
                                    </th>
                                    <th rowspan="2" style="text-align: center;">Keuangan</th>
                                </tr>
                                <tr>
                                    <th width="1%">Fisik</th>
                                    <th width="1%">Keu</th>
                                </tr>
                            </thead>
                            <tbody id="target-apbd">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-info  pull-left" id="btn_copy_target_awal" onclick="copy_target_apbd_awal()">Copy Target Awal</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal EXPORT EXCEL -->


<div class="modal fade" id="modal_export_apbd_excel" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Export Data Apbd Melalui Excel</h5>
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
                                <form id="form-export-program" method="post" enctype="multipart/form-data" action="<?php echo base_url('data_apbd/export_apbd_instansi/') ?>">
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