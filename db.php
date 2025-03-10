<?php

$host = 'localhost';
$username = 'root';
$dbname = 'atm_project';
$password = '';

$conn = mysqli_connect('localhost','root','','atm_project');

if(!$conn){
    die('error'. mysqli_connect_error());
}

?>