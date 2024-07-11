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
function kodeProduk($id)
{
    $ci = get_instance();
    $ci->db->where('id_produk', $id);
    $sql = $ci->db->get('produk')->result_array();
    foreach ($sql as $d) {
        return $d['kode_produk'];
    }
}
function namaProduk($id)
{
    $ci = get_instance();
    $ci->db->where('id_produk', $id);
    $sql = $ci->db->get('produk')->result_array();
    foreach ($sql as $d) {
        return $d['nama_produk'];
    }
}
function nama($id)
{
    $ci = get_instance();
    $ci->db->where('id', $id);
    $sql = $ci->db->get('user')->result_array();
    foreach ($sql as $d) {
        return $d['nama'];
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
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://pro.rajaongkir.com/api/province?id=" . $id . "",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "key: 69e56d1a26b3184f0057188aa30cf7ad"
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
        $data = json_decode($response);
        $result = $data->rajaongkir->results;

        return $result->province;
    }
}
function kota($id)
{

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://pro.rajaongkir.com/api/city?id=$id",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "key: 69e56d1a26b3184f0057188aa30cf7ad"
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
        $data = json_decode($response);
        $result = $data->rajaongkir->results;

        return $result->city_name;
    }
}
function kecamatan($id)
{
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://pro.rajaongkir.com/api/subdistrict?id=$id",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "key: 69e56d1a26b3184f0057188aa30cf7ad"
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
        $data = json_decode($response);
        $result = $data->rajaongkir->results;

        return $result->subdistrict_name;
    }
}
function desa($id)
{
    $url = "https://pro.rajaongkir.com/api/province?id" . $id . "";

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $data =   json_decode($response);

    return $data->name;
}
function Rupiah($angka)
{
    return number_format($angka, 0, ',', '.');
}
function Rupiah2($angka)
{
    return number_format($angka, 0, '.');
}
