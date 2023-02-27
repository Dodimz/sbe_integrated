<?php

/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 */
?>
<!-- Datatables -->
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<!-- Select2 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
<!-- X-editable -->
<script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>
<script>
    $(document).ready(function() {
        showKegiatanApbd();
    });

    function showAutoCurrency() {
        $('input.currency').number(true, 0);
    }

    function showKegiatanApbd(kode_rekening_program = '') {
        $('#table-realisasi-keuangan').DataTable({
            serverSide: true,
            bDestroy: true,
            responsive: true,
            ajax: {
                url: baseUrl('realisasi/dt_realisasi_keuangan/'),
                type: "POST",
                data: {
                    kode_rekening_program: kode_rekening_program
                },
            },
            columnDefs: [{
                    targets: [0, -1, -2],
                    orderable: false,
                },
                {
                    width: "1%",
                    targets: [-1, -2],
                },
                {
                    className: "dt-center",
                    targets: [-1],
                },
                {
                    className: "dt-right",
                    targets: [2, 3, 4, 5],
                },
            ],

        });
    }

    $('#table-realisasi-keuangan').on('click', '#realisasi-keuangan', function() {
        let kode_rekening_kegiatan = $(this).attr('kode-rekening-kegiatan');
        let pagu = $(this).attr('pagu');
        $('#modal-realisasi-keuangan').modal('show');
        $('#modal-realisasi-keuangan').find('.modal-title').text(kode_rekening_kegiatan);
        $('#pagu').val(convert_to_rupiah(pagu));
        get_realisasi_keuangan(kode_rekening_kegiatan, pagu);
    });

    function get_realisasi_keuangan(kode_rekening_kegiatan) {
        $.ajax({
            url: baseUrl('realisasi/get_realisasi_keuangan/'),
            type: "POST",
            dataType: "JSON",
            data: {
                kode_rekening_kegiatan: kode_rekening_kegiatan
            },
            success: function(data) {
                if (data.status == true) {
                    $('#data-realisasi-keuangan').html('');
                    $.each(data.data, function(k, v) {
                        let bp;
                        let bb;
                        let bm;

                        // if (data.opd == 'Bagian') {
                            bp = `<a href="#" id="r-bp" rekening="${kode_rekening_kegiatan}" pk="${v.id}" class="edit" data-type="text" onclick="edit_realisasi_keuangan(this)"> ${convert_to_rupiah(v.belanja_pegawai)}</a>`;
                            bb = `<a href="#" id="r-bb" rekening="${kode_rekening_kegiatan}" pk="${v.id}" class="edit" data-type="text" onclick="edit_realisasi_keuangan(this)"> ${convert_to_rupiah(v.belanja_barang_jasa)}</a>`;
                            bm = `<a href="#" id="r-bm" rekening="${kode_rekening_kegiatan}" pk="${v.id}" class="edit" data-type="text" onclick="edit_realisasi_keuangan(this)"> ${convert_to_rupiah(v.belanja_modal)}</a>`;
                        // } else {
                        //     bp = convert_to_rupiah(v.belanja_pegawai);
                        //     bb = convert_to_rupiah(v.belanja_barang_jasa);
                        //     bm = convert_to_rupiah(v.belanja_modal);
                        // }
                        $('#data-realisasi-keuangan').append(
                            `<tr>
                                <td>${k+1}</td>
                                <td>${bulan(v.bulan)}</td>
                                <td align="right">
                                    ${bp}
                                </td>
                                <td align="right">
                                    ${bb}
                                </td>
                                <td align="right">
                                    ${bm}
                                </td>
                                <td align="right">
                                    ${convert_to_rupiah(v.total)}
                                </td>
                            </tr>`
                        );
                    });
                }
            }
        });
    }

    function edit_realisasi_keuangan(x) {
        $.fn.editableform.buttons = '<button type="submit" class="btn btn-primary btn-sm editable-submit">OK</button>' +
            '<button type="button" class="btn btn-default btn-sm editable-cancel">Batal</button>';

        let id = $(x).attr('pk');
        let rekening = $(x).attr('rekening');
        $(x).editable({
            mode: 'inline',
            pk: id,
            savenochange: true,
            url: baseUrl('realisasi/update_realisasi_keuangan/'),
            success: function(c) {
                get_realisasi_keuangan(rekening);
            },
        });
    }

    function convert_to_rupiah(angka) {
        var rupiah = '';
        var angkarev = angka.toString().split('').reverse().join('');
        for (var i = 0; i < angkarev.length; i++)
            if (i % 3 == 0) rupiah += angkarev.substr(i, 3) + '.';
        return rupiah.split('', rupiah.length - 1).reverse().join('');
    }

    function bulan(x) {
        let bulan = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'July', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        return bulan[x];
    }
</script>