<?php 

$id_group = $this->session->userdata('id_group');
if ($id_group==0 || $id_group==2 || $id_group==4) { ?>

<div class="mb-3 card">
    <div class="card-body">
        <div class="row">
            
                    <div class="card-body">
                        <h5 class="card-title">Paket Pekerjaan</h5>
                        <h5 class="card-title" id="nama_skpd"></h5>
                        <div class="divider"></div>
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a data-toggle="tab" href="#tab-eg10-1" class="active nav-link">SKPD Provinsi</a>
                            </li>
                            <li class="nav-item">
                                <a data-toggle="tab" href="#tab-eg10-2" class="nav-link">Kab Kota</a>
                            </li>
                      
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab-eg10-1" role="tabpanel">
                                <div class="table-responsive tables" style="overflow-x:scroll">
                                     <table id="table-bantuan" class="display" style="width:100%">
                                        <thead>
                                            <tr>
                                      
                                                <th style="text-align: center;">No</th>
                                                <th style="text-align: center;">Kode Ticket</th>
                                                <th style="text-align: center;">Pelapor</th>
                                                <th style="text-align: center;">SKPD</th>
                                                <th style="text-align: center;">Menu</th>
                                                <th style="text-align: center;">Masalah</th>
                                                <th style="text-align: center;">Waktu Report</th>
                                                <th style="text-align: center;">Status</th>
                                                <th style="text-align: center;">Action</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab-eg10-2" role="tabpanel">
                                <div class="table-responsive tables" style="overflow-x:scroll">
                                     <table id="table-bantuan_kab_kota" class="display" style="width:100%">
                                        <thead>
                                            <tr>
                                      
                                                <th style="text-align: center;">No</th>
                                                <th style="text-align: center;">Kode Ticket</th>
                                                <th style="text-align: center;">Pelapor</th>
                                                <th style="text-align: center;">Kabupaten / Kota</th>
                                                <th style="text-align: center;">Menu</th>
                                                <th style="text-align: center;">Masalah</th>
                                                <th style="text-align: center;">Waktu Report</th>
                                                <th style="text-align: center;">Status</th>
                                                <th style="text-align: center;">Action</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                            
                        </div>
                    </div>
               
        </div>
    </div>
</div>

     
<?php  }else{  ?>


<div class="mb-3 card">
    <div class="card-body">
    	<div class="row">
            
            <?php 
            $id_tabel = $id_group==5 ? 'table-bantuan' : 'table-bantuan_kab_kota';
            if ($id_group=='5' || $id_group=='7'): ?>
                
                <div class="col-md-12">
                    <button class="btn btn-info" onclick="tambah_bantuan()">Minta Bantuan Baru</button>
                <br> <br>
            <?php endif ?>
            </div>
    		<div class="col-md-12">
                <div class="table-responsive">
    		        <table id="<?php echo $id_tabel ?>" class="display" style="width:100%">
    		            <thead>
    		                <tr>
    		          
                                <th style="text-align: center;">No</th>
                                <th style="text-align: center;">Kode Ticket</th>
    		                    <th style="text-align: center;">Pelapor</th>
                                <th style="text-align: center;"><?php echo $id_group==5 ? "SKPD" : "KAB/Kota" ?></th>
    		                    <th style="text-align: center;">Menu</th>
                                <th style="text-align: center;">Masalah</th>
                                <th style="text-align: center;">Waktu Report</th>
                                <th style="text-align: center;">Status</th>
    		                    <th style="text-align: center;">Action</th>
    		                </tr>
    		            </thead>
    		        </table>
                </div>
		    </div>
	    </div>
    </div>
</div>

<?php } ?>



