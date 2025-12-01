<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registro</title>
  <link rel="stylesheet" href="../css/estilo.css">
</head>
<body>

<header>
  <h1>Registro</h1>
</header>

<div class="container">
  <div class="card">
    <form action="guardar_registro.php" method="POST">
      <input type="text" name="nombre" placeholder="Nombre" required>
      <input type="text" name="usuario" placeholder="Usuario" required>
      <input type="password" name="password" placeholder="Contraseña" required>
      <button class="btn">Registrarse</button>
    </form>
  </div>
</div>

</body>
</html>
