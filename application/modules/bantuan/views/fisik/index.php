<?php
/**
	* Author     : Alfikri, M.Kom
	* Created By : Alfikri, M.Kom
	* E-Mail     : alfikri.name@gmail.com
	* No HP      : 081277337405
*/
?>
<div class="row">
    <div class="col-md-3 col-lg-3">
        <div class="widget-chart widget-chart2 text-left mb-3 card-btm-border card-shadow-primary border-primary card">
            <div class="widget-chat-wrapper-outer">
                <div class="widget-chart-content">
                    <div class="widget-title opacity-5 text-uppercase">Paket Pekerjaan</div>
                    <div class="widget-numbers mt-2 fsize-4 mb-0 w-100">
                        <div class="widget-chart-flex align-items-center">
                            <div>
                                <span class="opacity-10 text-success pr-2">
                                    <i class="fa fa-angle-up"></i>
                                </span>
                                <?php echo $total_paket; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-lg-3">
        <div class="widget-chart widget-chart2 text-left mb-3 card-btm-border card-shadow-danger border-danger card">
            <div class="widget-chat-wrapper-outer">
                <div class="widget-chart-content">
                    <div class="widget-title opacity-5 text-uppercase">Paket Rutin</div>
                    <div class="widget-numbers mt-2 fsize-4 mb-0 w-100">
                        <div class="widget-chart-flex align-items-center">
                            <div>
                                <span class="opacity-10 text-danger pr-2">
                                    <i class="fa fa-angle-down"></i>
                                </span>
                                <?php echo $total_paket_rutin; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-lg-3">
        <div class="widget-chart widget-chart2 text-left mb-3 card-btm-border card-shadow-danger border-danger card">
            <div class="widget-chat-wrapper-outer">
                <div class="widget-chart-content">
                    <div class="widget-title opacity-5 text-uppercase">Paket Swakelola</div>
                    <div class="widget-numbers mt-2 fsize-4 mb-0 w-100">
                        <div class="widget-chart-flex align-items-center">
                            <div>
                                <span class="opacity-10 text-danger pr-2">
                                    <i class="fa fa-angle-down"></i>
                                </span>
                                <?php echo $total_paket_swakelola; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-lg-3">
        <div class="widget-chart widget-chart2 text-left mb-3 card-btm-border card-shadow-warning border-warning card">
            <div class="widget-chat-wrapper-outer">
                <div class="widget-chart-content">
                    <div class="widget-title opacity-5 text-uppercase">Paket Penyedia</div>
                    <div class="widget-numbers mt-2 fsize-4 mb-0 w-100">
                        <div class="widget-chart-flex align-items-center">
                            <div>
                                <span class="opacity-10 text-danger pr-2">
                                	<i class="fa fa-angle-down"></i>
                                </span>
                                <?php echo $total_paket_penyedia; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4 col-lg-4">
        <div class="main-card mb-3 card">
            <div class="scroll-area-lg">
                <div class="scrollbar-container ps--active-y">
                    <ul class="list-group list-group-flush" id="list-instansi">
                        
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8 col-md-8">
        <div class="main-card mb-3 card">
            <div class="card-body">
                <h5 class="card-title">Paket Pekerjaan</h5>
                <div class="divider"></div>
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a data-toggle="tab" href="#tab-eg10-1" class="active nav-link">Swakelola <span id="badge-swakelola"></span></a>
                    </li>
                    <li class="nav-item">
                        <a data-toggle="tab" href="#tab-eg10-2" class="nav-link">Penyedia <span id="badge-penyedia"></span></a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab-eg10-1" role="tabpanel">
                        <div class="table-responsive tables">
                            <table id="table-paket-swakelola" class="display" style="width:100%;">
                                <thead>
                                    <tr>
                                        <th width="1%">No</th>
                                        <th>Nama Paket</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab-eg10-2" role="tabpanel">
                        <div class="table-responsive tables">
                            <table id="table-paket-penyedia" class="display" style="width:100%">
                                <thead>
                                    <tr>
                                        <th width="1%">No</th>
                                        <th>Nama Paket</th>
                                        <th></th>
                                        <th></th>
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