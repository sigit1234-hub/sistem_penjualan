<div class="container-xxl flex-grow-1 container-p-y">
  <?= $this->session->flashdata('message'); ?>
  <!-- Layout Demo -->
  <!-- <div class="layout-demo-wrapper"> -->
  <form id="payment-form" method="POST" action="<?= base_url('Kasir/checkout') ?>">
    <div class="row">
      <div class="col-lg-8 col-md-6 mb-4 order-0">
        <div class="card">
          <div class="d-flex align-items-end row">
            <div class="card-body">
              <div class="table-responsive text-nowrap" style="height: 300px; overflow: auto;">
                <!-- table produc  -->
                <table class="table table-bordered" id="tabelProduk">
                  <thead>
                    <div id="hasil"></div>
                    <tr>
                      <th>No</th>
                      <th>Nama Produk</th>
                      <th>Kode Produk</th>
                      <th>Harga</th>
                      <th>Qty</th>
                      <th>Total</th>
                    </tr>
                  </thead>
                  <tbody width="500px" id="tabelInput">

                    <?php

                    for ($i = 1; $i <= 20; $i++) {  ?>

                      <tr id="dataTable<?= $i ?>">
                        <td width="2%"><?= $i; ?></td>
                        <td width="15%">
                          <select class="form-control" id="product-name<?= $i; ?>" style="width: 250px;" onclick="getName(event,<?= $i ?>)"></select>
                        </td>
                        <td width="15%">
                          <input style="text-transform: uppercase;" type="text" id="kodeBarang<?= $i ?>" class="form-control" width="15px" disabled>
                        </td>
                        <!-- <td width="30%">
                          <p id="namaProduk<?= $i ?>"></p>
                        </td> -->
                        <td width="15%">
                          <p id="hargaProduk<?= $i ?>"></p>
                          <input type="text" id="hargaInput<?= $i ?>" value="" hidden>
                          <input type="text" id="diskonInput<?= $i ?>" value="" hidden>
                        </td>
                        <td width=" 15%">
                          <input type="number" id="qtyProduk<?= $i ?>" name="qty" min="1" value="" class="form-control" onchange="hitungTotal(<?= $i ?>)" oninput="cegahInput(<?= $i ?>)">
                        </td>
                        <td>
                          <p id="totalProduk<?= $i; ?>"></p>
                        </td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>

              </div>
            </div>
            <!-- table discount  -->
            <div class="card-body">
              <p>Catatan</p>
              <div class="table-responsive text-nowrap" style="height: 300px; overflow: auto;">
                <table class="table table-bordered" id="tabelDiskon">
                  <thead>
                    <tr class="text-center">
                      <th>No</th>
                      <th>Kode</th>
                      <th>Nama Produk</th>
                      <th>Harga</th>
                      <th>Diskon</th>
                    </tr>
                  </thead>
                  <tbody id="tabelBody">

                  </tbody>
                </table>

              </div>
            </div>
          </div>
        </div>
      </div>



      <!-- Total -->
      <div class="col-lg-4 col-md-12 order-1">
        <div class="row">
          <div class="col-lg-12 mb-4">
            <div class="card">
              <div class="card-body">
                <form id="myForm">
                  <div class="row mb-3">
                    <label class="col-sm-4 col-form-label" for="basic-default-name">Total Harga</label>
                    <div class="col-sm-8 ">
                      <input type="text" style="text-align: right;" class="form-control" id="grandTotalHarga" name="grandTotalHarga" value="" readonly />
                      <input type="text" style="text-align: right;" class="form-control" id="tampungHarga" name="tampungHarga" value="" readonly hidden />
                      <input type="text" style="text-align: right;" class="form-control" id="tampungQty" name="tampungQty" value="" readonly hidden />
                      <input type="text" style="text-align: right;" class="form-control" id="kembalian" name="kembalian" value="" readonly hidden />
                      <input type="text" style="text-align: right;" class="form-control" id="tampungKode" name="tampungKode" value="" readonly hidden />
                      <input type="hidden" name="result_type" id="result-type" value="">
                      <input type="hidden" name="result_data" id="result-data" value="">
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label class="col-sm-4 col-form-label" for="basic-default-company">Pembeli</label>
                    <div class="col-sm-8">
                      <input type="text" style="text-align: right;" class="form-control" id="user" name="user" required />
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label class="col-sm-4 col-form-label" for="basic-default-company">Diskon</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" style="text-align: right;" id="grandDiskon" name="grandDiskon" readonly value="0" />
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label class="col-sm-4 col-form-label" for="basic-default-company">Catatan</label>
                    <div class="col-sm-8">
                      <textarea type="text" class="form-control" id="catatan" name="catatan"></textarea>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label class="col-sm-4 col-form-label" for="basic-default-email">Tunai</label>
                    <div class="col-sm-8">
                      <div class="input-group input-group-merge">
                        <input type="text" id="inputTunai" style="text-align: right;" value="0" class="form-control" placeholder="Masukkan pembayaran" oninput="hitungKembalian(); addRp(this)" />
                      </div>
                      <div class="form-text">Masukkan jumlah tunai</div>
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label class="col-sm-4 col-form-label" for="basic-default-message">Kembalian</label>
                    <div class="col-sm-8">
                      <h3 class="text-center text-nowrap mb-1" id="nilaiKembalian"></h3>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-12">
                      <button style="width: 100%;" id="submitBtn" class="btn btn-primary btn-block btn-block">Proses Pesanan</button>
                    </div>
                  </div>
                </form>
                <!-- <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> +28.42%</small> -->
              </div>
            </div>
          </div>
        </div>

      </div>

      <!-- row  -->
    </div>
  </form>
  <!-- </div>s -->
  <!--/ Layout Demo -->
</div>
<!-- / Content -->