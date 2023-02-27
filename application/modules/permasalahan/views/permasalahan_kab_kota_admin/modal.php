<div class="modal fade" id="modal_input_permasalahan" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Input Permasalahan SKPD</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
               
                <form id="form_input_permasalahan">
                    <input type="hidden" name="id_permasalahan" id="id_permasalahan" class="id_permasalahan">
                    <input type="hidden" name="id_instansi" id="id_instansi" class="id_instansi">
                    <input type="hidden" name="tahap" id="tahap">
                    <input type="hidden" name="tahun" id="tahun">
                        
                    <div class="form-group">
                        <table class="table">
                            <tr>
                                <td>SKPD</td> 
                                <td>:</td>  
                                <td class="nama_instansi"></td>
                            </tr>  
                            <tr>
                                <td>Tahapan APBD</td> 
                                <td>:</td>  
                                <td class="nama_tahap"></td>
                            </tr>   
                            <tr>
                                <td>Tahun Anggaran</td> 
                                <td>:</td>  
                                <td class="tahun_anggaran"></td>
                            </tr>   
                        </table>
                    </div>
                    <div class="form-group">
                        <label for="permasalahan"><b>Permasalahan</b> </label>
                        <textarea name="permasalahan" id="permasalahan" class="form-control" rows="10"></textarea>
                    </div>
                   
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                 <button type="button" class="btn btn-primary" id="simpanedit_permasalahan" onclick="saveedit_permasalahan_skpd_kab_kota()">Simpan Perubahan</button>
                <button type="button" class="btn btn-primary" id="hapus_permasalahan" onclick="hapus_permasalahan_skpd_kab_kota()">Hapus </button>
                <button type="button" class="btn btn-primary" id="simpan_permasalahan" onclick="save_permasalahan_skpd_kab_kota()">Simpan</button>
                
            </div>
        </div>
    </div>
</div>






<div class="modal fade" id="modal_input_solusi_permasalahan" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Input Solusi Permasalahan SKPD</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
               
                <form id="form_input_solusi_permasalahan">
                    <input type="hidden" name="id_instansi" id="id_instansi" class="id_instansi">
                    <input type="hidden" name="id_solusi" id="id_solusi" class="id_solusi">
                    <input type="hidden" name="tahun" id="tahun" class="tahun">
                    <input type="hidden" name="tahap" id="tahap">
                        
                    <div class="form-group">
                         <table class="table">
                            <tr>
                                <td>SKPD</td> 
                                <td>:</td>  
                                <td class="nama_instansi"></td>
                            </tr>  
                            <tr>
                                <td>Tahapan APBD</td> 
                                <td>:</td>  
                                <td class="nama_tahap"></td>
                            </tr>   
                            <tr>
                                <td>Tahun Anggaran</td> 
                                <td>:</td>  
                                <td class="tahun_anggaran"></td>
                            </tr>  
                        </table>
                    </div>
                    <div class="form-group">
                        <label for="permasalahan"><b>Permasalahan</b> </label>
                        <ol id="list_permasalahan"></ol>
                    </div>
                    <div class="form-group">
                        <label for="permasalahan"><b>Solusi</b> </label>
                        <textarea name="solusi" id="solusi" class="form-control" rows="10"></textarea>
                    </div>
                   
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="simpanedit_solusi" onclick="saveedit_solusi_permasalahan_skpd_kab_kota()">Simpan Perubahan</button>
                <button type="button" class="btn btn-primary" id="hapus_solusi" onclick="hapus_solusi_permasalahan_skpd_kab_kota()">Hapus</button>
                <button type="button" class="btn btn-primary" id="simpan_solusi" onclick="save_solusi_permasalahan_skpd_kab_kota()">Simpan Solusi</button>
                
            </div>
        </div>
    </div>
</div>
