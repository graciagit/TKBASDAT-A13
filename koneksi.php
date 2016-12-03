<?php

  $HOST = 'localhost';     # Host name 
  $PORT = '5432';     # Host name 
  $USER = 'visa.kinasya';     # database user name 
  $DBNAME = 'visa.kinasya';   # name of the database
  $PASSWORD = 'visa190895'; # password the database user
  
  
  $conn = pg_connect("host=$HOST port=$PORT dbname=$DBNAME user=$USER password=$PASSWORD");
  
  
   
  
  ?>