<?php
$id_group = $this->session->userdata('id_group');
?>
<!-- Modal Master User-->
<div class="modal fade" id="modal-tambah-bantuan" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Input Masalah Untuk Bantuan Aplikasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form_tambah_bantuan">

                    <div class="form-group">
                        <label for="masalah">No Wa Pelapor</label>
                        <input type="text" class="form-control" id="wa" name="wa">
                    </div>
                    <div class="form-group">
                        <label for="group">Menu</label> <br>
                      
                              <select name="menu" class="form-control" id="menu" style="width: 100%;">
                                <option value="">--Pilih Menu--</option>
                            <?php foreach($menu_bantuan->result() as $rows => $value): ?>
                                <option value="<?php echo $value->id_menu; ?>"><?php echo $value->category_name .' - '.$value->menu_name  ; ?></option>
                            <?php endforeach; ?>
                        </select>
                      
                    </div>
                    <div class="form-group">
                        <label for="masalah">Masalah</label>
                        <input type="text" class="form-control" id="masalah" name="masalah">
                    </div>
                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <textarea class="form-control" id="keterangan" name="keterangan" rows="8"></textarea>
                    </div>
                    
                    
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="clodemodal_add_bantuan">Close</button>
                <button type="button" class="btn btn-primary" id="" onclick="simpan_bantuan()">Simpan Bantuan</button>
               
            </div>
        </div>
    </div>
</div>
<!-- Modal Master User-->
<div class="modal fade" id="modal-detail-bantuan" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Bantuan <span id="kode_ticket">Kode Ticket</span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close_modal_detail_bantuan">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form_tambah_bantuan">
                    
                    <div class="form-group">
                      <input type="hidden" class="form-control" id="id_bantuan">
                      <input type="hidden" class="form-control" id="id_group_pelapor">
                       <table class="table">
                           <tr>
                               <td>Pelapor</td>
                               <td>:</td>
                               <td class="pelapor"></td>
                           </tr>
                           <tr>
                               <td><?php echo $id_group==5 ? "SKPD" : "Kab / Kota" ?></td>
                               <td>:</td>
                               <td class="skpd"></td>
                           </tr>
                           <tr>
                               <td>No Whats App</td>
                               <td>:</td>
                               <td class="no_wa"></td>
                           </tr>
                         
                           <tr>
                               <td>Menu</td>
                               <td>:</td>
                               <td class="menu"></td>
                           </tr>
                           <tr>
                               <td>Masalah</td>
                               <td>:</td>
                               <td class="masalah"></td>
                           </tr>
                           <tr>
                               <td>Keterangan Masalah</td>
                               <td>:</td>
                               <td class="keterangan_masalah"></td>
                           </tr>
                           <tr>
                               <td>Status</td>
                               <td>:</td>
                               <td class="status"></td>
                           </tr>
                       </table>
                    </div>
                    <div class="form-group" id="tracking" width='100%' height="300px">
                        
                        <table class="table" id="table-tracking-bantuan" width="100%">
                          <thead>
                            <tr>
                              <td colspan="4"><center><b>Tracking</b></center></td>
                            </tr>
                            <tr>
                              <td>No</td>
                              
                              <td>Keterangan</td>
                              <td>Dilihat</td>
                            </tr>
                          </thead>
                        </table>
                    </div>
                    <div id="penyelesaian">
                    </div>
                     <div class="form-group" id="form_tracking">
                       <?php 
                       if($this->session->userdata('id_group')=='5'){
                            $checked = "checked";
                            $value = "1";
                            $hide = "hidden='true'";
                        }else{
                            $checked = "";
                            $value = "0";
                            $hide = "";
                        }
                        ?>
                        <div <?php echo $hide ?>> 
                      <input type="checkbox" id="show_tracking_ke_operator" value="<?php echo $value ?>" style="margin-bottom : 10px" <?php echo $checked ?>> Boleh Dilihat Operator 
                        </div>
                      
                       <textarea class="form-control" id="input_tracking" placeholder="Keterangan Tracking"></textarea>
                       <button class="btn btn-info btn-sm btn-block" onclick="simpan_tracking()" type="button">Simpan Tracking</button>
                    </div>
                    <?php if($this->session->userdata('id_group')=='0' || $this->session->userdata('id_group')=='2'){ ?>
                     <hr>
                     <div id="form_close_bantuan">
                       <div class="form-group">
                        <label for="">Penyebab masalah yang ditemukan</label>
                         <textarea class="form-control" id="penyebab"></textarea>
                      </div>
                       <div class="form-group">
                        <label for="">Jenis Penyelesaian</label>
                         <select class="form-control" id="penyelesaian">
                           <option value="Tidak Ada">--Pilih Penyelesaian--</option>
                           <option value="Maintenance">Maintenance</option>
                           <option value="Perubahan Data">Perubahan Data</option>
                         </select>
                      </div>
                       <div class="form-group">
                        <label for="">Solusi</label>
                         <textarea class="form-control" id="solusi"></textarea>
                      </div>
                       <div class="form-group">
                        <input type="checkbox" id="show_permasalahan_ke_operator" value="0" style="margin-bottom : 10px"> Tampilkan masalah, dan solusi ke Operator 
                        
                      </div>
                      
                       <div class="form-group">
                        <button type="button" class="btn btn-info" onclick="akhiri_bantuan()">Akhiri Bantuan</button>
                      </div>
                    </div>
                    <?php } ?>
                    
                </form>
            </div>
           
        </div>
    </div>
</div>