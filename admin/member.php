<?php
// panggil file-file yang diperlukan
include ('../inc/class_skin.php');
include ('../template/admin_var.php');


// dapatkan data proses dari URL
$proses = $_GET['proses'];
if ($proses == '')
$proses = 'form';
$proses = filter_str($proses);
// handel setiap proses dengan switch dan case
switch ($proses)
{
/***********/
case 'form':
$judul = "<h2>Form Registrasi - Rumah Pintar</h2>\n";
// buat form dan tabel untuk registrasi
$reg = "<p>Mohon isi semua field dibawah ini untuk mendaftar menjadi member Rumah Pintar.<br> Klik DAFTAR untuk melanjtkan proses
registrasi.</p>"
."<form action='member.php?proses=proses_form' method='post'>"
."<table border='0' cellpadding='4' width='60%'>"
."<tr bgcolor='#7cb500'>"
." <td class='putih' colspan='2' align='center'>Form Registrasi</td></tr>"
."<tr><td>Username: </td><td><input type='text' name='username' maxlength='16'> max. 16 karakter. </td></tr>"
."<tr><td>Password: </td><td><input type='password' name='password' maxlength='16'> max. 16 karakter.</td></tr>"
."<tr> <td>Email: </td><td><input type='text' name='email'></td> </tr><td><input type='submit' value='DAFTAR'></td> </tr>"
."<tr bgcolor='#7cb500' height='20'><td colspan='2'></td></tr>"
."</table></form>";
break;
/***********/
/******************/
case 'proses_form':
/******************/
// ambil data yang di-post dari form registrasi
$username = $_POST['username'];
$kode = $_POST['password'];
$email = $_POST['email'];
$pesan_error = ''; // variabel untuk pesan error
// cek setiap field
if (!cek_field($_POST))
$pesan_error = "Error: Masih ada field yang kosong.<br>";
if (!cek_email($email))
$pesan_error .= "Error: Email tidak valid.<br>";
$format = '[^a-zA-Z0-9_]'; // username dan password hanya alphanumerik dan _
if (preg_match("/$format/", $username) || preg_match("/$format/", $kode))
$pesan_error .= "Error: Username atau password hanya boleh terdari dari "
."alpabet, numerik dan _.<br>";
$password = balik_md5($kode); // enkripsi password
// cek isi $pesan_error jika tidak kosong maka ada error
if ($pesan_error != '')
$reg = $pesan_error.$kembali;
else
{
konek_db(); // koneksikan ke mysqli server
// lakukan query
$hasil = mysqli_query($koneksi,"INSERT INTO `data_user` (`username`, `email`, `password`, `kode`) VALUES ('$username', '$email', '$password', '$kode')");
// cek status
if (!$hasil)
$reg = "Error: Gagal memasukkan data ke database. Kontak admin.<br>\n".$kembali;
else
$reg = "Proses registrasi sukses.<a href='index.php'>Kembali</a>";
mysqli_close();
}
break;
/************/
} // akhir dari switch
// panggil class skin
$skin = new skin; // buat objek skin
$skin->ganti_skin('../template/skin_utama.php'); // tentukan file template
$skin->ganti_tag('{SEKARANG}', $tgl);
$skin->ganti_tag('{MENU}', $menu);
$skin->ganti_tag('{JUDUL}', $judul);
$skin->ganti_tag('{UTAMA}', $reg);
$skin->ganti_tag('{SISI1}', '');
$skin->ganti_tag('{SISI2}', '');
$skin->ganti_tampilan();
?>