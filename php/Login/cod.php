<?php
session_start();

if(isset($_SESSION['idUser'])){
    header('Location: ../index.php');
  }

if(isset($_POST['ok'])){
$coddigitado = addslashes($_POST['codv']);

$codanalise = $_SESSION['codigoverificacao'];

if($coddigitado == $codanalise){
    $msg = 1;
    unset($_SESSION['codigoverificacao']);
}else{
    $msg = 2;
}
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Codigo de verificação</title>
</head>
<body>
    <form action="cod.php" method="POST">
        <label for="codv">Digite o código de verificação aqui:</label><br>
        <input placeholder="Código de verificação..." type="text" name="codv" required>
        <input type="submit" name="ok" value="Verificar">
    </form>

    <?php
    if(isset($msg) and isset($_POST['ok'])){
        if($msg == 1){
            echo "Código verificado com sucesso, redirecionando para a página de mudança de senha...";
            header("Refresh: 5;url=http://localhost/iFTOhub/php/Login/mudarsenha.php");
        }
        if($msg == 2){
            echo "O código digitado não coincide com o enviado ao e-mail.";
        }
    }
    ?>
</body>
</html>