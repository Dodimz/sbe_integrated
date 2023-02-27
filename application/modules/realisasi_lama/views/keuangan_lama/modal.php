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
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Pagu</label>
                            <input type="text" class="form-control" id="pagu" readonly="true" value="">
                        </div>
                        <table class="table" id="table-realisasi-keuangan">
                            <thead>
                                <tr>
                                    <th rowspan="2" width="1%">No</th>
                                    <th rowspan="2">Bulan</th>
                                    <th colspan="4" style="text-align: center;">Belanja</th>
                                </tr>
                                <tr>
                                    <th width="1%">Pegawai</th>
                                    <th width="1%">Barang_Jasa</th>
                                    <th width="1%">Modal</th>
                                    <th width="1%">Total</th>
                                </tr>
                            </thead>
                            <tbody id="data-realisasi-keuangan">

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