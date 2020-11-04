<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirme seu cadastro</title>
    <link rel="icon" href="../../logoifhub.png">
</head>
<body>
    <?php
    session_start();

    if(!isset($_SESSION['idUser'])){
        header('Location: ../index.php');
    }
    ?>

    <h1>Confirme sua conta acessando o link enviado ao seu e-mail para poder aproveitar ao máximo nosso site!</h1>
    <br>
    <a href="../index.php">Voltar para a página inicial</a>
</body>
</html>