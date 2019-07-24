<?php
    session_start();
    if($_SESSION['rol'] !=1){
        header('location: ./');
    }
    require ("sendgrid-php/sendgrid-php.php");
    include "../conexion.php";
    if(!empty($_POST)){
        $alert='';
        if(empty($_POST['nombre']) || empty($_POST['correo']) || empty($_POST['usuario'])
        || empty($_POST['clave']) || empty($_POST['rol'])){
           
            $alert='<p class="mensage">Todos los campos son abligatorios</p>';
        }else{
            $nombre = $_POST['nombre'];
            $correo = $_POST['correo'];
            $user = $_POST['usuario'];
            $clave = $_POST['clave'];
            $rol = $_POST['rol'];

            $consulta= mysqli_query($conection,"SELECT *FROM usuario WHERE  usu_correo = '$correo'");
            $resultado = mysqli_fetch_array($consulta);

            if($resultado > 0){
                $alert='<p class="mensage" style=" color: #FFF; background: orange; text-align: center;  border-radius: 5px;  padding: 4px 15px;">El usuario ya existe</p>';
            }else{
                $consulta_insert = mysqli_query($conection,"INSERT INTO usuario(usu_nombre, usu_correo, usu_usuario, usu_password, id_rol)
                VALUES('$nombre','$correo','$user','$clave','$rol')");

                if($consulta_insert){
                    $alert='<p class="mensage" style=" color: #FFF; background: #60A756; text-align: center;  border-radius: 5px;  padding: 4px 15px;">Usuario registrado con éxito </p>';
               
                // Enviar mail 
                    //nombre, correo, clave, ..
                    $nombre = $_POST['nombre'];
                    $destinatario = $_POST['correo'];
                    $clave = $_POST['clave'];
                    $link = "https://pedidosya.herokuapp.com";
                    $asuntos = "Bienvenido a Pedidos Ya!";
                    
                    
                    $from = new SendGrid\Email(null, "pedidosya@info.com.ec");
                    $subject = "Bienvenido a Pedidos Ya!";
                    $to = new SendGrid\Email(null, "$destinatario");
                    
                    
                    $content = new SendGrid\Content("text/plain", "Hello, $nombre!
                    Tus credenciales de acceso: \n Usuario: $destinatario \n Contraseña: $clave, 
                    Para ingresar al Pedidos Ya! ingresa al siguiente link: $link
                    ");
                    $mail = new SendGrid\Mail($from, $subject, $to, $content);

                    $apiKey = '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';
                    $sg = new \SendGrid($apiKey);

                    $response = $sg->client->mail()->send()->post($mail);
                    //echo $response->statusCode();
                    //echo $response->headers();
                    //echo $response->body(); 
               
               
                }else{
                    $alert='<p class="mensage" style=" color: #FFF; background: red; text-align: center;  border-radius: 5px;  padding: 4px 15px;">Ocurrio un error al registrar al usuario</p>';
                }
            }
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
  <title>Registrar usuario</title>
  <?php include "estructura/estructura.php"; ?>
</head>
<body>
<?php include "estructura/header.php"; ?>
    <div class="bloque">
    <div class = "publicar">
    <h2>Registrar usuario</h2>
        <div class="card">
            
            </h5></strong></div>
            <div class="alerta"><?php echo isset($alert)? $alert : ''; ?></div>
            <div class="card-content p-2">
                <form class="ingresar" action="" method="post" data-role="validator" action="javascript:">
                    <div class="form-group">
                        <label for="nombre">Nombres y apellidos:</label>
                        <input type="text" name="nombre" placeholder="Ingresa tus nombres completos" data-validate="required" onkeypress="return soloLetras(event);"/>
                    </div>
                    <div class="form-group">
                        <label for="correo">Correo eléctronico:</label>
                        <input type="email" name="correo" placeholder="Correo eléctronico" data-validate="required email"/>
                        <span class="invalid_feedback">
                            Ingresa un correo electrónico válido
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="usuario">Nombre de usuario:</label>
                        <input type="text" name="usuario" placeholder="Usuario" data-validate="required"/>
                    </div>
                    <div class="form-group">
                        <label for="clave">Contraseña:</label>
                        <input type="password" name="clave" placeholder="Contraseña"  data-validate="minlength=8"/>
                        <span class="invalid_feedback">
                            La contraseña debe tener 8 caracteres o más!
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="rol">Rol de usuario:</label>
                        <?php
                            $consulta_rol = mysqli_query($conection, "SELECT *FROM rol");
                            $resultado_rol = mysqli_num_rows($consulta_rol);
                        ?>
                        <select name="rol" id='rol' class="unaVez" data-validate="required">

                            <?php
                                echo $option;
                                if ($resultado_rol > 0){
                                    while ($rol = mysqli_fetch_array($consulta_rol)){
                            ?>
                                    <option value="<?php echo $rol['rol_id']; ?>"><?php echo $rol['rol_nombre'] ?></option>
                            <?php    
                                    }
                                }
                            ?>
                        </select>
                    </div>
                    <br>
                    <div class="col-12 text-right">
                        <button class="button success">Registrar</button>
                    </div>
                </form>  
            </div>
        </div>
    </div>  
    </div>
</body>
</html>

