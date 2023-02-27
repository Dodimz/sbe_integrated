        <div class="card-shadow-primary profile-responsive card-border mb-3 card">
            <div class="dropdown-menu-header">
                <div class="dropdown-menu-header-inner bg-info">
                    <div class="menu-header-image opacity-2" style="background-image: url('assets/images/dropdown-header/abstract1.jpg')"></div>
                    <div class="menu-header-content btn-pane-right">
                        <div class="avatar-icon-wrapper mr-2 avatar-icon-xl">
                            
                        </div>
                         <div>
                            <h5 class="menu-header-title">Synchronize Aplikasi</h5>
                            <h6 class="menu-header-subtitle">Target dan Realisasi OPD</h6>
                        </div>
                        <div class="menu-header-btn-pane">
                            <div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-content">
                <div class="tab-pane show active" id="info_21">
             
            <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <div class="widget-content">
                                <div class="row">
                                	<div class="col-md-6">
                                		<div class="form-group">
                                			
	                                		<label><b>Tahun</b></label>
			                                <select class="form-control" id="tahun" name="tahun">
							                	<?php foreach ($config->result_array() as $k => $v) { ?>
							                		<option value="<?php echo $v['tahun_anggaran'] ?>" <?php if($v['tahun_anggaran']==tahun_anggaran()){echo "selected";} ?>><?php echo $v['tahun_anggaran'] ?></option>
							                	<?php } ?>
							                </select>
                                		
                                		</div>
                                	</div>
                                	<div class="col-md-6">
                                		<div class="form-group">
	                                		<label><b>Tahapan APBD</b></label>
			                                <select class="form-control" id="tahapan_apbd" name="tahapan_apbd">
							                	<option value="2"<?php if(tahapan_apbd()==2){echo "selected";} ?>>APBD AWAL</option>
							                	<option value="4"<?php if(tahapan_apbd()==4){echo "selected";} ?>>APBD PERUBAHAN</option>
							                </select>
							            </div>
                                		
                                	</div>

                                	<div class="col-md-12" id="synchronize_all">
                                		
                                		<div class="btn-group btn-block">
							                <button class="btn btn-block btn-info btn-sm" onclick="sync_all()" id="tombol_sync_all" style="width:150px">Synchronize Semua SKPD</button>   
							            </div>
                                		
                                		
                                	</div>

                                </div>







								
				                	<br>	




                            </div>
                        </li>
                        <li class="p-0 list-group-item">
                            <div class="grid-menu grid-menu-3col">
                                <div class="no-gutters row">
                                    <div class="col-sm-4">
                                        <div class="widget-content">
                                            <div class="text-center">
                                                <h5 class="widget-heading">Selesai Synchronize</h5>
                                               <h5>
                                                    <span id="jumlah_selesai_synchronize">0</span>
                                                </h5>
                                            </div>
                                        </div>
                                    </div>
                                     <div class="col-sm-4">
                                        <div class="widget-content">
                                            <div class="text-center">
                                                <h5 class="widget-heading">Synchronize Berhasil</h5>
                                                 <h5>
                                                    <span id="jumlah_synchronize_berhasil">0</span>
                                                </h5>
                                            </div>
                                        </div>
                                    </div>
                                     <div class="col-sm-4">
                                        <div class="widget-content">
                                            <div class="text-center">
                                                <h5 class="widget-heading">Synchronize Gagal</h5>
                                                 <h5>
                                                    <span id="jumlah_synchronize_gagal">0</span>
                                                </h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        
                    </ul>
        
            </div>
        </div>
    </div>




<div class="tabs-animation">
	<div class="row">
	    <div class="col-lg-12 col-xl-12">
	        <div class="main-card mb-3 card">
	            <div class="card-body">
	                <h5 class="card-title">Target dan Realisasi</h5>

	                <table class="mb-0 table table-bordered" width="100%">
	                    <thead>
	                        <tr>
	                            <th width="1%">No</th>
	                            <th width="1%">Kode OPD</th>
	                            <th>Nama Instansi</th>
	                            <!-- <th>Mulai Realisasi</th>
	                            <th>Akhir Realisasi</th>
	                            <th>Synchronize Progress</th> -->
	                            <th>Status</th>
	                            <th>Keterangan</th>
	                            <th>Option</th>
	                        </tr>
	                    </thead>
	                    <tbody id="aliran-kas-opd">
	                    </tbody>
	                </table>
	            </div>
	        </div>
	    </div>
	</div>
</div>

