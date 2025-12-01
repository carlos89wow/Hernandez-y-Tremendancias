<?php
include("../config/db.php");

$nombre  = $_POST["nombre"];
$usuario = $_POST["usuario"];
$pass    = password_hash($_POST["password"], PASSWORD_DEFAULT);

$sql = "INSERT INTO usuarios (nombre, usuario, password)
        VALUES ('$nombre', '$usuario', '$pass')";

if ($conexion->query($sql)) {
  header("Location: login.php");
} else {
  echo "Error al registrar usuario";
}
?>
