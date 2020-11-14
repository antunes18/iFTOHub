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

if(!isset($_SESSION['idUser'])){

}else{
  $idautor = $_SESSION['idUser'];

  $sql = "SELECT NomeAutor from iftohub.autor WHERE idAutor = $idautor";
  $sql = $pdo->prepare($sql);
  $sql->execute();

  $dado = $sql->fetch();
  $nomeautorp = $dado['NomeAutor']; 
}

$titulop = addslashes($_POST['tituloprojeto']);
$orientadorp = addslashes($_POST['orientador']);
$coorientadorp = addslashes($_POST['coorientador']);
$anop =  addslashes($_POST['anop']);
$areaconhecimentop = addslashes($_POST['aconhe']);

if(isset($_FILES['artigopdf'])){

    $extensao = ".pdf";
    $novonome = $titulop . "-" . $nomeautorp . $extensao;
    $diretorio = "artigos/";

    move_uploaded_file($_FILES['artigopdf']['tmp_name'], $diretorio.$novonome);

    $sql = "INSERT INTO iftohub.projeto (AreaConhecimento, Titulo, Ano, NomeOrientador, NomeCoorientador, ArtigoPDF)VALUES('$areaconhecimentop', '$titulop', $anop, '$orientadorp', '$coorientadorp', '$novonome')";
    if($pdo->query($sql)){
        $_SESSION['uploadtrue'] = true;
        $idProjeto = $pdo->lastInsertId();
        $sql = "INSERT INTO iftohub.autorprojeto(idAutor, idProjeto)VALUES($idautor, $idProjeto)";
        $pdo->query($sql);

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

        try{
        //$mailpp->SMTPDebug = SMTP::DEBUG_SERVER;
        $mailpp->isSMTP();
        $mailpp->Host = 'smtp.gmail.com';
        $mailpp->SMTPAuth = true;
        $mailpp->Username ='hubifto@gmail.com';
        $mailpp->Password ='23112019';
        $mailpp->Port = 587;

        $mailpp->setFrom('hubifto@gmail.com');
        $mailpp->addAddress('hubifto@gmail.com');

        $mailpp->isHTML(true);
        $mailpp->Subject = 'Uma nova solicitacao de insercao de projeto foi criada!';
        $mailpp->Body = "Solicitação de inserção do projeto de título: <b>$titulop</b> <br/><br/>Criada por: <b>$nomeautorp</b> <br/><br/>Área do conhecimento: <b>$areaconhecimentop</b>";
        $mailpp->AltBody = "Solicitação de inserção do projeto de título: <b>$titulop</b> <br/><br/>Criada por: <b>$nomeautorp</b> <br/><br/>Área do conhecimento: <b>$areaconhecimentop</b>";
        $mailpp->send();

        header('Location: projeto.php');
        } catch (Exception $e){
        echo "Erro ao enviar mensagem: {$mailpp->ErrorInfo}";
        }
    }
    else{
        $_SESSION['uploaderror'] = true;
    }
}
header('Location:projeto.php');
?>
