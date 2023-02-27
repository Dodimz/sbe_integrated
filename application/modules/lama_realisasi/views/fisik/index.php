<?php
/**
	* Author     : Alfikri, M.Kom
	* Created By : Alfikri, M.Kom
	* E-Mail     : alfikri.name@gmail.com
	* No HP      : 081277337405
*/
?>
<div class="row">
    <div class="col-md-6 col-lg-2">
        <div class="widget-chart widget-chart2 text-left mb-3 card-btm-border card-shadow-primary border-primary card">
            <div class="widget-chat-wrapper-outer">
                <div class="widget-chart-content">
                    <div class="widget-title opacity-5 text-uppercase">Paket Pekerjaan</div>
                    <div class="widget-numbers mt-2 fsize-4 mb-0 w-100">
                        <div class="widget-chart-flex align-items-center">
                            <div>
                                <button class="btn btn-outline-info" type="button"><?php echo $total_paket; ?> Paket</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-2">
        <div class="widget-chart widget-chart2 text-left mb-3 card-btm-border card-shadow-danger border-danger card">
            <div class="widget-chat-wrapper-outer">
                <div class="widget-chart-content">
                    <div class="widget-title opacity-5 text-uppercase">Rutin</div>
                    <div class="widget-numbers mt-2 fsize-4 mb-0 w-100">
                        <div class="widget-chart-flex align-items-center">
                            <div>
                               <button class="btn btn-outline-info" type="button"><?php echo $total_paket_rutin; ?> Paket</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-2">
        <div class="widget-chart widget-chart2 text-left mb-3 card-btm-border card-shadow-warning border-warning card">
            <div class="widget-chat-wrapper-outer">
                <div class="widget-chart-content">
                    <div class="widget-title opacity-5 text-uppercase">Swakelola</div>
                    <div class="widget-numbers mt-2 fsize-4 mb-0 w-100">
                        <div class="widget-chart-flex align-items-center">
                            <div>
                                <button class="btn btn-outline-info" type="button"><?php echo $total_paket_swakelola; ?> Paket</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-2">
        <div class="widget-chart widget-chart2 text-left mb-3 card-btm-border card-shadow-success border-success card">
            <div class="widget-chat-wrapper-outer">
                <div class="widget-chart-content">
                    <div class="widget-title opacity-5 text-uppercase">Penyedia</div>
                    <div class="widget-numbers mt-2 fsize-4 mb-0 w-100">
                        <div class="widget-chart-flex align-items-center">
                            <div>
                                <button class="btn btn-outline-info" type="button"><?php echo $total_paket_penyedia; ?> Paket</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-2">
        <div class="widget-chart widget-chart2 text-left mb-3 card-btm-border card-shadow-success border-success card">
            <div class="widget-chat-wrapper-outer">
                <div class="widget-chart-content">
                    <div class="widget-title opacity-5 text-uppercase">Deadline</div>
                    <div class="widget-numbers mt-2 fsize-4 mb-0 w-100">
                        <div class="widget-chart-flex align-items-center">
                            <div>
                                <button class="btn btn-outline-info" type="button"><?php echo $deadline ?></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>  <div class="col-md-6 col-lg-2">
        <div class="widget-chart widget-chart2 text-left mb-3 card-btm-border card-shadow-success border-success card">
            <div class="widget-chat-wrapper-outer">
                <div class="widget-chart-content">
                    <div class="widget-title opacity-5 text-uppercase">Helpdesk</div>
                    <div class="widget-numbers mt-2 fsize-4 mb-0 w-100">
                        <div class="widget-chart-flex align-items-center">
                            <div>
                                <button class="btn btn-outline-info" type="button"><?php echo $helpdesk ?></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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