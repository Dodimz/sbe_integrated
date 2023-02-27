<?php
/**
	* Author     : Alfikri, M.Kom
	* Created By : Alfikri, M.Kom
	* E-Mail     : alfikri.name@gmail.com
	* No HP      : 081277337405
*/
?>
<!-- Modal Maps -->
<div class="modal fade" id="modal-maps-mode-input" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            	
                <div class="row">
                    

                    <div class="col-md-6">
                        <div class="form-group required">
                              <label for="latitude" class="control-label"><b>Latitude (X)</b></label>
                              <div class="input-group">
                                <input type="text" class="form-control calcius" name="input_latitude" id="input_latitude" placeholder="Latitude">
                                
                              </div>
                              <div class="help-block"></div>
                          </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group required">
                              <label for="longitude" class="control-label"><b>Longitude (Y)</b></label>
                              <div class="input-group">
                                <input type="text" class="form-control calcius" name="input_longitude" id="input_longitude" placeholder="Longitude" >
                                
                              </div>
                              <div class="help-block"></div>
                          </div>
                    </div>
                  
                </div>
	            <div class="row">
	            	<div class="col-md-12">
	            		<div class="form-group">
	            			<input type="hidden" id="id_paket" onchange="initialize_maps()">
	            			<input type="hidden" id="id_lokasi" name="id_lokasi">
	            		</div>
	            	</div>
	            </div>
            </div>
             <div class="modal-footer">
                <button type="button" class="btn btn-secondary closemodal" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary"  onclick="tetapkan_koordinat_diinput()">Tetapkan Koordinat</button>
               
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="modal-maps-mode-select" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Pilih Titik Koordinat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel-body" style="height:400px;" id="map-canvas"></div>
                        <br>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group required">
                              <label for="latitude" class="control-label"><b>Latitude (X)</b></label>
                              <div class="input-group">
                                <input type="text" class="form-control calcius" name="latitude" id="latitude" placeholder="Latitude" readonly>
                                
                              </div>
                              <div class="help-block"></div>
                          </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group required">
                              <label for="longitude" class="control-label"><b>Longitude (Y)</b></label>
                              <div class="input-group">
                                <input type="text" class="form-control calcius" name="longitude" id="longitude" placeholder="Longitude"  readonly>
                                
                              </div>
                              <div class="help-block"></div>
                          </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <input type="hidden" id="id_paket" onchange="initialize_maps()">
                            <input type="hidden" id="id_lokasi" name="id_lokasi">
                        </div>
                    </div>
                </div>
            </div>
             <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button  type="button" class="btn btn-info"  id="clearmap">Bersihkan</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="tetapkan_koordinat_terpilih()">Tetapkan Koordinat</button>
               
            </div>
        </div>
    </div>
</div>