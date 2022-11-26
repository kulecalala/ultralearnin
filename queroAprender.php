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

	// Actualizar dados do objectivo
	if ( isset( $_POST['btn-Actualizar'] ) ) {

		// verifica os dados necessarios
		if ( isset( $_POST['titulo'], $_POST['idHab'], $_POST['descricao'], $_POST['dataCriacao'], $_POST['tecnologia'], $_POST['sobreHab'], $_POST['percentagemHab'], $_POST['estadoHab'] ) ) {

			// set dados
			$obAprender->id          = $_POST['idHab'];
	    $obAprender->descricao   = $_POST['descricao'];
	    $obAprender->key_word    = $_POST['titulo'];
	    $obAprender->tecnologia  = $_POST['tecnologia'];
	    $obAprender->lancado_em  = $_POST['dataCriacao'];
	    $obAprender->sobre       = $_POST['sobreHab'];
	    $obAprender->percentagem = $_POST['percentagemHab'];
	    $obAprender->criada_por  = $codigoUser;
	    $obAprender->estado      = $_POST['estadoHab'];

			// Actualiza os dados da habilidade
			if ( $obAprender->actualizar() ) {
				// tudo ok
			} else {
				// reportar erro
			}

			// actualiza a pagina
			header('location: ');

		}
	}

	// Apagar determinada habilidade
	if ( isset( $_POST['btn-apagar'] ) ) {

		if ( isset( $_POST['idHab'] ) ) {
			$obAprender->id = $_POST['idHab'];

			// excluir habilidade
			if ($obAprender->excluir() ) {
				// tudo ok
			} else {
				// reportar erro
			}

			// redirecionar
			header('location: /queroAprender.php');
		}

	}

	// lista de coisas a aprender
	$formatarAprender = '';

	// codigo da habilidade
	$idHabilidadeS = filter_input(INPUT_GET, 'queroAprenderCod', FILTER_SANITIZE_STRING);

	// realizar buscas - filros
	$b_frase  = filter_input(INPUT_GET, 'pesquisar_por', FILTER_SANITIZE_STRING);
	$b_filtro = filter_input(INPUT_GET, 'filtrar_por', FILTER_SANITIZE_STRING);

	// validar filtro
	$b_filtro = in_array($b_filtro, ['p', 'a', 'f', 'r'])? $b_filtro: '';

	// Condicoes SQL
	$condicoes = [
		strlen( $b_frase )? 'descricao LIKE "%'. $b_frase .'%"': null,
		strlen( $b_frase )? 'key_word LIKE "%'. $b_frase .'%"': null,
		strlen( $b_filtro )? 'estado = "'. $b_filtro .'"': null,
		strlen( $idHabilidadeS )? 'id = "'. $idHabilidadeS .'"': null,
		'criada_por = "'. $codigoUser .'"'
	];

	// remove posicoes vazias
	$condicoes = array_filter( $condicoes );

	// monta a clausula where
	$where = implode(' AND ', $condicoes);

	// Resultados gerais
	$todoOqueQueroAprender = $obAprender->getResultados($where, null, '20');

	// Lista de habilidades a aprender
	$obAAprender = $obAprender->getResultados('estado = "a" AND criada_por = "'. $codigoUser .'"', 'lancado_em ASC', '8');

	// Lista de habilidades por aprender
	$obPorAprender = $obAprender->getResultados('estado = "p" AND criada_por = "'. $codigoUser .'"', 'lancado_em ASC', '8');

	// Lista de habilidades aprendidas
	$obAprendidasHab = $obAprender->getResultados('estado = "f" AND criada_por = "'. $codigoUser .'"', 'lancado_em ASC', '8');

	// Lista de habilidades a serem revisadas
	$obHabilidadesARev =  $obAprender->getResultados('estado = "r" AND criada_por = "'. $codigoUser .'"', 'lancado_em ASC', '8');

	//Exibe mensagens de aviso
	include __DIR__.'/includes/avisos.php';

	//Carrega a interface padrao
	include __DIR__."/includes/header.php";
	include __DIR__."/includes/queroAprender.php";
	include __DIR__."/includes/footer.php";
	include __DIR__.'/includes/centralAjuda.php';
