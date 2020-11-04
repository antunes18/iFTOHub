<?php
$host="mysql:dbname=iftohub;host=localhost";
$usuario="root";
$pass="";

global $pdo;

try{
    //orientada a objetos com PDO
    $pdo = new PDO($host, $usuario, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e){
    echo "ERRO: ".$e->getMessage();
    exit;
}

?>