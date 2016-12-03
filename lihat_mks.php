<html>
<head></head>
<body>

<link rel="stylesheet" type="text/css" href="DataTables-1.10.12/media/css/jquery.dataTables.css">
	<style type="text/css" class="init">
	
	</style>
	<script type="text/javascript" language="javascript" src="//code.jquery.com/jquery-1.12.3.min.js">
	</script>
	<script type="text/javascript" language="javascript" src="DataTables-1.10.12/media/js/jquery.dataTables.js">
	</script>

	<script type="text/javascript" language="javascript" class="init">
	
$(document).ready(function() {
	$('#visa').DataTable( {
		"pagingType": "full_numbers"
	} );
} );

	</script>
	
<style>
.button {
  font: bold 14px Arial;
  text-decoration: none;
  background-color: #EEEEEE;
  color: #333333;
  padding: 5px 5px 5px 5px;
  border-top: 1px solid #CCCCCC;
  border-right: 1px solid #333333;
  border-bottom: 1px solid #333333;
  border-left: 1px solid #CCCCCC;
  width:400px;
}
</style>
<?php
// script untuk memanggil fungsi php pg_connect untuk koneksi ke postgresql
include "koneksi.php";
//$conn = pg_connect("host=localhost port=5432 dbname=visa.kinasya user='visa.kinasya' password='visa190895'");
//disini nama database saya adalah nama_database

$result = pg_prepare($conn, "my_query", 'SELECT * FROM sisidang.mata_kuliah_spesial order by idmks asc');
// disini saya membuat table dengan nama mahasiswa
$result = pg_execute($conn, "my_query",array());



echo "
<a class='button' href = 'form_input_mks.php'>Tambah</a>
<br><br>
<table border='1px' id='visa'>
<thead>
<th> idmks</th>
<th> npm</th>
<th> tahun</th>
<th> semester</th>
<th> judul</th>
<th>issiapsidang</th>
<th>pengumpulanhardcopy</t>
<th>izinmajusidang</th>
<th>idjenismks</th>
</thead>
<tbody>
";
// kolom yang ada di table mahasiswa saya hanya ada 2 yaitu nim dan nama
while ($row = pg_fetch_assoc($result))
{
echo "<tr>";
echo "<td>".$row['idmks']."</td>"; 
echo "<td>".$row['npm']."</td>";
echo "<td>".$row['tahun']."</td>";
echo "<td>".$row['semester']."</td>";
echo "<td>".$row['judul']."</td>";
echo "<td>".$row['issiapsidang']."</td>";
echo "<td>".$row['pengumpulanhardcopy']."</td>";
echo "<td>".$row['izinmajusidang']."</td>";
echo "<td>".$row['idjenismks']."</td>";
echo "</tr>";
}
echo "<tbody></table>";
?>
</html>