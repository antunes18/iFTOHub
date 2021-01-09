<?php
session_start();

if(!isset($_SESSION['idUser'])){
  header('Location: ../Login/avisologar.php');
}
if(isset($_SESSION['idUser'])){
  require '../conexao.php';
  global $pdo;
  $idautor = $_SESSION['idUser'];

  //Verificando se o usuário confirmou a conta
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
  <meta http-equiv="Content-Language" content="pt-br">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Projeto</title>
  <link rel="icon" href="../../img/logoifhub.png">
  <link href="../../css/bootstrap.min.css" rel="stylesheet">
  <link href="../../css/album.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Spartan&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
  <link rel="stylesheet" href="../../css/style.css">
  <style>
    .error {
        color:#856404; 
        background-color:#fff3cd;
        border-color: #bfff;
        position:relative;
        padding:.50rem 1.25rem;
        margin-bottom:0.25rem;
        border:1px solid transparent;
        border-radius:.25rem;
      }
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
                <li><a href="../Contato/contato.php" class="text-white">Falar com os administradores</a></li>
              </ul>
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
              <h1 class="jumbotron-heading">Deseja colocar seu projeto no site?</h1>
              <p class="lead text-muted">Preencha os campos abaixo</p>
            </div>
          </section>
          <form action="processaprojeto.php" method="post" class="form-group" enctype="multipart/form-data" id="form-projeto" autocomplete = "off">
          <?php
            if(isset($_SESSION['uploadtrue'])){
            if($_SESSION['uploadtrue']==true){
            ?>
            <div class="alert alert-success" role="alert">
              Projeto enviado com sucesso :-D!
            </div>
            <?php
            }}
            unset($_SESSION['uploadtrue']);
            if(isset($_SESSION['uploaderror'])){
            if($_SESSION['uploaderror']==true){
            ?>
          <?php
            }}
            unset($_SESSION['uploaderror']);
          ?>
            <div class="form-group">
                <label for="InputTitulo">Título:</label>
                <input type="text" name="tituloprojeto" id="titulo-projeto" class="form-control" required> 
            </div>
            <div class="form-group">
                <label for="InputOrien">Orientador(a):</label>
                <input type="text" name="orientador" id="Orientador" class="form-control" required> 
            </div>
            <div class="form-group">
                <label for="InputOrien">Coorientador(a):</label>
                <input type="text" name="coorientador" id="Coorientador" class="form-control"> 
            </div>
            <div class="form-group">
                <label for="anop">Ano:</label>
                <input type="number" name="anop" id="anop" class="form-control" required min="2008" max="2021" step="1" > 
            </div>
            <div class="form-group">
                <label for="aconhe">Área do conhecimento:</label>
                <select class="form-control" name="aconhe" id="aconhe" required>
                    <option value="null" selected disabled>Do que se trata?</option>
                    <option value="cet">CIÊNCIAS EXATAS E DA TERRA</option> 
                    <option value="cb">CIÊNCIAS BIOLÓGICAS</option>
                    <option value="eng">ENGENHARIAS</option>
                    <option value="cs">CIÊNCIAS DA SAÚDE</option>
                    <option value="ca">CIÊNCIAS AGRÁRIAS</option>
                    <option value="csa">CIÊNCIAS SOCIAIS APLICADAS</option>
                    <option value="ch">CIÊNCIAS HUMANAS</option>
                    <option value="lla">LINGUÍSTICA, LETRAS E ARTES</option>
                    <option value="mul">MULTIDISCIPLINAR</option>
                </select>
            </div>
            <div class="form-group">
                <label for="artigopdf">Documento (em .pdf):</label>
                <div>
                  <input type="file" class="form-control" name="artigopdf" id="artigopdf" accept="application/pdf" required autocomplete = "off">
                </div>
            </div>
            <div class="text-center mt-4">
              <button class="btn btn-lg btn-primary" type="submit" title="Enviar projeto">Enviar</button>
              <button class="btn btn-lg btn-primary ml-4" type="reset" title="Limpar formulário">Limpar</button>
            </div>
          </form>
    </main>
    <script src="../../js/jquery-3.2.1.slim.min.js"></script>
    <script src="../../js/popper.min.js"></script>
    <script src="../../js/bootstrap.min.js"></script>
    <script src="../../js/holder.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.2/dist/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.2/dist/additional-methods.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
    <script src="../../js/projeto.js"></script>
</body>
</html>
<?php
  }else{
    header('Location: ../Cadastro/avisoconfirmar.php');
  }
}
?>