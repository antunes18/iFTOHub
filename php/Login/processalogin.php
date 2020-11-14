<?php
session_start();

if(isset($_POST['logemail']) && !empty($_POST['logemail']) && isset($_POST['logsenha']) && !empty($_POST['logsenha'])){
    
    require '../conexao.php';
    require 'Usuario.class.php';
    
    $u = new Usuario();

    $email = addslashes($_POST['logemail']);
    $senha = addslashes($_POST['logsenha']);

    if($u->login($email,$senha) == true){
        if(isset($_SESSION['idUser'])){
            header('Location: ../index.php');
        }else{
            header('Location: login.php');
            $_SESSION['erro'] = true;
        }
    }else{
        header('Location: login.php');
        $_SESSION['erro'] = true;
    }

}else{
    header('Location: login.php');
    $_SESSION['erro'] = true;
}

?>