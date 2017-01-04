<?php
session_start();

// panggil file-file yang diperlukan
include ('../inc/class_skin.php');
include ('../template/admin_var.php');
$koneksi = mysqli_connect('localhost', 'satpam');
$password = balik_md5('pas123');
echo $password;

// dapatkan data dari URL
$proses = $_GET['proses'];
if ($proses == '')
$proses = 'login';
$proses = filter_str($proses); // filter string
konek_db(); // koneksikan ke database
// handel setiap proses dengan switch dan case
echo konek_db();





switch ($proses)
{
	case 'test':
	$hasil=mysqli_query($koneksi,"select * from data_user");
while($data = mysqli_fetch_array($hasil)){
	$admin .="<tr><td>$data[0]</td><td>$data[3]</td>
	<td>$data[1]</td></tr>";
}
break;
/************/
case 'login':
/************/
// cek apakah admin sudah login atau belum
if (!cek_session('admin'))
{
$admin = "<h2>Rumah Pintar - login</h2>\n";
$judul = "
<form action='index.php?proses=proses_login' method='post'>
<table border='0' cellpadding='4'>
<tr bgcolor='#7cb500' alignt='center'>
<td colspan='2' class='putih'>Admin Login</td></tr>
<tr><td>Username: </td><td><input type='text' name='username'></td></tr>
<tr><td>Password: </td><td><input type='password' name='password'></td></tr>
<tr><td></td><td><input type='submit' value='L O G I N'></td></tr>
<tr bgcolor='#7cb500' height='20'><td colspan='2'></td></tr>
</table>
</form>\n\n";
// kosongkan nilai variabel $admin_menu
$admin_menu = '';
}
else
{
$admin .= "<h2>Selamat datang di control panel - Rumah Pintar</h2>
<p>Silahkan pilih menu di atas untuk memanage Rumah Pintar.</p>
<p></p>";
$hasil=mysqli_query("select * from data_user");
$jml_baris = mysqli_num_rows($hasil);
if($jml_baris>0){
	$admin .="<table border=1><th colspan=3 align='center'>Daftar Member Rumah Pintar</th>
<tr><td align='center' width=200px>Username</td><td align='center' width=200px>Password</td><td align='center' width=200px>Email</td></tr>";

while($data = mysqli_fetch_array($hasil)){
	$admin .="<tr><td>$data[0]</td><td>$data[3]</td><td>$data[1]</td></tr>";
}
$admin .="</table>\n";
}
else $admin .="Belum ada member Rumah Pintar. <a href=member.php>Tambah Member</a>";
	}
break;
/************/
/*******************/
case 'proses_login':
/*******************/
$username = filter_str($_POST['username']);
$password = filter_str($_POST['password']);
$password = balik_md5($password); // enkripsi password
// kosongkan variabel $admin_menu
$admin_menu = '';
// cek kecocokan data dengan fungsi login
if (!login('admin', $username, $password))
{$admin = "<p>Username atau password salah.<br>\n$kembali</p>";
}else
{
$admin = "<p>Login berhasil. Klik <a href='index.php'>disini</a>"
." untuk masuk admin area</p>\n";
// buatkan session karena berhasil login
$_SESSION['admin'] = $username;
}
break;
/*************/
/*************/
case 'logout':
/*************/
if (!logout('admin'))
{
$admin_menu = ''; // kosongkan menu
$admin = "<p>Tidak bisa logout. <a href='index.php'>Login</a> dulu.</p>\n";
}
else
{
$admin_menu = ''; // kosongkan menu
$admin = "<p>Anda telah logout dari sistem. <a href='index.php'>Login</a>"
." kembai.</p>\n";
}
break;

case '__add_admin_to_database__':
/********************************/
/*
case ini berfungsi untuk memasukkan account administrator ke database
ini dikarenakan fungsi yang kita gunakan login adalah balik_md5()
dan untuk menghasilkan string chiper ini hanya bisa dilakukan lewat
script PHP bukan pada mysqli
untuk memanggil fungsi ini harus diketikkan langsung pada address bar
index.php?proses=__add_admin_to_database__ lalu ENTER
untuk mencegah eksploitasi sistem, kita tidak menyediakan form untuk
menambahkan account admin ke database melainkan langsung
melakukan query
*/
// kosongkan nilai $admin_menu
$admin_menu = '';
// tentukan username dan password yang diinginkan
$username = 'admin';
$password = balik_md5('pas123');
// lakukan query INSERT untuk memasukkan account ke database
$hasil = mysqli_query("INSERT INTO admin VALUES('$username', '$password')");
if (!$hasil)
$admin = "Error: Gagal memasukkan ke database. Mungkin account "
."sudah dimasukkan. <br>\n$kembali";
else
$admin = "Account untuk administrator berhasil dimasukkan ke database. <br>"
."<a href='index.php'>Login</a>\n";
break;
/**********/
} // akhir dari switch
mysqli_close($koneksi); // tutup koneksi
$skin = new skin; // buat objek skin
$skin->ganti_skin('../template/skin_utama.php');
$skin->ganti_tag('{SEKARANG}', $tgl);
$skin->ganti_tag('{JUDUL}', $judul);
$skin->ganti_tag('{UTAMA}', $admin);
$skin->ganti_tag('{MENU}', $admin_menu);
$skin->ganti_tag('{SISI1}', '');
$skin->ganti_tag('{SISI2}', '');
$skin->ganti_tampilan();
?>