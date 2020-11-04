<?php

class Usuario{

    public function login($email, $senha){
        global $pdo;

        $sql = "SELECT * FROM iftohub.autor WHERE Email = :email AND Senha = :senha";
        $sql = $pdo->prepare($sql);
        $sql->bindValue("email", $email);
        $sql->bindValue("senha", md5($senha));
        $sql->execute();

        if($sql->rowCount() > 0){
            $dado = $sql->fetch();

            $_SESSION['idUser'] = $dado['idAutor'];

            return true;
        }else{
            return false;
        }

    }
}

?>