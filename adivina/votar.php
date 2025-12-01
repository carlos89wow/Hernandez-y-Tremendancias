<?php
session_start();
include("../config/db.php");

if (!isset($_SESSION["usuario_id"])) {
  header("Location: ../auth/login.php");
  exit;
}

$usuario_id  = $_SESSION["usuario_id"];
$pregunta_id = $_POST["pregunta_id"];
$opcion      = $_POST["opcion"];

/* Evitar doble voto */
$check = $conexion->query(
  "SELECT * FROM votos WHERE usuario_id = $usuario_id AND pregunta_id = $pregunta_id"
);

if ($check->num_rows == 0) {
  $sql = "INSERT INTO votos (usuario_id, pregunta_id, opcion_elegida)
          VALUES ($usuario_id, $pregunta_id, $opcion)";
  $conexion->query($sql);
}

header("Location: index.php");
exit;
