<?php
session_start();

include("../conexao.php");
require_once('../../src/PHPMailer.php');
require_once('../../src/SMTP.php');
require_once('../../src/Exception.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if(isset($_POST['ok'])){

$email = $_SESSION['emailuser'];
$novasenha = addslashes($_POST['senha']);

$sql1 = "SELECT Senha FROM iftohub.autor WHERE Email = '$email'";
$sql1 = $pdo->prepare($sql1);
$sql1->execute();

$dado = $sql1->fetch();
$senhaantiga = $dado['Senha'];

if(isset($email)  and isset($novasenha)){
  if(md5($novasenha) == $senhaantiga){
    $_SESSION['senhaigual'] = true;
  }else{
    $sql = "UPDATE iftohub.autor SET Senha = md5('$novasenha') WHERE Email = '$email'";
    $sql = $pdo->prepare($sql);
    if($sql->execute()){

        $mailms = new PHPMailer(true);

        try{
            //$mailms->SMTPDebug = SMTP::DEBUG_SERVER;
            $mailms->isSMTP();
            $mailms->Host = 'smtp.gmail.com';
            $mailms->SMTPAuth = true;
            $mailms->Username ='hubifto@gmail.com';
            $mailms->Password ='23112019';
            $mailms->SMTPOptions = array(
              'ssl' => array(
                  'verify_peer' => false,
                  'verify_peer_name' => false,
                  'allow_self_signed' => true
              )
          );
            $mailms->Port = 587;

            $mailms->setFrom('hubifto@gmail.com');
            $mailms->addAddress($email);

            $mailms->isHTML(true);
            $mailms->Subject = "Senha alterada no iFTOHub";
            $mailms->Body = "Olá, sua senha foi alterada no site iFTOHub após uma solicitação de redefinição de senha!";
            $mailms->AltBody = "Olá, sua senha foi alterada no site iFTOHub após uma solicitação de redefinição de senha!";
            if($mailms->send()){
                unset($_SESSION['emailuser']);
                $_SESSION['senharedefinida'] = true;
            }
            }
         catch (Exception $e){
            echo "Erro ao enviar mensagem: {$mailms->ErrorInfo}";
        }
      }
    }
}
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Redefinir Senha</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../img/logoifhub.png">
    <link href="../../css/bootstrap.min.css" rel="stylesheet">
    <link href="../../css/album.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="icon" href="../../img/logoifhub.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
    <style>
      #alternarSenha2 {
        cursor: pointer;
      }
    </style>
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
<form class="form-signin" method="post" action="mudarsenhalogado.php">
<div class="text-center mb-4">
        <h1 class="mb-3 mt-5 font-weight-normal lead">Redefina sua senha:</h1>
      </div>
    <p class="mt-5"></p>
    <div class="form-group w-50 m-auto" id="div-senha">
      <span><img src="../../icons/lock.svg" alt="password icon" height="32" width="32"></span>
      <label for="campoSenha">Nova senha</label>
      <input type="password" name="senha" id="campoSenha" class="form-control" required title="Digite uma senha" placeholder="Digite uma nova senha">
      <i class="far fa-eye" id="alternarSenha"></i>
    </div>
    <p class="mt-5"></p>
    <div class="form-group w-50 m-auto" id="div-senha">
      <span><img src="../../icons/lock.svg" alt="password icon" height="32" width="32"></span>
      <label for="campoSenhaConfirma">Confirmar senha</label>
      <input type="password" name="confirma" id="campoSenhaConfirma" class="form-control" required title="Digite novamente a senha" placeholder="Confirme a senha">
      <i class="far fa-eye" id="alternarSenha2"></i>
    </div>
    <p class="mt-5"></p>
  <button class="btn btn-lg btn-block w-50 m-auto" type="submit" name="ok" title="Redefinir Senha">Redefinir Senha</button>
    <?php
    if(isset($_SESSION['senharedefinida'])){
        if($_SESSION['senharedefinida'] == true){
            echo "<p class='mt-3'></p>";
            echo "<p class='alert alert-success m-auto w-50 text-center' role='alert'>Senha modificada com sucesso. Enviamos também uma mensagem ao seu e-mail.</p>";
            echo "<p class='mt-3'></p>";
            echo "<p class='alert alert-info m-auto w-50 text-center' role='alert'>Vamos redirecinoná-lo(a) para a página inicial...</p>";
            echo "<p class='mt-5'></p>";
            unset($_SESSION['senharedefinida']);
            header("Refresh: 5;url=http://localhost/iFTOhub/php/index.php");
        }
    }
    if(isset($_SESSION['senhaigual'])){
      if($_SESSION['senhaigual'] == true){
        echo "<p class='mt-3'></p>";
        echo "<p class='alert alert-warning m-auto w-50 text-center' role='alert'>A nova senha não pode ser igual a anterior!</p>";
        echo "<p class='mt-3'></p>";
        echo "<p <p class='alert alert-info m-auto w-50 text-center' role='alert'>Por favor, digite uma nova senha caso queira alterar a anterior, porém se quiser manter a atual, clique ou toque na logo do site para retornar para a página inicial.</p>";
        echo "<p class='mt-5'></p>";
        unset($_SESSION['senhaigual']);
      }
    }
    ?>
</form>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.2/dist/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.2/dist/additional-methods.min.js"></
<script src="../../js/register.js"></script>
<script>
    const alternarSenha = document.querySelector('#alternarSenha');
    const alternarSenha2 = document.querySelector('#alternarSenha2');
    const senha = document.querySelector("#campoSenha");
    const senhaConfirmada = document.querySelector("#campoSenhaConfirma");
    // Nova senha
    alternarSenha.addEventListener('click', function (e) {
      if (senha.type === "password") {
        senha.type = "text";
      }
      else {
        senha.type = "password";
      }
      this.classList.toggle('fa-eye-slash');
    });
    // Confirmar senha
    alternarSenha2.addEventListener('click', function (e) {
      if (senhaConfirmada.type === "password") {
        senhaConfirmada.type = "text";
      }
      else {
        senhaConfirmada.type = "password";
      }
      this.classList.toggle('fa-eye-slash');
    });
  </script>
</body>
</html>