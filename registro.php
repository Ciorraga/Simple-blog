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
    <div class="col-sm-4 col-sm-offset-4">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <center><h3>Registro de usuario</h3></center>
            </div>
            <div class="panel-body">
                <form class="form-horizontal" action="registro.php" method="post">
                    <div class="form-group">
                        <label for="labUser" class="col-sm-2 control-label" style="text-align:left;">Usuario</label>
                        <div class="col-sm-10">
                            <input type="text" name="user" class="form-control" id="inputUser" placeholder="Nombre de usuario">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="labPass" class="col-sm-2 control-label" style="text-align:left;">Password</label>
                        <div class="col-sm-10">
                            <input type="password" name="pass" class="form-control" id="inputPass" placeholder="Introduce password">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="labPass2" class="col-sm-2 control-label" style="text-align:left;">Password</label>
                        <div class="col-sm-10">
                            <input type="password" name="pass2" class="form-control" id="inputPass2" placeholder="Repite password">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="labEmail" class="col-sm-2 control-label" style="text-align:left;">E-Mail</label>
                        <div class="col-sm-10">
                            <input type="email" name="email" class="form-control" id="inputEmail" placeholder="Introduzca E-mail">
                        </div>
                    </div>
                    <div class="form-group" style="margin-left:10%;margin-top:5%;">
                        <label class="radio-inline">
                            <input type="radio" name="tipo" id="tipoComun" value="comun"> Común
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="tipo" id="tipoAdmin" value="admin"> Administrador
                        </label>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-sm-offset-4 col-sm-8">
                            <button type="submit" name="Registrar" class="btn btn-primary"/>Registrar</button>
                            <button type="reset" class="btn btn-default"/>Limpiar</button>   
                        </div>
                    </div>
                </form>
            </div>        
        </div>
    </div>
</body>
</html>

<?php
    if(isset($_POST['Registrar'])){
        $error = "";
        $nick = $_POST['user'];
        $pass = $_POST['pass'];
        $pass2 = $_POST['pass2'];
        $email = $_POST['email'];      
        $radio = $_POST['tipo'];
        
        if($nick==null || $pass==null || $pass2==null || $email==null || $radio==null){                    
            $error = "Debe rellenar todos los campos";
            $error = base64_encode($error);
            header('Location: registro.php?error='.$error);
        }    
        if($pass != $pass2){
            $error = "Las contraseñas no son iguales";
            $error = base64_encode($error);
            header('Location: registro.php?error='.$error);                
        } 
        
        try{
            include_once 'config.php';
        
            $nuevoSQL = $dbh->prepare('INSERT INTO usuarios (usuario,password,email,tipo) VALUES (:usuario, :password, :email, :tipo)');
            $nuevoSQL->bindValue(':usuario', $nick, PDO::PARAM_STR);
            $nuevoSQL->bindValue(':password', $pass, PDO::PARAM_STR);
            $nuevoSQL->bindValue(':email', $email, PDO::PARAM_STR);
            $nuevoSQL->bindValue(':tipo', $radio, PDO::PARAM_STR);
            $nuevoSQL->execute();

            $ok = "Usuario creado correctamente";
            $ok = base64_encode($ok);
            header('Location: index.php?ok='.$ok);
        }
        catch (PDOException $e){
            $error = "Ha ocurrido un problema al acceder a la base de datos";
            $error = base64_encode($error);
            header('Location: registro.php?error='.$error);
        }        
          
    }

?>