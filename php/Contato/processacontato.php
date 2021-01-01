<?php
session_start();

require_once('../../src/PHPMailer.php');
require_once('../../src/SMTP.php');
require_once('../../src/Exception.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$mailc = new PHPMailer(true);

if(!isset($_POST['envioucontato'])){
  header('Location: ../Login/login.php');
}else{
if(!isset($_SESSION['idUser'])){
  header('Location: ../Login/login.php');
}else{
  require '../conexao.php';
  global $pdo;
  $idautor = $_SESSION['idUser'];

  $sql = "SELECT Email from iftohub.autor WHERE idAutor = $idautor";
  $sql = $pdo->prepare($sql);
  $sql->execute();

  $dado = $sql->fetch();
  $emailc = $dado['Email']; 
}

$assunto = addslashes($_POST['assunto']);
$msg = addslashes($_POST['msg']);

$assunto = utf8_decode($assunto);
$msg = utf8_decode($msg);
try{
    //$mailc->SMTPDebug = SMTP::DEBUG_SERVER;
    $mailc->isSMTP();
    $mailc->Host = 'smtp.gmail.com';
    $mailc->SMTPAuth = true;
    $mailc->Username ='contatohubifto@gmail.com';
    $mailc->Password ='23112019';
    $mailc->SMTPOptions = array(
      'ssl' => array(
          'verify_peer' => false,
          'verify_peer_name' => false,
          'allow_self_signed' => true
      )
  );
    $mailc->Port = 587;
    $mailc->setFrom('contatohubifto@gmail.com');
    $mailc->addAddress('contatohubifto@gmail.com');

    $mailc->isHTML(true);
    $mailc->Subject = "Mensagem de $emailc";
    $mailc->Body = "<b>Autor:</b> $emailc <br/><br/>
    <b>Assunto:</b> $assunto <br/><br/>
    <b>Mensagem:</b> $msg";
    $mailc->AltBody = "<b>Autor:</b> $emailc <br/><br/>
    <b>Assunto:</b> $assunto <br/><br/>
    <b>Mensagem:</b> $msg";
    if($mailc->send()){
        $_SESSION['msgenviada'] = true;
    }

    header('Location: contato.php');
  } catch (Exception $e){
      echo "Erro ao enviar mensagem: {$mailc->ErrorInfo}";
  }
}
?>