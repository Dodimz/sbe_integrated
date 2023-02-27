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
                <h5 class="modal-title" id="exampleModalLabel">Input Anggaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
               
                <form id="form_anggaran_sub_kegiatan">
                	<input type="hidden" name="pengelompokan" id="pengelompokan">
                    <input type="hidden" name="kode_sub_kegiatan" id="kode_sub_kegiatan" class="kode_sub_kegiatan">
                    <input type="hidden" name="kode_kegiatan" id="kode_kegiatan">
                    <input type="hidden" name="kode_program" id="kode_program">
                    <input type="hidden" name="kode_bidang_urusan" id="kode_bidang_urusan">
                    <input type="hidden" name="tahap" id="tahap">
                    <input type="hidden" name="tahun" id="tahun">
                        
					<div class="form-group">
                        <table class="table">
                            <tr>
                                <td>Kategori </td> 
                                <td>:</td>  
                                <td class="kategori"></td>
                            </tr>  
                            <tr>
                                <td>Kode Sub Kegiatan </td> 
                                <td>:</td>  
                                <td class="kode_sub_kegiatan"></td>
                            </tr>   
                            <tr>
                                <td>Nama Sub Kegiatan </td> 
                                <td>:</td>  
                                <td class="nama_sub_kegiatan"></td>
                            </tr>   
                        </table>
                    </div>
                    <div class="form-group">
                        <table class="table">
                            <tr>
                                <td><input type="checkbox" name="rea_bo" class="" id="rea_bo" onclick="ceklis_realisasi('rea_bo')" disabled> <b>Belanja Operasi</b></td>
                                <td><input type="checkbox" name="rea_bm" class="" id="rea_bm" onclick="ceklis_realisasi('rea_bm')" disabled> <b>Belanja Modal</b></td>
                                <td><input type="checkbox" name="rea_btt" class="" id="rea_btt" onclick="ceklis_realisasi('rea_btt')" disabled> <b>Belanja Tidak Terduga</b></td>
                                <td><input type="checkbox" name="rea_bt" class="" id="rea_bt" onclick="ceklis_realisasi('rea_bt')" disabled> <b>Belanja Transfer</b></td>
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
                                    <td class="kode_sub_kegiatan"></td>
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
                            <input type="hidden" name="tahun" id="tahun">
                        </div>
                        <table class="table tablr-striped table-bordered" id="table-target" border=1>
                            <thead>
                                <tr>
                                    <th rowspan="4" width="1%">No</th>
                                    <th rowspan="4">Bulan</th>
                                    <th colspan="6" style="text-align: center;" >
                                        Target
                                    </th>
                                  
                                </tr>
                                <tr>
                                    <th rowspan="2" colspan="2">Fisik</th>
                                    <th colspan="4">Keu</th>
                                </tr>
                                <tr>    
                                  
                                    <th colspan="2">%</th>
                                    <th colspan="2">RP</th>
                                </tr>
                                <tr>
                                    <th>Bulanan</th>
                                    <th>Akumulasi</th>
                                    <th>Bulanan</th>
                                    <th>Akumulasi</th>
                                    <th>Bulanan</th>
                                    <th>Akumulasi</th>
                                </tr>
                              

                            </thead>
                            <tbody id="target-apbd">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                
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











<!-- Modal setting ski teknis -->
<div class="modal fade" id="modal-ski_teknis" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Input Sub Kegiatan Teknis</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <form id="form-ski_teknis">

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
                              
                            </table>
                            <input type="hidden" name="kode_sub_kegiatan" id="kode_sub_kegiatan">
                            <input type="hidden" name="kode_kegiatan" id="kode_kegiatan">
                            <input type="hidden" name="kode_program" id="kode_program">
                            <input type="hidden" name="kode_bidang_urusan" id="kode_bidang_urusan">
                            <input type="hidden" name="tahap" id="tahap">
                        </div>
                           <!--  <div class="form-group">
                                <label for="anggaran">Pagu</label>
                                <input type="text" id="anggaran" name="anggaran" class="form-control currency" readonly="readonly">
                            </div> -->

                            <div class="form-group">
                                <label for="kelompok">Unit Pelaksana</label>
                                <select name="kelompok" id="kelompok" class="form-control">
                                    <option value="">--Pilih Unit Pelaksana--</option>
                                    <option value="Cabang Dinas">Cabang Dinas</option>
                                    <option value="UPTD">UPTD</option>
                                    <option value="Panti Sosial">Panti Sosial</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="keterangan">Keterangan</label>
                                <input type="text" class="form-control" id="keterangan" name="keterangan">
                            </div>
                            <div class="form-group" style="display:none">
                                <label for="kode">Kode (Optional)</label>
                                <input type="hidden" class="form-control" id="kode" name="kode">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="save_ski_teknis()">Save</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="closemodal">Close</button>
            </div>
        </div>
    </div>
</div>






<!-- Modal edit ski teknis -->
<div class="modal fade" id="modal-edit_ski_teknis" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Sub Kegiatan Teknis</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <form id="form-edit_ski_teknis">

                        <div class="form-group">
                            <table class="table">
                                <tr>
                                    <td>Kode</td>
                                    <td>:</td>
                                    <td class="kode_sub_kegiatan"></td>
                                </tr>
                                <tr>
                                    <td>Sub Kegiatan</td>
                                    <td>:</td>
                                    <td id="nama_sub_kegiatan"></td>
                                </tr>
                              
                            </table>
                            <input type="hidden" name="kode_sub_kegiatan" id="kode_sub_kegiatan">
                            <input type="hidden" name="id_sub_kegiatan_instansi" id="id_sub_kegiatan_instansi">
                        </div>
                           <!--  <div class="form-group">
                                <label for="anggaran">Pagu</label>
                                <input type="text" id="anggaran" name="anggaran" class="form-control currency" readonly="readonly">
                            </div> -->

                            <div class="form-group">
                                <label for="kelompok">Unit Pelaksana</label>
                                <select name="kelompok" id="kelompok" class="form-control kelompok">
                                    <option value="">--Pilih Unit Pelaksana--</option>
                                    <option value="Cabang Dinas">Cabang Dinas</option>
                                    <option value="UPTD">UPTD</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="keterangan">Keterangan</label>
                                <input type="text" class="form-control keterangan" id="keterangan" name="keterangan">
                            </div>
                            <div class="form-group" style="display:none">
                                <label for="kode">Kode (Optional)</label>
                                <input type="hidden" class="form-control kode" id="kode" name="kode">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="save_edit_ski_teknis()">Simpan Perubahan</button>
                <button type="button" class="btn btn-secondary closemodal" data-dismiss="modal" id="closemodal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Sumber Dana -->
<div class="modal fade" id="modal-sumber_dana" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Input Sumber Dana</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="data-target">
                <div class="row">
                    <div class="col-md-12">
                        <form id="form-sumber_dana">

                        <div class="form-group">
                            <table class="table">
                                <tr>
                                    <td>Kode</td>
                                    <td>:</td>
                                    <td class="kode_sub_kegiatan"></td>
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
                            <input type="hidden" name="tahun" id="tahun">
                            <input type="hidden" id="status" name="status">
                        </div>
                           <!--  <div class="form-group">
                                <label for="anggaran">Pagu</label>
                                <input type="text" id="anggaran" name="anggaran" class="form-control currency" readonly="readonly">
                            </div> -->

                            <div class="form-group">
                                <label for="dak">PAD</label>
                                <input type="text" class="form-control currency" id="pad" name="pad" style="text-align: right;" value="0" onblur="if(value==''){value='0'}">
                            </div>
                            <div class="form-group">
                                <label for="dau">DAU</label>
                                <input type="text" class="form-control currency" id="dau" name="dau" style="text-align: right;" value="0" onblur="if(value==''){value='0'}">
                            </div>
                            <div class="form-group">
                                <label for="dak">DAK</label>
                                <input type="text" class="form-control currency" id="dak" name="dak" style="text-align: right;" value="0" onblur="if(value==''){value='0'}">
                            </div>
                            <div class="form-group">
                                <label for="dbh">DBH</label>
                                <input type="text" class="form-control currency" id="dbh" name="dbh" style="text-align: right;" value="0" name="dbh" onblur="if(value==''){value='0'}">
                            </div>
                            <div class="form-group">
                                <label for="lainnya">Lainnya</label>
                                <input type="text" class="form-control currency" id="lainnya" style="text-align: right;" name="lainnya" value="0" onblur="if(value==''){value='0'}">
                            </div>
                            <div class="form-group" id="form_nama_sumber_dana">
                                <label for="lainnya">Nama Sumber Dana (Lainnya)</label>
                                <input type="text" class="form-control" id="nama_sumber_dana_lainnya" name="nama_sumber_dana_lainnya">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="save_sumber_dana()">Save</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Sumber Dana -->
<div class="modal fade" id="modal_laporan" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Laporan Realisasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="data-target">
                <iframe id="tampil_pdf" style="display: none;" src="" width="100%" height="600px"></iframe>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modal_laporan_semua_permasalahan" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Rekap data permasalahan sub kegiatan SKPD</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="data-target">
                <iframe id="tampil_pdf_print_permasalahan" style="display: none;" src="" width="100%" height="600px"></iframe>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>




<div class="modal fade" id="modal_input_permasalahan" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Input Permasalahan Sub Kegiatan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
               
                <form id="form_input_permasalahan">
                    <input type="hidden" name="id_permasalahan" id="id_permasalahan" class="id_permasalahan">
                    <input type="hidden" name="kode_sub_kegiatan" id="kode_sub_kegiatan" class="kode_sub_kegiatan">
                    <input type="hidden" name="kode_kegiatan" id="kode_kegiatan">
                    <input type="hidden" name="kode_program" id="kode_program">
                    <input type="hidden" name="kode_bidang_urusan" id="kode_bidang_urusan">
                    <input type="hidden" name="tahap" id="tahap">
                    <input type="hidden" name="tahun" id="tahun">
                        
                    <div class="form-group">
                        <table class="table">
                            <tr>
                                <td>Kategori </td> 
                                <td>:</td>  
                                <td class="kategori"></td>
                            </tr>  
                            <tr>
                                <td>Kode Sub Kegiatan </td> 
                                <td>:</td>  
                                <td class="kode_sub_kegiatan"></td>
                            </tr>   
                            <tr>
                                <td>Nama Sub Kegiatan </td> 
                                <td>:</td>  
                                <td class="nama_sub_kegiatan"></td>
                            </tr>   
                        </table>
                    </div>
                    <div class="form-group">
                        <label for="permasalahan"><b>Permasalahan</b> </label>
                        <textarea name="permasalahan" id="permasalahan" class="form-control" rows="10"></textarea>
                    </div>
                   
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                 <button type="button" class="btn btn-primary" id="simpanedit_permasalahan" onclick="saveedit_permasalahan_sub_kegiatan()">Simpan Perubahan</button>
                <button type="button" class="btn btn-primary" id="hapus_permasalahan" onclick="hapus_permasalahan_sub_kegiatan()">Hapus </button>
                <button type="button" class="btn btn-primary" id="simpan_permasalahan" onclick="save_permasalahan_sub_kegiatan()">Simpan</button>
                
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modal_input_solusi_permasalahan" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Input Solusi Permasalahan Sub Kegiatan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
               
                <form id="form_input_solusi_permasalahan">
                    <input type="hidden" name="id_instansi" id="id_instansi" class="id_instansi">
                    <input type="hidden" name="id_solusi" id="id_solusi" class="id_solusi">
                    <input type="hidden" name="kode_sub_kegiatan" id="kode_sub_kegiatan" class="kode_sub_kegiatan">
                    <input type="hidden" name="kode_kegiatan" id="kode_kegiatan">
                    <input type="hidden" name="kode_program" id="kode_program">
                    <input type="hidden" name="kode_bidang_urusan" id="kode_bidang_urusan">
                    <input type="hidden" name="tahap" id="tahap">
                    <input type="hidden" name="tahun" id="tahun">
                        
                    <div class="form-group">
                        <table class="table">
                            <tr>
                                <td>Kategori </td> 
                                <td>:</td>  
                                <td class="kategori"></td>
                            </tr>  
                            <tr>
                                <td>Kode Sub Kegiatan </td> 
                                <td>:</td>  
                                <td class="kode_sub_kegiatan"></td>
                            </tr>   
                            <tr>
                                <td>Nama Sub Kegiatan </td> 
                                <td>:</td>  
                                <td class="nama_sub_kegiatan"></td>
                            </tr>   
                        </table>
                    </div>
                    <div class="form-group">
                        <label for="permasalahan"><b>Permasalahan</b> </label>
                        <ol id="list_permasalahan"></ol>
                    </div>
                    <div class="form-group">
                        <label for="permasalahan"><b>Solusi</b> </label>
                        <textarea name="solusi" id="solusi" class="form-control" rows="10"></textarea>
                    </div>
                   
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="simpanedit_solusi" onclick="saveedit_solusi_permasalahan_sub_kegiatan()">Simpan Perubahan</button>
                <button type="button" class="btn btn-primary" id="hapus_solusi" onclick="hapus_solusi_permasalahan_sub_kegiatan()">Hapus</button>
                <button type="button" class="btn btn-primary" id="simpan_solusi" onclick="save_solusi_permasalahan_sub_kegiatan()">Simpan Solusi</button>
                
            </div>
        </div>
    </div>
</div>

<!-- ============================================================================================================================================= -->
<!-- khusus bagian untuk pengusulan data APBD -->


<div class="modal fade" id="modal_master_program" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        <input type="text" class="form-control" id="kode" name="kode">
                    </div>
                    <div class="form-group">
                        <label for="">Nama Program</label>
                        <input type="text" class="form-control" id="nama" name="nama">
                    </div>
                    
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="clodemodalmodal_master_program">Close</button>
                <button type="button" class="btn btn-primary" id="btnSave_master_program" onclick="save_master_program()">Save Program</button>
                <button type="button" class="btn btn-primary" id="btnUpdate_master_program" onclick="update_master_program()">Save Perubahan</button>
            </div>
        </div>
    </div>
</div>




<div class="modal fade" id="modal_master_kegiatan" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        <input type="text" class="form-control" id="kode" name="kode">
                    </div>
                    <div class="form-group">
                        <label for="">Nama kegiatan</label>
                        <input type="text" class="form-control" id="nama" name="nama">
                    </div>
                    
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="clodemodalmodal_master_kegiatan">Close</button>
                <button type="button" class="btn btn-primary" id="btnSave_master_kegiatan" onclick="save_master_kegiatan()">Save kegiatan</button>
                <button type="button" class="btn btn-primary" id="btnUpdate_master_kegiatan" onclick="update_master_kegiatan()">Save Perubahan</button>
            </div>
        </div>
    </div>
</div>



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






<div class="modal fade" id="modal_pilih_copy_sub_kegiatan" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Copy Data APBD</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="data-target">
                <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Tahun Anggaran</label>
                                 <select class="form-control" id="pilih_tahun_copy">
                                <option></option>
                                    <?php 
                                    if ($config) {
                                    foreach ($config->result_array() as $k => $v) { ?>
                                    <option value="<?php echo $v['tahun_anggaran'] ?>"><?php echo $v['tahun_anggaran'] ?></option>
                                    <?php } 
                                } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Tahapan APBD</label>
                                <select class="form-control" id="pilih_tahap_copy">
                                    <option></option>
                                    <option value="2">APBD AWAL</option>
                                    <option value="4">APBD PERUBAHAN</option>
                                </select>
                            </div>
                        </div>
                            
                            
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-secondary" onclick="lihat_data_apbd()">Lihat Data APBD</button>
            </div>
        </div>
    </div>
</div>