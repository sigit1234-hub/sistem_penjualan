$(document).ready(function () {
	for (B = 1; B <= 1; B++) {
		BarisbaruSPL();
	}
	$("#TambahAnggota").click(function (e) {
		e.preventDefault();
		BarisbaruSPL();
	});
	$("LoopTable tbody")
		.find("input[type=text]")
		.filter(":visible:first")
		.focus();
});

function BarisbaruSPL() {
	$(document).ready(function () {
		$("[data-toggle='tooltipSPL']").tooltip();
	});
	var Nomor = $("#LoopTable tbody tr").length + 1;
	var Baris = "<tr>";
	Baris += '<td class ="text-center">' + Nomor + "</td>";
	Baris += "<td>";
	Baris +=
		'<input type="text" name="kategori[]" class="form-control" placeholder="Masukkan kategori..." required/>';
	Baris += '<?= form_error("kategori[]")';
	Baris += "</td>";
	Baris += '<td class="text-center">';
	Baris +=
		'<a class="btn btn-sm btn-danger" data-toggle="tooltip" id="HapusBarisSPL"><b style="color:white">X</b></a>';
	Baris += "</td>";
	Baris += "</tr";
	$("#LoopTable tbody").append(Baris);
	$("#LoopTable tbody tr").each(function () {
		$(this).find("td:nth-child(2) input").focus();
	});
}
$(document).on("click", "#HapusBarisSPL", function (e) {
	e.preventDefault();
	var Nomor = 1;
	$(this).parent().parent().remove();
	$("LoopTable tbody tr").each(function () {
		$(this).find("td:nth-child(1)").html(Nomor);
		Nomor++;
	});
});
