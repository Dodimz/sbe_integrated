
<div class="modal fade" id="modal-ganti-periode" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ganti Periode</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
               
                <form id="form_anggaran_sub_kegiatan">
                	
                        
					<div class="form-group">
                       <label>Tahun</label>
                       <select class="form-control" id="tahun">
                       	<?php foreach ($config as $key => $value) { 
                       	 $selected = tahun_anggaran()==$value['tahun_anggaran'] ? "selected" : ''  ?>
                       		<option value="<?php echo $value['tahun_anggaran'] ?>" <?php echo $selected ?>><?php echo $value['tahun_anggaran']?></option>
                       	<?php } ?>
                       </select>
                    </div>
					<div class="form-group">
                       <label>Tahapan APBD</label>
                       <select class="form-control" id="tahap">
                       	<?php foreach ($tahap as $k => $v) { 
                       		$selected = tahapan_apbd()==$v ? "selected" : ''  ?>
                       		<option value="<?php echo $k?>" <?php echo $selected; ?>><?php echo $v ?></option>
                       	<?php } ?>
                       </select>
                    </div>
                    
                   
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btn_save_anggaran_sub_kegiatan" onclick="hasil_ganti_periode()">Filter</button>
                
            </div>
        </div>
    </div>
</div>


