<?php
$koneksi = mysqli_connect('localhost', 'root','','rumahpintar');
	// jika gagal melakukan koneksi tampilkan pesan kesalahannya
	
	if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
  
$sql="SELECT * FROM admin";

if ($result=mysqli_query($koneksi,$sql))
  {
  // Return the number of rows in result set
  $rowcount=mysqli_num_rows($result);
  printf("Result set has %d rows.\n",$rowcount);
  // Free result set
  mysqli_free_result($result);
  }

  if($rowcount>0){
	echo "<table border=1><th colspan=3 align='center'>Daftar Member Rumah Pintar</th>
<tr><td align='center' width=200px>Username</td><td align='center' width=200px>Password</td><td align='center' width=200px>Email</td></tr>";
  }
  
  // Associative array
$row=mysqli_fetch_array($result,MYSQLI_ASSOC);
printf ("%s (%s)\n",$row["Lastname"],$row["Age"]);

echo "</table>\n";


mysqli_close($koneksi);
	?>