<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
define('DB_SERVER', "201.148.104.209");
define('DB_USERNAME', "ruletacu_admin2");
define('DB_PASSWORD', "Askuru12$");
define('DB_NAME', "ruletacu_whatTheFloral");
 
/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
