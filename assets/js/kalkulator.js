function getSelectedCheckboxes() {
	// Mengambil semua elemen checkbox dengan class "pilihan"
	var checkboxes = document.querySelectorAll(".pilihan");

	// Membuat array untuk menyimpan checkbox yang dipilih
	var selectedCheckboxes = [];

	// Loop melalui setiap checkbox dan cek apakah dipilih
	checkboxes.forEach(function (checkbox) {
		if (checkbox.checked) {
			selectedCheckboxes.push(checkbox.id);
		}
	});

	// Menampilkan checkbox yang dipilih
	alert("Checkbox yang dipilih: " + selectedCheckboxes.join(", "));
}
