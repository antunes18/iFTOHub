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
            $mailms->Subject = "Senha alterada no site iFTOHub";
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
<form class="form-signin" method="post" action="mudarsenhalogado.php">
<div class="text-center mb-4">
        <h1 class="mb-3 mt-5 font-weight-normal">Redefina sua senha =)!</h1>
      </div>
    <p class="mt-5"></p>
    <div class="form-group w-50 m-auto">
      <span><img src="../../icons/lock.svg" alt="password icon" height="32" width="32"></span>
      <label for="campoSenha">Nova senha</label>
      <input type="password" name="senha" id="campoSenha" class="form-control" required title="Digite uma senha" placeholder="Digite uma nova senha">
    </div>
    <p class="mt-5"></p>
    <div class="form-group w-50 m-auto">
      <span><img src="../../icons/lock.svg" alt="password icon" height="32" width="32"></span>
      <label for="campoSenhaConfirma">Confirmar senha</label>
      <input type="password" name="confirma" id="campoSenhaConfirma" class="form-control" required title="Digite novamente a senha" placeholder="Digite novamente a nova senha">
    </div>
    <p class="mt-5"></p>
  <button class="btn btn-lg btn-block w-50 m-auto" type="submit" name="ok" title="Redefinir Senha">Redefinir Senha</button>
    <?php
    if(isset($_SESSION['senharedefinida'])){
        if($_SESSION['senharedefinida'] == true){
            echo "<br>Senha modificada com sucesso, enviamos também uma mensagem ao seu e-mail!";
            echo "<br>Vamos redirecinoná-lo(a) para a página inicial...";
            unset($_SESSION['senharedefinida']);
            header("Refresh: 5;url=http://localhost/iFTOhub/php/index.php");
        }
    }
    if(isset($_SESSION['senhaigual'])){
      if($_SESSION['senhaigual'] == true){
        echo "<br>A nova senha não pode ser igual a anterior!<br>";
        echo "<br>Digite uma nova senha caso queira alterar a anterior, porém se quiser manter <br> a atual basta clicar na logo do site e ir para a página inicial<br>";
        unset($_SESSION['senhaigual']);
      }
    }
    ?>
</form>
</body>
</html>