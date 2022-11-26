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

	// Marcar tarefa feita
	if ( isset($_POST['btn-tFeita']) ) {

	  if ( isset($_POST['idTarefa'], $_POST['dataCricao'], $_POST['titulo'], $_POST['descricao'], $_POST['cadeira'], $_POST['estado']) ) {

		 	// get dados
	  	$id        = $_POST['idTarefa'];
			$data      = filter_var($_POST['dataCricao'], FILTER_SANITIZE_STRING);
		  $titulo    = filter_var($_POST['titulo'], FILTER_SANITIZE_STRING);
			$descricao = filter_var($_POST['descricao'], FILTER_SANITIZE_STRING);
			$repetir   = $_POST['renovar'];
			$sobre     = $_POST['cadeira'];

			// set dados
			$obToDoList->id        = $id;
		  $obToDoList->id_user   = $codigoUser;
		  $obToDoList->titulo    = $titulo;
		  $obToDoList->descricao = $descricao;
		  $obToDoList->sobre     = $sobre;
			$obToDoList->data      = $data;
			$obToDoList->feitaEm  = date('Y-m-d H:i:s');
		  $obToDoList->renovar   = $repetir;
			$obToDoList->estado    = 'f';

			// marcar como feita
			if ( $obToDoList->actualizar() ) {
				// tudo ok
				$mensagem = 'A sua tarefa foi realizada com sucesso!';
			} else {
				// reportar erro
				$mensagem = 'Ops! Ocorreu um erro o actualizar estado da tarefa para feita!';
			}

		}

	}

	// delete tarefa
	if ( isset($_POST['btn-delete']) ) {

		if ( isset($_POST['idTarefa']) ) {

			// set dados
			$obToDoList->id        = $_POST['idTarefa'];
	    $obToDoList->id_user   = $codigoUser;

			// Apagar tarefa
			if ( $obToDoList->excluir() ) {
				// tudo ok
				$mensagem = 'A sua tarefa foi apagada com sucesso!';
			} else {
				// reportar erro
				$mensagem = 'Ops! Ocorreu um erro ao apagar a tarefa!';
			}

		}

	}

	// actualizar tarefa
	if ( isset($_POST['btn-update']) ) {

		// verifica dados necessarios
		if ( isset($_POST['idTarefa'], $_POST['dataCricao'], $_POST['titulo'], $_POST['descricao'], $_POST['repetir'], $_POST['cadeira'], $_POST['estado']) ) {

			// get dados
			$id        = $_POST['idTarefa'];
			$data      = filter_var($_POST['dataCricao'], FILTER_SANITIZE_STRING);
			$titulo    = filter_var($_POST['titulo'], FILTER_SANITIZE_STRING);
			$descricao = filter_var($_POST['descricao'], FILTER_SANITIZE_STRING);
			$repetir   = $_POST['repetir'];
			$sobre     = $_POST['cadeira'];
			$estado    = $_POST['estado'];

			// set dados
			$obToDoList->id        = $id;
	    $obToDoList->id_user   = $codigoUser;
	    $obToDoList->titulo    = $titulo;
	    $obToDoList->descricao = $descricao;
	    $obToDoList->sobre     = $sobre;
	    $obToDoList->renovar   = $repetir;

			// repetir a tarefa
			if ( $repetir == 'y' ) {
				// sim

				// formata data de criacao
				$dataCri22 = substr($_POST['actualizada'], 0, 10);

				// verifica se a tarefa foi feita hoje
				if ( $dataCri22 == date('Y-m-d') ) {
					// sim
					$obToDoList->data    = $data;
					$obToDoList->feitaEm = date('Y-m-d H:i:s');
					$obToDoList->estado  = $estado;
				} else {
					// nao
				  $obToDoList->data    = date('Y-m-d H:i:s');
				  $obToDoList->feitaEm = null;
				  $obToDoList->estado  = 'p';
			  }

			} else {
				// nao
				$obToDoList->data    = $data;
				$obToDoList->feitaEm = date('Y-m-d H:i:s');
				$obToDoList->estado  = $estado;
			}

			// actualizar
			if ( $obToDoList->actualizar() ) {
				// tudo ok
				$mensagem = 'Os detalhes da sua tarefa foram actualizados com sucesso!';
			} else {
				// reportar erro
				$mensagem = 'Ops! Ocorreu um erro ao actualizar os detalhes da tarefa!';
			}

		}

	}

	// filtros
	$b_titulo = filter_input(INPUT_GET , 'buscar', FILTER_SANITIZE_STRING);
	$b_estado = filter_input(INPUT_GET , 'tipo', FILTER_SANITIZE_STRING);

	// condicoes SQL
	$condicoes = [
		strlen( $b_titulo )? 'titulo LIKE "%'.str_replace(' ', '%', $b_titulo).'%"': null,
		strlen( $b_estado )? 'estado = "'.$b_estado.'"': null,
		strlen( $b_titulo )? 'descricao LIKE "'.str_replace(' ', '%', $b_titulo).'"': null
	];

	// remove posicoes vazias
	$condicoes = array_filter( $condicoes );

	// clausula where
	$where = implode(' OR ', $condicoes);

	// Adiciona o utilizador a condicao
	$where = strlen($where)? $where.' AND id_user = "'.$codigoUser.'"': 'id_user = "'.$codigoUser.'"';

	/*echo '<pre>';
	print_r( $where );
	echo '</pre>'; exit;*/

	// quanridade de tarefas
	$qtdeTarefas = $obToDoList->getQuantidadeTarefas($where);

  // get tarefas
  $getMyToDoList = $obToDoList->getTarefas($where, 'estado ASC');

	//Exibe mensagens de aviso
	include __DIR__.'/includes/avisos.php';

	//Carrega a interface padrao
	include __DIR__."/includes/header.php";
	include __DIR__."/includes/gestorDeTarefas.php";
	include __DIR__."/includes/footer.php";
	include __DIR__.'/includes/centralAjuda.php';
