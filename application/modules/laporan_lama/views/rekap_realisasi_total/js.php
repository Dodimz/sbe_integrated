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
  }
  let img_chart;

  function get_chart() {

  }

  function show_laporan(x) {
    let options = $.ajax({
      url: baseUrl('dashboard/simulasi'),
      dataType: 'JSON',
      async: false,
      success: function(data) {}
    });

    var exportUrl = 'https://export.highcharts.com/';

    // POST parameter for Highcharts export server
    var object = {
      options: JSON.stringify(options.responseJSON),
      type: 'image/jpeg',
      async: true
    };

    // Ajax request
    $.ajax({
      type: 'post',
      url: exportUrl,
      data: object,
      success: function(data) {
        $('#bulan').val('');
        if (x != 0) {
          $('#tampil_pdf').show();
          $('#tampil_pdf').attr('src', baseUrl('laporan/realisasi_total?bulan=') + x + '&tes=' + data + '#view=FitH');
        }
      }
    });


  }
</script>