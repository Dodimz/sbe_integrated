<div class="mb-3 card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="kota"><strong>Kabupaten / Kota</strong></label>
                    <select name="kota" id="kota" class="form-control" onchange="show_laporan(this.value)">
                        <?php if ($this->session->userdata('group_name') == "ADMIN" or $this->session->userdata('group_name') == "SUPER ADMIN") : ?>
                            <option value=""></option>
                        <?php endif; ?>
                        <?php foreach ($kota->result() as $key => $value) : ?>
                            <option value="<?= sbe_crypt($value->id_kota, 'E'); ?>"><?= $value->nama_kota; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
          
        
        </div>
        <div class="row">
            <iframe id="tampil_pdf" style="display: none;" src="" width="100%" height="768px"></iframe>
        </div>
    </div>
</div>