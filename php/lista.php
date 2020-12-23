<?php
session_start();
require 'conexao.php';
require_once('../src/PHPMailer.php');
require_once('../src/SMTP.php');
require_once('../src/Exception.php');
global $pdo;

        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\SMTP;
        use PHPMailer\PHPMailer\Exception;

        $maill = new PHPMailer(true);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Projetos Pendentes</title>
  <link rel="icon" href="../img/logoifhub.png">
  <link href="../css/bootstrap.min.css" rel="stylesheet">
  <script src="../js/jquery-3.2.1.slim.min.js"></script>
  <link href="../css/album.css" rel="stylesheet">
  <link rel="stylesheet" href="../css/lista.css">
  <link rel="stylesheet" href="../css/style.css">
  <script src="https://kit.fontawesome.com/be43ae3ae0.js"></script>
  <style>
    .btn {
      background-color: #19882c;
      color: #ffffff;
    }
    #btnr {
      background-color: #FF0000;
      color: #ffffff;
    }
    .selecoesvx{
      
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

    ?>
    <main>
    <section>
      <div class="container">
        <h1>Lista de projetos</h1>
        <h2>Pendentes:</h2>
    <?php

    $contarprojetos = 0;

    while($contagempendente = $sql->fetch(PDO::FETCH_ASSOC)){
      $sql3 = "SELECT Titulo FROM iftohub.projeto WHERE idProjeto = " . $contagempendente['idProjeto'];
      $projetoautor = $pdo->prepare($sql3);
      $projetoautor->execute();
      $dadop = $projetoautor->fetch();
      $projeto = $dadop['Titulo'];
      $name = "id" . $contagempendente['idProjeto'];
      echo "
      <form class='form-signin' method='POST' action='lista.php'>
      <div class='card'>
      <div class='card-body'>
      <input type='checkbox' name='projetos[]' value='$name'> " . $projeto . " - ";

      $sql2 = "SELECT NomeAutor FROM iftohub.autor WHERE idAutor = " . $contagempendente['idAutor'];
      $nomeautor = $pdo->prepare($sql2);
      $nomeautor->execute();
      $dado = $nomeautor->fetch();
      $nome = $dado['NomeAutor'];
      echo $nome . "</input>";

      $contarprojetos ++;

      if($contarprojetos > 0){
        echo "<input  class='btn' type='submit' name ='confirmou' value='V'>";
        ?>
        &emsp;
        <?php
        echo "<input  class='btn' id='btnr' type='submit' name ='reprovou' value='X'>
        </div>
        </div>
        <br>";
        echo "</form>";
      }
    }
  ?>
        <?php
        $consulta = "SELECT * FROM iftohub.autorprojeto WHERE Status = 0 ORDER BY idProjeto ASC";
        $consulta = $pdo->prepare($consulta);
        $consulta->execute();

        $dadoconsulta = $consulta->fetch();
        $existe = $dadoconsulta['idProjeto'];

         if($existe == null){
           echo "Não há nenhum projeto pendente.";
         }

         // CASO O ADM CONFIRME OS PROJETOS, ESSA AÇÃO SERÁ EXECUTADA:
         if(isset($_POST['confirmou'])){
          $sql6 = "SELECT * FROM iftohub.autorprojeto WHERE Status = 0 ORDER BY idProjeto ASC";
          $sql6 = $pdo->prepare($sql6);
          $sql6->execute();

          while($contagempendente2 = $sql6->fetch(PDO::FETCH_ASSOC)){
            $idprojeto = $contagempendente2['idProjeto'];
            $idautor = $contagempendente2['idAutor'];

            foreach($_POST['projetos'] as $projetos){
            if(isset($_POST["projetos"]) && "id" . $contagempendente2['idProjeto'] == $projetos){
              if($pdo->query("UPDATE iftohub.autorprojeto SET Status='1' WHERE idProjeto = $idprojeto")){
                echo "sucesso";
              }
              if($pdo->query("UPDATE iftohub.autor SET StatusProjeto='0' WHERE idAutor = $idautor")){
                
                $sql4 = "SELECT Email from iftohub.autor WHERE idAutor = $idautor";
                $sql4 = $pdo->prepare($sql4);
                $sql4->execute();

                $dado = $sql4->fetch();
                $emaill = $dado['Email']; 

                $sql5 = "SELECT Titulo FROM iftohub.projeto WHERE idProjeto = $idprojeto";
                $projetoautor = $pdo->prepare($sql5);
                $projetoautor->execute();
                $dadop = $projetoautor->fetch();
                $projeto = $dadop['Titulo'];
                
                try{
                  //$maill->SMTPDebug = SMTP::DEBUG_SERVER;
                  $maill->isSMTP();
                  $maill->Host = 'smtp.gmail.com';
                  $maill->SMTPAuth = true;
                  $maill->Username ='hubifto@gmail.com';
                  $maill->Password ='23112019';
                  $maill->SMTPOptions = array(
                    'ssl' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true
                    )
                );
                  $maill->Port = 587;
          
                  $maill->setFrom('hubifto@gmail.com');
                  $maill->addAddress($emaill);
          
                  $maill->isHTML(true);
                  $maill->Subject = 'Projeto Aprovado no site iFTOHub!';
                  $maill->Body = "Solicitação de inserção do projeto de título: <b>$projeto</b> aprovada em nosso site, você já consegue visualizá-lo acessando a página inicial do iFTOHub. Além disso, sua conta já está liberada para solicitar uma nova inserção de projeto!<br/><br/>";
                  $maill->AltBody = "Solicitação de inserção do projeto de título: <b>$projeto</b> aprovada em nosso site, você já consegue visualizá-lo acessando a página inicial do iFTOHub. Além disso, sua conta já está liberada para solicitar uma nova inserção de projeto!<br/><br/>";
                  $maill->send();
          
                  header('Location: lista.php');
                  } catch (Exception $e){
                  echo "Erro ao enviar mensagem: {$maill->ErrorInfo}";
                  } 
              }
            }
          }
        }
         }

        // CASO O ADM REPROVE OS PROJETOS ESSA AÇÃO SERÁ EXECUTADA:
        if(isset($_POST['reprovou'])){
          $sql6 = "SELECT * FROM iftohub.autorprojeto WHERE Status = 0 ORDER BY idProjeto ASC";
          $sql6 = $pdo->prepare($sql6);
          $sql6->execute();
          while($contagempendente2 = $sql6->fetch(PDO::FETCH_ASSOC)){
            $idprojeto = $contagempendente2['idProjeto'];
            $idautor = $contagempendente2['idAutor'];

            $sql5 = "SELECT Titulo FROM iftohub.projeto WHERE idProjeto = $idprojeto";
            $projetoautor = $pdo->prepare($sql5);
            $projetoautor->execute();
            $dadop = $projetoautor->fetch();
            $projeto = $dadop['Titulo'];

            foreach($_POST['projetos'] as $projetos){
              if(isset($_POST["projetos"]) && "id" . $contagempendente2['idProjeto'] == $projetos){
              if($pdo->query("DELETE FROM iftohub.autorprojeto WHERE idProjeto = $idprojeto")){
                echo "sucesso";
              }
              else{
                echo "fracasso";
              }
              if($pdo->query("DELETE FROM iftohub.projeto WHERE idProjeto = $idprojeto")){
                echo "sucesso";
              }
              else{
                echo "fracasso";
              }
              if($pdo->query("UPDATE iftohub.autor SET StatusProjeto='0' WHERE idAutor = $idautor")){
                
                $sql4 = "SELECT Email from iftohub.autor WHERE idAutor = $idautor";
                $sql4 = $pdo->prepare($sql4);
                $sql4->execute();

                $dado = $sql4->fetch();
                $emaill = $dado['Email']; 
                
                try{
                  //$maill->SMTPDebug = SMTP::DEBUG_SERVER;
                  $maill->isSMTP();
                  $maill->Host = 'smtp.gmail.com';
                  $maill->SMTPAuth = true;
                  $maill->Username ='hubifto@gmail.com';
                  $maill->Password ='23112019';
                  $maill->SMTPOptions = array(
                    'ssl' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true
                    )
                );
                  $maill->Port = 587;
          
                  $maill->setFrom('hubifto@gmail.com');
                  $maill->addAddress($emaill);
          
                  $maill->isHTML(true);
                  $maill->Subject = 'Projeto Reprovado no site iFTOHub!';
                  $maill->Body = "Solicitação de inserção do projeto de título: <b>$projeto</b> reprovada em nosso site, quando isto acontece, provavelmente o arquivo que nos enviou não se tratava de um projeto. Você já consegue inserir um novo projeto no site!<br/><br/>";
                  $maill->AltBody = "Solicitação de inserção do projeto de título: <b>$projeto</b> reprovada em nosso site, quando isto acontece, provavelmente o arquivo que nos enviou não se tratava de um projeto. Você já consegue inserir um novo projeto no site!<br/><br/>";
                  $maill->send();
          
                  header('Location: lista.php');
                  } catch (Exception $e){
                  echo "Erro ao enviar mensagem: {$maill->ErrorInfo}";
                  } 
              };
            }
          }
         }
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