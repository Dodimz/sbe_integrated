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
                <div id="pesan_upload"></div>
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
                <div class="table-responsive" id="show-dokumen" style="height:400px; overflow-y: scroll">
                    <div id="caption-daftar-dokumen"></div>

                    <table class="table table-striped" id="table-list-evidence" >
                        <thead>
                            <th width="1%">No</th>
                            <th >Dokumen</th>
                            <th >Status</th>
                            <th >Nilai</th>
                            <th width="15%"><center>Option</center></th>
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




<div class="modal fade" id="modal-lihat-evidence" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="id_paket_pekerjaan" name="id_paket_pekerjaan">
                <input type="hidden" id="id_realisasi_fisik" name="id_realisasi_fisik">
                <input type="hidden" id="jenis_paket" name="jenis_paket">
                <input type="hidden" id="id_metode" name="id_metode">
                <input type="hidden" id="dokumen" name="dokumen">
                <input type="hidden" id="nilai_pelaksanaan" name="nilai_pelaksanaan">
                <!-- <div class="file-pdf">
                    <embed src="" type="application/pdf" width="100%" height="500px"/>
                </div> -->
                <div class="file-pdf">
                    <iframe src="" frameborder="0" width="100%" height="500px"></iframe>
                </div>
                <?php if ($this->session->userdata('group_name') == 'HELPDESK' || $this->session->userdata('group_name') == 'ADMIN') : ?>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" id="status" name="status" onchange="form_keterangan(this.value)" class="form-control">
                            <option value="Pilih Status">Pilih Status</option>
                            <option value="Sudah Validasi">Approve</option>
                            <option value="Ditolak">Reject</option>
                        </select>
                    </div>
                    <div id="form-keterangan">

                    </div>
                <?php endif; ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="close_evidence">Close</button>
                <?php if ($this->session->userdata('group_name') == 'HELPDESK' ||$this->session->userdata('group_name') == 'ADMIN') : ?>
                    <button type="button" class="btn btn-primary" id="btn-update-nilai" onclick="update_nilai()">OK</button>
                <?php endif; ?>
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