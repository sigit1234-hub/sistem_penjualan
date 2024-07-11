<?php

/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2017, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	CodeIgniter
 * @author	EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (https://ellislab.com/)
 * @copyright	Copyright (c) 2014 - 2017, British Columbia Institute of Technology (http://bcit.ca/)
 * @license	http://opensource.org/licenses/MIT	MIT License
 * @link	https://codeigniter.com
 * @since	Version 1.0.0
 * @filesource
 */
defined('BASEPATH') or exit('No direct script access allowed');

// edit validation 
$lang['form_validation_required']        = '{field} wajib diisi.';
$lang['form_validation_isset']            = '{field} harus memiliki nilai.'; // teman-teman bisa menganti semua validation berikutnya menjadi bhs indonseia
$lang['form_validation_valid_email']        = '{field} bidang harus berisi alamat email yang valid.';
$lang['form_validation_valid_emails']        = '{field} bidang harus berisi semua alamat email yang valid.';
$lang['form_validation_valid_url']        = '{field} bidang harus berisi URL yang valid.';
$lang['form_validation_valid_ip']        = '{field} bidang harus berisi IP yang valid.';
$lang['form_validation_min_length']        = '{field} field must be at least {param} characters in length.';
$lang['form_validation_max_length']        = '{field} panjang bidang minimal harus {param} karakter.';
$lang['form_validation_exact_length']        = '{field} panjang bidang harus tepat {param} karakter.';
$lang['form_validation_alpha']            = '{field} bidang hanya boleh berisi karakter alfabet.';
$lang['form_validation_alpha_numeric']        = '{field} bidang hanya boleh berisi karakter alfanumerik.';
$lang['form_validation_alpha_numeric_spaces']    = '{field} bidang hanya boleh berisi karakter alfanumerik dan spasi.';
$lang['form_validation_alpha_dash']        = '{field} bidang hanya boleh berisi karakter alfanumerik, garis bawah, dan tanda hubung.';
$lang['form_validation_numeric']        = '{field} bidang harus berisi angka saja.';
$lang['form_validation_is_numeric']        = '{field} bidang harus berisi hanya karakter numerik.';
$lang['form_validation_integer']        = '{field} bidang harus berisi bilangan bulat.';
$lang['form_validation_regex_match']        = '{field} bidang harus berisi bilangan bulat.';
$lang['form_validation_matches']        = '{field} bidang tidak cocok dengan bidang {param}.';
$lang['form_validation_differs']        = '{field} bidang harus berbeda dari bidang {param}.';
$lang['form_validation_is_unique']         = '{field} bidang harus berisi nilai unik.';
$lang['form_validation_is_natural']        = '{field} bidang hanya boleh berisi angka.';
$lang['form_validation_is_natural_no_zero']    = '{field} bidang hanya boleh berisi angka dan harus lebih besar dari nol.';
$lang['form_validation_decimal']        = '{field} bidang harus berisi angka desimal.';
$lang['form_validation_less_than']        = '{field} bidang harus berisi angka kurang dari {param}.';
$lang['form_validation_less_than_equal_to']    = '{field} bidang harus berisi angka yang kurang dari atau sama dengan {param}.';
$lang['form_validation_greater_than']        = '{field} bidang harus berisi angka yang lebih besar dari {param}.';
$lang['form_validation_greater_than_equal_to']    = '{field} bidang harus berisi angka yang lebih besar atau sama dengan {param}.';
$lang['form_validation_error_message_not_set']    = 'Unable untuk mengakses pesan kesalahan yang sesuai dengan nama bidang Anda {field}.';
$lang['form_validation_in_list']        = '{field} bidang harus berupa salah satu dari: {param}.';
