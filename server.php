<?php
session_start();

// Inicializar variables
$username = "";
$email    = "";
$errors = array(); 

// Conectar a la base de datos
$db = mysqli_connect('localhost', 'root', '', 'seguridad');

// Registro de usuario
if (isset($_POST['reg_user'])) {
  //Esto evita un ataque tipo SQL Injection al restringir los caracteres especiales en los campos
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

  // Validación de datos en registro ...
  // añadiendo (array_push())correspondiente al arreglo $errors
  if (empty($username)) { array_push($errors, "Se requiere un nombre de usuario"); }
  if (empty($email)) { array_push($errors, "Se requiere un Email"); }
  if (empty($password_1)) { array_push($errors, "Se requiere una contraseña"); }
  if ($password_1 != $password_2) {
	array_push($errors, "Las contraseñas no coinciden");
  }

  // Validar contraseña
  $mayusculas = preg_match('@[A-Z]@', $password_1);
  $minusculas = preg_match('@[a-z]@', $password_1);
  $numero    = preg_match('@[0-9]@', $password_1);
  $espcaracteres = preg_match('@[^\w]@', $password_1);
  if(!$mayusculas || !$minusculas || !$numero || !$espcaracteres || strlen($password_1) < 8) {
    array_push($errors, "La contraseña debe tener como minimo 8 caracteres de longitud y debe incluir al menos una mayúscula, un numero, y un caracter especial.");
}

  // Primero revisar la base de datos para asegurarse 
  // que un usuario no tenga usuario o email repetidos
  $user_check_query = "SELECT * FROM usuarios WHERE nombre='$username' OR email='$email' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
  if ($user) { // Si el usuario existe
    if ($user['nombre'] === $username) {
      array_push($errors, "Ese nombre ya existe");
    }

    if ($user['email'] === $email) {
      array_push($errors, "Ese correo ya esta en uso");
    }
  }

  // Finalmente, registra si no hubieron errores en el formulario
  if (count($errors) == 0) {

    //TODO: Modificar el algoritmo
    $password = password_hash($password_1, PASSWORD_DEFAULT); //Usando bcrypt
  	//$password = md5($password_1);//Encripta la contraseña antes de guardarla

  	$query = "INSERT INTO usuarios (nombre, email, password) 
  			  VALUES('$username', '$email', '$password')";
  	mysqli_query($db, $query);
  	$_SESSION['nombre'] = $username;
  	$_SESSION['success'] = "Iniciaste sesion";
  	header('location: index.php');
  }
}




//Para el login
if (isset($_POST['login_user'])) {
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = mysqli_real_escape_string($db, $_POST['password']);
  
    if (empty($username)) {
        array_push($errors, "Se requiere un nombre de usuario");
    }
    if (empty($password)) {
        array_push($errors, "Se requiere una contraseña");
    }
  
    if (count($errors) == 0) {
        $password = md5($password);
        $query = "SELECT * FROM usuarios WHERE nombre='$username' AND password='$password'";
        $results = mysqli_query($db, $query);
        if (mysqli_num_rows($results) == 1) {
          $_SESSION['nombre'] = $username;
          $_SESSION['success'] = "Iniciaste sesion";
          header('location: index.php');
        }else {
            array_push($errors, "Nombre de usuario o contraseña incorrectos");
        }
    }
  }
  
  ?>