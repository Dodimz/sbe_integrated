<?php

/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 */
?>
<!-- Modal Realisasi Keuangan -->
<div class="modal fade" id="modal-realisasi-keuangan" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Input Realisasi Keuangan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                       
                        <div class="form-group">
                            <table class="table">
                                <tr>
                                    <td>Kode</td>
                                    <td>:</td>
                                    <td id="td_kode_sub_kegiatan"></td>
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
                        </div>
                        <div id="info_target"></div>
                        <table class="table table-striped table-bordered" id="table-realisasi-keuangan" >
                            <thead>
                                <tr>
                                    <th rowspan="3" width="1%">No</th>
                                    <th rowspan="3">Bulan</th>
                                    <th colspan="1" style="text-align: center;" id="jenis_belanja"></th>
                                </tr>
                              
                                <tr id="rincian_jenis_belanja">
                                </tr>
                            </thead>
                            <tbody id="data-realisasi-keuangan">

                            </tbody>
                            <tbody>
                                <tr id="total_realisasi">
                                    
                                </tr>

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