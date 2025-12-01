<?php
session_start();
include("../config/db.php");

$usuario = $_POST["usuario"];
$password = $_POST["password"];

$consulta = $conexion->query(
  "SELECT * FROM usuarios WHERE usuario='$usuario'"
);

if ($consulta->num_rows == 1) {
  $user = $consulta->fetch_assoc();

  if (password_verify($password, $user["password"])) {
    $_SESSION["usuario_id"] = $user["id"];
    $_SESSION["nombre"] = $user["nombre"];
    header("Location: ../index.php");
    exit;
  }
}

echo "Usuario o contraseña incorrectos";
?>
