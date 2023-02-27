<?php
/**
	* Author     : Alfikri, M.Kom
	* Created By : Alfikri, M.Kom
	* E-Mail     : alfikri.name@gmail.com
	* No HP      : 081277337405
*/

?>
<div class="tabs-animation">
	<div class="row">
	    <div class="col-lg-12 col-xl-12">
	        <div class="main-card mb-3 card">
	            <div class="card-body">
	                <h5 class="card-title">Target dan Realisasi</h5>
	                <table class="mb-0 table table-bordered">
	                    <thead>
	                        <tr>
	                            <th width="1%" rowspan="3">No</th>
	                            <th width="1%" rowspan="3">Kode OPD</th>
	                            <th rowspan="3">Nama Instansi</th>
	                            <th rowspan="3">Mulai Realisasi</th>
	                            <th rowspan="3">Akhir Realisasi</th>
	                            <th rowspan="3">Status</th>
	                            <th width="1%" rowspan="3"><button class="btn btn-info btn-sm" onclick="sync_all()" id="tombol_sync_all" style="width:150px">Synchronize <br> Semua SKPD</button></th>
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

<?php echo $extra_js2 ?>