<?php
//just one connection page to be called in the include_once section of every page where database connection is required

$db_host		= 'localhost';
$db_user		= 'root';        //Note: Use ‘root’ here if you experience any issues
$db_pass		= 'Faddy';          //Note: Use spaces here if you experience any issues($dbpass  =  ‘’)
$db_database	= 'e_bookshop';

$conn=mysqli_connect($db_host,$db_user,$db_pass) or die ("cannot connect to database  ".mysqli_connect_error());
$db=mysqli_select_db($conn,$db_database) or die("cannot select database")
?>