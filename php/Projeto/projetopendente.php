<?php
session_start();
?>

  <!DOCTYPE html>
  <html lang="pt-br">
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Projeto em Análise</title>
      <link rel="icon" href="../../logoifhub.png">
      <link href="../../css/bootstrap.min.css" rel="stylesheet">
      <link href="../../css/album.css" rel="stylesheet">
      <link rel="stylesheet" href="../../css/style.css">
      <link rel="icon" href="../../img/logoifhub.png">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css"/>
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
      <main role="main">
          <div class="jumbotron text-center">
              <h1 class="display-4 animate__heartBeat">Ops!</h1>
              <p class="lead">Verificamos que você já possui um <b>projeto em análise.</b></p>
              <p class="lead">Enviaremos um e-mail quando inserirmos seu projeto no site!</p>
              <hr class="my-4">
          <div class="mt-3">
              <a class="btn btn-lg" href="../index.php" role="button" title="Página inicial">Voltar para a página inicial</a>
          </div>
          </div>
      </main>
  </body>
  </html>