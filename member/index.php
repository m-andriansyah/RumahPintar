<?php
session_start();
include ('../inc/class_skin.php');
include ('../inc/fungsi.php');
include ('../template/var_utama.php');
$proses = $_GET['proses'];
if ($proses == '')
$proses = 'view';
$proses = filter_str($proses);
// cek user apakah sudah login atau belum
if (!cek_session('member'))
$member = $not_login; // $not_login ada di member_var.php
else
{
switch ($proses)
{
/***********/
case 'view':
/***********/
$judul = "<h2>Selamat Datang</h2>\n";
$member = "<table border=1><tr>	
								<td colspan=2 align='center'>Kipas</td>
								<td colspan=2 align='center'>Led</td>
								<td colspan=2 align='center'>Lampu</td>
								<td colspan=2 align='center'>Pintu</td>
								<td colspan=2 align='center'>Tirai</td>
							</tr>
							<tr>
								<td align='center'><button class='onkipas'>Nyala</button></td>
								<td align='center'><button class='offkipas'>Mati</button></td>
								<td align='center'><button class='on'>Nyala</button></td>
								<td align='center'><button class='off'>Mati</button></td>
								<td align='center'><button class='on5w'>Nyala</button></td>
								<td align='center'><button class='off5w'>Mati</button></td>
								<td align='center'><button class='on1'>Buka</button></td>
								<td align='center'><button class='off1'>Tutup</button></td>
								<td align='center'><button class='opn'>Buka</button></td>
								<td align='center'><button class='clos'>Tutup</button></td>
							</tr>";
break;

case 'logout':
/*************/
if (!logout('member'))
$member = "<p>Tidak bisa logout. Login <a href='../login.php'>Login</a>
dulu</p>\n";
else
$member = "<p>Anda telah logout dari sistem. Klik "
."<a href='../login.php'>disini</a> untuk login kembali.</p>\n";
break;
/*********/
}
}
$skin = new skin; // buat objek skin
$skin->ganti_skin('../template/skin_utama.php');
// ganti tag tertentu dengan variabel yang diinginkan
$skin->ganti_tag('{SEKARANG}', $tgl);
$skin->ganti_tag('{JUDUL}', $judul);
$skin->ganti_tag('{UTAMA}', $member);
$skin->ganti_tag('{MENU}', $mem_menu);
$skin->ganti_tag('{SISI1}', $iklanku);
$skin->ganti_tag('{SISI2}', $login);
$skin->ganti_tampilan();
?>