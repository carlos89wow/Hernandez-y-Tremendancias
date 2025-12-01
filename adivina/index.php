<?php
session_start();

if (!isset($_SESSION["usuario_id"])) {
  header("Location: ../auth/login.php");
  exit;
}

include("../config/db.php");

/* Obtener una pregunta activa */
$sql = "SELECT * FROM preguntas WHERE activa = 1 ORDER BY RAND() LIMIT 1";
$consulta = $conexion->query($sql);
$pregunta = $consulta->fetch_assoc();

/* Verificar si el usuario ya votó */
$usuario_id = $_SESSION["usuario_id"];
$yaVoto = false;

if ($pregunta) {
  $pid = $pregunta["id"];
  $check = $conexion->query(
    "SELECT * FROM votos WHERE usuario_id = $usuario_id AND pregunta_id = $pid"
  );

  if ($check->num_rows > 0) {
    $yaVoto = true;
  }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Adivina Quién</title>
  <link rel="stylesheet" href="../css/estilo.css">
</head>
<body>

<header>
  <h1>Adivina Quién</h1>
  <nav>
    <a href="../index.php">Inicio</a>
    <a href="../premios/index.php">Premiaciones</a>
    <a href="../auth/logout.php">Salir</a>
  </nav>
</header>

<div class="container">

  <?php if ($pregunta): ?>

    <div class="card">
      <h3><?= $pregunta["pregunta"] ?></h3>

      <?php if (!$yaVoto): ?>
        <form action="votar.php" method="POST">
          <input type="hidden" name="pregunta_id" value="<?= $pregunta["id"] ?>">

          <button class="opcion" name="opcion" value="1">
            A) <?= $pregunta["opcion1"] ?>
          </button>

          <button class="opcion" name="opcion" value="2">
            B) <?= $pregunta["opcion2"] ?>
          </button>

          <button class="opcion" name="opcion" value="3">
            C) <?= $pregunta["opcion3"] ?>
          </button>

          <button class="opcion" name="opcion" value="4">
            D) <?= $pregunta["opcion4"] ?>
          </button>

        </form>
      <?php else: ?>

        <p>✅ Ya votaste esta pregunta</p>

        <?php
        $res = $conexion->query("
          SELECT opcion_elegida, COUNT(*) AS total
          FROM votos
          WHERE pregunta_id = {$pregunta['id']}
          GROUP BY opcion_elegida
          ORDER BY total DESC
          LIMIT 1
        ");

        $ganador = $res->fetch_assoc();
        $opcionGanadora = "opcion" . $ganador["opcion_elegida"];
        ?>

        <h3>🏆 Respuesta más votada:</h3>
        <p><?= $pregunta[$opcionGanadora] ?></p>

      <?php endif; ?>

    </div>

  <?php else: ?>
    <div class="card">No hay preguntas activas.</div>
  <?php endif; ?>

</div>

</body>
</html>
