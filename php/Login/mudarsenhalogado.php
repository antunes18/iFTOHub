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
</head>
<body>
<form class="form-signin" method="post" action="mudarsenhalogado.php">
      <div class="text-center mb-4">
         <a href="../index.php" title="Voltar para página inicial">
          <img class="mb-4" src="../../img/logoifhub.png" alt="Logo iFTO Hub" width="72" height="72">
        </a>
        <h1 class="h3 mb-3 font-weight-normal">Redefina sua senha!</h1>
      </div>
    <div class="form-group">
      <span><img src="../../icons/lock.svg" alt="password icon" height="32" width="32"></span>
      <label for="campoSenha">Nova senha</label>
      <input type="password" name="senha" id="campoSenha" class="form-control" required title="Digite uma senha">
    </div>
    <div class="form-group">
      <span><img src="../../icons/lock.svg" alt="password icon" height="32" width="32"></span>
      <label for="campoSenhaConfirma">Confirmar senha</label>
      <input type="password" name="confirma" id="campoSenhaConfirma" class="form-control" required title="Digite novamente a senha">
    </div>
  <button class="btn btn-lg  btn-block" type="submit" name="ok" title="Redefinir Senha">Redefinir Senha</button>

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

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.2/dist/jquery.validate.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.2/dist/additional-methods.min.js"></script>
  <script src="../../js/register.js"></script>
</form>
</body>
</html>