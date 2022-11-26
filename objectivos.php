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

	// Actualizar dados do objectivos
	if ( isset( $_POST['btn-Actualizar'] ) ) {
		if ( isset( $_POST['idObjectivosCod'], $_POST['tituloObj'], $_POST['descircaoObj'], $_POST['dataCriacaoObj'], $_POST['alcancarEmObj'], $_POST['objSobre'], $_POST['percentagemObj'], $_POST['categoriaObj'], $_POST['estadoObj'] ) ) {

			// set dados
			$obObjectivos->id            = $_POST['idObjectivosCod'];
	    $obObjectivos->titulo        = $_POST['tituloObj'];
	    $obObjectivos->descricao     = $_POST['descircaoObj'];
	    $obObjectivos->data_inicio   = $_POST['dataCriacaoObj'];
	    $obObjectivos->data_validade = $_POST['alcancarEmObj'];
	    $obObjectivos->sobre         = $_POST['objSobre'];
	    $obObjectivos->percentagem   = $_POST['percentagemObj'];
	    $obObjectivos->utilizador    = $codigoUser;
	    $obObjectivos->categoria     = $_POST['categoriaObj'];
	    $obObjectivos->estado        = $_POST['estadoObj'];

			if ( $obObjectivos->actualizar() ) {
				// ok
			} else {
				// reportar erro
			}

			// recarrega a pagina
			header('location: ');
		}

	}

	// Apagar objectivo
	if ( isset( $_POST['btn-apagar'] ) ) {

		// Dados necessarios
		if ( $_POST['idObjectivosCod'] ) {

			// Set dados
			$obObjectivos->id = $_POST['idObjectivosCod'];

			if ( $obObjectivos->excluir() ) {
				// Tudo ok
			} else {
				// reportar erro
			}

			header('location: /objectivos.php');
		}

	}

	// buscas
	$b_frase  = filter_input(INPUT_GET, 'pesquisar_por', FILTER_SANITIZE_STRING);

	// FIltro
	$b_filtro = filter_input(INPUT_GET, 'filtrar_por', FILTER_SANITIZE_STRING);
	// Validar filtro

	$b_filtro = in_array($b_filtro, ['n', 'c', 'm', 'l', 'a'])? $b_filtro: '';

	// objectivo codigo
	$objEspecifico = filter_input(INPUT_GET, 'objectivosCod', FILTER_SANITIZE_STRING);

	// Condicoes SQL
	$condicoes = [
		strlen( $b_frase )? 'titulo LIKE "%'. str_replace(' ', '%', $b_frase ) .'%" OR descricao LIKE "%'. str_replace(' ', '%', $b_frase) .'%"' : null,
		strlen( $b_filtro )? 'estado = "'. $b_filtro .'"' : null,
		'utilizador = "'. $codigoUser .'"',
		strlen( $objEspecifico ) ? 'id = "'. $objEspecifico .'"': null
	];

	// Remove posicoes vazias
	$condicoes = array_filter( $condicoes );

	// clausula where
	$where = implode(' AND ', $condicoes);

	/*echo '<pre>';
  print_r( $where );
  echo '</pre>'; exit;*/

	// buscar objectivo especifico
	$obObjectivoEspecifico = $obObjectivos->getObjectivos( $where );

	// Objectivos da semana
	$obObjectivosDaSemana = $obObjectivos->getObjectivos( $where, 'titulo DESC', '8' );
	$objectivosDaSemana = '';

	foreach ( $obObjectivosDaSemana as $key=>$dados ) {

		$descricao = $dados->descricao;
		$descricao = (strlen($descricao) > 285)? substr($descricao, 0, 285).'...' : $descricao;

		$codObj = $dados->id;

		$objectivosDaSemana .= '<div class="list-items-d-o">
															<div class="descricao">'. $descricao .'</div>
															<a href="?objectivosCod='. $codObj .'">
																<div class="buttom"> Ver mais </div>
															</a>
														</div>';
	}

	if ( strlen($objectivosDaSemana) == 0 ) {
		$objectivosDaSemana .= '<div class="sms-objectivos">
															Sem objectivos para esta semana!
		                        </div>';
	}
	/*
	* Fim objectivos da semana*/

	// Objectivos pendentes
	$objectivosPendentes = '';

	// Objectivos de curto prazo
	$obObjectivosDeCurtoPrazo = $obObjectivos->getObjectivos('utilizador = "'. $codigoUser .'" AND estado = "c"', 'titulo DESC', '8' );
	$objectivosDeCurtoPrazo = '';

	foreach ( $obObjectivosDeCurtoPrazo as $key=>$dados ) {
		$descricao = $dados->descricao;
		$descricao = (strlen($descricao) > 285)? substr($descricao, 0, 285).'...' : $descricao;

		$codObj = $dados->id;

		$objectivosDeCurtoPrazo .= '<div class="list-items-d-o">
																	<div class="descricao">'. $descricao .'</div>
																	<a href="?objectivosCod='. $codObj .'">
																		<div class="buttom"> Ver mais </div>
																	</a>
																</div>';
	}

	if ( strlen($objectivosDeCurtoPrazo) == 0 ) {
		$objectivosDeCurtoPrazo .= '<div class="sms-objectivos">
																	Sem objectivos de curto prazo!
		                        		</div>';
	}
	/*
	* Fim objectivos de curto prazo*/

	// Objectivos de medio prazo
	$obObjectivosDeMedioPrazo = $obObjectivos->getObjectivos('utilizador = "'. $codigoUser .'" AND estado = "m"', 'titulo DESC', '8' );
	$objectivosDeMedioPrazo = '';

	foreach ( $obObjectivosDeMedioPrazo as $key=>$dados ) {
		$descricao = $dados->descricao;
		$descricao = (strlen($descricao) > 285)? substr($descricao, 0, 285).'...' : $descricao;

		$codObj = $dados->id;

		$objectivosDeMedioPrazo .= '<div class="list-items-d-o">
																	<div class="descricao">'. $descricao .'</div>
																	<a href="?objectivosCod='. $codObj .'">
																		<div class="buttom"> Ver mais </div>
																	</a>
																</div>';
	}

	if ( strlen($objectivosDeMedioPrazo) == 0 ) {
		$objectivosDeMedioPrazo .= '<div class="sms-objectivos">
																	Sem objectivos de médio prazo!
		                        		</div>';
	}


	// Objectivos de longo prazo
	$obObjectivosLongoPrazo = $obObjectivos->getObjectivos('utilizador = "'. $codigoUser .'" AND estado = "l"', 'titulo DESC', '8' );
	$objectivosDeLongoPrazo = '';

	foreach ( $obObjectivosLongoPrazo as $key=>$dados ) {
		$descricao = $dados->descricao;
		$descricao = (strlen($descricao) > 285)? substr($descricao, 0, 285).'...' : $descricao;

		$codObj = $dados->id;

		$objectivosDeLongoPrazo .= '<div class="list-items-d-o">
																	<div class="descricao">'. $descricao .'</div>
																	<a href="?objectivosCod='. $codObj .'">
																		<div class="buttom"> Ver mais </div>
																	</a>
																</div>';
	}

	if ( strlen($objectivosDeLongoPrazo) == 0 ) {
		$objectivosDeLongoPrazo .= '<div class="sms-objectivos">
																	Sem objectivos de longo prazo!
		                        		</div>';
	}

	//Exibe mensagens de aviso
	include __DIR__.'/includes/avisos.php';

	//Carrega a interface padrao
	include __DIR__."/includes/header.php";
	include __DIR__."/includes/objectivos.php";
	include __DIR__."/includes/footer.php";
	include __DIR__.'/includes/centralAjuda.php';
