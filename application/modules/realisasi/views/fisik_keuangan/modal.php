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
                                    <td>SKPD</td>
                                    <td>:</td>
                                    <td id="td_nama_instansi"></td>
                                </tr>
                               
                                <tr>
                                    <td>Tahapan</td>
                                    <td>:</td>
                                    <td id="nama_tahapan"></td>
                                </tr>
                               
                                <tr>
                                    <td>Pagu Jenis Belanja <span class="nama_jenis_belanja"></span></td>
                                    <td>:</td>
                                    <td id="pagu_jenis_belanja"></td>
                                </tr>
                                <tr>
                                    <td>Pagu Total</td>
                                    <td>:</td>
                                    <td id="pagu_total"></td>
                                </tr>
                            </table>
                            <input type="hidden" class="form-control" id="pagu" readonly="true" value="">
                            
                        </div>
                        <div id="info_target"></div>
                        <div style="overflow-x:scroll">
                            
                        <table class="table table-striped table-bordered" id="table-realisasi-keuangan" >
                            <thead>
                                <tr>
                                    <th rowspan="3" width="1%">No</th>
                                    <th rowspan="3">Bulan</th>
                                    <th colspan="1" style="text-align: center;" id="jenis_belanja">Realisasi Keuangan <span class="nama_jenis_belanja"></span></th>
                                    <th rowspan="2" style="text-align: center;" >Realisasi Fisik <span class="nama_jenis_belanja"></span></th>
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
            </div>
            <div class="modal-footer">
               
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-realisasi-lra" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Input LRA</h5>
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
                                    <td>SKPD</td>
                                    <td>:</td>
                                    <td id="td_nama_instansi"></td>
                                </tr>
                               
                                <tr>
                                    <td>Tahapan</td>
                                    <td>:</td>
                                    <td id="nama_tahapan"></td>
                                </tr>
                               
                                <tr>
                                    <td>Pagu Jenis Belanja <span class="nama_jenis_belanja"></span></td>
                                    <td>:</td>
                                    <td id="pagu_jenis_belanja"></td>
                                </tr>
                                <tr>
                                    <td>Pagu Total</td>
                                    <td>:</td>
                                    <td id="pagu_total"></td>
                                </tr>
                            </table>
                            <input type="hidden" class="form-control" id="pagu" readonly="true" value="">
                            
                        </div>
                        <div id="info_target"></div>
                        <div style="overflow-x:scroll">
                            
                        <table class="table table-striped table-bordered" id="table-realisasi-keuangan" >
                            <thead>
                                <tr>
                                    <th rowspan="3" width="1%">No</th>
                                    <th rowspan="3">Bulan</th>
                                    <th colspan="1" style="text-align: center;" id="jenis_belanja">Realisasi LRA <span class="nama_jenis_belanja"></span></th>
                                   
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
            </div>
            <div class="modal-footer">
               
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                
            </div>
        </div>
    </div>
</div>