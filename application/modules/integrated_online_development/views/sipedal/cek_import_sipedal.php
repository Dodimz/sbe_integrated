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
                            </div>                </div>
                        <div class="app-inner-layout__wrapper">
                            <div class="app-inner-layout__content card">
								<div class="mb-3 card">
									<div class="card-body">
										<h5 class="card-title">Data Paket Telah di Dimporkan</h5>
												<table class="table" id="datatable_1">
													<thead>	
														<tr>	
															<th>No</th>
															<th>Nama Paket</th>
															<th>Jenis Paket</th>
															<th>Metode</th>
															<th>Lokasi </th>
															<th>Volume </th>
															<th>Pagu </th>
															<th>Ditambahkan Pada </th>
														</tr>
													</thead>
													<tbody>	
														<?php 
														$no=1;foreach ($data_paket_import as $k => $v) { ?>
															<tr>	
																<td><?php echo $no++ ?></td>
																<td><?php echo $v['nama_paket'] ?></td>
																<td><?php echo $v['jenis_paket'] ?></td>
																<td><?php echo $v['metode'] ?></td>
																
															</tr>
														<?php } ?>
													</tbody>
												</table>
									</div>
								</div>
                            </div>
                            <div class="app-inner-layout__sidebar card">
                                <ul class="nav flex-column">
                                    
                                    <li class="nav-item-header nav-item">Statistik</li>
                                    <li class="nav-item"><a href="javascript:void(0);" class="nav-link"><i class="nav-link-icon pe-7s-wallet"> </i><span>Data Sipedal Import ke SBE</span></a></li>
                                    <li class="nav-item"><a href="javascript:void(0);" class="nav-link"><i class="nav-link-icon pe-7s-chat"> </i><span>Jumlah data di Sipedal</span>
                                        <div class="ml-auto badge badge-info"><?php echo $jumlah_data_sipedal ?></div>
                                    </a></li>
                                    <li class="nav-item"><a href="javascript:void(0);" class="nav-link"><i class="nav-link-icon pe-7s-config"> </i><span>Jumlah Paket Keseluruhan <br>Integrasi Dan Manual</span>
                                        <div class="ml-auto badge badge-success">New</div>
                                    </a></li>
                                    <li class="nav-item-divider nav-item"></li>
                                    <li class="nav-item"><a href="javascript:void(0);" class="nav-link"><i class="nav-link-icon pe-7s-box2"> </i><span>Sub Kegiatan Paket Import Diperbaharui</span></a></li>
                                    <li class="nav-item"><a href="javascript:void(0);" class="nav-link"><i class="nav-link-icon pe-7s-coffee"> </i><span>Others</span>
                                        <div class="ml-auto badge badge-warning">512</div>
                                    </a></li>
                                    <li class="nav-item-divider nav-item"></li>
                             
                                 
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>






   <script type="text/javascript">
// $(document).ready( function () {
//     $('#datatable_1').DataTable();
// } );
   </script>

   