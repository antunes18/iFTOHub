<?php
session_start();

if(isset($_SESSION['idUser'])){
  header('Location: avisologadocadastro.php');
}
else{
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <link href="https://fonts.googleapis.com/css?family=Spartan&display=swap" rel="stylesheet">
    <title>Cadastrar</title>
    <link rel="icon" href="../../img/logoifhub.png">
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/floating-labels.css">
    <link rel="stylesheet" href="../../css/style.css">
    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }
      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
      .error {
        color:#856404; 
        background-color:#fff3cd;
        border-color:#ffeeba;
        position:relative;
        padding:.75rem 1.25rem;
        margin-bottom:1rem;
        border:1px solid transparent;
        border-radius:.25rem;
      }
      .erro-cadastro {
        position: fixed;
        top: 0;
        width: 100%;
      }
    </style>
  </head>
  <body>
      <?php
      if(isset($_SESSION['cadassim'])){
        if($_SESSION['cadassim'] == true){
      ?>
      <div class="fixed-top text-center" role="alert">
        <div class="alert alert-success">
          <p class="lead font-weight-bold">Cadastro efetuado!</p>
          <p class="lead">Confirme sua conta acessando o link enviado ao seu e-mail.</p>
          <p class="lead">Vá para a página de login clicando <a href="../Login/login.php">aqui</a></p>
        </div>
      </div>
      <?php
        }
      }
      unset($_SESSION['cadassim']);
      ?>
      <?php
      if(isset($_SESSION['userexiste'])){
        if($_SESSION['userexiste'] == true){
      ?>
      <div class="erro-cadastro">
        <p class="alert alert-danger text-center" role="alert"><strong>O e-mail digitado já está em uso. Por favor, digite outro e tente novamente.</strong></p>
      </div>
      <?php
        }
      }
      unset($_SESSION['userexiste']);
      ?>
    <form class="form-signin" method="post" action="processa.php">
      <div class="text-center mb-4">
         <a href="../index.php" title="Voltar para página inicial">
          <img class="mb-4" src="../../img/logoifhub.png" alt="Logo iFTO Hub" width="72" height="72">
        </a>
        <h1 class="h3 mb-3 font-weight-normal">Cadastra-se! :-) </h1>
      </div>
      <div class="form-group">
        <span><img src="../../icons/person.svg" alt="person icon" height="32" width="32"></span>
        <label for="campoNome">Nome completo</label>
        <input type="text" name="nome" id="campoNome" class="form-control" style="text-transform: uppercase;" required autofocus title="Digite seu nome completo">
      </div>
    <div class="form-group">
      <span><img src="../../icons/envelope.svg" alt="email icon" height="32" width="32"></span>
      <label for="campoEmail">Email</label>
      <input type="email" name="email" id="campoEmail" class="form-control" required minlength="11" title="Digite seu e-mail">
    </div>
    <div class="form-group">
      <span><img src="../../icons/lock.svg" alt="password icon" height="32" width="32"></span>
      <label for="campoSenha">Senha</label>
      <input type="password" name="senha" id="campoSenha" class="form-control" required title="Digite uma senha">
    </div>
    <div class="form-group">
      <span><img src="../../icons/lock.svg" alt="password icon" height="32" width="32"></span>
      <label for="campoSenhaConfirma">Confirmar senha</label>
      <input type="password" name="confirma" id="campoSenhaConfirma" class="form-control" required title="Digite novamente a senha">
    </div>
    <div class="form-group">
      <span><img src="../../icons/house.svg" alt="campus icon" height="32" width="32"></span>
      <label for="campuss">Campus</label>
        <select class="form-control" name="campus" id="campuss" required title="Selecione sua unidade">
          <option value="null" disabled selected>Selecione seu <i>campus</i></option>
          <option value="Araguaina">Araguaína</option> 
          <option value="Araguatins">Araguatins</option>
          <option value="ColinasTocantins">Colinas do Tocantins</option>
          <option value="Dianopolis">Dianópolis</option>
          <option value="FormosoAraguaia">Formoso do Araguaia</option>
          <option value="Gurupi">Gurupi</option>
          <option value="Palmas">Palmas</option>
          <option value="LagoConfusao">Lagoa da Confusão</option>
          <option value="ParaisoTocantins">Paraíso do Tocantins</option>
          <option value="PedroAfonso">Pedro Afonso</option>
          <option value="PortoNacional">Porto Nacional</option>
        </select>
    </div>
  <button class="btn btn-lg  btn-block" type="submit" title="Confirmar cadastro" name="cadastrar">Cadastrar</button>
  <button  id="reset" class="btn btn-block" type="reset" title="Limpar formulário">Limpar</button>
  <p class="mt-5 mb-3 text-muted text-center">© 2020</p>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.2/dist/jquery.validate.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.2/dist/additional-methods.min.js"></script>
  <script src="../../js/register.js"></script>
</form>
</body>
</html>
<?php
}
?>