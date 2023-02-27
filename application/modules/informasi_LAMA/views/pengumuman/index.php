<?php
/**
	* Author     : Alfikri, M.Kom
	* Created By : Alfikri, M.Kom
	* E-Mail     : alfikri.name@gmail.com
	* No HP      : 081277337405
*/
?>
<?php echo $this->session->flashdata('pesan') ?>
<div class="mb-3 card">
    <div class="card-body">
    	<div class="row">
            
            <?php if ($this->session->userdata('id_group')=='2'): ?>
                
                <div class="col-md-12">
                    <button class="btn btn-info" onclick="tambah_pengumuman()">Pengumuman Baru</button>
                <br> <br>
            <?php endif ?>
            </div>
    		<div class="col-md-12">
                <div class="table-responsive">
    		        <table id="table-pengumuman" class="display" style="width:100%">
    		            <thead>
    		                <tr>
    		          
                                <th style="text-align: center;">No</th>
    		                    <th style="text-align: center;">Judul</th>
                                <th style="text-align: center;">Keterangan</th>
                                <th style="text-align: center;">Waktu Pelaksanaan</th>
    		                    <th style="text-align: center;">Action</th>
    		                </tr>
    		            </thead>
    		        </table>
                </div>
		    </div>
	    </div>
    </div>
</div>





