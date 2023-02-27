<?php

/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 */
?>
<!-- Modal Dokumen Realisasi -->
<div class="modal fade" id="modal-dokumen-realisasi" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="id_paket_pekerjaan" name="id_paket_pekerjaan">
                <input type="hidden" id="id_realisasi_fisik" name="id_realisasi_fisik">
                <input type="hidden" id="jenis_paket" name="jenis_paket">
                <input type="hidden" id="id_metode" name="id_metode">
                <input type="hidden" id="dokumen" name="dokumen">
                <!-- <div class="file-pdf">
                    <embed src="" type="application/pdf" width="100%" height="500px"/>
                </div> -->
                <div class="file-pdf">
                    <iframe src="" frameborder="0" width="100%" height="500px"></iframe>
                </div>
                <?php if ($this->session->userdata('group_name') == 'HELPDESK') : ?>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" id="status" name="status" onchange="form_keterangan(this.value)" class="form-control">
                            <option value="Pilih Status">Pilih Status</option>
                            <option value="Sudah Validasi">Approve</option>
                            <option value="Ditolak">Reject</option>
                        </select>
                    </div>
                    <div id="form-keterangan">

                    </div>
                <?php endif; ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <?php if ($this->session->userdata('group_name') == 'HELPDESK') : ?>
                    <button type="button" class="btn btn-primary" id="btn-update-nilai" onclick="update_nilai()">OK</button>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>