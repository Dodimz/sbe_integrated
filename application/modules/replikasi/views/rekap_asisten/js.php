<?php

/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 */
?>
<!-- Select2 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
<!-- Script -->
<script>
  $(document).ready(function() {
    show_select2();
  });

  function show_select2() {
    $('#bulan').select2({
      placeholder: "Pilih Bulan",
      allowClear: false,
      width: 'style',
      theme: 'bootstrap4'
    });
    $('#tahun').select2({
      placeholder: "Pilih Tahun",
      allowClear: false,
      width: 'style',
      theme: 'bootstrap4'
    });
    $('#tahap').select2({
      placeholder: "Pilih Tahap",
      allowClear: false,
      width: 'style',
      theme: 'bootstrap4'
    });
  }

  function show_laporan(x) {
    var tahun = $('#tahun').val();
    var tahap = $('#tahap').val();
    $('#bulan').val('');
    if (x != 0) {
      $('#tampil_pdf').show();
      $('#tampil_pdf').attr('src', baseUrl('laporan/pdf_laporan_rekap_asisten?bulan=') + x + '&tahun=' + tahun + '&tahap=' +tahap + '#view=FitH');
      // $('#tampil_pdf').attr('src', baseUrl('laporan/realisasi_per_asisten?bulan=') + x + '#view=FitH');
    }
  }
</script>