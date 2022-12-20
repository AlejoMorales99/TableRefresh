<?php
header('Access-Control-Allow-Origin: *'); 
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('https://parzibyte.me/blog/2018/12/26/codificar-decodificar-json-php/');

require_once("../models/consulta.php");


$consulta = new Conexion();

echo json_encode($consulta->Conexion());