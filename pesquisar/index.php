<?php
	session_start();
	require __DIR__.'/../vendor/autoload.php';

	//Controle de acesso
	use \App\Config\AcessoControl;

	//set dados user
	$statusOn = new AcessoControl($_SESSION['userId'], $_SESSION['userLog']);

	//Configuracao do formulario de acesso rapido
	include __DIR__.'/../includes/add_config.php';
	include __DIR__.'/../includes/add.php';

	//Notificaos
	$mensagem = '';

	$pesquisar = filter_Var($_GET['procurar'] ?? null, FILTER_SANITIZE_STRING);

	include __DIR__."/../includes/header.php";
	include __DIR__."/../includes/pesquisar.php";
	include __DIR__."/../includes/footer.php";
