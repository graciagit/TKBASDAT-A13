<?php
include "koneksi.php";

$tampil=pg_query($conn, "select * from  sisidang.mata_kuliah_spesial order by idmks DESC limit 1");
$data=pg_fetch_array($tampil); 
$jumlah=$data['idmks']+1;
echo $jumlah;
$result=pg_query($conn, "INSERT INTO sisidang.mata_kuliah_spesial(idmks, npm, tahun, semester, judul, idjenismks)
    VALUES ('$jumlah', '$_POST[npm]', '2015', '1', '$_POST[judul]', '$_POST[idjenismks]');");
	
if(!$result){
  echo pg_last_error($conn);
} else {
  echo "Updated successfully";
}

// Close the connection
pg_close($dbconn);


header ("location:lihat_mks.php");

?>