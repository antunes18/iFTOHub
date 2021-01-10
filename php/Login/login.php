<?php
session_start();

if (isset($_SESSION['idUser']))
{
  header('Location: avisologado.php');
}
else
{
?>
<!DOCTYPE html>
<!-- saved from url=(0059)https://getbootstrap.com/docs/4.4/examples/floating-labels/ -->
<html lang="pt-br">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login</title>
    <link rel="icon" href="../../img/logoifhub.png">
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/floating-labels.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
    <link rel="stylesheet" href="../../css/style.css">
    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }
      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
      .error {
        color: #CC3300;
        font-weight: bold;
      }
      #esquecisenha {
        color: #19882c;
      }
      #esquecisenha:hover {
        color: #0a5517;
      }
    </style>
  </head>
  <body>
    <form class="form-signin" method="POST" action="processalogin.php" autocomplete="off">
  <div class="text-center mb-4">
    <a href="../index.php"><img class="mb-4" src="../../img/logoifhub.png" alt="Aqui vai a logo do site (img)" width="72" height="72" title="Voltar para a página inicial"></a>
  </div>
    <?php
    if (isset($_SESSION['erro']))
    {
        if ($_SESSION['erro'] == true)
        {
    ?>
          <div class="alert alert-danger text-center" role="alert">
            <p>Erro ao efetuar login!</p>
            <p>e-mail e/ou senha estão incorretos.</p>
          </div>
          <?php
            if (empty($_SESSION['contagemerro']))
            {
              $_SESSION['contagemerro'] = 0;
            }
            if ($_SESSION['contagemerro'] < 3)
            {
              $conta = 3 - $_SESSION['contagemerro'];
              echo "<p lass='alert alert-info' role='alert'>Você ainda tem $conta tentativas para logar</p>";
              $_SESSION['contagemerro'] = $_SESSION['contagemerro'] + 1;
            }
            else
            {
              echo "<p class='alert alert-warning' role='alert'>Você atingiu o limite de tentativas de login, tente novamente em 10 minutos./p><br><br>";
              unset($_SESSION['contagemerro']);
              $_SESSION['loginbloq'] = true;
              $_SESSION['horatentada'] = time();
            }
        }
    }
    unset($_SESSION['erro']);
    if (!isset($_SESSION['loginbloq']))
    {
      $_SESSION['loginbloq'] = false;
    }
    if ($_SESSION['loginbloq'] == false)
    {
    ?>
  <div class="form-group">
    <span><img src="../../icons/envelope.svg" alt="email icon" height="32" width="32"></span>
    <label for="logemail">Email</label>
    <input type="email" name="logemail" class="form-control" required autofocus title="Digite seu e-mail utilizado no cadastro">
  </div>
  <div class="form-group" id="div-senha">
    <span><img src="../../icons/lock.svg" alt="password icon" height="32" width="32"></span>
    <label for="logsenha">Senha</label>
    <input type="password" name="logsenha" class="form-control" required title="Digite sua senha utilizada no cadastro" id="senha">
    <i class="far fa-eye" id="alternarSenha"></i>
  </div>
  <div class="mb-4">
    <a id="esquecisenha" href="esqueceusenha.php" target="_blank">Esqueci minha senha</a>
  </div>
  <button class="btn btn-lg btn-block" type="submit" title="Logar">Autenticar</button>
  <a href="../Cadastro/cadastro.php"  title="Ir para a página de cadastro" class="btn btn-lg btn-block">Primeiro Acesso</a>
  <p class="mt-5 mb-3 text-muted text-center">© 2020</p>
  <?php
  }
  else
  {
      if (isset($_SESSION['loginbloq']) && ($_SESSION['loginbloq'] == true) && isset($_SESSION['horatentada']))
      {
          if (time() - $_SESSION['horatentada'] >= 600)
          {

            // depois de passar 10 minutos:
            unset($_SESSION['loginbloq']);
            unset($_SESSION['horatentada']);
            header("Refresh: 0.5;url=http://localhost/iFTOhub/php/Login/login.php");

          }
      }
      if (isset($_SESSION['loginbloq']))
      {
          if ($_SESSION['loginbloq'] == true)
          {
              if (isset($_SESSION['horatentada']))
              {
                  $contaa = time() - $_SESSION['horatentada'];
                  if ($contaa >= 0 && $contaa <= 60)
                  {
                    $minuto = 10;
                  }
                  if ($contaa >= 61 && $contaa <= 120)
                  {
                    $minuto = 9;
                  }
                  if ($contaa >= 121 && $contaa <= 180)
                  {
                    $minuto = 8;
                  }
                  if ($contaa >= 181 && $contaa <= 240)
                  {
                    $minuto = 7;
                  }
                  if ($contaa >= 241 && $contaa <= 300)
                  {
                    $minuto = 6;
                  }
                  if ($contaa >= 301 && $contaa <= 360)
                  {
                    $minuto = 5;
                  }
                  if ($contaa >= 361 && $contaa <= 420)
                  {
                    $minuto = 4;
                  }
                  if ($contaa >= 421 && $contaa <= 480)
                  {
                    $minuto = 3;
                  }
                  if ($contaa >= 481 && $contaa <= 540)
                  {
                    $minuto = 2;
                  }
                  if ($contaa >= 541 && $contaa <= 600)
                  {
                    $minuto = 1;
                  }
                  if (isset($minuto))
                  {
                    echo "<p class='alert alert-warning' role='alert'>Ainda faltam <b>$minuto minutos</b> para tentar logar novamente!</p>";
                  }
              }
          }
      }
  }
  ?>
</form>
  <script>
    console.log("Funcionando...");
    const alternarSenha = document.querySelector('#alternarSenha');
    const senha = document.querySelector("#senha");
    alternarSenha.addEventListener('click', function (e) {
      if (senha.type === "password") {
        senha.type = "text";
      } else {
        senha.type = "password";
      }
      this.classList.toggle('fa-eye-slash');
    });
  </script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.2/dist/jquery.validate.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.2/dist/additional-methods.min.js"></script>
  <script src="../../js/login.js"></script>
</body>
</html>
<?php
}
?>