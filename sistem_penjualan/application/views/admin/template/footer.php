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

<!-- Vendors JS -->
<script src="<?= base_url('vendor/admin/assets/vendor/') ?>libs/apex-charts/apexcharts.js"></script>

<!-- Main JS -->
<script src="<?= base_url('vendor/admin/') ?>assets/js/main.js"></script>

<!-- Page JS -->
<script src="<?= base_url('vendor/admin/') ?>assets/js/dashboards-analytics.js"></script>

<script src="<?= base_url('vendor/admin/') ?>assets/js/extended-ui-perfect-scrollbar.js"></script>
<!-- file upload  -->
<script src="<?= base_url('assets/fileuploads/') ?>js/dropify.min.js"></script>

<!-- Place this tag in your head or just before your close body tag. -->
<script async defer src="https://buttons.github.io/buttons.js"></script>
<script src="<?= base_url('assets/js/') ?>tablekategori.js"></script>
<script src="<?= base_url('assets/js/') ?>editTable.js"></script>
<script src="<?= base_url('assets/js/') ?>search.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>


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

<!-- <script>
    let counter = 1;

    function addInput() {
        const formContainer = document.getElementById('formContainer');

        // Buat div untuk setiap input baru
        const inputContainer = document.createElement('div');
        inputContainer.className = 'input-container';

        // Buat input Dropify baru
        const input = document.createElement('input');
        input.type = 'file';
        input.name = 'file_' + counter;
        input.className = 'dropify';

        // Tambahkan input ke dalam container
        inputContainer.appendChild(input);

        // Tambahkan container ke dalam form
        formContainer.appendChild(inputContainer);

        // Aktifkan Dropify untuk input baru
        $(input).dropify();

        counter++;
    }
</script> -->

<!-- Include Dropify initialization script -->
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
</body>

</html>