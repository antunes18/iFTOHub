<?php
require '../conexao.php';
global $pdo;

$h = $_GET['h'];

if(!empty($h)){
    $pdo->query("UPDATE iftohub.autor SET status='1' WHERE MD5(idAutor) = '$h'");

    echo "Cadastro confirmado com sucesso!";
}
?>