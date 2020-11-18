<?php
session_start();

include("../conexao.php");
require_once('../../src/PHPMailer.php');
require_once('../../src/SMTP.php');
require_once('../../src/Exception.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$erro = Array();

if(isset($_POST['ok'])){
    
    $email = addslashes($_POST['email']);

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $erro[] = "Email inválido.";
    }

    $sql = "SELECT * FROM iftohub.autor WHERE Email = '$email'";
    $sql = $pdo->prepare($sql);
    $sql->execute();

    if($sql->rowCount() == 0){
        $erro[] = "O e-mail informado não existe nos nossos registros.";
    }else{

    if(count($erro)==0){

    //Gerar código de recuperação para enviar ao e-mail do usuário
    $codverifica = substr(md5(time()), 0, 6);
    
    $mailes = new PHPMailer(true);

try{
    //$mailes->SMTPDebug = SMTP::DEBUG_SERVER;
    $mailes->isSMTP();
    $mailes->Host = 'smtp.gmail.com';
    $mailes->SMTPAuth = true;
    $mailes->Username ='hubifto@gmail.com';
    $mailes->Password ='23112019';
    $mailes->Port = 587;

    $mailes->setFrom('hubifto@gmail.com');
    $mailes->addAddress($email);

    $mailes->isHTML(true);
    $mailes->Subject = "Redefina sua senha";
    $mailes->Body = "Aqui está seu código de verificação: $codverifica";
    $mailes->AltBody = "Aqui está seu código de verificação: $codverifica";
    if($mailes->send()){
        $_SESSION['codigoverificacao'] = $codverifica;
        $_SESSION['emailuser'] = $email;
    }
  } catch (Exception $e){
      echo "Erro ao enviar mensagem: {$mailes->ErrorInfo}";
  }
}
}
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Esqueceu sua senha?</title>
</head>
<body>
    <?php
    if(count($erro)>0){
        foreach($erro as $msg){
            echo "<p>$msg</p>";
        }
    }
    ?>
    <form action="esqueceusenha.php" method="POST">
        <label for="email">Digite o e-mail da sua conta aqui:</label><br>
        <input placeholder="Seu email..." type="email" name="email" required>
        <input type="submit" name="ok" value="Gerar Código">
    </form>

    <?php
    if(isset($_POST['ok']) && count($erro)==0){
    echo "Enviamos um código de verificação para o e-mail digitado acima, acesse sua caixa de e-mails e digite o código <a href='cod.php'>clicando aqui</a>";
    }
    ?>
</body>
</html>