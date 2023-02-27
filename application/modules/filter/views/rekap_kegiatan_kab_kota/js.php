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
    $('#provinsi').select2({
      placeholder: "Pilih Provinsi",
      allowClear: false,
      width: 'style',
      theme: 'bootstrap4'
    });
    $('#kota').select2({
      placeholder: "Pilih Kota",
      allowClear: false,
      width: 'style',
      theme: 'bootstrap4'
    });
  }

  function show_laporan(x) {
    $('#provinsi').val('');
    if (x != 0) {
      $('#tampil_pdf').show();
      $('#tampil_pdf').attr('src', baseUrl('laporan/pdf_laporan_kegiatan_kab_kota?id_kota=') + x + '#view=FitH');
    }
  }



  function list_kab_kota(id_provinsi)
  {
    $.ajax(
        {
            url     : baseUrl('laporan/list_kab_kota/'),
            dataType: 'JSON',
            type    : 'POST',
            data    : { id_provinsi : id_provinsi},
            success : function(data)
            {
              console.log(data);
                if(data.status == true)
                {
                  $('#kota').html('');
                  $('#kota').append('<option value=""></option>');
                  $.each(data.data, function(k, v){
                    $('#kota').append('<option value='+ v.id +'>'+ v.kab_kota +'</option>');
                  });
                }
            }
        });
  }
</script>