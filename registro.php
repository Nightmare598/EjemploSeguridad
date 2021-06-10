<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
  <title>Registro de Usuarios</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <div class="header">
  	<h2>Registro</h2>
  </div>
	
  <form method="post" action="registro.php">
  	<?php include('errors.php'); ?>
  	<div class="input-group">
  	  <label>Usuario</label>
  	  <input type="text" name="username" value="<?php echo $username; ?>">
  	</div>
  	<div class="input-group">
  	  <label>Email</label>
  	  <input type="email" name="email" value="<?php echo $email; ?>">
  	</div>
  	<div class="input-group">
  	  <label>Contraseña</label>
  	  <input type="password" name="password_1">
  	</div>
  	<div class="input-group">
  	  <label>Confirmar contraseña</label>
  	  <input type="password" name="password_2">
  	</div>
  	<div class="input-group">
  	  <button type="submit" class="btn" name="reg_user">Registrar</button>
  	</div>
  	<p>
  		¿Ya eres un miembro? <a href="login.php">Ingresar</a>
  	</p>
  </form>
</body>
</html>