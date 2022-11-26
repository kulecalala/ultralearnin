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

	// Actualizar dict
	if ( isset($_POST['UpdateDict']) ) {

		// verifica dados necessarios
		if ( isset($_POST['idDict'], $_POST['termoDict'], $_POST['descricaDict'], $_POST['fonteDict'], $_POST['tipoDict'], $_POST['cadeiraDict'], $_POST['tecnologiaDict']) ) {

			// set dados
			$id         = $_POST['idDict'];
			$termo      = filter_Var($_POST['termoDict'], FILTER_SANITIZE_STRING);
			$descricao  = filter_Var($_POST['descricaDict'], FILTER_SANITIZE_STRING);
			$fonte      = filter_Var($_POST['fonteDict'], FILTER_SANITIZE_STRING);
			$tipoDict   = filter_Var($_POST['tipoDict'], FILTER_SANITIZE_STRING);
			$sobreDict  = filter_Var($_POST['cadeiraDict'], FILTER_SANITIZE_STRING);
			$tecnoDict = $_POST['tecnologiaDict'];

			// configurar objecto
			$obDicionario->id             = $id;
	    $obDicionario->termo          = $termo;
	    $obDicionario->definicao      = $descricao;
	    $obDicionario->user           = $codigoUser;
	    $obDicionario->fonte          = $fonte;
	    $obDicionario->tipo           = $tipoDict;
	    $obDicionario->relacionado_a  = $sobreDict;
	    $obDicionario->tecnologia     = $tecnoDict;
	    $obDicionario->actualizado_em = date('Y-m-d');

			// actualiza dict
			if ( $obDicionario->actualizar() ) {
				// tudo ok
				$mensagem = 'A sua actualização ao dicionário foi efectuada com sucesso!';
			} else {
				// reportar erro
				$mensagem = 'Ops! Ocorreu um erro ao actualizar o dicionário!';
			}

		}

	}

	// Delete dict
	if ( isset($_POST['deleteDict']) ) {


		if ( isset( $_POST['idDict'] ) ) {

			// set dados
			$id = $_POST['idDict'];

			// configurar objecto
			$obDicionario->id   = $id;
	    $obDicionario->user = $codigoUser;

			// apadar dict termo
			if ( $obDicionario->excluir() ) {
				// tudo ok

				// RESET GET
				unset( $_GET['findNexo'] );

				// Set sms
				$mensagem = 'O seu contributo ao Ultra-Dict foi apagado com sucesso!';
			} else {
				// reportar erro
				$mensagem = 'Ops! Ocorreu um erro ao apagares o seu contributo ao Ultra-Dict!';
			}

		}


	}

	// set dados da busca
	$b_frases = filter_input(INPUT_GET, 'buscar_por', FILTER_SANITIZE_STRING);
	$b_filtro = filter_input(INPUT_GET, 'filtrar_por', FILTER_SANITIZE_STRING);
	$b_cadeir = filter_input(INPUT_GET, 'cadeiras', FILTER_SANITIZE_STRING);

	// validar filtro
	$b_filtro = in_array($b_filtro, ['g', 't', 'i'])? $b_filtro: '';

	// condicoes SQL
	$condicoes = [
		strlen( $b_frases )? 'termo LIKE "%'. $b_frases .'%"': null,
		strlen( $b_frases )? 'definicao LIKE "%'. $b_frases .'%"': null,
		strlen( $b_frases )? 'fonte LIKE "'. $b_frases .'"': null,
		strlen( $b_cadeir )? 'relacionado_a = "'. $b_cadeir .'"': null,
		strlen( $b_filtro )? 'tipo = "'. $b_filtro .'"': null
	];

	// remove posicoes vazias
	$condicoes = array_filter($condicoes);

	// clausula where
	$where = implode(' OR ', $condicoes);

	// get termos
	$getTermos = $obDicionario->getDefinicoes( $where, 'termo ASC');

	// get quantidade de palavras
	$qtdeWords = $obDicionario->getQuantidadeWords( $where );

	//Exibe mensagens de aviso
	include __DIR__.'/includes/avisos.php';

	//Carrega a interface padrao
	include __DIR__."/includes/header.php";
	include __DIR__."/includes/dict.php";
	include __DIR__."/includes/footer.php";
	include __DIR__.'/includes/centralAjuda.php';
