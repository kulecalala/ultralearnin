<?php
	session_start();
	require __DIR__.'/vendor/autoload.php';

	//Controle de acesso
	use \App\Config\AcessoControl;

	//set dados user
	$statusOn = new AcessoControl($_SESSION['userId'], $_SESSION['userLog']);

	//Avisos
	$mensagem = '';

	//Configuracao do formulario de acesso rapido
	include __DIR__.'/includes/add_config.php';
	include __DIR__.'/includes/add.php';

	//
	use \App\Db\Pagination;

	// Buscar
	$busca = filter_input(INPUT_GET, 'site', FILTER_SANITIZE_STRING);

	// Condicoes SQL
	$condicoes = [
		strlen($busca)? 'titulo LIKE "%'.str_replace(' ', '%', $busca).'%"' : null,
		strlen($busca)? 'link LIKE "%'.str_replace(' ', '%', $busca).'%"' : null
	];

	// Remove pocicoes vazias
	$condicoes = array_filter($condicoes);

	// Clausula where
	$where = implode(' OR ', $condicoes);

	// Quantidade total de sites
	$quantidadeSites = $obSites->getQuantidadeSites($where);

	// Paginacao
	$obPagination = new Pagination($quantidadeSites, $_GET['pagina'] ?? 1, 9);

	// Obtem sites
	$sitesList = $obSites->getSites($where, 'titulo ASC', $obPagination->getLimit() );

	//Exibe mensagens de aviso
	include __DIR__.'/includes/avisos.php';

	//Carrega a interface padrao
	include __DIR__.'/includes/header.php';
	include __DIR__.'/includes/sites.php';
	include __DIR__.'/includes/footer.php';
	include __DIR__.'/includes/centralAjuda.php';
