<?php
	include "connect-db.php";
	session_start();

	$tampil=pg_query($conn, "select distinct npm from sisidang.mahasiswa where nama='".$_POST['selectmhs']."';");
	$data=pg_fetch_array($tampil); 
	$npm=$data['npm'];
	echo $npm."<br>";

	$tampil=pg_query($conn, "select distinct idmks from sisidang.mata_kuliah_spesial where npm='".$npm."';");
	$data=pg_fetch_array($tampil); 
	$idmks=$data['idmks'];
	echo $idmks."<br>";
	echo $_POST['selectruang']."<br>";

	$tampil=pg_query($conn, "select distinct idruangan from sisidang.ruangan where namaruangan='".$_POST['selectruang']."';");
	$data=pg_fetch_array($tampil); 
	$idruangan=$data['idruangan'];
	echo $idruangan."<br>";

	$result=pg_query($conn, "INSERT INTO sisidang.jadwal_sidang(idmks, tanggal, jammulai, jamselesai, idruangan)
	    VALUES ('$idmks', '$_POST[tanggal]', '$_POST[jammulai]', '$_POST[jamselesai]', $idruangan);");
		
	if(!$result){
	  echo pg_last_error($conn);
	} else {
	  echo "jadwal baru updated successfully";
	}

	for ($i = 1; $i <= intval($_POST['count-penguji']); $i++) {
		$index = "selectpenguji" . $i;

		$tampil=pg_query($conn, "select distinct nip from sisidang.dosen where nama='".$_POST[$index]."';");
		$data=pg_fetch_array($tampil); 
		$nip=$data['nip'];
		echo $nip."<br>";

		$result=pg_query($conn, "INSERT INTO sisidang.dosen_penguji
		VALUES ('$idmks', '$nip');");
		
		if(!$result){
		  echo pg_last_error($conn);
		} else {
		  echo "dosen penguji updated successfully";
		}		
	}

	if (isset($_POST['sudah'])) {
		echo "sudah";
		$_SESSION['hardcopy'] = true;
		$result=pg_query($conn, "UPDATE sisidang.mata_kuliah_spesial SET pengumpulanhardcopy=true WHERE idmks=" . $idmks . ";");
		
		if(!$result){
		  echo pg_last_error($conn);
		} else {
		  echo "hardcopy updated successfully";
		}
	} else {
		$_SESSION['hardcopy'] = false;
	}

	// Close the connection
	pg_close($conn);

	$_SESSION['nama'] = $_POST['selectmhs'];
	$_SESSION['tanggal'] = $_POST['tanggal'];
	$_SESSION['jammulai'] = $_POST['jammulai'];
	$_SESSION['jamselesai'] = $_POST['jamselesai'];
	$_SESSION['ruangan'] = $_POST['selectruang'];

	header ("location:tambahjadwal.php");
?>