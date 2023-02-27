<?php

/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 */
// var_dump($this->session->userdata());
// $id_group = $this->session->userdata('id_group');
$id_user = $this->session->userdata('íd_user');
$id_instansi = $this->session->userdata('id_intansi');

?>

<div class="row">
     <div class="col-md-12 col-lg-12">
        <?php echo $this->session->flashdata('pesan') ?>
    </div>
</div>
<div class="mb-3 card">
    <div class="card-body">
        <div class="pull-right">
            <a class="btn btn-info btn-xs" href="<?php echo base_url() ?>data_apbd/setting" data-toggle="tooltip" title="Kembali"><i class="fa fa-arrow-left"></i></a>
        </div>
                <h5 class="card-title">Data APBD Yang Diusulkan</h5>
                <div class="divider"></div>
                 <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a data-toggle="tab" href="#program" class="active nav-link" id="tombol_program">Program</a>
                    </li>
                    <li class="nav-item">
                        <a data-toggle="tab" href="#kegiatan" class="nav-link" id="tombol_kegiatan">Kegiatan</a>
                    </li>
                    <li class="nav-item">
                        <a data-toggle="tab" href="#sub_kegiatan" class="nav-link" id="tombol_sub_kegiatan">Sub Kegiatan</a>
                    </li>
                    <li class="nav-item">
                        <a data-toggle="tab" href="#cara_input" class="nav-link" >Cara Penginputan</a>
                    </li>
                </ul>
                <div class="tab-content">
                            <div class="tab-pane active" id="program" role="tabpanel">
                                <button class="btn btn-info" style="margin-bottom:20px" onclick="tambah_usulan_program()" data-toggle="tooltip" title="Upload Dokumen APBD">Usulkan Program</button> <br>
                                <div class="table-responsive tables" style="overflow-x:scroll">
                                    <table id="table-usulan-program" class="table table-bordered" style="width:100%;">
                                        <thead>
                                            <tr>
                                                <th style="width:100px" >No</th>
                                                <th>Kode Program</th>
                                                <th>Nama Program</th>
                                                <th>Status</th>
                                                <th style="width:400px" >Action</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="kegiatan" role="tabpanel">
                                <button class="btn btn-info" style="margin-bottom:20px" onclick="tambah_usulan_kegiatan()" data-toggle="tooltip" title="Upload Dokumen APBD">Usulkan Kegiatan</button> <br>
                                <div class="table-responsive tables" style="overflow-x:scroll">
                                    <table id="table-usulan-kegiatan" class="display" style="width:100%">
                                        <thead>
                                           <tr>
                                                <th width="1%">No</th>
                                                <th>Kode Kegiatan</th>
                                                <th>Nama Kegiatan</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="sub_kegiatan" role="tabpanel">
                                <button class="btn btn-info" style="margin-bottom:20px" onclick="tambah_usulan_sub_kegiatan()" data-toggle="tooltip" title="Upload Dokumen APBD">Usulkan Sub Kegiatan</button> <br>
                                <div class="table-responsive tables" style="overflow-x:scroll">
                                    <table id="table-usulan-sub-kegiatan" class="display" style="width:100%">
                                        <thead>
                                           <tr>
                                                <th width="1%">No</th>
                                                <th>Kode Sub Kegiatan</th>
                                                <th>Nama Sub Kegiatan</th>
                                                 <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="cara_input" role="tabpanel">
                                <h5>Program</h5>
                                Pada saat penginputan usulan program pengisian kode program terdiri dari 3 digit  <br>
                                digit yang dimaksud adalah karakter yang dipisahkan dengan tanda titik (.) <br>
                                Contohnya : 1.01.01 <br>
                                Apabila pada saat penginputan kode program tidak sesuai dengan contoh diatas maka sistem menolak untuk menyimpan data usulan program
                                <hr>
                                <h5>Kegiatan</h5>
                                Pada saat penginputan usulan kegiatan pengisian kode kegiatan terdiri dari 5 digit  <br>
                                digit yang dimaksud adalah karakter yang dipisahkan dengan tanda titik (.) <br>
                                Contohnya : 1.01.01.1.01 <br>
                                Apabila pada saat penginputan kode kegiatan tidak sesuai dengan contoh diatas maka sistem menolak untuk menyimpan data usulan kegiatan
                                <hr>
                                <h5> Sub Kegiatan</h5>
                                Pada saat penginputan usulan sub kegiatan pengisian kode sub kegiatan terdiri dari 6 digit  <br>
                                digit yang dimaksud adalah karakter yang dipisahkan dengan tanda titik (.) <br>
                                Contohnya : 1.01.01.1.01.03 <br>
                                Apabila pada saat penginputan kode sub kegiatan tidak sesuai dengan contoh diatas maka sistem menolak untuk menyimpan data usulan sub kegiatan
                                <hr>
                            </div>
                        </div>



        </div>
    </div>
</div>

