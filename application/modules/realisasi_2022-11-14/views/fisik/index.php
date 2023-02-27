<?php
/**
	* Author     : Alfikri, M.Kom
	* Created By : Alfikri, M.Kom
	* E-Mail     : alfikri.name@gmail.com
	* No HP      : 081277337405
*/
?>
<div class="row">
    <div class="col-md-12 col-lg-12 col-xl-12">
                            <div class="card-shadow-primary profile-responsive card-border mb-3 card">
                                <div class="dropdown-menu-header">
                                    <div class="dropdown-menu-header-inner bg-focus">
                                        <div class="menu-header-image opacity-3" style="background: #e2faff;"></div>
                                        <div class="menu-header-content btn-pane-right">
                                            <div>
                                                <h6 class="menu-header-subtitle">HELPDESK <?php echo nama_instansi() ?></h6>
                                                <h5 class="menu-header-title"><?php echo $helpdesk ?></h5>
                                            </div>
                                      
                                        </div>
                                    </div>
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="bg-warm-flame list-group-item">
                                        <div class="widget-content p-0">
                                            <div class="widget-content-wrapper">
                                                <div class="widget-content-left">
                                                    <div class="widget-heading text-dark opacity-7"><span id="timer_kunci_lrfk"></span></div>
                                                    <div class="widget-subheading opacity-10">
                                                        <b>
                                                             
                                                        </b>
                                                        
                                                        <span class="pr-2">
                                                            <b style="color:#b843f0" id="pesan_penginputan">
                                                            
                                                                
                                                            </b>
                                                        </span>
                                                    </div>
                                                </div>
                                              <!--   <div class="widget-content-right">
                                                        <div class="widget-chart-content">
                                                            <div class="widget-chart-flex">
                                                                <span class="pl-1">Persentasi Realisasi Tercapai</span>
                                                                <div class="widget-numbers text-dark">
                                                                    <span class="pull-right"><?php echo $nilai_rf ?> %</span></div>
                                                                <div class="widget-description ml-auto text-info">
                                                                    </div>
                                                            </div>
                                                        </div>
                                                </div> -->
                                            </div>
                                        </div>
                                    </li>
                                    <li class="p-0 list-group-item">
                                        <div class="widget-content">
                                                <div class="row">
                                                    <div class="col-md-6 col-xl-3">
                                                        <div class="card mb-3 widget-content bg-arielle-smile">
                                                            <div class="widget-content-wrapper text-white">
                                                                <div class="widget-content-left">
                                                                    <div class="widget-subheading"><b>Total Paket</b></div>
                                                                    <div class="widget-heading">
                                                                        Semua Paket Pekerjaan  
                                                                    </div>
                                                                </div>
                                                                <div class="widget-content-right">
                                                                    <div class="widget-numbers text-white">
                                                                        <?php echo $total_paket; ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-xl-3">
                                                        <div class="card mb-3 widget-content bg-arielle-smile">
                                                            <div class="widget-content-wrapper text-white">
                                                                <div class="widget-content-left">
                                                                    <div class="widget-subheading"><b>Total Paket</b></div>
                                                                    <div class="widget-heading">
                                                                        Rutin
                                                                    </div>
                                                                </div>
                                                                <div class="widget-content-right">
                                                                    <div class="widget-numbers text-white">
                                                                        <?php echo $total_paket_rutin; ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-xl-3">
                                                        <div class="card mb-3 widget-content bg-arielle-smile">
                                                            <div class="widget-content-wrapper text-white">
                                                                <div class="widget-content-left">
                                                                    <div class="widget-subheading"><b>Total Paket</b></div>
                                                                    <div class="widget-heading">
                                                                        Swakelola  
                                                                    </div>
                                                                </div>
                                                                <div class="widget-content-right">
                                                                    <div class="widget-numbers text-white">
                                                                        <?php echo $total_paket_swakelola; ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-xl-3">
                                                        <div class="card mb-3 widget-content bg-arielle-smile">
                                                            <div class="widget-content-wrapper text-white">
                                                                <div class="widget-content-left">
                                                                    <div class="widget-subheading"><b>Total Paket</b></div>
                                                                    <div class="widget-heading">
                                                                        Penyedia 
                                                                    </div>
                                                                </div>
                                                                <div class="widget-content-right">
                                                                    <div class="widget-numbers text-white">
                                                                        <?php echo $total_paket_penyedia; ?>
                                                                    </div>
                                                                </div>
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

<div class="mb-3 card">
    <div class="card-body">
    	<div class="row">
    		<div class="col-md-12">
                <div class="table-responsive">
    		        <table id="table-kpa" class="display" style="width:100%">
    		            <thead>
    		                <tr>
    		                    <th style="text-align: center;" width="1%"><i class="fa fa-angle-down"></i></th>
    		                    <th style="text-align: center;">Nama Sub Instansi</th>
    		                    <th style="text-align: center;">KPA</th>
    		                    <th style="text-align: center;">Jumlah PPTK</th>
    		                </tr>
    		            </thead>
    		        </table>
                </div>
		    </div>
	    </div>
    </div>
</div>