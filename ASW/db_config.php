<?php
//$dbhost = "appserver-01.alunos.di.fc.ul.pt";
//$dbuser = "asw024";
//$dbpass = "asw024";
//$dbname = "asw024";

$dbhost = "127.0.0.1:3306";
$dbuser = "root";
$dbname = "asw024";
$dbpass = "";

global $conn;


$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);


if (mysqli_connect_error()) {
  die("Erro na conexão à base de dados:" .mysqli_connect_error());
}
