<?php
$host = "localhost";
$db = "arcanebiblio";
$user = "root";
$pass = "";

$mysqli = new mysqli($host, $user, $pass, $db);
if($mysqli->connect_errno){
    die("Falha na conexao com o banco de dados!");
}
