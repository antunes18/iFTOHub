<?php
session_start();
require '../conexao.php';
global $pdo;

if(!isset($_SESSION['idUser'])){

}else{
  $idautor = $_SESSION['idUser'];

  $sql = "SELECT NomeAutor from iftohub.autor WHERE idAutor = $idautor";
  $sql = $pdo->prepare($sql);
  $sql->execute();

  $dado = $sql->fetch();
  $nomeautorp = $dado['NomeAutor']; 
}

$titulop = addslashes($_POST['titulo-projeto']);
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
    }
    else{
        $_SESSION['uploaderror'] = true;
    }
}
header('Location:projeto.php');
?>
