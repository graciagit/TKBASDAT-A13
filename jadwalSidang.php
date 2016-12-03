<?php 
	session_start();
	require "database.php";
	$username = $_SESSION['username'];
	$role = $_SESSION["role"];
	$nama = $_SESSION["nama"];
	$roleData = "";
	$orderBy = cekOrder();
	if($_GET['page'] != null){
		$offset = $_GET['page']*10 - 10;	
	}
	else {
		$offset = 1;
	}
	
	function cekOrder(){
		$order = $_GET['order'];
		if($order == 'nama'){
			$order = "m.nama";
		}
		elseif($order == 'namamks'){
			$order = "jmks.namamks";
		}
		elseif($order == 'waktu'){
			$order = "js.tanggal, js.jammulai";
		}
		else{
			$order = "js.tanggal, js.jammulai";	
		}
		return $order;		
	}

	function hitungPageAdmin(){
		$orderBy = cekOrder();
		$conn = connectDatabase();
		$sql = "SELECT m.npm, m.nama, jmks.namamks, mks.judul, js.tanggal, js.jammulai, js.jamselesai, r.namaruangan 
		FROM MAHASISWA m, JENIS_MKS jmks, MATA_KULIAH_SPESIAL mks, JADWAL_SIDANG js, RUANGAN r
		WHERE m.NPM=mks.NPM AND mks.idjenismks=jmks.id AND mks.idmks=js.idmks AND js.idruangan=r.idruangan AND mks.issiapsidang=true";

		$result = pg_query($conn, $sql);
		if (!$result) {
			die("Error in SQL query: " . pg_last_error());
		}

		$numrow = pg_num_rows($result);
		$jumlahPage = $numrow / 10;

		$pagging = "";
		for($i=1; $i<=$jumlahPage; $i=$i+1){
			$pagging = $pagging . "<li><a href='jadwalSidang.php?order=" .$_GET['order']. "&page=" .$i. "'>" .$i. "</a></li>";
		}

		return $pagging;
	}

	// ROLE MAHASISWA
	if($role == "MHS"){
		$npm = $_SESSION["npm"];
		$conn = connectDatabase();

		$sql = "SELECT mks.judul, js.tanggal, js.jammulai, js.jamselesai, r.namaruangan FROM MATA_KULIAH_SPESIAL mks, JADWAL_SIDANG js, RUANGAN R, MAHASISWA m WHERE MKS.idmks=js.idmks AND m.npm=mks.npm AND r.idruangan=js.idruangan AND mks.issiapsidang=true AND m.npm='" . $npm ."'";
		$result = pg_query($conn, $sql);
		if (!$result) {
			die("Error in SQL query: " . pg_last_error());
		}
		elseif(pg_fetch_assoc($result) < 1){
			$roleData = "Jadwal Sidang Anda belum Ada";
		}

		while($row = pg_fetch_assoc($result)){
			$roleData = $roleData. 
			"<table><tr><td>Judul Tugas Akhir</td><td>" .$row['judul']."</td></tr>
			<tr><td>Jadwal Sidang</td><td>" .$row['tanggal']. "</td></tr>
			<tr><td>WaktuSidang</td><td>" .$row['jammulai']. " - " .$row['jamselesai']. " @ " .$row['namaruangan']. "</td></tr>
			<tr><td>Dosen Pembimbing</td><td>";

			$sqlInner = "SELECT d.nama, CASE mks.izinmajusidang when 't' then 'Izin maju sidang' else 'Tidak Diizinkan' END AS izinsidang, CASE mks.pengumpulanhardcopy when 't' then 'Kumpul Hard Copy' else 'Belum Kumpul Hard Copy' END AS hardcopy
			FROM DOSEN d, DOSEN_PEMBIMBING dp, MATA_KULIAH_SPESIAL mks
			WHERE d.NIP=dp.nip_dosenpembimbing AND mks.idmks=dp.idmks AND mks.npm='" . $npm . "'";
			$resultInner = pg_query($conn, $sqlInner);
			if (!$resultInner) {
				die("Error in SQL query: " . pg_last_error());
			}
			$listPembimbing = "";
			while($rowInner = pg_fetch_assoc($resultInner)){
				$listPembimbing = $listPembimbing .
				$rowInner['nama'] .", Status: ". $rowInner['izinsidang'] .", ". $rowInner['hardcopy'] . "<br>";
			};

			// Masukin ke data
			$roleData = $roleData . $listPembimbing . "</td></tr>
			<tr><td>Dosen Penguji</td><td>";

			$sqlInner = "SELECT d.nama FROM DOSEN d, DOSEN_PENGUJI dpj, MATA_KULIAH_SPESIAL mks WHERE d.NIP=dpj.nip_dosenpenguji AND mks.idmks=dpj.idmks AND mks.npm='" . $npm . "'";
			$resultInner = pg_query($conn, $sqlInner);
			if (!$resultInner) {
				die("Error in SQL query: " . pg_last_error());
			}
			$listPenguji = "";
			while($rowInner = pg_fetch_assoc($resultInner)){
				$listPenguji = $listPenguji .
				$rowInner['nama'] ."<br>";
			};

			// Masukin ke data
			$roleData = $roleData . $listPenguji . "</td></tr></table><br>";
		}
	}

	// ROLE DOSEN
	if($role == "DOSEN"){
		$roleData = jadwalSidangDosen("Pembimbing") ."<br>". jadwalSidangDosen("Penguji");
	}

	function jadwalSidangDosen($roleSpesifik){
		$nip = $_SESSION["nip"];
		$nama = $_SESSION["nama"];
		$conn = connectDatabase();
		$fk = "";
		$tabel = "";
		$orderBy = cekOrder();

		if($roleSpesifik == "Pembimbing"){
			$fk = "dp.nip_dosenpembimbing";
			$tabel = "DOSEN_PEMBIMBING dp";
		}
		elseif($roleSpesifik == "Penguji"){
			$fk = "dp.nip_dosenpenguji";
			$tabel = "DOSEN_PENGUJI dp";
		}

		// Ngambil data mahasiswanya
		$sql = "SELECT js.idjadwal, m.npm, m.nama AS namam, jmks.namamks, mks.judul, js.tanggal, js.jammulai, js.jamselesai, r.namaruangan, CASE mks.izinmajusidang when 't' then 'Izin maju sidang' else 'Tidak Diizinkan' END AS izinsidang, CASE mks.pengumpulanhardcopy when 't' then 'Kumpul Hard Copy' else 'Belum Kumpul Hard Copy' END AS hardcopy 
		FROM MAHASISWA m, JENIS_MKS jmks, MATA_KULIAH_SPESIAL mks, JADWAL_SIDANG js, RUANGAN r, DOSEN d, ".$tabel."
		WHERE m.npm=mks.npm AND mks.idmks=js.idmks AND mks.idjenismks=jmks.id AND r.idruangan=js.idruangan AND mks.idmks=dp.idmks AND ".$fk."=d.nip AND ".$fk."='" .$nip. "'
		ORDER BY " . $orderBy;
	
		$result = pg_query($conn, $sql);
		
		if (!$result) {
			die("Error in SQL query: " . pg_last_error());
		}

		$d = "";
		while($row = pg_fetch_assoc($result)){
			$d = $d . "<tr><td>" .
			$row['namam'] ."</td><td>". 
			$row['namamks'] ."<br><br>Sebagai:<br>".$roleSpesifik."</td><td>". 
			$row['judul']."</td><td>". 
			$row['tanggal'] ."<br>". 
			$row['jammulai'] ." - ". 
			$row['jamselesai'] ."<br>". 
			$row['namaruangan'] ."</td><td>";
			
			$sqlInner = "SELECT d.nama AS namad
			FROM DOSEN d, ".$tabel.", MATA_KULIAH_SPESIAL mks, MAHASISWA m, JADWAL_SIDANG js
			WHERE m.npm=mks.npm AND mks.idmks=js.idmks AND mks.idmks=dp.idmks AND d.nip=".$fk." AND m.npm='" .$row['npm']. "' AND js.idjadwal='" .$row['idjadwal']. "' AND d.nama NOT LIKE '" .$nama. "'";
			$resultInner = pg_query($conn, $sqlInner);
			if (!$resultInner) {
				die("Error in SQL query: " . pg_last_error());
			};
			while($rowInner = pg_fetch_assoc($resultInner)){
				$d = $d . $rowInner['namad'] . "<br>";
			};

			$d = $d . "</td><td>" .
			$row['izinsidang'] ."<br>". 
			$row['hardcopy'] ."</td></tr>";
		}

		$data = "";
		$data = $data .
		"<p>
			Sort By: [<a href='jadwalSidang.php?order=nama&page=1'>Mahasiswa</a>], 
			[<a href='jadwalSidang.php?order=namamks&page=1'>Jenis Sidang</a>], 
			[<a href='jadwalSidang.php?order=waktu&page=1'>Waktu</a>]
		</p>
		<table><th>Mahasiswa</th><th>Jenis Sidang</th><th>Judul</th><th>Waktu dan Lokasi</th><th>".$roleSpesifik." Lain</th><th>Status</th>
		<tr>"
			.$d.
		"</tr></table>";

		return $data;
	}

	// ROLE ADMIN
	if($role == "ADMIN"){
		$conn = connectDatabase();
		$sql = "SELECT m.npm, m.nama, jmks.namamks, mks.judul, js.tanggal, js.jammulai, js.jamselesai, r.namaruangan 
		FROM MAHASISWA m, JENIS_MKS jmks, MATA_KULIAH_SPESIAL mks, JADWAL_SIDANG js, RUANGAN r
		WHERE m.NPM=mks.NPM AND mks.idjenismks=jmks.id AND mks.idmks=js.idmks AND js.idruangan=r.idruangan AND mks.issiapsidang=true
		ORDER BY " . $orderBy . "
		LIMIT 10 OFFSET " . $offset;

		$result = pg_query($conn, $sql);
		if (!$result) {
			die("Error in SQL query: " . pg_last_error());
		}

		$numrow = pg_num_rows($result);
		$jumlahPage = $numrow / 10;
		
		$data = "";
		while($row = pg_fetch_assoc($result)){
			$data = $data . 
				"<tr><td>" .$row['nama']. "</td>
				<td>" .$row['namamks']. "</td>
				<td>" .$row['judul']. "</td>
				<td>" .$row['tanggal']. "<br>" .$row['jammulai']. " - " .$row['jamselesai']. "<br>" .$row['namaruangan']. "</td>";

			// Ambil Pembimbing
			$sqlInner = "SELECT d.nama
				FROM DOSEN d, DOSEN_PEMBIMBING dp, MATA_KULIAH_SPESIAL mks
				WHERE d.NIP=dp.nip_dosenpembimbing AND mks.idmks=dp.idmks AND mks.npm='" . $row['npm'] . "'";
			$resultInner = pg_query($conn, $sqlInner);
			if (!$resultInner) {
				die("Error in SQL query: " . pg_last_error());
			}
			$listPembimbing = "";
			while($rowInner = pg_fetch_assoc($resultInner)){
				$listPembimbing = $listPembimbing . 
					$rowInner['nama'] ."<br>";
			};

			$data = $data . 
				"<td>" .$listPembimbing. "</td>";

			// Ambil Penguji
			$sqlInner = "SELECT d.nama FROM DOSEN d, DOSEN_PENGUJI dpj, MATA_KULIAH_SPESIAL mks WHERE d.NIP=dpj.nip_dosenpenguji AND mks.idmks=dpj.idmks AND mks.npm='" . $row['npm'] . "'";
			$resultInner = pg_query($conn, $sqlInner);
			if (!$resultInner) {
				die("Error in SQL query: " . pg_last_error());
			}
			$listPenguji = "";
			while($rowInner = pg_fetch_assoc($resultInner)){
				$listPenguji = $listPenguji .
					$rowInner['nama'] ."<br>";
			};

			$data = $data . 
				"<td>" .$listPenguji. "</td><td><a href='#'>Edit</a></td></tr>";
		}

		$roleData = "<button><a href='#'>Tambah</a></button>
			<p>
				Sort By: [<a href='jadwalSidang.php?order=nama&page=1'>Mahasiswa</a>], 
				[<a href='jadwalSidang.php?order=namamks&page=1'>Jenis Sidang</a>], 
				[<a href='jadwalSidang.php?order=waktu&page=1'>Waktu</a>]
			</p>
			<table><th>Mahasiswa</th><th>Jenis Sidang</th><th>Judul</th><th>Waktu dan Lokasi</th><th>Dosen Pembimbing</th><th>Dosen Penguji</th><th>Action</th>" 
			.$data. 
			"</table>" . hitungPageAdmin();
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset ="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
	</head>

	<body>
		<div id="title">
			<h1>Jadwal Sidang - <?php echo $nama; ?></h1>
			<?php include "navbar.php"; ?>
		</div>
		<?php echo $roleData; ?>
	</body>
</html>