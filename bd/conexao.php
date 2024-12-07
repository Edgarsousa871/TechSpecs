<?php

$utilizador = 'root';
$pass = '';
$database = 'pap';
$host = 'localhost';

$mysqli = new mysqli($host, $utilizador, $pass, $database);

if($mysqli->error) {
    die("Falha ao conectar a base de dados. " . $mysqli->error); 
}
?>