function hitQty(id) {
	var ic = $("#icon" + id).prop("class");

	var totalHarga = $("#total_harga").val();
	if (ic == "fa fa-check-square fa-lg") {
		var totalSementara = $("#jumlahHarga" + id).val();
		var jmlTotal = $("#total_harga").val();
		var kurang = jmlTotal - totalSementara;
		$("#total_harga").val(kurang);

		var harga = $("#harga" + id).val();
		var qty = $("#qty" + id).val();
		var jumlah = harga * qty;
		// alert(jumlah);

		var sum = kurang * 1 + jumlah * 1;
		document.getElementById("jumlah_sum").innerHTML = formatRupiah(sum);
		$("#total_harga").val(sum);
		document.getElementById("jumlahHarga" + id).value = jumlah;
	}
}

function add_fav(idKeranjang) {
	var ic = $("#ic" + idKeranjang).val();
	var harga = $("#harga" + idKeranjang).val();
	var qty = $("#qty" + idKeranjang).val();
	var jumlah = harga * qty;
	var totalHarga = $("#total_harga").val();
	if (ic == "fa fa-square-o fa-lg") {
		$("#icon" + idKeranjang).prop("class", "fa fa-check-square fa-lg");
		$("#ic" + idKeranjang).val("fa fa-check-square fa-lg");
		var sum = totalHarga * 1 + jumlah * 1;

		document.getElementById("jumlah_sum").innerHTML = formatRupiah(sum);
		document.getElementById("jumlahHarga" + idKeranjang).value = jumlah;
		$("#total_harga").val(sum);
	} else {
		$("#icon" + idKeranjang).prop("class", "fa fa-square-o fa-lg");
		$("#ic" + idKeranjang).val("fa fa-square-o fa-lg");
		var sum = totalHarga * 1 - jumlah * 1;
		document.getElementById("jumlah_sum").innerHTML = formatRupiah(sum);
		$("#total_harga").val(sum);
	}
}
