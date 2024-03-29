<?php 
  session_start(); 

  if (!isset($_SESSION['nombre'])) {
  	$_SESSION['msg'] = "You must log in first";
  	header('location: login.php');
  }
  if (isset($_GET['logout'])) {
  	session_destroy();
  	unset($_SESSION['username']);
  	header("location: login.php");
  }
?>
<!DOCTYPE html>
<html>
<head>
	<title>Index</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<div class="header">
	<h2>Pagina Principal</h2>
</div>
<div class="content">
  	<!-- Notificacion -->
  	<?php if (isset($_SESSION['success'])) : ?>
      <div class="error success" >
      	<h3>
          <?php 
          	echo $_SESSION['success']; 
          	unset($_SESSION['success']);
          ?>
      	</h3>
      </div>
  	<?php endif ?>

    <!-- Logueado con la info del usuario -->
    <?php  if (isset($_SESSION['nombre'])) : ?>
    	<p>Bienvenido <strong><?php echo $_SESSION['nombre']; ?></strong></p>
    	<p> <a href="index.php?logout='1'" style="color: red;">Cerrar sesion</a> </p>
    <?php endif ?>
</div>
		
</body>
</html>