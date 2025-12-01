<?php
session_start();
if (!isset($_SESSION["usuario_id"])) {
  header("Location: ../auth/login.php");
  exit;
}

include("../config/db.php");
$usuario_id = $_SESSION["usuario_id"];

$premios = $conexion->query("SELECT * FROM premios ORDER BY id");
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Premiaciones</title>
  <link rel="stylesheet" href="../css/estilo.css">
</head>
<body>

<header>
  <h1>Premiaciones</h1>
  <nav>
    <a href="../index.php">Inicio</a>
    <a href="../adivina/index.php">Adivina Quién</a>
    <a href="../auth/logout.php">Salir</a>
  </nav>
</header>

<div class="container">

<?php while ($p = $premios->fetch_assoc()): ?>
  <div class="card">
    <h2><?= $p["nombre"] ?></h2>
    <p><?= $p["descripcion"] ?></p>

    <!-- RANKING -->
    <h3>🏆 Van ganando:</h3>
    <?php
      $pid = $p["id"];
      $ranking = $conexion->query("
        SELECT c.nombre, COUNT(v.id) AS total
        FROM votos_premios v
        JOIN concursantes c ON v.concursante_id = c.id
        WHERE v.premio_id = $pid
        GROUP BY c.nombre
        ORDER BY total DESC
      ");

      if ($ranking->num_rows > 0):
        while ($r = $ranking->fetch_assoc()):
          echo "<p>✅ {$r["nombre"]} — {$r["total"]} votos</p>";
        endwhile;
      else:
        echo "<p>Aún no hay votos</p>";
      endif;
    ?>

    <hr>

    <!-- FORMULARIO -->
    <form action="votar_premio.php" method="POST">
      <input type="hidden" name="premio_id" value="<?= $pid ?>">

      <?php
        $concursantes = $conexion->query("
          SELECT * FROM concursantes WHERE premio_id = $pid
        ");
        while ($c = $concursantes->fetch_assoc()):
      ?>
        <label>
          <input type="radio" name="concursante_id" value="<?= $c["id"] ?>" required>
          <?= $c["nombre"] ?>
        </label><br>
      <?php endwhile; ?>

      <br>
      <button class="btn">Votar</button>
    </form>

  </div>
<?php endwhile; ?>

</div>

</body>
</html>
