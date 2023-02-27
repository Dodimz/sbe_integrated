


<div class="modal fade" id="modal-pilih-skpd" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Pilih SKPD</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                 <table id="table-skpd" class="display" style="width:100%">
                    <thead>
                       <tr>
                            <th width="1%">No</th>
                            <th>Nama SKPD</th>
                            <th>Evidece Belum Validasi</th>
                            <th>Evidece Ditolak</th>
                            <th>Action</th>
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

<div class="modal fade" id="modal-identitas-paket" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Identitas Paket Pekerjaan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <b>Data APBD</b>
                         <table width="100%" class="table">
                                    <tr>
                                        <td valign="top">Kode Rekening</td>
                                        <td valign="top">:</td>
                                        <td valign="top">
                                            <span id="kode_sub_kegiatan"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign="top">Program</td>
                                        <td valign="top">:</td>
                                        <td valign="top">
                                            <span id="nama_program"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign="top">Kegiatan</td>
                                        <td valign="top">:</td>
                                         <td valign="top">
                                            <span id="nama_kegiatan"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign="top">Sub Kegiatan</td>
                                        <td valign="top">:</td>
                                         <td valign="top">
                                            <span id="nama_sub_kegiatan"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign="top">PPTK</td>
                                        <td valign="top">:</td>
                                         <td valign="top">
                                            <span id="nama_pptk"></span>
                                        </td>
                                    </tr>
                            </table>

                    </div>
                    <div class="col-md-6">
                        <b>Paket Pekerjaan</b>
                         <table width="100%" class="table">
                                <tr>
                                        <td valign="top">Nama Paket Pekerjaan</td>
                                        <td valign="top">:</td>
                                        <td valign="top">
                                            <span id="nama_paket"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign="top">Volume Pelaksanaan</td>
                                        <td valign="top">:</td>
                                        <td valign="top">
                                            <span id="volume_paket"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign="top">Evidence Di Upload</td>
                                        <td valign="top">:</td>
                                        <td valign="top">
                                            <span id="evidence_diupload"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign="top">Belum Diperiksa</td>
                                        <td valign="top">:</td>
                                        <td valign="top">
                                            <span id="belum_diperiksa"></span>
                                        </td>
                                    </tr>
                                  
                            </table>

                    </div>
                    <div class="col-md-12" style="overflow-y: scroll; height:300px">
                        <b>Evidence</b>
                         <table width="100%" class="table table-striped table-bordered" id="table_evidence_paket">
                                <thead>
                                    <tr>
                                                <th> Dokumen</th>
                                                <th width="10%">Status</th>
                                                <th width="1%">Nilai</th>
                                                <th width="10%">Action</th>
                                            </tr>
                                </thead>
                                <tbody id="data_evidence">
                                    
                                </tbody>
                            </table>
                        <div id="pesan_data_evidence"></div>

                    </div>
                </div>
                
                           
                 
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
               
            </div>
        </div>
    </div>
</div>




<div class="modal fade" id="modal-dokumen-realisasi" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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

<div class="modal fade" id="modal_all_statistika" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Laporan data statistika evidence</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <iframe id="tampil_pdf_all_statistika" style="display: none;" src="" width="100%" height="600px"></iframe>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

