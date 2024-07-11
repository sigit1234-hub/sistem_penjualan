<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Api_m extends CI_Model
{
    public function provinsi()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://pro.rajaongkir.com/api/province",
            CURLOPT_SSL_VERIFYHOST => 0,
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
            $dataProvinsi = $data->rajaongkir->results;
            echo "<option>Pilih Provinsi</option>";
            foreach ($dataProvinsi as $d) {
                echo "<option id_provinsi='" . $d->province_id . "' value='" . $d->province_id . "'>";
                echo $d->province;
                echo "</option>";
            }
        }
    }
    public function kota()
    {

        $id = $_POST['idProvinsi'];
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://pro.rajaongkir.com/api/city?province=$id",
            CURLOPT_SSL_VERIFYHOST => 0,
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
            $data = json_decode($response, true);
            $dataKota = $data["rajaongkir"]["results"];


            // echo "<pre>";
            // print_r($dataKota);
            // echo "</pre>";

            echo "<option>Pilih Kota/Kabupaten</option>";
            foreach ($dataKota as $kota) {
                echo "<option idKota='" . $kota['city_id'] . "' value='" . $kota['city_id'] . "'>";
                echo $kota["type"] . " " . $kota["city_name"];
                echo "</option>";
            }
        }
    }
    public function kecamatan()
    {

        $id = $_POST['idKota'];
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://pro.rajaongkir.com/api/subdistrict?city=$id",
            CURLOPT_SSL_VERIFYHOST => 0,
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
            $data = json_decode($response, true);
            $datakecamatan = $data["rajaongkir"]["results"];


            // echo "<pre>";
            // print_r($datakecamatan);
            // echo "</pre>";

            echo "<option>Pilih Kecamatan</option>";
            foreach ($datakecamatan as $kecamatan) {
                echo "<option value='" . $kecamatan["subdistrict_id"] . "'>";
                echo $kecamatan["subdistrict_name"];
                echo "</option>";
            }
        }
    }
    public function cekOngkir()
    {
        $kota_asal = $_GET['idKotaAsal'];
        $kota_tujuan = $_GET['idKotaTujuan'];
        $berat = $_GET['berat'];
        $kurir = $_GET['kurir'];

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://pro.rajaongkir.com/api/cost",
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "origin=" . $kota_asal . "&originType=subdistrict&destination=" . $kota_tujuan . "&destinationType=subdistrict&weight=" . $berat . "&courier=" . $kurir . "",
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded",
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
            $data = json_decode($response, true);
            $dataOngkir = $data["rajaongkir"]["results"]["0"]["costs"];

            if ($kurir == 'toko') {
                echo "<option data-estimasi='1 Hari' data-paket='pengiriman toko' value='15000'>";
                echo "Pengiriman Toko (Rp 15.000)";
                echo "</option>";
            }
            // echo "<pre>";
            // print_r($datakecamatan);
            // echo "</pre>";
            foreach ($dataOngkir as $ongkos) {
                // echo "Paket :" . $ongkos['service'] . "<br>";
                // echo "Harga :" . $ongkos["cost"][0]['value'] . "<br>";
                // echo "Estimas :" . $ongkos["cost"][0]['etd'] . "<br><br>";
                echo "<option data-estimasi='" . $ongkos["cost"][0]["etd"] . " Hari' data-paket ='" . $ongkos['service'] . "'value='" . $ongkos["cost"][0]['value'] . "'>";
                echo $ongkos['service'] . ' (Rp ' . number_format($ongkos["cost"][0]["value"], 0, ',', '.') . ')';
                echo "</option>";
                // echo $kota_tujuan;
            }
        }
    }
}
