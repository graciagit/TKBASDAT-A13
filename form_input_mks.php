<?php
// script untuk memanggil fungsi php pg_connect untuk koneksi ke postgresql
include "koneksi.php";
//$conn = pg_connect("host=localhost port=5432 dbname=visa.kinasya user='visa.kinasya' password='visa190895'");
//disini nama database saya adalah nama_database

$result = pg_prepare($conn, "my_query", 'SELECT * FROM sisidang.term');
$result = pg_execute($conn, "my_query",array());
$result1 = pg_prepare($conn, "my_query1", 'SELECT * FROM sisidang.jenis_mks');
$result1 = pg_execute($conn, "my_query1",array());
$result2 = pg_prepare($conn, "my_query2", 'SELECT * FROM sisidang.mahasiswa');
$result2 = pg_execute($conn, "my_query2",array());
$result3 = pg_prepare($conn, "my_query3", 'SELECT * FROM sisidang.dosen');
$result3 = pg_execute($conn, "my_query3",array());
$result4 = pg_prepare($conn, "my_query4", 'SELECT * FROM sisidang.dosen');
$result4 = pg_execute($conn, "my_query4",array());
$result5 = pg_prepare($conn, "my_query5", 'SELECT * FROM sisidang.dosen');
$result5 = pg_execute($conn, "my_query5",array());
$result6 = pg_prepare($conn, "my_query6", 'SELECT * FROM sisidang.dosen');
$result6 = pg_execute($conn, "my_query6",array());

echO"<form action='aksi_input_mks.php' method='POST'><h1>Tambah Data MKS</h1>
<table border='1' width='600px' cellspacing='0' cellpadding='9'>
	<tr>
		<td>TERM</td>
		<td>
		<select name='term'>";
			while ($row = pg_fetch_assoc($result))
{
	echo"<option value='$row[tahun] $row[semester] '>$row[tahun] $row[semester] </option>";
}
		echo"</select>
		
		</td>
	</tr>
	<tr>
		<td>JENIS MKS</td>
		<td>
		<select name='idjenismks'>";
			while ($row = pg_fetch_assoc($result1))
{
	echo"<option value='$row[id]'>$row[namamks] </option>";
}
		echo"</select>
		
		</td>
	</tr>
	<tr>
		<td>MAHASISWA</td>
		<td>
		<select name='npm'>";
			while ($row = pg_fetch_assoc($result2))
{
	echo"<option value='$row[npm]'>$row[nama] </option>";
}
		echo"</select>
		
		</td>
	</tr>
	<tr>
		<td>JUDUL MKS</td>
		<td><input name= 'judul' type ='text'> </input>
		</td>
	</tr>
	<tr>
		<td>PEMBIMBING 1</td>
		<td>
		<select name='pembimbing1'>";
			while ($row = pg_fetch_assoc($result3))
{
	echo"<option value='$row[nama]'>$row[nama] </option>";
}
		echo"</select>
		
		</td>
	</tr>
	<tr>
		<td>PEMBIMBING 2</td>
		<td>
		<select name='pembimbing2'>";
			while ($row = pg_fetch_assoc($result4))
{
	echo"<option value='$row[nama]'>$row[nama] </option>";
}
		echo"</select>
		
		</td>
	</tr>
	<tr>
		<td>PEMBIMBING 3</td>
		<td>
		<select name='pembimbing3'>";
			while ($row = pg_fetch_assoc($result5))
{
	echo"<option value='$row[nama]'>$row[nama] </option>";
}
		echo"</select>
		
		</td>
	</tr>
		<tr>
		<td>PENGUJI 1</td>
		<td>
		<select name='penguji1'>";
			while ($row = pg_fetch_assoc($result6))
{
	echo"<option value='$row[nama]'>$row[nama] </option>";
}
		echo"</select>
		
		</td>
	</tr>
	<tr>
		<td></td>
		<td><input type='submit' name='tambahpenguji' value='TAMBAH PENGUJI'/></input>
		</td>
	</tr>
	<tr>
		<td><input type='submit' name='simpan' value='SIMPAN'/> </td>
		<td><input type='submit' name='batal' value='BATAL'/></input>
		</td>
	</tr>
</table></form>";
?>