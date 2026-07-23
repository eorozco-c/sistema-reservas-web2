<?php
$servidor = "localhost";
$usuario = "root"; // Cambia si usas otro usuario
$password = "";    // Cambia si tienes contraseña configurada
$basedatos = "AGENCIA";

// Crear conexión
$conn = new mysqli($servidor, $usuario, $password, $basedatos);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
// La conexión está lista para ser incluida en otros archivos
?>