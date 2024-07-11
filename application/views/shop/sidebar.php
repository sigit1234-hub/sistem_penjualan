<!-- Product Section Begin -->
<!-- <section class="product spad"> -->
<div class="container">
    <div class="row">
        <div class="col-lg-3 col-md-5">
            <div class="sidebar">
                <div class="sidebar__item">
                    <h4>Kategori</h4>
                    <ul>
                        <?php foreach ($kategori as $k) : ?>
                            <!-- <li><a href="#"><?= $k['nama_kategori']; ?></a></li> -->
                            <li>
                                <a href="<?= base_url('Belanja') . '?kategori=' . $k['id_kategori'] ?>"><?= $k['nama_kategori']; ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class=" sidebar__item">
                    <h4>Urutan</h4>
                    <div class="sidebar__item__size">
                        <label for="large">
                            Harga terendah
                            <input type="radio" id="large">
                        </label>
                    </div>
                    <div class="sidebar__item__size">
                        <label for="medium">
                            Harga tertinggi
                            <input type="radio" id="medium">
                        </label>
                    </div>
                </div>
            </div>
        </div>