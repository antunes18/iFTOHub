<?php
session_start();
require 'conexao.php';
global $pdo;
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>iFTO Hub</title>
  <link rel="icon" href="../img/logoifhub.png">
  <link href="../css/bootstrap.min.css" rel="stylesheet">
  <script src="../js/jquery-3.2.1.slim.min.js"></script>
  <link href="../css/album.css" rel="stylesheet">
  <link rel="stylesheet" href="../css/lista.css">
  <script src="https://kit.fontawesome.com/be43ae3ae0.js"></script>
  <style>
    .btn {
      background-color: #19882c;
      color: #ffffff;
    }
  </style>
</head>
<body>
    <header>
        <div class="collapse mb-0" id="navbarHeader">
        <div class="container">
            <div class="row">
            <div class="col-sm-8 col-md-7 py-4">
                <h4 class="text-white">Sobre</h4>
                <p class="text-white">Esta aplicação web tem como objetivo patentear projetos científicos desenvolvidos no
                    Instituto Federal de Educação, Ciência e Tecnologia do Tocantins - IFTO. A
                    proposta é que todos os estudantes possam expor seus projetos tendo sido eles
                    aprovados ou não, formando um sistema que incentiva o crescimento do estudante
                    visionando um maior conhecimento e aprendizado do mesmo em relação à projetos
                    científicos, concluindo em fazer um repositório online para todo o corpo discente.</p>
                </div>
                <div class="col-sm-4 offset-md-1 py-4">
                <h4 class="text-white">Contato</h4>
                <ul class="list-unstyled">
                    <li><a href="Contato/contato.php" class="text-white">Falar com os administradores</a></li>
                </ul>
                </div>
            </div>
            </div>
        </div>
        <div class="navbar navbar-dark bg-dark box-shadow">
            <div class="container d-flex justify-content-between">
            <a href="index.php" class="navbar-brand d-flex align-items-center">
                <img src="../img/logoifhub.png" alt="Logo iFTOHub" width="40px" height="40px">
                <strong>iFTOHub</strong>
            </a>
            </div>
        </div>
    </header>
    <?php
    // Selecionando os registros
    $sql = "SELECT * FROM iftohub.autorprojeto WHERE Status = 0 ORDER BY idProjeto ASC";
    $sql = $pdo->prepare($sql);
    $sql->execute();

    while($contagempendente = $sql->fetch(PDO::FETCH_ASSOC)){
      $sql3 = "SELECT Titulo FROM iftohub.projeto WHERE idProjeto = " . $contagempendente['idProjeto'];
      $projetoautor = $pdo->prepare($sql3);
      $projetoautor->execute();
      $dadop = $projetoautor->fetch();
      $projeto = $dadop['Titulo'];
      echo "<template id='ItemTemplate'>
            <li data-todo-id='" . $contagempendente['idProjeto'] . "'>
            <div class='projeto-item'>
            <p id='projetoItemTitle' class='projeto-item-title'>" . $projeto . " - ";

      $sql2 = "SELECT NomeAutor FROM iftohub.autor WHERE idAutor = " . $contagempendente['idAutor'];
      $nomeautor = $pdo->prepare($sql2);
      $nomeautor->execute();
      $dado = $nomeautor->fetch();
      $nome = $dado['NomeAutor'];
      echo $nome . "</p>
            <div class='projeto-item-actions'>
            <button id='confirmarProjeto' class='btn btn-success'><i class='fas fa-check'></i></button>
            </div>
            </div>
            </li>
            </template>";
    }
  ?>
  <main>
    <section>
      <div class="container">
        <h1>Lista de projetos</h1>
        <h2>Pendentes:</h2>
        <?php
        $consulta = "SELECT * FROM iftohub.autorprojeto WHERE Status = 0 ORDER BY idProjeto ASC";
        $consulta = $pdo->prepare($consulta);
        $consulta->execute();

        $dadoconsulta = $consulta->fetch();
        $existe = $dadoconsulta['idProjeto'];

         if($existe == null){
           echo "Não há nenhum projeto pendente.";
         }
        ?>
        <ul id="lista-projeto" class="lista-projeto">
        </ul>
      </div>
    </section>
  </main>
    <script type="module" src="../js/projetoPendente.js"></script>
    <!-- <script src="../js/sample-solution.js"></script> -->
</body>