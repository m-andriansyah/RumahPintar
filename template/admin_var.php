<?php
// cegah pengaksesan langsung dari browser
if (preg_match('/var_utama.php/i', $_SERVER['PHP_SELF']))
{
header('Location: ../index.php'); // kembalikan ke halaman utama
exit;
}

include ('../inc/fungsi.php'); // panggil fungsi.php

$tgl = "Hari ini: ".show_tgl(); // tanggal sekarang

// variabel untuk menu admin
$admin_menu = "<a href='member.php'>Tambah Member</a> &nbsp :: &nbsp <a href='index.php?proses=logout'>Logout</a>";
// varibel untuk menampilkan pesan belum login
$not_login = "<p>Anda belum login. <a href='index.php'>Login</a> dulu</p>";
// variabel untuk menampilkan teks berjalan
$anim_teks = "
<marquee scrolldelay='50' scrollamount='2'>Control panel Rumah Pintar
</marquee>";
// variabel untuk menampilkan link kembali
$kembali = "<br><a href='javascript: history.back();'><< Kembali</a>";
?>