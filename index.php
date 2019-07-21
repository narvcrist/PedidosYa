<?php
	
	$alert='';
	session_start();
	if(!empty($_SESSION['active']))
	{
		header('location: sistema/');
	}else{
		if(!empty($_POST))
		{
			if(empty($_POST['usuario']) || empty($_POST['clave']))
			{
				$alert='Ingrese sus credenciales';
			
			}else{
				require_once('conexion.php');
			
			$user= $_POST['usuario'];
			$pass= $_POST['clave'];
			//$query= mysqli_query($conection,"SELECT *FROM usuario WHERE usu_usuario= '$user' AND usu_password= $pass'");
			//$result = mysqli_num_rows($query);
			//	if($result > 0){
			

			//$conection=mysqli_connect("localhost","root","","sistemapedidos");
			$conection=mysqli_connect("remotemysql.com","vN3T9N3HJT","65oLG7iRbU","vN3T9N3HJT");
			$consulta="SELECT * FROM usuario WHERE usu_correo='$user' and usu_password='$pass'";
			
			$resultado=mysqli_query($conection,$consulta);
			mysqli_close($conection);
			$filas=mysqli_num_rows($resultado);
			if($filas > 0)
				{
				$data = mysqli_fetch_array($resultado);
				$_SESSION['active']= true;
				$_SESSION['Usu_id']= $data['usu_id'];
				$_SESSION['usuario']= $data['usu_nombre'];
				$_SESSION['user']= $data['usu_usuario'];
				$_SESSION['rol']= $data['id_rol'];
				header('location: sistema/');
				}else{
					$alert='Correo o clave estan incorrectas';
					session_destroy();
			}
		}	
		
	}
}	
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
<nav class="navbar navbar-light bg-light">
  <span class="navbar-brand" href="#">
    <img src="sistema/img/logo.png" width="30" height="30" class="d-inline-block align-top" alt="">
    Pedidos Ya!
  </span>
</nav>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="css/estilo.css" rel="stylesheet" type="text/css">
</head>
<body>

	<form class="ingresar" action="" method="post">
        <h2>Iniciar sesión</h2> 
        <input  class="campo1" id="email" type="email" name="usuario" placeholder="Usuario" >
        <input  class="campo" id="clave" type="password" name="clave" placeholder="Contraseña" >
		<div class="alert"><?php echo isset($alert)? $alert :''; ?></div>
		<div class="col-12 text-right">
			<input type="submit" value="Iniciar sesión">
        </div>
    </form>
</body>
</html>