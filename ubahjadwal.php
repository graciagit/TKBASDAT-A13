<?php 
	include 'connect-db.php';
	session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<title>Ubah Jadwal Sidang</title>
	<style type="text/css">
		.tabelnya {
	        border: 1px solid black;
	        position: static;
	        height: 100%;
	        width: 100%;
	        text-align: center;
	        margin-left: 0%; 
		}
		table {
			font-family: arial, sans-serif;
			border-collapse: collapse;
			width: 40%;
		 	border: 1;
		  	font-size: 14px;
		}

		td, th {
			border: 1px solid #A8D08D;
			text-align: left;
			padding: 9px;
		  	letter-spacing: 1;
		}

		#penguji-div {
			padding: 10px;
		}

		td.penguji-td {
			padding-left: 0px;
			padding-right: 0px;
		}

		#penguji-element {
			width: 100%;
			border: 1px solid #E2EFD9;
		}

		tr:nth-child(even) {
			background-color: #E2EFD9;
		}

		.button {
		    background-color: #A8D08D; /* Green */
		    border: none;
		    color: white;
		    padding: 15px 32px;
		    text-align: center;
		    text-decoration: none;
		    display: inline-block;
		    font-size: 16px;
		    cursor: pointer;
		    float: left;
		}

		.button:hover {
		    background-color: #A6D487;
		}
	</style>
</head>
<body>
	<nav class="navbar navbar-inverse">
	 	<div class="container-fluid">
	    	<div class="navbar-header">
	      		<a class="navbar-brand" href="#">SISidang</a>
	    	</div>
		    <ul class="nav navbar-nav">
		      	<li class="active"><a href="#"><span class="glyphicon glyphicon-home"></span> Home </a></li>
		      	<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Jadwal Sidang MKS <span class="caret"></span></a>
			        <ul class="dropdown-menu">
			          	<li><a href="tambahjadwal.php">Tambah Jadwal </a></li>
			          	<li><a href="ubahjadwal.php">Ubah Jadwal</a></li>
			          	<li><a href="#">Lihat Jadwal</a></li>
			          	<li><a href="#">Izin Jadwal</a></li>
			        </ul>
		      	</li>
		      	<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Mata Kuliah Spesial <span class="caret"></span></a>
			        <ul class="dropdown-menu">
			          	<li><a href="tambahmks.php">Tambah MKS</a></li>
			          	<li><a href="#">Lihat Daftar MKS</a></li>
			        </ul>
		      	</li>
		      	<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Jadwal Non Sidang <span class="caret"></span></a>
			        <ul class="dropdown-menu">
			          	<li><a href="#">Tambah Jadwal</a></li>
			          	<li><a href="#">Lihat Jadwal</a></li>
			        </ul>
		      	</li>
		    </ul>
		    <ul class="nav navbar-nav navbar-right">
		      	<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="glyphicon glyphicon-user"></span> Admin </a>
		        	<ul class="dropdown-menu">
		          		<li><a href="logout.php"><span class="glyphicon glyphicon-off"></span> Sign Out </a></li>
		          		<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" a href="#"><span class="glyphicon glyphicon-cog"></span> Settings </a></li>
		        	</ul>
		     	</li>
		    </ul>
	  	</div>
	</nav>
  
	<div class="tabelnya">
		<h2 align="center">Ubah Jadwal Sidang MKS</h2><br>
		
		<form name="ubahjadwal" id="ubahjadwal" action="simpanjadwal.php" method="post">
			<table align="center">
				<tr>
					<td> Mahasiswa </td>
			 		<td>
			 			<select name="selectmhs" id="mhs">
							<?php
								$list = pg_query($conn, "select nama from sisidang.mahasiswa m, sisidang.mata_kuliah_spesial mks where m.npm=mks.npm order by nama asc");
								while($row_list=pg_fetch_assoc($list)) { ?>
									<option value=<?php echo "'" . $row_list["nama"] . "'"; if (strcmp($row_list['nama'], isset($_SESSION['nama']))) echo "selected";?>> <?php echo $row_list["nama"]; ?> </option>
								<?php } ?>
						</select>
					</td>
			 	</tr>
	 	
				<tr>
					<td> Tanggal </td>
					<td>
				 		<input type="date" class="form-control" id="date" name="tanggal" value=<?php echo "'" . isset($_SESSION['tanggal']) . "'";?> placeholder="YYYY-MM-DD">
					</td>
			 	</tr>

				<tr>
					<td> Jam Mulai </td>
			 		<td>
				 		<input type="time" class="form-control" id="time1" name="jammulai" value=<?php echo "'" . isset($_SESSION['jammulai']) . "'";?> placeholder="HH:MM">
					</td>
		 		</tr>
	 	
				<tr>
					<td> Jam Selesai </td>
					<td>
						<input type="time" class="form-control" id="time2" name="jamselesai" value=<?php echo "'" . isset($_SESSION['jamselesai']) . "'";?> placeholder="HH:MM">
					</td>
		 		</tr>
	 	
				<tr>
					<td> Ruangan </td>
			 		<td>
			 			<select name="selectruang" id="ruang">
							<?php
								$list = pg_query($conn, "select namaruangan from sisidang.ruangan order by namaruangan asc");
								while($row_list=pg_fetch_assoc($list)) { ?>
									<option value=<?php echo "'" . $row_list["namaruangan"] . "'"; ?>> <?php echo $row_list["namaruangan"]; ?> </option>
								<?php } ?>
						</select>
					</td>
			 	</tr>
		 	
				<tr>
					<td colspan="2" class="penguji-td">
						<div id="penguji-div">
							<table id='penguji-element'>
								<tr style="padding-bottom: 10px;">
									<td style="width:50%" class="penguji-td">Penguji 1</td>
									<td style="width:50%" class="penguji-td">
										<select name="selectpenguji1" id="penguji">
										<?php
											$list = pg_query($conn, "select distinct nama from sisidang.dosen d, sisidang.dosen_penguji p where d.nip=p.nip_dosenpenguji order by nama asc");
											while($row_list=pg_fetch_assoc($list)) { ?>
												<option value=<?php echo "'" . $row_list["nama"] . "'"; ?>> <?php echo $row_list["nama"]; ?> </option>
										<?php } ?>
										</select>
									</td>
								</tr>
							</table>
						</div>
					</td>
			 	</tr>

			 	<tr>
			 		<td> Pengumpulan Hardcopy </td>
			 		<td>
			 			<form action="">
							<input type="checkbox" name="sudah" value="sudah"> Sudah <br>
						</form>
			 		</td>
			 	</tr>

			 	<tr>
			 		<td></td>
			 		<td> <button class="btn btn-success" align="center" type="button" onclick="tambahpenguji()">Tambah Penguji</button> </td>
			 		<script type="text/javascript">
			 			var count = 2;
			 			function tambahpenguji() {
			 				var option = document.getElementById('penguji-element');
			 				option.innerHTML = option.innerHTML + "<tr style='padding-bottom: 10px;'><td style='width:50%' class='penguji-td'>Penguji " + count + "</td><td style='width:50%' class='penguji-td'><select name='selectpenguji" +  count + "' id='penguji'> <?php include ('connect-db.php'); $db = pg_connect("dbname=postgres user=postgres port=5432 password=basdat13"); $list = pg_query($db, 'select distinct nama from sisidang.dosen d, sisidang.dosen_penguji p where d.nip=p.nip_dosenpenguji order by nama asc'); while($row_list=pg_fetch_assoc($list)) { ?> <option value=\"<?php echo $row_list['nama']; ?>\"> <?php echo $row_list['nama']; ?> </option> <?php } ?> </select></td></tr>";

			 				document.getElementById('count').value = count++;
			 			}
			 		</script>
			 	</tr>
		 	</table>
		 	<br><br>
		 	<input type="text" id="count" name="count-penguji" value="1" hidden>
		 	<input type="submit" class="btn btn-success" align="center" name="simpan" value="SIMPAN">
			<input type="submit" class="btn btn-success" align="center"  name="batal" value="BATAL"><br><br>
	 	</form>	
 	</div>

 	<div class="panel-footer"> 
 		<h4 align="center"> TK Basdat A13 </43>
 	</div>
</body>
</html>