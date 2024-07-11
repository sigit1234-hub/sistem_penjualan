/*-------------------
		Quantity change
	--------------------- */
var proQty = $(".pro-qty");
proQty.prepend('<span class="dec qtybtn">-</span>');
proQty.append('<span class="inc qtybtn">+</span>');
proQty.on("click", ".qtybtn", function () {
	var $button = $(this);
	var oldValue = $button.parent().find("input").val();
	if ($button.hasClass("inc")) {
		var newVal = parseFloat(oldValue) + 1;
	} else {
		// Don't allow decrementing below zero
		if (oldValue > 0) {
			var newVal = parseFloat(oldValue) - 1;
		} else {
			newVal = 0;
		}
	}
	$button.parent().find("input").val(newVal);
});

fetch(`https://kanglerian.github.io/api-wilayah-indonesia/api/provinces.json`)
	.then((response) => response.json())
	.then((provinces) => {
		var dataPro = provinces;
		$.ajax({
			url: "<?= base_url(Belanja/dataAlamatUser) ?>",
			type: "GET",
			dataType: "json",
			success: function (data) {
				fetch(
					`https://kanglerian.github.io/api-wilayah-indonesia/api/province/` +
						data["provinsi"] +
						`.json`
				)
					.then((response) => response.json())
					.then((proKu) => {
						var tampungPro =
							`<option data-pro="` +
							proKu.id +
							`" value="` +
							proKu.id +
							`">` +
							proKu.name +
							`</option>`;
						dataPro.forEach((element) => {
							tampungPro += `<option data-pro="${element.id}" value="${element.id}">${element.name}</option>`;
						});
						document.getElementById("lengkap").value = data["lengkap"];
						document.getElementById("patokan").value = data["patokan"];
						document.getElementById("provinsi").innerHTML = tampungPro;
					});
				fetch(
					`https://kanglerian.github.io/api-wilayah-indonesia/api/regency/` +
						data["kota"] +
						`.json`
				)
					.then((response) => response.json())
					.then((proKu) => {
						var tampungPro =
							`<option data-reg="` +
							proKu.id +
							`" value="` +
							proKu.id +
							`">` +
							proKu.name +
							`</option>`;

						document.getElementById("kota").innerHTML = tampungPro;
					});
				fetch(
					`https://kanglerian.github.io/api-wilayah-indonesia/api/district/` +
						data["kecamatan"] +
						`.json`
				)
					.then((response) => response.json())
					.then((proKu) => {
						var tampungPro =
							`<option data-dist="` +
							proKu.id +
							`" value="` +
							proKu.id +
							`">` +
							proKu.name +
							`</option>`;

						document.getElementById("kecamatan").innerHTML = tampungPro;
					});
				fetch(
					`https://kanglerian.github.io/api-wilayah-indonesia/api/village/` +
						data["desa"] +
						`.json`
				)
					.then((response) => response.json())
					.then((proKu) => {
						var tampungPro =
							`<option data-vill="` +
							proKu.id +
							`" value="` +
							proKu.id +
							`">` +
							proKu.name +
							`</option>`;

						document.getElementById("desa").innerHTML = tampungPro;
					});
			},
		});
	});

// provinsi

fetch(`https://kanglerian.github.io/api-wilayah-indonesia/api/provinces.json`)
	.then((response) => response.json())
	.then((provinces) => {
		var dataPro = provinces;
		var tampungPro = "<option >-Pilih-</option>";
		dataPro.forEach((element) => {
			tampungPro += `<option data-pro="${element.id}" value="${element.id}">${element.name}</option>`;
		});
		document.getElementById("provinsi").innerHTML = tampungPro;
	});

// kabupaten
const selectPro = document.getElementById("provinsi");

selectPro.addEventListener("change", (e) => {
	var pro = e.target.options[e.target.selectedIndex].dataset.pro;
	fetch(
		`https://kanglerian.github.io/api-wilayah-indonesia/api/regencies/${pro}.json`
	)
		.then((response) => response.json())
		.then((regencies) => {
			var dataPro = regencies;

			var tampungPro = "<option>-Pilih-</option>";
			dataPro.forEach((element) => {
				tampungPro += `<option data-reg="${element.id}" value="${element.id}">${element.name}</option>`;
			});
			document.getElementById("kota").innerHTML = tampungPro;
		});
});

//kecamatan
const selectKota = document.getElementById("kota");

selectKota.addEventListener("change", (e) => {
	var kota = e.target.options[e.target.selectedIndex].dataset.reg;
	fetch(
		`https://kanglerian.github.io/api-wilayah-indonesia/api/districts/${kota}.json`
	)
		.then((response) => response.json())
		.then((districts) => {
			var dataPro = districts;

			var tampungPro = "<option>-Pilih-</option>";
			dataPro.forEach((element) => {
				tampungPro += `<option data-dist="${element.id}" value="${element.id}">${element.name}</option>`;
			});
			document.getElementById("kecamatan").innerHTML = tampungPro;
		});
});

//kelurahan
const selectKelu = document.getElementById("kecamatan");

selectKelu.addEventListener("change", (e) => {
	var kec = e.target.options[e.target.selectedIndex].dataset.dist;
	fetch(
		`https://kanglerian.github.io/api-wilayah-indonesia/api/villages/${kec}.json`
	)
		.then((response) => response.json())
		.then((villages) => {
			var dataPro = villages;

			var tampungPro = "<option>-Pilih-</option>";
			dataPro.forEach((element) => {
				tampungPro += `<option value="${element.id}">${element.name}</option>`;
			});
			document.getElementById("desa").innerHTML = tampungPro;
		});
});

function cekOngkir() {
	var xmlhttp = new XMLHttpRequest();

	xmlhttp.onreadystatechange = function () {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("hasil").innerHTML = this.responseText;
		}
	};
	xmlhttp.open(
		"GET",
		"http://localhost/sistem_penjualan/Belanja/reqOngkos?kotaAsal=37&kotaTujuan=275&berat=1000&kurir=jne"
	);
	xmlhttp.send();
}
