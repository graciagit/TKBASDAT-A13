<?php

	$db = pg_connect('host=localhost dbname=contacts user=contacts password=firstphp');
	 $IdJadwal = pg_escape_int($_POST['IdJadwal']);
     $Tanggalmulai = pg_escape_string($_POST['Tanggalmulai']);
     $Tanggalselesai = pg_escape_string($_POST['Tanggalselesai']);
     $Alasan = pg_escape_string($_POST['keterangan']);
     $Repetisi = pg_escape_string($_POST['tanggal']);
     $NIPdosen = pg_escape_string($_POST['nip']);

     $query = "INSERT INTO JADWAL_NON_SIDANG(IdJadwal, Tanggalmulai, Tanggalselesai, keterangan, tanggal, nip) VALUES('" . $IdJadwal . "', '" . $Tanggalmulai . "', '" . $Tanggalselesai . "', '" . $Alasan . "', '" . $Repetisi . "', '" . $NIPdosen . "')";
        $result = pg_query($query);
        if (!$result) {
            $errormessage = pg_last_error();
            echo "Error with query: " . $errormessage;
            exit();
        }
        pg_close(); 


?>