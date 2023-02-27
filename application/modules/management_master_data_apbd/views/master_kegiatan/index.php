
<div class="row">
    <div class="col-md-12 col-lg-12">
        <div class="main-card mb-3 card">
            <div class="card-body">
                <div class="notifikasi"></div>
                <button type="button" class="btn btn-primary" id="addMasterUser" onclick="add_master_kegiatan()">Tambah Kegiatan</button>
                <button type="button" class="btn btn-primary" id="addMasterUser" onclick="export_master_kegiatan()">Import Data</button>
                <hr>
                <?php echo $this->session->flashdata('pesan'); ?>
                <table id="table-master-kegiatan" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th style="width:1%">No</th>
							<th>Kode kegiatan</th>

							<th>Nama kegiatan</th>
                            <th>Ditambahkan Oleh</th>
                            <th>Action</th>
                         
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>







