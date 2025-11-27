<?php 
$servername="localhost";
$username="root";
$password="";
$db_name="crud_table";

$link=new mysqli($servername,$username,$password,$db_name);
if ($link->connect_error) {
    die("Connection failed: " . $link->connect_error);
}

?>