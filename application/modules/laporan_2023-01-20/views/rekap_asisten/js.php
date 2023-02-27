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
    $('#kategori').select2({
      placeholder: "Pilih Kategori Laporan",
      allowClear: false,
      width: 'style',
      theme: 'bootstrap4'
    });
    $('#kategori_laporan').select2({
      placeholder: "Pilih Kategori Laporan",
      allowClear: false,
      width: 'style',
      theme: 'bootstrap4'
    });
  }

  function show_laporan() {
    var bulan = $('#bulan').val();
    var tahun = $('#tahun').val();
    var tahap = $('#tahap').val();
    var kategori = $('#kategori').val();
    var kategori_penampilan_data = $('#kategori_laporan').val();
    var perhitungan = $('#perhitungan').val();
    



   if (tahun=='') {
      Swal.fire('Error','Harap Pilih Tahun Anggaran','error');
      return false;
    }
    else if (tahap=='') {
      Swal.fire('Error','Harap Pilih Tahapan APBD','error');
      return false;
    }
    else if (bulan=='') {
      Swal.fire('Error','Harap Pilih Bulan','error');
      return false;
    }
    else if (kategori=='') {
      Swal.fire('Error','Harap Pilih Bulan','error');
      return false;
    }
    else if (perhitungan=='') {
      Swal.fire('Error','Harap Pilih Bulan','error');
      return false;
    }
    else{
      $('#tampil_pdf').show();
      $('#tampil_pdf').attr('src', baseUrl('laporan/pdf_laporan_rekap_asisten?bulan=') + bulan + '&tahun=' + tahun + '&tahap=' +tahap + '&kategori=' +kategori + '&kategori_penampilan_data=' +kategori_penampilan_data + '&perhitungan=' +perhitungan + '#view=FitH');
    }

  }
</script>