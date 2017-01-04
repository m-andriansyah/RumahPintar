<?php
// panggil file-file yang diperlukan
include ('inc/class_skin.php');
include ('inc/fungsi.php');
include ('template/var_utama.php');
// dapatkan data proses dari URL
$proses = $_GET['proses'];
if ($proses == '')
$proses = 'form';
$proses = filter_str($proses);
konek_db(); // koneksikan ke mysqli server
// handel setiap proses dengan case dan switch
switch ($proses)
{
/***********/
case 'form':
$judul = "<h2>Lupa Password</h2>";
$lupa = "
<p>Isikan username dan email anda kemudian klik KIRIM untuk mereset password
anda</p>
<form action='lupa_pass.php?proses=kirim' method='post'>
<table border='0' cellpadding='4'>
<tr bgcolor='#7cb500'>
<td class='putih' colspan='2'>Form Lupa Password</td></tr>
<tr> \n<td>Username: </td>
<td><input type='text' name='username'></td></tr>
<tr> \n<td>Email: </td>
<td><input type='text' name='email'></td></tr>
<tr><td></td><td><input type='submit' value='K I R I M'></td></tr>
<tr bgcolor='#7cb500' height='20'><td colspan='2'></td></tr>
</table>
</form>\n\n";
break;
/***********/
/************/
case 'kirim':
/************/
// ambil data yang dipost
$username = filter_str($_POST['username']);
$email = $_POST['email'];
// cek kevalidan email
if (!cek_email($email))
$lupa = "<p>Error: Email tidak valid.<br>\n$kembali</p>\n";
else
{
// lakukan query untuk mencocokkan data
$hasil = mysqli_query("SELECT * FROM data_user WHERE username='$username' AND
email='$email'");
// cek hasil
if (mysqli_num_rows($hasil) == 0)
$lupa = "<p>Error: Username atau email tidak ada
didatabase.<br>\n$kembali</p>";
else
{
// jika cocok maka buat password baru, update database lalu kirim email
// panggil fungsi pass_acak() untuk mendapatkan password secara acak
$new_pass = pass_acak();
// enkripsi password
$pass_enkrip = balik_md5($new_pass);
// update password yang ada di database
$q_update = mysqli_query("UPDATE data_user SET password='$pass_enkrip' WHERE
username='$username'");
// cek status
if (!$q_update)
$lupa = "<p>Error: Gagal mengupdate password didatabse.<br>\n$kembali</p>";
else
{
// kirim email
$to = $email; // alamat email user
$subject = "Password Baru Anda - Rumah Pintar";
$tgl_reset = date('d-m-Y, H:i');
$isi = "Dari admin@rumahpintar.localhost\n"
."===============================\n\n"
."Pada tanggal $tgl_reset anda dengan username $username, telah\n"
."melakukan request password. Dan di bawah ini adalah password\n"
."baru anda.\n\n"
."==================================\n"
."Username: $username\n"
."Password: $new_pass\n"
."==================================\n\n"
."Gunakan password diatas untuk masuk ke member area. Kemudian\n"
."update kembali password anda agar mudah anda ingat.\n\n"
."===========================\n"
."Admin superiklan.localhost\n"
."===========================";
$from = "From: admin@superiklan.localhost"; // ganti dengan email anda
// jika anda tidak memiliki program mail server atau anda belum di server
// sebenarnya, beri komentar pada fungsi mail berikut
mail($to, $subject, $isi, $from);
$lupa = "<p>Password berhasil direset. Silahkan cek email anda</p>";
}
}
}
break;
/************/
} // akhir dari switch
mysqli_close(); // tutup koneksi ke mysqli server
// panggil class skin
$skin = new skin; // buat objek skin
$skin->ganti_skin('template/skin_utama.php');
$skin->ganti_tag('{SEKARANG}', $tgl);
$skin->ganti_tag('{MENU}', $menu);
$skin->ganti_tag('{JUDUL}', $judul);
$skin->ganti_tag('{UTAMA}', $lupa);
$skin->ganti_tag('{SISI1}', '');
$skin->ganti_tag('{SISI2}', '');
$skin->ganti_tampilan();
?>