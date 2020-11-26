<?php
session_start();

if(isset($_SESSION['idUser'])){
    header('Location: ../index.php');
}

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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Esqueceu a senha</title>
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
    <div class="jumbotron text-center">
        <form action="esqueceusenha.php" method="POST">
            <label for="email"><strong>Digite o e-mail da sua conta:</label>
            <br>
            <input class='form-control w-50 m-auto' placeholder="Digite seu email" type="email" name="email" required>
            <input class="btn mt-3" type="submit" name="ok" value="Gerar Código" title="Gerar código">
        </form>
</div>
    <?php
    if(count($erro)>0){
        foreach($erro as $msg){
            echo "<div class='alert alert-warning text-center w-75 m-auto' role='alert'>$msg</div>";
        }
    }
    ?>
    <?php
    if(isset($_POST['ok']) && count($erro)==0){
    echo "<div class='alert alert-success text-center w-75 m-auto' role='alert'>Enviamos um código de verificação para o e-mail digitado acima. Acesse sua caixa de e-mails e digite o código <a href='cod.php'>clicando aqui</a></div><br>";
    echo "<div class='alert alert-warning text-center w-75 m-auto' role='alert'>Caso não tenha recebido nenhum código no seu e-mail, basta efetuar o processo anterior novamente, gerando um novo código</div>";
    }
    ?>
</body>
</html>