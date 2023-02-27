/* Fungsi Button Loading */
function button_loading(id_button, status, text_button = '')
{
	$('#'+ id_button).text(status == true ? 'Loading . . .' : text_button)
					 .prop('disabled', status);
}
/* Fungsi Remove Notif Validation */
function remove_notif_validation()
{
	$('.form-control').removeClass('is-valid')
					  .removeClass('is-invalid');
    $('.invalid-feedback').remove();
}
/* Fungsi Notif Messages Library Validation Codeigniter */
function notif_validation(data)
{
	$.each(data, function (key, value)
	{
		var element = $('#' + key);
		element.removeClass('is-invalid')
			   .removeClass('is-valid')
			   .addClass(value.length > 0 ? 'is-invalid' : 'is-valid')
			   .next('.invalid-feedback').remove();
		element.after(value);
	});
}
/* Fungsi Console Log */
function clog(data)
{
	console.log(data);
}
function replaceAll(str, find, replace) {
    return str.replace(find, replace);
}
/* Fungsi Format Number */
function formatNumber(num) {
  return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
}
/* Fungsi show datatables */
function showDatatables(idTable, url, targetOrder = [], targetClass = [], targetWidth = []) {
	$('#' + idTable).DataTable({
		processing: true,
		serverSide: true,
		bDestroy: true,
		responsive: true,
		autoWidth: true,
		ajax: {
			url: baseUrl(url),
			type: "POST",
			data: {},
		},
		columnDefs: [{
				targets: targetOrder,
				orderable: false,
			},
			{
				className: "dt-center",
				targets: targetClass,
			},
			{
				width: "1%",
				targets: targetWidth,
			},
		],

	});
}
/* Fungsi reset form */
function resetForm(form, select2 = []) {
	$('#' + form)[0].reset();
	if (select2.length > 0) {
		$.each(select2, function (key, value) {
			$('#' + value).val('').trigger('change');
		});
	}
}
/* Fungsi show modal */
function showModal(modal, title) {
	$('#' + modal).modal('show')
		.find('.modal-title').text(title);
}
/* Fungsi show select2 */
function showSelect2(idSelect2, placeholder) {
	$('#' + idSelect2).select2({
		placeholder: placeholder,
		allowClear: false,
		// theme: 'bootstrap4',
		width: 'style',
		theme: 'bootstrap4'
	});
}
/* Fungsi ajax save */
function ajaxSave(url, type, dataType, form, button, buttonTitle, modal) {
	$('#' + button).text('Loading...')
		.attr('disabled', true);
	$.ajax({
		url: baseUrl(url),
		type: type,
		dataType: dataType,
		data: $('#' + form).serialize(),
		success: function (data) {
			if (data.success == false) {
				$.each(data.messages, function (key, value) {
					var element = $('#' + key);
					element.closest('div.form-group')
						.removeClass('has-error')
						.addClass(value.length > 0 ? 'has-error' : 'has-success')
						.find('.text-danger')
						.remove();
					element.after(value);
				});
				$('#' + button).removeAttr('disabled')
					.html(buttonTitle);
			} else {
				$(".notifikasi").html('<div class="alert alert-success alert-dismissible">' + '<i class="fa fa-check"></i> ' + data.messages)
				$(".notifikasi").fadeTo(1000, 1000).slideUp(1000, function () {
					$(".notifikasi").slideUp(1000);
				});
				$('#' + form)[0].reset();
				$('#' + modal).modal('hide');
				$('#' + button).removeAttr('disabled')
					.html(buttonTitle);
			}
		},
		error: function (jqXHR, textStatus, errorThrown) {

		}
	});
}
/* Fungsi ajax delete */
function ajaxDelete(url, type, dataType, id = {}) {
	$.ajax({
		url: baseUrl(url),
		type: type,
		dataType: dataType,
		data: id,
		success: function (data) {
			$(".notifikasi").html('<div class="alert alert-success alert-dismissible">' + '<i class="fa fa-check"></i> ' + data.messages)
			$(".notifikasi").fadeTo(1000, 1000).slideUp(1000, function () {
				$(".notifikasi").slideUp(1000);
			});
		},
		error: function (jqXHR, textStatus, errorThrown) {

		}
	});
}
/* Fungsi change header theme template */
$('.switch-header-cs-class').on('click', function () {
	var me = this;
	var attr = $(me).attr('data-class');
	$.ajax({
		url: baseUrl('backend_template/set_theme'),
		type: 'POST',
		dataType: 'JSON',
		data: {
			header_class: attr,
			kategori: "header"
		},
		success: function (data) {

		},
		error: function (jqXHR, textStatus, errorThrown) {

		}
	});
});
/* Fungsi change sidebar theme template */
$('.switch-sidebar-cs-class').on('click', function () {
	var me = this;
	var attr = $(me).attr('data-class');
	$.ajax({
		url: baseUrl('backend_template/set_theme'),
		type: 'POST',
		dataType: 'JSON',
		data: {
			sidebar_class: attr,
			kategori: "sidebar"
		},
		success: function (data) {

		},
		error: function (jqXHR, textStatus, errorThrown) {

		}
	});
});
