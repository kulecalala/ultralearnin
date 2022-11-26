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

	// Enviar/actualizar solucao
	if ( isset( $_POST['btn-enviar-solucao'] ) ) {

		// Verificar dados necessarios
		if ( isset($_POST['idPrimario'], $_POST['idExercicio'], $_POST['solucaoDesafio'], $_POST['dataCriacao'], $_POST['tentativasS'], $_POST['categoriaS'], $_POST['estadoDesafio']) ) {

			// set dados
			$obMeusDesafio->id             = $_POST['idPrimario'] ?? '';
	    $obMeusDesafio->id_user        = $codigoUser;
	    $obMeusDesafio->id_desa_exerc  = $_POST['idExercicio'];
	    $obMeusDesafio->solucao        = $_POST['solucaoDesafio'];
	    $obMeusDesafio->pego_em        = $_POST['dataCriacao'];
	    $obMeusDesafio->categoria      = $_POST['categoriaS'];
	    $obMeusDesafio->tentativas     = $_POST['tentativasS'] + 1;
	    $obMeusDesafio->estado         = $_POST['estadoDesafio'];

			// get solucao do desafio
      $whereSolucao = 'id_user = "'. $codigoUser .'" AND id_desa_exerc = "'. $_POST['idExercicio'] .'"';
      $getSolucao = $obMeusDesafio->getDesafiosAceites( $whereSolucao, null, '1');

			// controler
			$resultadoSolucao = '';

      // obter resultado
      foreach ( $getSolucao as $key => $solucao ) {

				// controler
				$resultadoSolucao = 'Manuel Benedito, O Cara!';

      }

			if ( $resultadoSolucao == 'Manuel Benedito, O Cara!' ) {

				// Actualizar solucao do desafio
				if ( $obMeusDesafio->actualizar() ) {
					// tudo ok
					header('location: ');
				} else {
					// reportar erro
				}

			} else {

				// Cadastrar solucao do desafio
				if ( $obMeusDesafio->cadastrar() ) {
					// tudo ok
				} else {
					// reportar erro
				}

			}

		}

		header('location: ');
	}

	// Adicionar a lista de exercicios por resolver
	if ( isset( $_POST['btn-resolver-depois'] ) ) {

		// Verificar dados necessarios
		if ( isset($_POST['idPrimario'], $_POST['idExercicio'], $_POST['solucaoDesafio'], $_POST['dataCriacao'], $_POST['tentativasS'], $_POST['categoriaS'], $_POST['estadoDesafio']) ) {

			// set dados
	    $obMeusDesafio->id_user        = $codigoUser;
	    $obMeusDesafio->id_desa_exerc  = $_POST['idExercicio'];
	    $obMeusDesafio->solucao        = $_POST['solucaoDesafio'];
	    $obMeusDesafio->pego_em        = $_POST['dataCriacao'];
	    $obMeusDesafio->categoria      = $_POST['categoriaS'];
	    $obMeusDesafio->tentativas     = $_POST['tentativasS'];
	    $obMeusDesafio->estado         = $_POST['estadoDesafio'] ?? 'p';

			// Cadastrar solucao do desafio
			if ( $obMeusDesafio->cadastrar() ) {
				// tudo ok
			} else {
				// reportar erro
			}

		}

		header('location: ');

	}

	// Actualizar o desafio
	if ( isset( $_POST['btn-Actualizar'] ) ) {

		// verifica dados necessarios
		if ( isset( $_POST['titulo'], $_POST['idDesafio'], $_POST['desafioText'], $_POST['dataCriacao'], $_POST['desafioSobre'], $_POST['nivelDificuldade'], $_POST['categoriaDes'] ) ) {

			// set dados do desafio
			$obDesafio->id             = $_POST['idDesafio'];
	    $obDesafio->titulo         = $_POST['titulo'];
	    $obDesafio->desafio        = $_POST['desafioText'];
	    $obDesafio->sobre          = $_POST['desafioSobre'];
	    $obDesafio->adicionada_por = $codigoUser;
	    $obDesafio->data_inicio    = $_POST['dataCriacao'];
	    $obDesafio->nivel          = $_POST['nivelDificuldade'];
	    $obDesafio->categoria      = $_POST['categoriaDes'];

			// actulizar os dados
			if ( $obDesafio->actualizar() ) {
				// tudo ok
			} else {
				// Reportar erro
			}
		}

		// Actualizar pagina
		header('location: ');

	}

	// Apagar desafio
	if ( isset( $_POST['btn-apagar'], $_POST['idDesafio'] ) ) {

		// set dados necessarios
		$obDesafio->id             = $_POST['idDesafio'];
		$obDesafio->adicionada_por = $codigoUser;

		// actulizar os dados
		if ( $obDesafio->excluir() ) {
			// tudo ok
		} else {
			// Reportar erro
		}

		// Redirecionar a pagina
		header('location: /desafios.php');

	}

	// get lista de desafios e exercicios
	$carregarLista = '';

	// filtras requisitos das buscas
	$b_frase  = filter_input(INPUT_GET, 'pesquisar_por', FILTER_SANITIZE_STRING);
	$b_filtro = filter_input(INPUT_GET, 'filtrar_por', FILTER_SANITIZE_STRING);

	// Validar filtro
	$b_filtro = in_array($b_filtro, ['d', 'e', 'p', 'a', 'r'])? $b_filtro: '';

	// Condicoes SQL
	$condicoes = [
		strlen( $b_frase )? 'titulo LIKE "%'. $b_frase .'%"': null,
		strlen( $b_frase )? 'titulo LIKE "%'. $b_frase .'%"': null,
		strlen( $b_filtro )? 'categoria = "'. $b_filtro .'"': null,
	];

	// remover posicoes vazias
	$condicoes = array_filter( $condicoes );

	// monta clausula where
	$where = implode(' AND ', $condicoes);

	// instancia um objecto da classe desafios
	$obTodosExercDesaf = $obDesafio->getDesafios( $where );

	// clausula where exercicios
	$whereExercicios = 'id_user ="'. $codigoUser .'" AND categoria = "e" AND estado = "p" OR estado = "a"';

	// get lista de exercicios
	$obExerciciosAceites = $obMeusDesafio->getDesafiosAceites($whereExercicios, null, '8');

	// clausula where get desafios
  $whereDesafios = 'id_user ="'. $codigoUser .'" AND categoria = "d" AND estado = "p" OR estado = "a"';

  // Get lista de desafios
  $obDesafiosAceites = $obMeusDesafio->getDesafiosAceites( $whereDesafios, null, '8' );

	// condicoes para obter exercicios
	$whereExercicios = 'categoria = "e"';

	// objecto para obter exercicios
	$obListaExercicios = $obDesafio->getDesafios( $whereExercicios, 'titulo DESC', '12' );

	// get Quantidade de exercicios
	$getQuantidadeExercicios = $obDesafio->getQuantidadeDesafios( $whereExercicios );

	// condicoes para obter desafios
	$whereDesafios = 'categoria = "d"';

	// objeto para obter desafios
	$obListaDesafios = $obDesafio->getDesafios( $whereDesafios, 'titulo DESC', '12' );

	// get quantidade de desafios
	$getQuantidadeDesafios = $obDesafio->getQuantidadeDesafios( $whereDesafios );


/*
	echo '<pre>';
	print_r( $obDesafiosAceites );
	echo '<pre>'; exit;*/

	//Exibe mensagens de aviso
	include __DIR__.'/includes/avisos.php';

	//Carrega a interface padrao
	include __DIR__."/includes/header.php";
	include __DIR__."/includes/desafios.php";
	include __DIR__."/includes/footer.php";
	include __DIR__.'/includes/centralAjuda.php';
