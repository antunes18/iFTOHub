<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
        <meta name='viewport' content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Cadastro confirmado</title>
        <link rel='icon' href='../../img/logoifhub.png'>
        <link href='../../css/bootstrap.min.css' rel='stylesheet'>
        <script src="../../js/jquery-3.2.1.slim.min.js"></script>
        <link href="../../css/album.css" rel="stylesheet">
        <script src="https://kit.fontawesome.com/be43ae3ae0.js"></script>
        <link rel="stylesheet" href="../../css/style.css">
        <style>
            body, .jumbotron {
                background-color: #f5f5f5;
            }
        </style>
    </head>
    <header>
        <div class='navbar navbar-dark bg-dark box-shadow'>
            <div class='container d-flex justify-content-between'>
                <a href='#' class='navbar-brand d-flex align-items-center'>
                    <img src='../../img/logoifhub.png' alt='Logo iFTOHub' width='40px' height='40px'>
                    <strong>iFTOHub</strong>
                </a>
            </div>
        </div>
    </header>
    <main role="main">
        <div class="jumbotron">
            <?php
                require '../conexao.php';
                global $pdo;
                $h = $_GET['h'];
                if(!empty($h)){
                    $pdo->query("UPDATE iftohub.autor SET status='1' WHERE MD5(idAutor) = '$h'");
                    echo "<p class='alert alert-success text-center w-50 m-auto' role='alert'>
                    <strong>Cadastro confirmado com sucesso!</strong>
                </p>";
                }
                ?>
        </div>
        <hr>
        <div class="mt-3 text-center">
            <a class="btn btn-lg mt-4" href="../Login/login.php" role="button" title="Página de login"> Ir para a página de login</a>
        </div>
    </main>
</html>