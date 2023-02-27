<?php
/**
	* Author     : Alfikri, M.Kom
	* Created By : Alfikri, M.Kom
	* E-Mail     : alfikri.name@gmail.com
	* No HP      : 081277337405
*/
?>
<div class="row">
    <div class="col-md-12 col-lg-12">
        <?php echo $this->session->flashdata('pesan'); ?>
        <div class="main-card mb-3 card">
            <div class="card-body">
                <div class="notifikasi"></div>
                <button type="button" class="btn btn-primary" id="addMasterUser" onclick="add_master_sub_kegiatan()">Tambah Sub Kegiatan</button>
                <button type="button" class="btn btn-primary" id="addMasterUser" onclick="export_master_sub_kegiatan()">Import Data</button>
                <hr>
                <table id="table-master-sub_kegiatan" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th style="width:1%">No</th>
							<th>Kode Sub Kegiatan</th>

							<th>Nama Sub Kegiatan</th>
                            <th>Ditambahkan Oleh</th>
                            <th>Pemaketan</th>
                            <th>Status</th>
                            <th>Action</th>
                         
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
