<html>
<head>
<title>Rumah Pintar</title>
<style type="text/css">
 div {
background:grey;
 width: 60px;
 height:30px;
 float:left;
 margin:10px;
 cursor:pointer;
 }
 </style>
 
 <script src="/www/RumahPintar/jquery.min.js"></script>
<script>
$(document).ready(function(){

    $(".on5w").click(function(){
        $.get("kirim.php?cmd=E");
    });
	$(".off5w").click(function(){
        $.get("kirim.php?cmd=e",
        function(data,status){
            //alert("Data: " + data + "\nStatus: " + status);
			//$("div").css("background","red");
        });
    });

    $(".on").click(function(){
        $.get("kirim.php?cmd=a",
        function(data,status){
            //alert("Data: " + data + "\nStatus: " + status);
			$("img").src("pic_bulbon.gif");
        });
    });
	$(".off").click(function(){
        $.get("kirim.php?cmd=A",
        function(data,status){
            //alert("Data: " + data + "\nStatus: " + status);
			//$("div").css("background","red");
        });
    });
	
    $(".onkipas").click(function(){
        $.get("kirim.php?cmd=D",
        function(data,status){
            //alert("Data: " + data + "\nStatus: " + status);
			$("img").src("pic_bulbon.gif");
        });
    });
	$(".offkipas").click(function(){
        $.get("kirim.php?cmd=d",
        function(data,status){
            //alert("Data: " + data + "\nStatus: " + status);
			//$("div").css("background","red");
        });
    });
	
	$(".off1").click(function(){
        $.get("kirim.php?cmd=c",
        function(data,status){
            //alert("Data: " + data + "\nStatus: " + status);
			//$("div").css("background","red");
        });
    });
	
	$(".on1").click(function(){
        $.get("kirim.php?cmd=C",
        function(data,status){
            //alert("Data: " + data + "\nStatus: " + status);
			//$("div").css("background","red");
        });
    });
	
	 $(".opn").click(function(){
        $.get("kirim.php?cmd=b",
        function(data,status){
            //alert("Data: " + data + "\nStatus: " + status);
			$("img").src("pic_bulbon.gif");
        });
    });
	$(".clos").click(function(){
        $.get("kirim.php?cmd=B",
        function(data,status){
            //alert("Data: " + data + "\nStatus: " + status);
			//$("div").css("background","red");
        });
    });
});
</script>

<style>
body{font-family: verdana, arial, sans serif; font-size: 13px}
td{font-family: verdana, arial, sans serif; font-size: 13px}
table{border-collapse: collapse; border-color: #cccccc}
a{color: #7cb500}
a:visited{color: #7cb500}
a:hover{font-weight: bold; text-decoration: none; font-size: 14px}
</style>
</head>
<body class='batas'>

<table border='0' cellpadding='0' width='100%'>
<tr bgcolor='#7cb500' height='75'>
<td align='center' class='putih'><h1>- Rumah Pintar -</h1></td>
</tr>
</table>

<table border='0' cellpadding='4' width='100%'>
<tr height='25'>
<td width='70%' align="center">{MENU}</td>
</tr>
<tr valign='top'>
<td width='60%' align="center">{JUDUL}<p>{UTAMA}</p></td>
</tr>
</table>
</body>
</html>