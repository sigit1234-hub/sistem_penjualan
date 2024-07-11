//untuk edit status ditable
var Url_bro = "http://localhost/sistem_penjualan/";
function handleKeyPress(event) {
	// Mendapatkan kode tombol dari event
	var keyCode = event.keyCode || event.which;

	// Cek apakah tombol yang ditekan adalah Enter (kode 13)
	if (keyCode === 13) {
		// Mencegah aksi default jika tombol Enter ditekan
		event.preventDefault();
	}

	// Mencegah memasukkan karakter selain angka
	var validKeys = [48, 49, 50, 51, 52, 53, 54, 55, 56, 57]; // Kode angka 0-9
	if (validKeys.indexOf(keyCode) === -1) {
		event.preventDefault();
	}
}

$(".form-check-input").on("click", function () {
	//ambil data yang dikirim dari table(data-id)

	const dataId = $(this).data("id"); //ambil data yang namanya id di checkbox yang lagi di checked
	const statusId = $(this).data("status");

	$.ajax({
		url: Url_bro + "Admin/changeStatus",
		type: "POST",
		data: {
			idData: dataId,
			idStatus: statusId,
		},
		success: function () {
			document.location.href = Url_bro + "Admin/produk";
		},
	});
});

$("td[contenteditable='true']").on("blur", function () {
	let dataID = $(this).data("id");
	let field = $(this).data("field");
	let value = document.getElementById("input" + dataID + field).innerText;

	$.ajax({
		url: Url_bro + "Admin/editDatatable",
		type: "POST",
		data: {
			dataID: dataID,
			value: value,
			field: field,
		},
		success: function () {
			document.location.href = Url_bro + "Admin/produk";
		},
	});
});
$("h5[contenteditable='true']").on("blur", function () {
	let dataID = $(this).data("id");
	let field = $(this).data("field");
	let value = document.getElementById("input" + dataID + field).innerText;

	console.log(dataID);
	console.log(value);
	console.log(field);

	$.ajax({
		url: Url_bro + "Admin/editDatatable",
		type: "POST",
		data: {
			dataID: dataID,
			value: value,
			field: field,
		},
		success: function () {
			document.location.href = Url_bro + "Admin/produk";
		},
	});
});
$(document).ready(function () {
	// URL gambar yang ingin ditampilkan sebagai nilai awal
	var imageUrl = Url_bro + "assets/img/produk/15929839479711.jpg";

	// Inisialisasi Dropify dengan nilai awal (gambar)
	$(".dropify").dropify({
		defaultFile: imageUrl,
	});
});
