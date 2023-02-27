<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.13.1/datatables.min.css"/>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.13.1/datatables.min.js"></script>

		<div class="app-main__inner p-0">
                    <div class="app-inner-layout">
                        <div class="app-inner-layout__header bg-heavy-rain">
                            <div class="app-page-title">
                                <div class="page-title-wrapper">
                                    <div class="page-title-heading">
                                    	 <div class="widget-content-left">
                                                    <div class="widget-heading text-dark opacity-7">
														<h6 class="menu-header-subtitle" id="nama_skpd">Cek Import Aplikasi Sipedal - Simbangda</h6>
														<h5 class="menu-header-title" id="nama_helpdesk"><?php echo $nama_instansi ?></h5>
                                                    </div>
                                                    <div class="widget-subheading opacity-10">
                                                            <b>
                                                               Tahun : <?php echo $tahun ?>                                                          
                                                            </b>
                                                    </div>
                                                </div>
                                    </div>
                                    </div>
                            </div>                
                        </div>
                        <?php echo $this->session->flashdata('pesan') ?>
                        <div class="app-inner-layout__wrapper">
                            <div class="app-inner-layout__content card">
								<div class="mb-3 card">
									<div class="card-body">
                                        <div style="overflow-x: scroll">
                                            
										<h5 class="card-title">Data Paket Telah di Dimporkan</h5>
                                      			<table class="table" id="list_paket_import_sipedal">
													<thead>	
														<tr>	
															<th>No</th>
															<th>Sub Kegiatan</th>
                                                            <th>Nama Paket</th>
															<th>Jenis Paket</th>
                                                            <th>Kategori</th>
															<th>Metode</th>
															<th>Lokasi </th>
                                                            <th>Pagu </th>
														</tr>
													</thead>
													
												</table>

                                        <a href="<?php echo base_url() ?>integrasi_aplikasi/preview_import_dan_auto_evidence?id_opd=<?php echo $id_opd ?>&tahun=<?php echo $tahun ?>" class="btn btn-info">Preview (Auto Evidence diletakan setelah tombol ini di klik)</a>
                                        <br><br>
                                        </div>
									</div>
								</div>
                            </div>
                            <div class="app-inner-layout__sidebar card">
                                <ul class="nav flex-column">
                                    
                                    <li class="nav-item-header nav-item">Statistik</li>
                                    <li class="nav-item"><a href="javascript:void(0);" class="nav-link"><i class="nav-link-icon pe-7s-wallet"> </i><span>Data Sipedal Import ke SBE</span>
                                     <div class="ml-auto badge badge-info"><?php echo $jumlah_import_data_sipedal ?></div></a></li>
                                    <li class="nav-item"><a href="javascript:void(0);" class="nav-link"><i class="nav-link-icon pe-7s-chat"> </i><span>Jumlah data di Sipedal</span>
                                        <div class="ml-auto badge badge-info"><?php echo $jumlah_data_sipedal ?></div>
                                    </a></li>
                                    <li class="nav-item"><a href="javascript:void(0);" class="nav-link"><i class="nav-link-icon pe-7s-config"> </i><span>Jumlah Paket Keseluruhan <br>Integrasi Dan Manual</span>
                                        <div class="ml-auto badge badge-success"><?php echo $jumlah_data_paket ?></div>
                                    </a></li>
                                    <li class="nav-item-divider nav-item"></li>
                                    <?php if ($lokasi_mentah>0) { ?>
                                        <li class="nav-item" id="tombol_sinkron_lokasi"><a href="javascript:void(0);" class="nav-link" onclick="sinkron_lokasi_import_sipedal()"><i class="nav-link-icon pe-7s-box2"> </i><span>Sinkronisasi Lokasi</span></a></li>
                                    <?php } ?>
                                    <li class="nav-item"><a href="javascript:void(0);" class="nav-link"><i class="nav-link-icon pe-7s-coffee"> </i><span>Others</span>
                                        <div class="ml-auto badge badge-warning">512</div>
                                    </a></li>
                                    <li class="nav-item-divider nav-item"></li>
                             
                                 
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>


