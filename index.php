<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" href="css/styles.css">
        <style type="text/css">
           .col-sm-offset-4{margin-top:5%}
        </style>
        <title>Blog</title>
    </head>
<body>    
    <?php if(isset($_GET['error'])){
            $error = base64_decode($_GET['error']);            
            echo "<div class='alert alert-danger'><center>".$error."</center></div>";
        }       
    ?>
    <?php if(isset($_GET['ok'])){
            $ok = base64_decode($_GET['ok']);            
            echo "<div class='alert alert-success'><center>".$ok."</center></div>";
        }       
    ?>
    <div class="col-sm-4 col-sm-offset-4">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <center><h3>Pagina de entrada</h3></center>
            </div>
            <div class="panel-body">
                <form action="index.php" method="post">
                    <p class="input-group">
                        <span class="input-group-addon">Usuario</span>
                        <input type="text" class="form-control" type="text" maxlength="12" name="user" autofocus="true" placeholder="Introduce usuario"/>
                    </p>
                    <p class="input-group">
                        <span class="input-group-addon">Contraseña</span>
                        <input type="password" maxlength="12" name="pass" placeholder="Introduce contraseña" class="form-control"/>
                    </p>                   
                    
                    <button type="submit" name="Enviar" class="btn btn-primary"/>Entrar</button>
                    <button type="submit" name="Registrar" class="btn btn-primary"/><a href='registro.php'>Registrar</button>                
                </form>
            </div>        
        </div>
    </div>
    
</body>
</html>

<?php
    /**
     * index.php PAntalla de entrada a la aplicación
     */
            if (isset($_POST["Enviar"])){
                
                $user=trim($_POST["user"]); //El trim elimina espacios
                $contra=trim($_POST["pass"]);
            
                try{
                    include_once 'config.php'; //Con esto cogemos lo que haya en config.php y lo incorporo aquí                    
                    $usuarioSQL = $dbh->prepare("select idUsuario from usuarios where usuario=:usuario and password=:password");
                    $usuarioSQL->bindValue(':usuario', $user, PDO::PARAM_STR);//El param_STR sirve para decir que es un string lo que le entra
                    $usuarioSQL->bindValue(':password', $contra,PDO::PARAM_STR); 
                    $usuarioSQL->execute();
                    
                    $usuario = $usuarioSQL->fetch(); //fetch devuelve el primer resultado de la consulta anterior
                    if($usuario){
                        //echo "<div class='alert alert-success'>El usuario o la contraseña son correctos</div>";
                        $error = "El usuario o la contraseña son correctos";
                    }
                    else{
                        $error = "El usuario o la contraseña son incorrectos";
                        $error = base64_encode($error);
                        header('Location: index.php?error='.$error);
                    }
                }
                catch (PDOException $e){
                    $error = "Ha ocurrido un problema al acceder a la base de datos";
                    $error = base64_encode($error);
                    header('Location: index.php?error='.$error);
                    
                }               
            }
        ?>
