<?php
    $CFG = array(
        "db_host" => "localhost",
        "db_schema" => "blog_test",
        "db_usuario" => "userBBDD",
        "db_password" => "123456",
    );

     $dbh= new PDO('mysql:host='. $CFG['db_host'] .';dbname='. $CFG['db_schema'].';charset=utf8',$CFG['db_usuario'],$CFG['db_password']); 
     $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //Si hay algun error con el usuario saltala excepción
     $dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

