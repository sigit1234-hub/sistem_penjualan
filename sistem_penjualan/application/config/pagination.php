<?php
//styling pagination for numbering in pagination
// $config['num_links'] = 5; // jumlah untuk angka yang tampil di pagination
$config['full_tag_open'] = '<nav aria-label="Page navigation" style="margin-right: 20px;">
     <ul class="pagination justify-content-end">'; // opened
$config['full_tag_close'] = '</ul></nav>'; //closed

$config['first_link'] = 'First'; //tulisan yang paling awal
$config['first_tag_open'] = '<li class="page-item"><a>';
$config['first_tag_close'] = '</a></li>';

$config['last_link'] = 'Last'; //tulisan yang paling awal
$config['last_tag_open'] = '<li class="page-item"><a>';
$config['last_tag_close'] = '</a></li>';

$config['next_link'] = '&raquo'; //tulisan yang paling awal
$config['next_tag_open'] = '<li class="page-item"><a>';
$config['next_tag_close'] = '</a></li>';

$config['prev_link'] = '&laquo'; //tulisan yang paling awal
$config['prev_tag_open'] = '<li class="page-item"><a>';
$config['prev_tag_close'] = '</a></li>';

$config['cur_tag_open'] = '<li class="page-item active"><a class="page-link">';
$config['cur_tag_close'] = '</a></li>';

$config['num_tag_open'] = '<li class="page-item"><a>';
$config['num_tag_close'] = '</a></li>';

$config['attributes'] = array('class' => 'page-link');

