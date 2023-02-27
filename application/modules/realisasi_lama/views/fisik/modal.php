<?php
/**
	* Author     : Alfikri, M.Kom
	* Created By : Alfikri, M.Kom
	* E-Mail     : alfikri.name@gmail.com
	* No HP      : 081277337405
*/
?>
<!-- Modal Upload Dokumen Realisasi Fisik-->
<div class="modal fade" id="modal-upload-dokumen" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="progress" id="bar" style="margin-bottom: 10px;display: none;">
                    <div id="progress" class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                        <span class="sr-only">0%</span>
                    </div>
                </div>
                <form id="form-upload-dokumen">
                	
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Daftar Dokumen Realisasi Fisik-->
<div class="modal fade" id="modal-daftar-dokumen" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive" id="show-dokumen">
                    <div id="caption-daftar-dokumen"></div>

                    <table class="table" id="table-list-evidence" >
                        <thead>
                            <th width="1%">No</th>
                            <th width="1%">Dokumen</th>
                            <th>File</th>
                            <th width="10%">Validasi</th>
                        </thead>
                        <tbody id="daftar-dokumen-fisik">
                            
                        </tbody>
                        <tfoot id="total-nilai-fisik">
                            
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="warning_hapus_evidence" id-paket="" nama-paket="">Hapus Evidence</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="close_modal_daftar_dokumen">Close</button>
            </div>
        </div>
    </div>
</div>




<!-- Modal warning hapus Realisasi Fisik-->
<div class="modal fade" id="modal-hapus-evidence" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Hapus Evidence</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
               <div id="peringatan-hapus"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="hapus_evidence" id-paket="">Hapus</button>
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
                <h5 class="modal-title" id="nama_paket_lokasi">Kelola Lokasi Paket</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                
                <div class="divider"></div>
                <table id="table-lokasi" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th width="1%">No</th>
                            <th>Kab/Kota</th>
                            <th>Kecamatan</th>
                            
                          
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