<div class="modal fade" id="modal_grafik_skpd" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Grafik <span id="nama_skpd"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                












<div class="tabs-animation">
 <input type="hidden" class="form-control" id="id_instansi_grafik" value="">
    <div class="row">
        <div class="col-lg-12 col-xl-12">
            <div class="main-card mb-3 card">
                <div class="card-body">
                   <div id="grafik_realisasi_skpd"></div>
                <table class="table table-striped table-bordered">
                    <thead>
                        <th colspan="2"><center>Bulan / Keterangan</center></th>
                        <th>Jan</th>
                        <th>Feb</th>
                        <th>Mar</th>
                        <th>Apr</th>
                        <th>Mei</th>
                        <th>Jun</th>
                        <th>Jul</th>
                        <th>Agu</th>
                        <th>Sep</th>
                        <th>Okt</th>
                        <th>Nov</th>
                        <th>Des</th>
                    </thead>
                    <tbody>
                      
                       
                        <tr id="tfisik">
                            <td rowspan="3" align="center">Fisik</td>
                        </tr>
                        <tr id="rfisik">
                        </tr>
                        <tr id="dfisik">
                        </tr>
                          <tr id="tkeu">
                            <td rowspan="3" align="center">Keuangan</td>
                        </tr>
                        <tr id="rkeu">
                        </tr>
                        <tr id="dkeu">
                        </tr>
                    </tbody>
                </table>
                <div class="btn-group btn-block">
                       <button type="button" class="btn-icon btn-shadow btn-outline-2x btn btn-outline-primary" onclick="grafik('Akumulasi')"><i class="fa fa-plus"> </i> Grafik Akumulasi</button>
                       <button type="button" class="btn-icon btn-shadow btn-outline-2x btn btn-outline-primary"  onclick="grafik('Bulanan')"><i class="fa fa-calendar"> </i> Grafik Bulanan</button>
               
                </div>







                </div>
            </div>
        </div>
        
    </div>
</div>








            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

