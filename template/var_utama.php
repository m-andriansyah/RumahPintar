<?php
// cegah pengaksesan langsung dari browser
if (preg_match('/var_utama.php/i', $_SERVER['PHP_SELF']))
{
header('Location: ../index.php'); // kembalikan ke halaman utama
exit;
}

// buat variabel untuk tanggal sekarang
$tgl = "Hari ini: ".show_tgl(); // fungsi untuk menampilkan tanggal sekarang

// buat variabel untuk menampilkan menu
$menu = "";

// buat link kembali berguna jika ada error.
$kembali = "<br><a href='javascript: history.back()'><< Kembali</a>\n";
?>