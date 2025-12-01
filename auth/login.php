<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link rel="stylesheet" href="../css/estilo.css">
</head>
<body>

<header>
  <h1>Iniciar Sesión</h1>
</header>

<div class="container">
  <div class="card">
    <form action="validar.php" method="POST">
      <input type="text" name="usuario" placeholder="Usuario" required>
      <input type="password" name="password" placeholder="Contraseña" required>
      <button class="btn">Entrar</button>
    </form>
  </div>
</div>

</body>
</html>
