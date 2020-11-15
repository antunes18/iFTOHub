<?php
session_start();
require '../conexao.php';
global $pdo;

$nome=addslashes($_POST['nome']);
$senha=addslashes($_POST['senha']);
$email=addslashes($_POST['email']);
$campus=addslashes($_POST['campus']);

//Verificando se o e-mail já está cadastrado
$sql = "SELECT * FROM iftohub.autor WHERE Email = '$email'";
$sql = $pdo->prepare($sql);
$sql->execute();

if($sql->rowCount() != 0){
  $_SESSION['userexiste'] = true;
  header('Location: cadastro.php');
  exit;
}else{
  $sql = "insert into iftohub.autor (NomeAutor,Senha,Email,Campus,Status,StatusProjeto)values('$nome',md5('$senha'),'$email','$campus',0,0)";
  $pdo->query($sql);
  $_SESSION['cadassim'] = true;
}

$idAutor = $pdo->lastInsertId();
$md5id = md5($idAutor);
?>

<?php
  require_once('../../src/PHPMailer.php');
  require_once('../../src/SMTP.php');
  require_once('../../src/Exception.php');

  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\SMTP;
  use PHPMailer\PHPMailer\Exception;

  $mail = new PHPMailer(true);

  try{
    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username ='hubifto@gmail.com';
    $mail->Password ='23112019';
    $mail->Port = 587;

    $mail->setFrom('hubifto@gmail.com');
    $mail->addAddress($email);

    $mail->isHTML(true);
    $mail->Subject = 'Confirme seu cadastro no site iFTOhub';
    $link = "http://localhost/iFTOhub/php/Cadastro/confirma.php?h=".$md5id;
    $mail->Body = "Clique aqui para confirmar seu cadastro ".$link;
    $mail->AltBody = "Clique aqui para confirmar seu cadastro ".$link;
    $mail->send();

    header('Location: cadastro.php');
  } catch (Exception $e){
      echo "Erro ao enviar mensagem: {$mail->ErrorInfo}";
  }
  ?>