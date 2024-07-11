const btnCart = document.querySelector(".fa-shopping-cart");
btnCart.addEventListener("click", function () {
	const userId = $(this).data("user");
	const produkId = $(this).data("produk");
	$.ajax({
		url: "<?= base_url('Home/inputCart'); ?>",
		type: "post",
		data: {
			userId: userId,
			produkId: produkId,
		},
		success: function () {
			document.location.href = "<?= base_url('Home') ?>";
		},
	});
});

function tambahCart() {
	alert("ok");
}
