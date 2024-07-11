<?php

function tanggal()
{
    $timezone = time() + (60 * 60 * 7);
    return gmdate('Y-m-d H:i:s', $timezone);
}

function tgl($tanggal)
//tanggal di ambil dari function tanggal diatas
//2023-08-23 21:08:22
{
    $tanggals = substr($tanggal, 8, 2);
    //9 : ambil 9 karakter dari tanggal di ats terus ambil datanya 2 kebelakang
    $bulan = substr($tanggal, 5, 2);
    $tahun = substr($tanggal, 0,  4);

    return $tanggals . " " . bulan($bulan) . " " . $tahun;
}
function tgl_jam($tgls)
{
    $tanggal = substr($tgls, 8, 2);
    //9 : ambil 9 karakter dari tanggal di ats terus ambil datanya 2 kebelakang
    $bulan = substr($tgls, 5, 2);
    $tahun = substr($tgls, 0,  4);
    $jam = substr($tgls, 11,  2);
    $menit = substr($tgls, 14,  2);

    return $tanggal . " " . bulan($bulan) . " " . $tahun . " " . $jam . ":" . $menit;
}
function bulan($bulan)
{
    switch ($bulan) {
        case '01':
            return 'Januari';
            break;
        case '02':
            return 'Februari';
            break;
        case '03':
            return 'Maret';
            break;
        case '04':
            return 'April';
            break;
        case '05':
            return 'Mei';
            break;
        case '06':
            return 'Juni';
            break;
        case '07':
            return 'Juli';
            break;
        case '08':
            return 'Agustus';
            break;
        case '09':
            return 'September';
            break;
        case '10':
            return 'Oktober';
            break;
        case '11':
            return 'November';
            break;
        case '12':
            return 'Desember';
            break;

        default:
            # code...
            break;
    }
}
