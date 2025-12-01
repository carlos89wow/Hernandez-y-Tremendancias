<?php
session_start();
include("../config/db.php");

if (!isset($_SESSION["usuario_id"])) {
  header("Location: ../auth/login.php");
  exit;
}

$usuario_id = $_SESSION["usuario_id"];
$premio_id = $_POST["premio_id"];
$concursante_id = $_POST["concursante_id"];

$check = $conexion->query("
  SELECT * FROM votos_premios 
  WHERE usuario_id = $usuario_id AND premio_id = $premio_id
");

if ($check->num_rows == 0) {
  $conexion->query("
    INSERT INTO votos_premios (usuario_id, concursante_id, premio_id)
    VALUES ($usuario_id, $concursante_id, $premio_id)
  ");
}

header("Location: index.php");
exit;
