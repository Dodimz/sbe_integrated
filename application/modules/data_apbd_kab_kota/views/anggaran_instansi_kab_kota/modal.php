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



<div class="modal fade" id="modal_input_anggaran" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Input Anggaran <br><span class="instansi"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
               
                <form id="form_anggaran_sub_kegiatan">
                    <input type="hidden" name="id_instansi" id="id_instansi">

                    <input type="hidden" name="tahap" id="tahap">
                        
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
                            <tr >
                                <td>
                                    <label for="">Belanja Bantuan Sosial</label>
                                     <input type="text" class="form-control currency" style="text-align: right;" id="bo_bbs" name="bo_bbs" onblur="if(value==''){value='0'}" value="0">
                                </td>
                                <td>
                                    <label for="">Belanja Modal Aset Tak Berwujud</label>
                                     <input type="text" class="form-control currency" style="text-align: right;" id="bm_bmatb" name="bm_bmatb" onblur="if(value==''){value='0'}" value="0">
                                </td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr >
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
                <button type="button" class="btn btn-primary" id="btn_save_anggaran_sub_kegiatan" onclick="save_anggaran_instansi_kab_kota()">Save changes</button>
                
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
                                    <td>SKPD</td>
                                    <td>:</td>
                                    <td class="nama_instansi"></td>
                                </tr>
                              
                                <tr>
                                    <td>Tahapan</td>
                                    <td>:</td>
                                    <td id="nama_tahapan"></td>
                                </tr>
                                <tr>
                                    <td>Pagu</td>
                                    <td>:</td>
                                    <td class="pagu"></td>
                                </tr>
                            </table>
                            <input type="hidden" class="form-control" id="pagu" readonly="true" value="">
                            <input type="hidden" name="id_instansi" id="id_instansi">
                            <input type="hidden" name="id_kota" id="id_kota">
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