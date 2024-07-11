<?php
function status($where)
{
    $ci = get_instance();
    $ci->db->where('id', $where);
    $status = $ci->db->get('status')->result_array();
    foreach ($status as $s) {
        return $s['nama_status'];
    }
}
function kategoriProduk($id = null)
{
    $ci = get_instance();
    if ($id != null) {
        $ci->db->where('id_kategori !=', $id);
    }
    return $ci->db->get('kategori')->result_array();
}
function QRcode($id)
{
    $data = isset($_GET['data']) ? $_GET['data'] : $id;
    $size = isset($_GET['size']) ? $_GET['size'] : '200x200';
    $logo = isset($_GET['logo']) ? $_GET['logo'] : base_url('assets/logo/logo_white.png');

    header('Content-type: image/png');
    // Get QR Code image from Google Chart API
    // http://code.google.com/apis/chart/infographics/docs/qr_codes.html
    $QR = imagecreatefrompng('https://chart.googleapis.com/chart?cht=qr&chld=H|1&chs=' . $size . '&chl=' . urlencode($data));
    if ($logo !== FALSE) {
        $logo = imagecreatefromstring(file_get_contents($logo));

        $QR_width = imagesx($QR);
        $QR_height = imagesy($QR);

        $logo_width = imagesx($logo);
        $logo_height = imagesy($logo);

        // Scale logo to fit in the QR Code
        $logo_qr_width = $QR_width / 3;
        $scale = $logo_width / $logo_qr_width;
        $logo_qr_height = $logo_height / $scale;

        imagecopyresampled($QR, $logo, $QR_width / 3, $QR_height / 3, 0, 0, $logo_qr_width, $logo_qr_height, $logo_width, $logo_height);
    }
    imagepng($QR);
    imagedestroy($QR);
}
function downloadFile($lampiran)
{
    force_download('/assets/lampiran/' . $lampiran);
}
function gambar($id)
{
    $ci = get_instance();
    $ci->db->where('kode_produk', $id);
    $ci->db->limit(1);
    $sql = $ci->db->order_by('id_gambar', 'ASC')->get('gambar_produk')->result_array();
    foreach ($sql as $d) {
        return $d['nama_gambar'];
    }
}
function allImg($id)
{
    $ci = get_instance();
    $ci->db->where('kode_produk', $id);
    $sql = $ci->db->order_by('id_gambar', 'ASC')->get('gambar_produk')->result_array();
    return $sql;
}
function kategori($id)
{
    $ci = get_instance();
    $ci->db->where('id_kategori', $id);
    $sql = $ci->db->get('kategori')->result_array();
    foreach ($sql as $d) {
        return $d['nama_kategori'];
    }
}

function checked($id)
{
    $ci = get_instance();
    $getCek = $ci->db->get_where('keranjang', ['id_keranjang' => $id])->row_array();

    if ($getCek['checked'] == 1) { //jika $result yang diatas menghitung row dan ternyata hasil nya lebihdari 0
        return "checked = 'checked' "; //maka centang yang di role_access.php berupa name inputnya kedalam checked
    }


    // $ci->db->where('id_keranjang', $id);
    // $result = $ci->db->update('keranjang', ['checked' => 1]);
}

function provinsi($id)
{
    $url = "https://kanglerian.github.io/api-wilayah-indonesia/api/province/" . $id . ".json";

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $data =   json_decode($response);

    return $data->name;
}
function kota($id)
{
    $url = "https://kanglerian.github.io/api-wilayah-indonesia/api/regency/" . $id . ".json";

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $data =   json_decode($response);

    return $data->name;
}
function kecamatan($id)
{
    $url = "https://kanglerian.github.io/api-wilayah-indonesia/api/district/" . $id . ".json";

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $data =   json_decode($response);

    return $data->name;
}
function desa($id)
{
    $url = "https://kanglerian.github.io/api-wilayah-indonesia/api/village/" . $id . ".json";

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $data =   json_decode($response);

    return $data->name;
}
