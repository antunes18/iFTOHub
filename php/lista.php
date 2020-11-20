<?php
session_start();
require 'conexao.php';
global $pdo;

$sql = "SELECT * FROM iftohub.autorprojeto WHERE Status = 0";
$sql = $pdo->prepare($sql);
$sql->execute();

$numeropendente = $sql->rowCount();
$sql1 = Array();

// for($i = 1; $i <= $numeropendente; $i++) {
//   $sql2 = "SELECT MIN(idProjeto) FROM iftohub.autorprojeto WHERE Status = 0 and AddLista = 'nao'";
//   $sql2 = $pdo->prepare($sql2);
//   $sql2->execute();
//   $dado = $sql2->fetch();
//   $idProjeto = $dado['MIN(idProjeto)'];
  
//   $sql1[$i] = "UPDATE iftohub.autorprojeto SET AddLista = 'sim' WHERE idProjeto = $idProjeto";
//   $consulta = $sql1[$i];
//   $pdo->prepare($consulta);
//   $pdo->query($consulta);

//   echo "$idProjeto";
// }
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
  <template id="ItemTemplate">
    <li data-todo-id="1">
      <div class="projeto-item">
        <p id="projetoItemTitle" class="projeto-item-title">AUTOR DO PROJETO - TÍTULO DO PROJETO</p>
        <div class="projeto-item-actions">
          <button id="confirmarProjeto" class="btn btn-success"><i class="fas fa-check"></i></button>
        </div>
      </div>
    </li>
  </template>
  <main>
    <section>
      <div class="container">
        <h1>Lista de projetos</h1>
        <h2>Pendentes:</h2>
        <ul id="lista-projeto" class="lista-projeto">
        </ul>
      </div>
    </section>
  </main>
    <script type="module" src="../js/projetoPendente.js"></script>
    <!-- <script src="../js/sample-solution.js"></script> -->
</body>