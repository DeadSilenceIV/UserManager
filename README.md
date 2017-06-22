# UserManager
Simple system for login and registration of users in PHP

# Manager Class
 **UserManager($host_name,$db_name,$db_user,$db_password)** (If the database placed in the instance does not exist, it will be created automatically, the tables are created automatically)

# Methods
Manager Class:
  - **createUser($username,$password)** - Create a new User in the database
  - **validateUser($username,$password)** - Validate the user and returns true or false 
  - **existsUser($username)** - Check if the user exists and returns true or false
# Installation
drag and drop Mysql.php and UserManager.php in the folder of your project
# Login Example
```
<?php session_start();
require 'UserManager.php';
if(isset($_SESSION['usuario'])){
    header('Location: index.php');
}
$errores = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$usuario = filter_var(strtolower($_POST['usuario']), FILTER_SANITIZE_STRING);
	$password = $_POST['password'];
	$password = hash('sha512', $password);
	if(empty($usuario) or empty($password)){
		 $errores .= 'Porfavor rellena todo los campos';
	}else{
		$UserManager = new UserManager('localhost','practica','root','');
		$validacion = $UserManager->validateUser($usuario,$password);
		if ($validacion == true) {
			$_SESSION['usuario'] = $usuario;
			header('Location: index.php');
		} else {
			$errores .= '<li>Datos Incorrectos</li>';
		}
	}
}
require 'views/login.view.php';
?>
```
# Register example
```
<?php session_start();
require 'UserManager.php';
if(isset($_SESSION['usuario'])){
    header('Location: contenido.php');
}
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $UserManager = new UserManager('localhost','practica','root','');
    $errores = '';
    $usuario = strtolower(filter_var($_POST['usuario'],FILTER_SANITIZE_STRING));
    $password = $_POST['password'];
    $password2 = $_POST['password2'];
    if(empty($usuario) or empty($password) or empty($password2)){
        $errores .= 'Porfavor rellena todo los campos';
    }
    $existencia = $UserManager->existsUser($usuario);
    if($existencia == true){
        $errores .= 'Ya existe un usuario con tu nombre'; 
    }
    $password = hash('sha512',$password);
    $password2 = hash('sha512',$password2);
    if($password != $password2){
        $errores .= 'Las contraseñas con conciden';
    }
    if(empty($errores)){
        $crear = $UserManager->createUser($usuario,$password);
        header('Location: login.php');
    }
}
require 'views/registrate.view.php';
?>
```

