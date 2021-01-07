<?php
session_start();
require '../conexao.php';
require_once('../../src/PHPMailer.php');
require_once('../../src/SMTP.php');
require_once('../../src/Exception.php');
global $pdo;

        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\SMTP;
        use PHPMailer\PHPMailer\Exception;

        $mailpp = new PHPMailer(true);
        $mailpp2 = new PHPMailer(true);

if(!isset($_SESSION['idUser'])){
    header('Location: ../Login/avisologar.php');
}else{
  $idautor = $_SESSION['idUser'];

  // SELECIONANDO O NOME DO AUTOR

  $sql = "SELECT NomeAutor from iftohub.autor WHERE idAutor = $idautor";
  $sql = $pdo->prepare($sql);
  $sql->execute();

  $dado = $sql->fetch();
  $nomeautorp = $dado['NomeAutor'];

  // SELECIONANDO O EMAIL DO AUTOR

  $sql2 = "SELECT Email from iftohub.autor WHERE idAutor = $idautor";
  $sql2 = $pdo->prepare($sql2);
  $sql2->execute();

  $dado2 = $sql2->fetch();
  $emailautor = $dado2['Email']; 
}

$titulop = addslashes($_POST['tituloprojeto']);
$orientadorp = addslashes($_POST['orientador']);
$coorientadorp = addslashes($_POST['coorientador']);
$anop =  addslashes($_POST['anop']);
$areaconhecimentop = addslashes($_POST['aconhe']);

//Verificando se o usuário tem algum projeto pendente
$sql2 = "SELECT StatusProjeto FROM iftohub.autor WHERE idAutor = $idautor";
$sql2 = $pdo->prepare($sql2);
$sql2->execute();

$dado = $sql2->fetch();
$statusprojeto = $dado['StatusProjeto'];

if(isset($_FILES['artigopdf'])){
    if($statusprojeto == 0){

    $extensao = ".pdf";
    $novonome = $titulop . "-" . $nomeautorp . $extensao;
    $diretorio = "artigos/";

    move_uploaded_file($_FILES['artigopdf']['tmp_name'], $diretorio.$novonome);

    $sql = "INSERT INTO iftohub.projeto (AreaConhecimento, Titulo, Ano, NomeOrientador, NomeCoorientador, ArtigoPDF)VALUES('$areaconhecimentop', '$titulop', $anop, '$orientadorp', '$coorientadorp', '$novonome')";
    if($pdo->query($sql)){
        $_SESSION['uploadtrue'] = true;
        $idProjeto = $pdo->lastInsertId();
        $sql = "INSERT INTO iftohub.autorprojeto(idAutor, idProjeto, Status)VALUES($idautor, $idProjeto, 0)";
        $pdo->query($sql);

        $pdo->query("UPDATE iftohub.autor SET StatusProjeto='1' WHERE idAutor = '$idautor'");

        if($areaconhecimentop == 'cet'){
            $areaconhecimentop = 'CIÊNCIAS EXATAS E DA TERRA';
        }
        elseif($areaconhecimentop == 'cb'){
            $areaconhecimentop = 'CIÊNCIAS BIOLÓGICAS';
        }
        elseif($areaconhecimentop == 'eng'){
            $areaconhecimentop = 'ENGENHARIAS';
        }
        elseif($areaconhecimentop == 'cs'){
            $areaconhecimentop = 'CIÊNCIAS DA SAÚDE';
        }
        elseif($areaconhecimentop == 'ca'){
            $areaconhecimentop = 'CIÊNCIAS AGRÁRIAS';
        }
        elseif($areaconhecimentop == 'csa'){
            $areaconhecimentop = 'CIÊNCIAS SOCIAIS APLICADAS';
        }
        elseif($areaconhecimentop == 'ch'){
            $areaconhecimentop = 'CIÊNCIAS HUMANAS';
        }
        elseif($areaconhecimentop == 'lla'){
            $areaconhecimentop = 'LINGUÍSTICA, LETRAS E ARTES';
        }
        elseif($areaconhecimentop == 'mul'){
            $areaconhecimentop = 'MULTIDISCIPLINAR';
        }

        // ENVIANDO E-MAIL PARA A EQUIPE DE ADM

        $subject = 'Uma nova solicitação de inserção de projeto foi criada!';
        $subject = utf8_decode($subject);

        $msgmailpp = "Solicitação de inserção do projeto de título: <b>$titulop</b> <br/><br/>Criada por: <b>$nomeautorp</b> <br/><br/>Área do conhecimento: <b>$areaconhecimentop</b>";
        $msgmailpp = utf8_decode($msgmailpp);

        try{
        //$mailpp->SMTPDebug = SMTP::DEBUG_SERVER;
        $mailpp->isSMTP();
        $mailpp->Host = 'smtp.gmail.com';
        $mailpp->SMTPAuth = true;
        $mailpp->Username ='hubifto@gmail.com';
        $mailpp->Password ='23112019';
        $mailpp->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        $mailpp->Port = 587;

        $mailpp->setFrom('hubifto@gmail.com');
        $mailpp->addAddress('hubifto@gmail.com');

        $mailpp->isHTML(true);
        $mailpp->Subject = $subject;
        $mailpp->Body = $msgmailpp;
        $mailpp->AltBody = $msgmailpp;
        $mailpp->send();

        header('Location: projeto.php');
        } catch (Exception $e){
        echo "Erro ao enviar mensagem: {$mailpp->ErrorInfo}";
        }

        // ENVIANDO E-MAIL PARA O AUTOR DO PROJETO

        $subject2 = 'Verificamos sua solicitação de inserção no site iFTOHub!';
        $subject2 = utf8_decode($subject2);

        $msgmailpp2 = "Olá <b>$nomeautorp</b>! Verificamos que você solicitou a inserção de um projeto de título: <b>$titulop</b>, aguarde a nossa equipe de adms confirmar/reprovar o projeto, quando tal ação for efetuada você receberá um e-mail com mais informações!";
        $msgmailpp2 = utf8_decode($msgmailpp2);

        try{
            //$mailpp->SMTPDebug = SMTP::DEBUG_SERVER;
            $mailpp2->isSMTP();
            $mailpp2->Host = 'smtp.gmail.com';
            $mailpp2->SMTPAuth = true;
            $mailpp2->Username ='hubifto@gmail.com';
            $mailpp2->Password ='23112019';
            $mailpp2->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
            $mailpp2->Port = 587;
    
            $mailpp2->setFrom('hubifto@gmail.com');
            $mailpp2->addAddress($emailautor);
    
            $mailpp2->isHTML(true);
            $mailpp2->Subject = $subject2;
            $mailpp2->Body = $msgmailpp2;
            $mailpp2->AltBody = $msgmailpp2;
            $mailpp2->send();
    
            header('Location: projeto.php');
            } catch (Exception $e){
            echo "Erro ao enviar mensagem: {$mailpp2->ErrorInfo}";
            }
    }
    else{
        $_SESSION['uploaderror'] = true;
        header('Location:projeto.php');
    }
}else{
    header('Location: projetopendente.php');
}
}
?>
