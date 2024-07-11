// ambil element yang di butuhkan di search

var keyword = document.getElementById('cari');
var tombolCari = document.getElementById('tombolCari');
var container = document.getElementById('container');

// tombolCari.addEventListener('click', function(){
//     alert('berhasil');
// });

//tambah event saat ada tulisan
keyword.addEventListener('keyup', function(){ //keyup bekerja saat kita lepas dari keyboard
   
    //buat objek ajak
    var xhr = new XMLHttpRequest();

    // cek kesiapan ajax
    xhr.onreadystatechange = function(){
        if(xhr.readyState == 4 && xhr.status == 200){
        console.log(xhr.responseText);
        }
    }

    //eksekusi ajax
    xhr.open('GET', 'assets/ajax/coba.txt', true);
    xhr.send();

});