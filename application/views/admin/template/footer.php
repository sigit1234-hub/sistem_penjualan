<!-- Footer -->
<footer class="content-footer footer bg-footer-theme">
    <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
        <div class="mb-2 mb-md-0">
            ©
            <script>
                document.write(new Date().getFullYear());
            </script>
            CV Dapur Berkah
        </div>
    </div>
</footer>
<!-- / Footer -->

<div class="content-backdrop fade"></div>
</div>
<!-- Content wrapper -->
</div>
<!-- / Layout page -->
</div>

<!-- Overlay -->
<div class="layout-overlay layout-menu-toggle"></div>
</div>
<!-- / Layout wrapper -->

<!-- Core JS -->
<!-- build:js assets/vendor/js/core.js -->
<script src="<?= base_url('vendor/admin/assets/vendor/') ?>libs/jquery/jquery.js"></script>
<script src="<?= base_url('vendor/admin/assets/vendor/') ?>libs/popper/popper.js"></script>
<script src="<?= base_url('vendor/admin/assets/vendor/') ?>js/bootstrap.js"></script>
<script src="<?= base_url('vendor/admin/assets/vendor/') ?>libs/perfect-scrollbar/perfect-scrollbar.js"></script>

<script src="<?= base_url('vendor/admin/assets/js') ?>/ui-toasts.js"></script>
<script src="<?= base_url('vendor/admin/assets/vendor/') ?>js/menu.js"></script>
<!-- endbuild -->
<script src="<?= base_url('vendor/admin') ?>/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
<script src="<?= base_url('vendor/admin') ?>/assets/js/extended-ui-perfect-scrollbar.js"></script>

<!-- Vendors JS -->
<script src="<?= base_url('vendor/admin/assets/vendor/') ?>libs/apex-charts/apexcharts.js"></script>

<!-- Main JS -->
<script src="<?= base_url('vendor/admin/') ?>assets/js/main.js"></script>

<!-- Page JS -->
<!-- <script src="<?= base_url('vendor/admin/') ?>assets/js/dashboards-analytics.js"></script> -->

<!-- file upload  -->
<script src="<?= base_url('assets/fileuploads/') ?>js/dropify.min.js"></script>

<!-- Place this tag in your head or just before your close body tag. -->
<script async defer src="https://buttons.github.io/buttons.js"></script>
<!-- <script src="<?= base_url('assets/js/') ?>tablekategori.js"></script> -->
<script src="<?= base_url('assets/js/') ?>editTable.js"></script>
<script src="<?= base_url('assets/js/') ?>search.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

<script>
    let timer;

    function resetTimer() {
        clearTimeout(timer);
        timer = setTimeout(logout, 2 * 60 * 60 * 5000); // 2 jam
    }

    function logout() {
        // Arahkan pengguna ke halaman logout atau kirim permintaan ke server untuk logout
        // alert("berhasil");
        window.location.href = '<?= base_url('Auth/logout') ?>'; // Sesuaikan URL logout Anda
    }

    // Daftar event untuk memantau aktivitas pengguna
    window.onload = resetTimer;
    document.onmousemove = resetTimer;
    document.onkeypress = resetTimer;
    document.ontouchstart = resetTimer;
    document.onclick = resetTimer;
    document.onscroll = resetTimer;
</script>

<script>
    $(document).ready(function() {
        for (B = 1; B <= 1; B++) {
            BarisbaruSPL();
        }
        $("#TambahAnggota").click(function(e) {
            e.preventDefault();
            BarisbaruSPL();
        });
        $("LoopTable tbody")
            .find("input[type=text]")
            .filter(":visible:first")
            .focus();
    });

    function BarisbaruSPL() {
        $(document).ready(function() {
            $("[data-toggle='tooltipSPL']").tooltip();
        });
        var Nomor = $("#LoopTable tbody tr").length + 1;
        var Baris = "<tr>";
        Baris += '<td class ="text-center">' + Nomor + "</td>";
        Baris += "<td>";
        Baris +=
            '<input type="text" name="kategori[]" class="form-control" placeholder="Masukkan kategori..." required/>';
        Baris += '<?= form_error("kategori[]") ?>';
        Baris += "</td>";
        Baris += "<td>";
        Baris +=
            '<input type="text" name="kode[]" class="form-control" placeholder="Masukkan kode..." required/>';
        Baris += '<?= form_error("kode[]") ?>';
        Baris += "</td>";
        Baris += '<td class="text-center">';
        Baris +=
            '<a class="btn btn-sm btn-danger" data-toggle="tooltip" id="HapusBarisSPL"><b style="color:white">X</b></a>';
        Baris += "</td>";
        Baris += "</tr";
        $("#LoopTable tbody").append(Baris);
        $("#LoopTable tbody tr").each(function() {
            $(this).find("td:nth-child(2) input").focus();
        });
    }
    $(document).on("click", "#HapusBarisSPL", function(e) {
        e.preventDefault();
        var Nomor = 1;
        $(this).parent().parent().remove();
        $("LoopTable tbody tr").each(function() {
            $(this).find("td:nth-child(1)").html(Nomor);
            Nomor++;
        });
    });
</script>
<script>
    // Mendapatkan query string dari URL
    const queryString = window.location.search;

    // Membuat objek URLSearchParams
    const params = new URLSearchParams(queryString);

    // Mengambil nilai parameter
    const id = params.get('id');
    if (id) {
        var myModal = new bootstrap.Modal(document.getElementById('largeModal' + id));

        // Buka modal
        myModal.show();
        console.log(id);
    }
</script>

<script>
    const chartOrderStatistics = document.querySelector('#orderStatisticsChart'),

        orderChartConfig = {
            chart: {
                height: 165,
                width: 130,
                type: 'donut'
            },
            labels: ['Electronic', 'Sports', 'Decor', 'Fashion'],

            series: [44, 15, 50, 50],
            colors: [config.colors.primary, config.colors.secondary, config.colors.info, config.colors.success],
            stroke: {
                width: 5,
                colors: cardColor
            },
            dataLabels: {
                enabled: false,
                formatter: function(val, opt) {
                    return parseInt(val) + '%';
                }
            },
            legend: {
                show: false
            },
            grid: {
                padding: {
                    top: 0,
                    bottom: 0,
                    right: 15
                }
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: '75%',
                        labels: {
                            show: true,
                            value: {
                                fontSize: '1.5rem',
                                fontFamily: 'Public Sans',
                                color: headingColor,
                                offsetY: -15,
                                formatter: function(val) {
                                    return parseInt(val) + '%';
                                }
                            },
                            name: {
                                offsetY: 20,
                                fontFamily: 'Public Sans'
                            },
                            total: {
                                show: true,
                                fontSize: '0.8125rem',
                                color: axisColor,
                                label: 'Weekly',
                                formatter: function(w) {
                                    return '48%';
                                }
                            }
                        }
                    }
                }
            }
        };
    if (typeof chartOrderStatistics !== undefined && chartOrderStatistics !== null) {
        const statisticsChart = new ApexCharts(chartOrderStatistics, orderChartConfig);
        statisticsChart.render();
    }
</script>

<script>
    function toast() {
        toastr.options = {
            "positionClass": "toast-top-right", // Atur posisi toast (top-right)
            "showDuration": "300", // Durasi tampilan toast (300 milidetik)
            "hideDuration": "1000", // Durasi animasi menyembunyikan toast (1000 milidetik)
            // Tambahan opsi lainnya
        };
    }
</script>
<script type="text/javascript">
    $('.dropify').dropify({
        messages: {
            'default': '',
            'replace': '<i class="bx bx-plus"></i>',
            'remove': '<i class="bx bx-trash"></i>',
            'error': 'Ooops, something wrong appended.'
        },
        error: {
            'fileSize': 'File terlalu besar! (1M max).'
        }
    });
</script>
<script>
    function hapusGambar(id) {
        const img = document.getElementById("viewGambar" + id);
        img.removeAttribute("src");
    }
</script>

<script>
    function klikFokus(id) {
        $('#largeModal' + id).on('shown.bs.modal', function() {
            $('#resi' + id).focus();
        });
    }

    function tabAktif(u) {

    }
</script>

<script>
    let counter = 1;

    function addInput() {
        const row = document.querySelector("#rowInput");
        const inputContainer = document.getElementById('input-container');
        const inputGroup = document.createElement('div');
        inputGroup.className = 'col-sm-3 mb-3';
        inputGroup.id = "input-container";

        const input = document.createElement('input');
        input.type = 'file';
        // input.name = 'file_' + counter;
        input.className = 'dropify';
        input.name = 'newGambar[]';
        input.multiple; // Gunakan array untuk menangani beberapa nilai

        const inputPost = document.createElement('input');
        inputPost.type = 'hidden';
        inputPost.name = 'newGambar2[]';

        const removeButton = document.createElement('button');
        removeButton.type = 'button';
        removeButton.className = 'btn btn-primary btn-block mt-2 pull-right';

        const i = document.createElement("i");
        i.className = 'bx bx-trash m-1';

        removeButton.appendChild(i);

        // removeButton.textContent = 'Hapus';
        removeButton.addEventListener('click', function() {
            inputGroup.remove();
        });

        const col2 = document.querySelector("div .col_tambah");

        inputGroup.appendChild(input);
        inputGroup.appendChild(inputPost);

        inputGroup.appendChild(removeButton);
        // inputContainer.appendChild(inputGroup);
        row.insertBefore(inputGroup, col2);
        // Aktifkan Dropify untuk input baru
        $(input).dropify();

        counter++;
    }
</script>


<script>
    $(document).ready(function() {
        // Inisialisasi Dropify untuk input pertama
        $('.dropify').dropify({
            messages: {
                'default': 'pilih',
                'replace': '<i class="bx bx-plus"></i>',
                'remove': '<i class="bx bx-trash"></i>',
                'error': 'Ooops, something wrong appended.'
            },
            error: {
                'fileSize': 'File terlalu besar! (1M max).'
            }
        });

        // Inisialisasi Dropify untuk input dinamis
        $(document).on('DOMNodeInserted', function(e) {
            if ($(e.target).hasClass('input-container')) {
                $(e.target).find('.dropify').dropify();
            }
        });
    });
</script>

<script>
    function hapusImg(id) {
        const yakin = confirm("Yakin?");
        if (yakin) {
            const Img = document.querySelector(".dataInput" + id);
            Img.remove();
            const gambarLama = document.querySelector(".gambarLama" + id);
            gambarLama.setAttribute("value", id);
            // return;
            const ubah = document.querySelector(".gambarUbah" + id);
            ubah.setAttribute("value", "0");
        } else {
            // alert("stop");
            return;
        }

    }
</script>
<script>
    function rubahIsi(id) {
        const ubah = document.querySelector(".gambarUbah" + id);
        ubah.setAttribute("value", "1");
        const gambarLama = document.querySelector(".gambarLama" + id);
        gambarLama.setAttribute("value", id);
    }
</script>

<!-- kasir  -->
<script>
    function getDetail(no) {
        consol.log("ts");
    }
</script>
<script>
    // Menjalankan fungsi saat halaman dimuat
    document.addEventListener('DOMContentLoaded', function() {
        // Mengambil data dari server saat halaman dimuat
        fetchData();
    });

    // Fungsi untuk mengambil data dari server
    function fetchData() {
        // Mengirim permintaan AJAX ke server
        var xhr = new XMLHttpRequest();
        xhr.open('GET', '<?php echo site_url("Admin/get_data"); ?>', true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // Menetapkan nilai input teks dengan data dari server
                document.getElementById('inputText').value = xhr.responseText;
            }
        };
        xhr.send();
    }
</script>
<script>
    // Fungsi yang akan dijalankan saat tombol diklik
    function kirimData(id) {
        // Mengambil nilai dari input teks
        var inputTextValue = document.getElementById('inputText').value;

        // Mengonstruksi URL dengan parameter
        var url = '<?php echo site_url('Admin/transaksi'); ?>?inputText=' + encodeURIComponent(id);

        // Mengarahkan browser ke URL yang sudah dikonstruksi
        window.location.href = url;
    }
</script>
<script>
    function dataProduk() {
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url("Admin/dataProduk") ?>',
            dataType: 'json',
            success: function(data) {

                var element = document.getElementById('dataProduk');
                element.innerHTML = data;
                console.log(data);
            }
        });
    }

    function dataUser() {
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url("Admin/dataUser") ?>',
            dataType: 'json',
            success: function(data) {

                var element = document.getElementById('dataUser');
                element.innerHTML = data;
                console.log(data);
            }
        });
    }

    function totalTransaksi() {
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url("Admin/totalTransaksi") ?>',
            dataType: 'json',
            success: function(data) {

                var element = document.getElementById('totalTransaksi');
                element.innerHTML = "Total transaksi " + data;
                console.log(data);
            }
        });
    }

    function pesananMasuk() {
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url("Admin/pesananMasuk") ?>',
            dataType: 'json',
            success: function(data) {

                var element = document.getElementById('pesananMasuk');
                element.innerHTML = data;
                console.log(data);
            }
        });
    }

    function traksaksiToko() {
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url("Kasir/totalTransaksiToko") ?>',
            dataType: 'json',
            success: function(data) {

                var element = document.getElementById('transaksiToko');
                element.innerHTML = "Total Transaksi : " + data;
                console.log(data);
            }
        });
    }

    setInterval(function() {
        dataProduk();
        dataUser();
        totalTransaksi();
        pesananMasuk();
        traksaksiToko();
    }, 2000);
</script>
</body>

</html>