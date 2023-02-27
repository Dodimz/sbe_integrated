<?php
$id_group = $this->session->userdata('id_group');
?>


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
                            <th>Helpdesk</th>
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


<div class="modal fade" id="modal-ganti-tahun" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ganti tahun anggaran validasi evidence</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id_instansi_ganti_tahun"  id="id_instansi_ganti_tahun">
                <label>Pilih Tahun Anggaran</label>
                <select class="form-control" name="tahun_anggaran_update" id="tahun_anggaran_update">
                    <?php foreach ($config as $k => $v) { ?>
                        <option value="<?php echo $v['tahun_anggaran'] ?>" <?php if(tahun_anggaran()==$v['tahun_anggaran']){echo "selected";} ?>><?php echo $v['tahun_anggaran'] ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-info" onclick="simpan_ganti_tahun_anggaran()">Ganti Tahun Anggaran</button>
               
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
                                        <td valign="top">Tahun</td>
                                        <td valign="top">:</td>
                                        <td valign="top">
                                            <span id="tahun"></span>
                                        </td>
                                    </tr>
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
                                        <td valign="top">Jenis Paket</td>
                                        <td valign="top">:</td>
                                        <td valign="top">
                                            <span id="jenis_paket"></span>
                                        </td>
                                    </tr>
                                <tr>
                                        <td valign="top">Metode</td>
                                        <td valign="top">:</td>
                                        <td valign="top">
                                            <span id="metode"></span>
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
                                                <?php if ($id_group!=5) { ?>
                                                <th width="10%"> Waktu Upload</th>
                                                <?php } ?>
                                                <th width="10%">Status</th>
                                                <th>Keterangan</th>
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
                <input type="hidden" id="tahun" name="tahun">
                <!-- <div class="file-pdf">
                    <embed src="" type="application/pdf" width="100%" height="500px"/>
                </div> -->
                <div class="file-pdf">
                    <iframe src="" frameborder="0" width="100%" height="500px"></iframe>
                </div>
                <?php if ($this->session->userdata('group_name') == 'HELPDESK' || $this->session->userdata('group_name') == 'ADMIN') { 
                    if (jadwal_validasi()['aktif']==1) { ?>
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
                    <?php }else{ ?>
                         <div class="form-group">
                            <div class="alert alert-danger">
                                <?php echo jadwal_validasi()['pesan'] ?>
                            </div>
                        </div>
                       
                    <?php } ?>
                <?php } ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="close_evidence">Close</button>
                <?php if ($this->session->userdata('group_name') == 'HELPDESK' ||$this->session->userdata('group_name') == 'ADMIN') { 
                    if (jadwal_validasi()['aktif']==1) { ?>
                    <button type="button" class="btn btn-primary" id="btn-update-nilai" onclick="update_nilai()">OK</button>
                <?php }else{ ?>
                     <button type="button" class="btn btn-primary" id="btn-update-nilai" onclick="Swal.fire('Error','<?php echo jadwal_validasi()['pesan'] ?>','error')">OK</button>
                <?php } 
                }?>
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
                <div class="row">
                  

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="bulan"><strong>Bulan Awal</strong></label>
                            <select name="bulan_awal" id="bulan_awal" class="form-control">
                                <?php 
                                $bulan_akhir = bulan_aktif();
                                for ($i = 1; $i <= $bulan_akhir; $i++) : ?>
                                    <option value="<?= $i; ?>" <?php if($i==1){echo "selected";} ?>><?= bulan_global($i); ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="bulan_akhir"><strong>Bulan Akhir</strong></label>
                            <select name="bulan_akhir" id="bulan_akhir" class="form-control">
                                <?php for ($i = 1; $i <= $bulan_akhir; $i++) : ?>
                                    <option value="<?= $i; ?>" <?php if($i==$bulan_akhir){echo "selected";} ?>><?= bulan_global($i); ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="tahun"><strong>Tahun</strong></label>
                            <select name="tahun" id="tahun" class="form-control">
                                <?php foreach($config as $k =>$v) { ?>
                                    <option value="<?= $v['tahun_anggaran']; ?>" <?php if($v['tahun_anggaran']==tahun_anggaran()){echo "selected";} ?>><?= $v['tahun_anggaran']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <button class="btn btn-block btn-info" onclick="show_all_statistika()">Searching</button>
                        </div>
                    </div>
                </div>
                <iframe id="tampil_pdf_all_statistika" style="display: none;" src="" width="100%" height="600px"></iframe>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

