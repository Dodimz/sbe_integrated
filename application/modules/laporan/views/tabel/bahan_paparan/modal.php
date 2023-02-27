<?php
/**
	* Author     : Alfikri, M.Kom
	* Created By : Alfikri, M.Kom
	* E-Mail     : alfikri.name@gmail.com
	* No HP      : 081277337405
*/
?>
<!-- Modal input-->
<div class="modal fade" id="data_realisasi_fisik" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Data realisasi fisik </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
               <table class="table">
                   <tr>
                       <th>No</th>
                       <th>SKPD</th>
                       <th>Realisasi Fisik</th>
                   </tr>
                   <?php 
                   $no_rf = 1;
                   foreach ($grafik_realisasi_fisik as $v) { ?>
                      <tr>
                           <td><?php echo $no_rf++ ?></td>
                           <td><?php echo $v['skpd'] ?></td>
                           <td><?php echo $v['rf'] ?></td>
                       </tr>
                   <?php } ?>
               </table>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
               
                
            </div>
        </div>
    </div>
</div>

<!-- Modal input-->
<div class="modal fade" id="data_realisasi_keuangan" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Data realisasi keuangan </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
               <table class="table">
                   <tr>
                       <th>No</th>
                       <th>SKPD</th>
                       <th>Realisasi keuangan</th>
                   </tr>
                   <?php 
                   $no_rf = 1;
                   foreach ($grafik_realisasi_keuangan as $v) { ?>
                      <tr>
                           <td><?php echo $no_rf++ ?></td>
                           <td><?php echo $v['skpd'] ?></td>
                           <td><?php echo $v['rk'] ?></td>
                       </tr>
                   <?php } ?>
               </table>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
               
                
            </div>
        </div>
    </div>
</div>

