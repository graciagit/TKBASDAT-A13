<?php
include "koneksi.php";


$result=pg_query($conn, "INSERT INTO sisidang.mata_kuliah_spesial(idmks, npm, tahun, semester, judul, idjenismks)
    VALUES (84, '$_POST[npm]', '2015', '1', '$_POST[judul]', '$_POST[idjenismks]');");
	
if(!$result){
  echo pg_last_error($conn);
} else {
  echo "Updated successfully";
}

// Close the connection
pg_close($dbconn);


header ("location:lihat_mks.php");

?>