<?php
session_start();

if(!isset($_SESSION['idUser'])){
  header('Location: ../Login/avisologar.php');
}
if(isset($_SESSION['idUser'])){
  require '../conexao.php';
  global $pdo;
  $idautor = $_SESSION['idUser'];

  $sql = "SELECT Status FROM iftohub.autor WHERE idAutor = $idautor";
  $sql = $pdo->prepare($sql);
  $sql->execute();

  $dado = $sql->fetch();
  $status = $dado['Status'];

  if($status == 1){
    if(!isset($_SESSION['idUser'])){

    }else{
      $idautor = $_SESSION['idUser'];

      $sql = "SELECT NomeAutor from iftohub.autor WHERE idAutor = $idautor";
      $sql = $pdo->prepare($sql);
      $sql->execute();
      $dado = $sql->fetch();
      $nomeuser = $dado['NomeAutor'];

      echo "
      <div class='clearfix'>
        <p id='welcome' class='float-left alert alert-success'>Bem-vind@, ". strtoupper($nomeuser) . "</p>
        <a id='exit' class='alert alert-dark float-right text-center' href='../Login/sair.php'>Sair</a>
      </div>";
      ?>
    <?php
    }
    ?>
    <!DOCTYPE html>
<!-- saved from url=(0050)https://getbootstrap.com/docs/4.0/examples/album/# -->
<html lang="pt-br">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="">
  <title>Contato</title>
  <link rel="icon" href="../../img/logoifhub.png">
  <link href="../../css/bootstrap.min.css" rel="stylesheet">
  <link href="../../css/album.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Spartan&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../../css/style.css">
  <style>
      #welcome {
      width: 80%;
      display:inline-block;
      margin-right: 0px;
      margin-left: 0px;
      outline:none; 
      border:none; 
      clear:none;
      margin: 0;   
    }
    #exit {
      width: 20%;
      display:inline-block;
      outline:none; 
      border:none; 
      text-decoration: none;
      clear:none;  
      margin: 0; 
    }
  </style>
</head>
<body>
  <header>
    <div class="collapse" id="navbarHeader">
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
                <li><a href="contato.php" class="text-white">Falar com os administradores</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      </div>
      <div class="navbar navbar-dark bg-dark box-shadow">
        <div class="container d-flex justify-content-between">
          <a href="../index.php" class="navbar-brand d-flex align-items-center">
            <img src="../../img/logoifhub.png" alt="Logo iFTOHub" width="40px" height="40px">
            <strong>iFTOHub</strong>
          </a>
          <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
        </div>
      </div>
    </header>
    <main role="main" class="container">
        <section class="jumbotron text-center">
            <div class="container">
              <h1 class="jumbotron-heading">Entre em contato conosco</h1>
              <p class="lead text-muted">Alguma dúvida, sugestão ou crítica?</p>
              <!-- <p>
                <a href="#" class="btn btn-primary my-2">Inserir projeto</a>
              </p> -->
            </div>
          </section>
          <?php
            if(isset($_SESSION['msgenviada'])){
            if($_SESSION['msgenviada'] == true){
            ?>
            <div class="alert alert-success text-center" role="alert">
              <p class="lead">Mensagem enviada com sucesso!</p>
              <p>Aguarde a resposta dos desenvolvedores no seu e-mail.</p>
            </div>
            <?php
            }
            }
            unset($_SESSION['msgenviada']);
            ?>
          <form action="processacontato.php" method="post" class="form-group">
            <div class="form-group">
                <label for="assunto">Assunto:</label>
                <select class="form-control" id="assunto" name="assunto" required>
                    <option value="null" select>Do que se trata?</option>
                    <option value="Dúvida">Dúvida</option> 
                    <option value="Sugestão">Sugestão</option>
                    <option value="Crítica">Crítica</option>
                    <option value="Outro">Outro</option>
                </select>
            </div>
            <div class="form-group">
                <label for="msg">Mensagem:</label>
                <textarea name="msg" class="form-control" cols="5" rows="5" required title="Digitar mensagem"></textarea>
            </div>
            <button type="submit" class="btn btn-lg btn-block" style="width: auto;" title="Enviar mensagem" name="envioucontato">Enviar</button>
          </form>
    </main>
    <script src="../../js/jquery-3.2.1.slim.min.js"></script>
    <script src="../../js/popper.min.js"></script>
    <script src="../../js/bootstrap.min.js"></script>
    <script src="../../js/holder.min.js"></script>
</body>
</html>
<?php
  }else{
    header('Location: ../Cadastro/avisoconfirmar.php');
  }
}
?>
