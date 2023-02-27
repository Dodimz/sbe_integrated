<?php
/**
	* Author     : Alfikri, M.Kom
	* Created By : Alfikri, M.Kom
	* E-Mail     : alfikri.name@gmail.com
	* No HP      : 081277337405
*/
?>
<div class="mb-3 card">
    <div class="card-body">
        <button class="btn btn-info btn-sm">Tambah Program</button>



        <button class="btn btn-info btn-sm" onclick="export_program()">Export</button>





        <!-- <button class="btn btn-info btn-sm">Kunci Export (jika sudah ada export(hilangkan tombol export)) </button> -->
        <hr>
        <div class="table-responsive">
            <table id="table-program-apbd" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th rowspan="2" style="text-align: center;">Rekening</th>
                        <th rowspan="2" style="text-align: center;">Nama Program</th>
                        <th colspan="3" style="text-align: center;">Belanja</th>
                        <th rowspan="2" style="text-align: center;">Total Pagu</th>
                    </tr>
                    <tr>
                        <th width="1%">Pegawai</th>
                        <th width="1%">Barang/Jasa</th>
                        <th width="1%">Modal</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>