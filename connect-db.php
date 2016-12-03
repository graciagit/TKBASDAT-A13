<?php

 	$host = 'localhost';     # Host name 
  	$port = '5432';     # Host name 
  	$user = 'postgres';     # database user name 
  	$dbname = 'postgres';   # name of the database
  	$password = 'basdat13'; # password the database user
  
  
  	$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");
 ?>