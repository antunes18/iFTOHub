<?php
session_start();

if(isset($_SESSION['idUser'])){
  require '../conexao.php';
  global $pdo;
  $idautor = $_SESSION['idUser'];

  $sql = "SELECT Status FROM iftohub.autor WHERE idAutor = $idautor";
  $sql = $pdo->prepare($sql);
  $sql->execute();

  $dado = $sql->fetch();
  $status = $dado['Status'];

  if($status == 0){
    ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirme seu cadastro</title>
    <link rel="icon" href="../../logoifhub.png">
    <link href="../../css/bootstrap.min.css" rel="stylesheet">
    <link href="../../css/album.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="icon" href="../../img/logoifhub.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css"/>
</head>
<body>
    <?php

    if(!isset($_SESSION['idUser'])){
        header('Location: ../index.php');
    }
    ?>
    <header>
        <div class="navbar navbar-dark bg-dark box-shadow">
        <div class="container d-flex justify-content-between">
          <a href="../index.php" class="navbar-brand d-flex align-items-center">
            <img src="../../img/logoifhub.png" alt="Logo iFTOHub" width="40px" height="40px">
            <strong title="Voltar para a página inicial">iFTOHub</strong>
          </a>
        </div>
    </header>
    <main role="main">
        <div class="jumbotron text-center">
            <h1 class="display-4 animate__heartBeat">Ops...</h1>
            <p class="lead"><strong>Confirme sua conta</strong> acessando o link enviado ao seu e-mail para poder aproveitar ao máximo nosso site!</p>
            <hr class="my-4">
        <div class="mt-3">
            <a class="btn btn-lg" href="../index.php" role="button" title="Página inicial">Voltar para a página inicial</a>
        </div>
        </div>
    </main>
</body>
</html>
<?php
  }else{
      ?>
      <script>
      history.back();
      </script>
      <?php
  }
}
?>