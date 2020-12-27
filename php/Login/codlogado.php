<?php
session_start();

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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../logoifhub.png">
    <link href="../../css/bootstrap.min.css" rel="stylesheet">
    <link href="../../css/album.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="icon" href="../../img/logoifhub.png">
</head>
<body>
<header>
    <div class="navbar navbar-dark bg-dark box-shadow">
        <div class="container d-flex justify-content-between">
          <a href="../index.php" class="navbar-brand d-flex align-items-center">
            <img src="../../img/logoifhub.png" alt="Logo iFTOHub" width="40px" height="40px">
            <strong title="Voltar para a página inicial">iFTOHub</strong>
          </a>
    </div>
</header>
<div class="jumbotron text-center">
    <form action="codlogado.php" method="POST">
        <label class="lead" for="codv">Digite o código de verificação aqui:</label><br>
        <input class="form-control w-50 m-auto" placeholder="Código de verificação..." type="text" name="codv" required>
        <input class="btn mt-3 w-25" type="submit" name="ok" value="Verificar">
    </form>
</div>
    <?php
    if(isset($msg) and isset($_POST['ok'])){
        if($msg == 1){
            echo "<p class='alert alert-success m-auto w-50 text-center lead' role='alert'>Código verificado com sucesso, redirecionando para a página de mudança de senha...</p>";
            header("Refresh: 5;url=http://localhost/iFTOhub/php/Login/mudarsenhalogado.php");
        }
        if($msg == 2){
            echo "<p class='alert alert-danger m-auto w-50 text-center lead'>O código digitado não coincide com o enviado ao e-mail.</p>";
        }
    }
    ?>
</body>
</html>