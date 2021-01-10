<?php
session_start();

if (!isset($_SESSION['idUser']))
{
    header('Location: Login/login.php');
}
else
{
    require 'conexao.php';
    global $pdo;
    $idautor = $_SESSION['idUser'];
    $sql = "SELECT NomeAutor from iftohub.autor WHERE idAutor = $idautor";
    $sql = $pdo->prepare($sql);
    $sql->execute();
    // Selecionando nome do autor para aparecer como logado.
    $dado = $sql->fetch();
    $nomeuser = $dado['NomeAutor'];
    $sql1 = "SELECT Email from iftohub.autor WHERE idAutor = $idautor";
    $sql1 = $pdo->prepare($sql1);
    $sql1->execute();
    // Selecionando email do usuário para verificar se é o adm ou não
    $dado1 = $sql1->fetch();
    $email = $dado1['Email'];
    echo "
  <div class='clearfix'>
    <p id='welcome' class='float-left alert alert-success'>Bem-vind@, " . strtoupper($nomeuser) . "</p>
    <a id='exit' class='alert alert-dark float-right text-center' href='Login/sair.php' title='Sair da sessão'>Sair</a>
	</div>";
	?>
<?php
}
?>
<!DOCTYPE html>
<!-- saved from url=(0050)https://getbootstrap.com/docs/4.0/examples/album/# -->
<html lang="pt-br">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<title>iFTO Hub</title>
		<link rel="icon" href="../img/logoifhub.png">
		<link href="../css/bootstrap.min.css" rel="stylesheet">
		<script src="../js/jquery-3.2.1.slim.min.js"></script>
		<link href="../css/album.css" rel="stylesheet">
		<script src="https://kit.fontawesome.com/be43ae3ae0.js"></script>
		<link rel="stylesheet" href="../css/style.css">
		<script src="https://printjs-4de6.kxcdn.com/print.min.js"></script>
		<style>
			#welcome {
				width: 80%;
				display:inline-block;
				outline:none; 
				border:none; 
				clear:none; 
				margin: 0; 
			}
			#exit {
				width: 20%;
				display:inline-block;
				outline:none; 
				border:none; 
				text-decoration: none;
				clear:none;  
				margin: 0;
			}
			#lista {
			  color: white;
			}
			#lista:hover {
				color: #19882c;
				text-decoration: none;
			}
			.fa, .fas {
			  font-size: 25px;
			}
			.page-link {
			  color: #19882c;
			}
			.page-link:hover {
			  color: #0a5517;
			}
			#repGitHub {
				color: #B30900;
			}
			#repGitHub:hover {
				text-decoration: none;
				color: #2F9E41;
			}
		</style>
	</head>
	<body>
		<header>
			<div class="collapse mb-0" id="navbarHeader">
				<div class="container">
					<div class="row">
						<div class="col-sm-8 col-md-7 py-4">
							<h4 class="text-white" title="Resumo do site">Sobre</h4>
							<p class="text-white">Esta aplicação web tem como objetivo patentear projetos científicos desenvolvidos no
								Instituto Federal de Educação, Ciência e Tecnologia do Tocantins - IFTO. A
								proposta é que todos os estudantes possam expor seus projetos tendo sido eles
								aprovados ou não, formando um sistema que incentiva o crescimento do estudante
								visionando um maior conhecimento e aprendizado do mesmo em relação à projetos
								científicos, concluindo em fazer um repositório online para todo o corpo discente.
							</p>
						</div>
						<div class="col-sm-4 offset-md-1 py-4">
							<h4 class="text-white">Contato</h4>
							<ul class="list-unstyled">
								<li><a href="Contato/contato.php" class="text-white" title="Contatar desenvolvendores">Falar com os desenvolvedores</a></li>
							</ul>
						</div>
						<?php
							if(isset($_SESSION['idUser'])){
								?>
						<div class="col-md-4 py-2">
							<h4 class="text-white">Senha</h4>
							<ul class="list-unstyled">
								<li><a href="Login/mudarsenhalog.php" class="text-white" title="Alterar senha">Mudar sua senha</a></li>
							</ul>
						</div>
						<?php
							}
							?>
					</div>
				</div>
			</div>
			<div class="navbar navbar-dark bg-dark box-shadow">
				<div class="container d-flex justify-content-between">
					<a href="index.php" class="navbar-brand d-flex align-items-center" title="Página inicial">
					<img src="../img/logoifhub.png" alt="Logo iFTOHub" width="40px" height="40px">
					<strong>iFTOHub</strong>
					</a>
					<?php
						if(isset($email)){
							if($email == 'hubifto@gmail.com'){
								echo "<a href='lista.php' id='lista' title='Projetos pendentes'><i class='fas fa-exclamation-triangle'></i></a>";
							}
						}
						?>
					<button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon" title="Menu"></span>
					</button>
				</div>
			</div>
		</header>
		<main role="main">
			<section class="jumbotron text-center">
				<div class="container">
					<h1 class="jumbotron-heading font-weight-bold" id="bvMsg"></h1>
					<p class="lead" id="intro"></p>
					<p>
						<a href="Projeto/projeto.php" class="btn my-2" title="Solicitar inserção de projeto">Inserir projeto</a>
					</p>
				</div>
			</section>
			<div class="album py-5 bg-light">
				<form class="form-inline d-flex justify-content-center mb-5">
					<input type="text" name="barradepesquisa" id="pesquisarInput" class="form-control form-control-lg w-75 mr-3" placeholder="Procurar projetos" arial-label="Procurar projetos">
					<i class="fas fa-search" aria-hiiden="true"></i>
				</form>
				<div class="container">
					<div class="row">
						<div class="col-md-4">
							<div class="card mb-4 box-shadow">
								<div class="card-body">
									<p class="card-text">iFTOHub: Uma Proposta De Repositório Institucional</p>
									<div hidden class="detalhes-projeto">
										<p>Araguaína</p>
										<p>Engenharias</p>
										<p>2020</p>
									</div>
									<div class="d-flex justify-content-between align-items-center">
										<div class="btn-group">
											<a href="#">
												<button type="button" class="btn btn-sm rounded">Baixar</button>
											</a>
											<button type="button" onclick="printJS('#')" class="btn btn-sm ml-2 rounded">Imprimir</button>
										</div>
										<small class="text-muted">IFTO</small>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="card mb-4 box-shadow">
								<div class="card-body">
									<p class="card-text">Uso Do Instagram Para Disseminação De Conhecimento Matemático: Uma Experiência No Campus Araguaína</p>
									<div hidden class="detalhes-projeto">
										<p>Araguaína</p>
										<p>2019</p>
										<p>Ciências Exatas E Da Terra</p>
									</div>
									<div class="d-flex justify-content-between align-items-center">
										<div class="btn-group">
											<a href="Projeto/artigos/artigo02.pdf">
												<button type="button" class="btn btn-sm rounded">Baixar</button>
											</a>
											<button type="button" onclick="printJS('iFTOHub/php/Projeto/artigos/artigo02.pdf')" class="btn btn-sm ml-2 rounded">Imprimir</button>
										</div>
										<small class="text-muted">JICE</small>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="card mb-4 box-shadow">
								<div class="card-body">
									<p class="card-text">Contribuição Do Esporte Na Saúde Mental</p>
									<div hidden class="detalhes-projeto">
										<p>Araguaína</p>
										<p>Ciências Humanas</p>
										<p>2019</p>
									</div>
									<div class="d-flex justify-content-between align-items-center">
										<div class="btn-group">
											<a href="Projeto/artigos/artigo03.pdf">
												<button type="button" class="btn btn-sm rounded">Baixar</button>
											</a>
											<button type="button" class="btn btn-sm ml-2 rounded" onclick="printJS('iFTOHub/php/Projeto/artigos/artigo03.pdf')">Imprimir</button>
										</div>
										<small class="text-muted">JICE</small>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="card mb-4 box-shadow">
								<div class="card-body">
									<p class="card-text">Desenvolvimento De Cadeira De Rodas Inteligente Para Pessoas Com Mobilidade Reduzida</p>
									<div hidden class="detalhes-projeto">
										<p>Araguaína</p>
										<p>Engenharias</p>
										<p>2019</p>
									</div>
									<div class="d-flex justify-content-between align-items-center">
										<div class="btn-group">
											<a href="Projeto/artigos/artigo04.pdf">
												<button type="button" class="btn btn-sm rounded">Baixar</button>
											</a>
											<button type="button" class="btn btn-sm ml-2 rounded" onclick="printJS('iFTOHub/php/Projeto/artigos/artigo04.pdf')">Imprimir</button>
										</div>
										<small class="text-muted">MOCISSPA</small>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="card mb-4 box-shadow">
								<div class="card-body">
									<p class="card-text">Sensor De Identificação Dos Estágios De Coloração De Frutas E Suas Variações Para Deficientes Visuais - SIFDEV</p>
									<div hidden class="detalhes-projeto">
										<p>Araguaína</p>
										<p>Engenharias</p>
										<p>2020</p>
									</div>
									<div class="d-flex justify-content-between align-items-center">
										<div class="btn-group">
										<a href="Projeto/artigos/artigo05.pdf">
											<button type="button" class="btn btn-sm rounded">Baixar</button>
										</a>
										<button type="button" class="btn btn-sm ml-2 rounded" onclick="printJS('iFTOHub/php/Projeto/artigos/artigo05.pdf')">Imprimir</button>
									</div>
										<small class="text-muted">FEBRACE</small>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="card mb-4 box-shadow">
								<div class="card-body">
									<p class="card-text">A Troca Da Enxada Pelo Lápis: Análise Do Processo De Protagonismo Acadêmico De Corpos Negro</p>
									<div hidden class="detalhes-projeto">
										<p>Araguaína</p>
										<p>Ciências Sociais</p>
										<p>2019</p>
									</div>
									<div class="d-flex justify-content-between align-items-center">
										<div class="btn-group">
											<a href="Projeto/artigos/artigo06.pdf">
												<button type="button" class="btn btn-sm rounded">Baixar</button>
											</a>
											<button type="button" class="btn btn-sm ml-2 rounded" onclick="printJS('iFTOHub/php/Projeto/artigos/artigo06.pdf')">Imprimir</button>
										</div>
										<small class="text-muted">JICE</small>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="card mb-4 box-shadow">
								<div class="card-body">
									<p class="card-text">Suporte Para Maçaneta De Porta E Dispensador De Álcool Automático Como Alternativa Para Reduzir A Disseminação Do Coronavírus</p>
									<div hidden class="detalhes-projeto">
										<p>Araguaína</p>
										<p>Engenharias</p>
										<p>2020</p>
									</div>
									<div class="d-flex justify-content-between align-items-center">
										<div class="btn-group">
										<a href="Projeto/artigos/artigo07.pdf">
											<button type="button" class="btn btn-sm rounded">Baixar</button>
										</a>
										<button type="button" class="btn btn-sm ml-2 rounded" onclick="printJS('iFTOHub/php/Projeto/artigos/artigo07.pdf')">Imprimir</button>
									</div>
										<small class="text-muted">IFTO</small>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="card mb-4 box-shadow">
								<div class="card-body">
									<p class="card-text">Fatores Condicionantes Para Reprovação/Desistência Dos Alunos Dos Cursos Técnicos Integrados Ao Ensino Médio No IFTO Campus Araguaína</p>
									<div hidden class="detalhes-projeto">
										<p>Araguaína</p>
										<p>Ciências Humanas</p>
										<p>2019</p>
									</div>
									<div class="d-flex justify-content-between align-items-center">
										<div class="btn-group">
										<a href="Projeto/artigos/artigo08.pdf">
											<button type="button" class="btn btn-sm rounded">Baixar</button>
										</a>
											<button type="button" class="btn btn-sm ml-2 rounded" onclick="printJS('iFTOHub/php/Projeto/artigos/artigo08.pdf')">Imprimir</button>
										</div>
										<small class="text-muted">JICE</small>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="card mb-4 box-shadow">
								<div class="card-body">
									<p class="card-text">Desenvolvimento De Cadeira De Rodas Inteligente Com Sistema De Recarga Por Energia Solar</p>
									<div hidden class="detalhes-projeto">
										<p>Araguaína</p>
										<p>Engenharias</p>
										<p>2019</p>
									</div>
									<div class="d-flex justify-content-between align-items-center">
										<div class="btn-group">
											<a href="Projeto/artigos/artigo09.pdf">
												<button type="button" class="btn btn-sm rounded">Baixar</button>
											</a>
											<button type="button" class="btn btn-sm ml-2 rounded" onclick="printJS('iFTOHub/php/Projeto/artigos/artigo09.pdf')">Imprimir</button>
										</div>
										<small class="text-muted">FBJC</small>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div>
				</div>
				<nav aria-label="Page navigation example">
					<ul class="pagination justify-content-center">
						<li class="page-item">
							<a class="page-link" href="index.php" aria-label="Previous">
							<span aria-hidden="true">&laquo;</span>
							</a>
						</li>
						<li class="page-item"><a class="page-link" href="index.php">1</a></li>
						<li class="page-item"><a class="page-link" href="paginas/pagina2.php">2</a></li>
						<li class="page-item"><a class="page-link" href="#">3</a></li>
						<li class="page-item">
							<a class="page-link" href="paginas/pagina2.php" aria-label="Next">
							<span aria-hidden="true">&raquo;</span>
							</a>
						</li>
					</ul>
				</nav>
			</div>
		</main>
		<footer class="text-muted box-shadow shadow p-3">
			<div class="container">
				<p class="float-right">
				<p class="text-center"><a href="https://github.com/Antunes2003/iFTOHub" target="_blank" id="repGitHub">Repositório no <i>GitHub</i></a></p>
			</div>
		</footer>
		<script src="../js/barraDePesquisa.js"></script>
		<script src="../js/index.js"></script>
		<script src="../js/popper.min.js"></script>
		<script src="../js/bootstrap.min.js"></script>
		<script src="../js/holder.min.js"></script>
	</body>
</html>