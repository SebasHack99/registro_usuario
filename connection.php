<?php
// Variables de creación para la conexión a la base de datos
$servidor = "127.0.0.1";
$usuario = "root";
$contrasena = "";
$baseDeDatos = "db_hic";

// Conexión a la base de datos
$enlace = mysqli_connect($servidor, $usuario, $contrasena, $baseDeDatos);

// Verificar la conexión
if (!$enlace) {
    die("Conexión fallida: " . mysqli_connect_error());
}
?>
