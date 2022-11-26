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

	// usa a class
	use \App\Entity\TipoCadeiras;

	// instancia objecto
	$obTipoCadeiras    = new TipoCadeiras();

	// Salvar cadeiras
  if ( isset($_POST['AddCadeiras']) ) {

    // Verifica dados necessarios
    if ( $_POST['cadeira'] != '' ) {

			// set id cadeira
      $obMinhasCad->cadeira   = $_POST['cadeira'];   // Cadeira id

			$obMinhasCad->professor = 1; // Professor id
      $obMinhasCad->user      = $codigoUser; // id utilizador

      if( $obMinhasCad->cadastrar() ) { //true

        $descricao = 'A nova cadeira foi salva com sucesso, não te esqueças, conhecimento e poder!';

        $obNotificacoes->user_id         = $codigoUser;
        $obNotificacoes->breve_descricao = $descricao;
        $obNotificacoes->caminho         = '/cadeiras.php';

        if ( $obNotificacoes->cadastrar() ) {
          // tudo ok
          $mensagem = 'Uma nova cadeira foi adicionada a sua lista de cadeiras!';
        } else {
          // reportar o erro
          $mensagem = 'Ops! Ocorreu um erro ao salvar a nova cadeira!';
        }

      } else { //false
        $mensagem = 'Ops! Ocorreu um erro ao salvar a nova cadeira!';
      }

    }

  }

	// Actualizar dados sobre a cadeira
	if ( isset( $_POST['actualizar'] ) ) {

		if( isset($_POST['periodo'], $_POST['dataInicio'], $_POST['dataTermino'], $_POST['pontosNecessarios'], $_POST['oProfessor'], $_POST['observacoes'], $_POST['estadoDaCadeira'], $_POST['idMinhaCad'], $_GET['id'] ) ) {

			// id da minha cadeira
			$idUserCad = filter_var($_POST['idMinhaCad'], FILTER_SANITIZE_STRING);

			// id da cadeira 'geral'
			$id = filter_var($_GET['id'], FILTER_SANITIZE_STRING);

			// periodo de estudo
			$periodo = in_array($_POST['periodo'], ['i', 't', 's', 'a'])? $_POST['periodo']: 'i';

			// observações
			$observacoes = filter_var($_POST['observacoes'], FILTER_SANITIZE_STRING) ?? null;

			// pontos necessarios
			$pontos = is_numeric($_POST['pontosNecessarios'])? $_POST['pontosNecessarios']: '0';

			// set dados da cadeira
			$obMinhasCad->id 							  = $idUserCad;
			$obMinhasCad->cadeira           = $id;
			$obMinhasCad->periodo 					= $periodo;
			$obMinhasCad->professor         = $_POST['oProfessor'];
			$obMinhasCad->observacoes       = $observacoes;
			$obMinhasCad->pontosNecessarios = $pontos;
			$obMinhasCad->user              = $codigoUser;
			$obMinhasCad->criadaEm          = $_POST['dataInicio'];
			$obMinhasCad->terminadaEm       = $_POST['dataTermino'];
			$obMinhasCad->estados           = $_POST['estadoDaCadeira'];


			//echo '<pre>'; print_r( $obMinhasCad ); echo '</pre>'; exit;

			if ( $obMinhasCad->actualizar() ) {

				$descricao = 'Os dados refentes a cadeira foram actualizados com sucesso!';

				$obNotificacoes->user_id         = $codigoUser;
        $obNotificacoes->breve_descricao = $descricao;
        $obNotificacoes->caminho         = '/cadeiras.php';

        if ( $obNotificacoes->cadastrar() ) {
          // tudo ok!
					$mensagem = 'Os dados referentes a cadeira foram actualizados com sucesso!';
        } else {
          // reportar o erro
					$mensagem = 'Ops! Ocorreu um erro ao actualizar os dados da cadeira!';
        }

			} else {
				$mensagem = 'Erro ao actualizar os dados referentes a cadeira!';
			}

		} else {
				$mensagem = 'Dados necessarios para a actualização das informações referentes a cadeira em falta, por favor preencha todos os campos!';
		}

	}

	// Eliminar cadeira
	if ( isset( $_POST['eliminar'] ) && is_numeric($_POST['idMinhaCad']) ) {

		if ( isset( $_POST['idMinhaCad'] ) ) {

			// id cadira
			$id = filter_var($_POST['idMinhaCad'], FILTER_SANITIZE_STRING);

			// set id cadeira
			$obMinhasCad->id = $id;

			if ( $obMinhasCad->excluir() ) {
				$descricao = 'Eliminaste uma das suas cadeiras!';

        $obNotificacoes->user_id         = $codigoUser;
        $obNotificacoes->breve_descricao = $descricao;
        $obNotificacoes->caminho         = '/cadeiras.php';

        if ( $obNotificacoes->cadastrar() ) {
					// tudo ok
					unset( $_GET['id'] ); // reseta o metodo get

					// sms informativa
					$mensagem = 'A sua cadeira foi eliminada com sucesso!';
        } else {
          // reportar o erro
					$mensgaem = 'Ops! Não foi possivel eliminar a cadeira, tente novamente!';
        }

			} else {
				$mensagem = 'Por motivos tecnicos não foi possivel eliminar a cadeira, por favor, tente novamente!';
			}

		} else {
			$mensagem = 'O codigo da cadeira é necessario para poder apaga-la, por favor, informe-o!';
		}

	}

	// control de acesso
	$controlDeAcesso = false;

	// Dados da cadeira do estudante
	$nomeCadeira      = '';
	$categoriaCadeira = '';
	$descricaoCadeira = '';
	$fotoCadeira      = '';

	$idMinhaCad    = '';
	$periodo       = '';
	$dataInicio    = '';
	$dataFinalizar = '';
	$estadoCade    = '';
	$periodo       = '';
	$sobreCadeira  = '';
	$pontosNecessarios = '';
	$oProfessor    = '';

	// Notas do estudante
	$asMinhasNotas = '';

	// Visualizar dados da minha cadeira
	if ( isset( $_GET['id'] ) && is_numeric( $_GET['id'] ) ) {

		$cadeira = $obMinhasCad->getMinhasCadeiras("cadeira = ". $_GET['id'] ." AND user = ". $codigoUser, "1" );

		foreach( $cadeira as $dados ) {

			// control de acesso
			$controlDeAcesso = true;

			$informacoes = $obCadeiras->getCadeira( $dados->cadeira );

			$tipoCad = $obTipoCadeiras->getTipoCad( $informacoes->tipo );

			$prof_id = $obMeusProfessores->getMeuProfessor( $dados->professor );

			$prof_nome = $obProfessor->getProfessor( $prof_id->id_proff );

			//echo '<pre>'; print_r(); echo '</pre>'; exit;

			// Dados da cadeira
			$nomeCadeira      = $informacoes->titulo ?? '...';
			$categoriaCadeira = $tipoCad->tipo ?? '...';
			$descricaoCadeira = $informacoes->descricao ?? '...';
			$fotoCadeira      = $informacoes->foto;

			// Dados relacionados a cadeira
			$idMinhaCad    = $dados->id;
			$periodo       = $dados->periodo ?? '...';
			$dataInicio    = $dados->criadaEm ?? '...';
			$dataFinalizar = $dados->terminadaEm ?? '...';
			$estadoCade    = $dados->estados ?? '...';
			$sobreCadeira  = $dados->observacoes ?? '...';
			$pontosNecessarios = $dados->pontosNecessarios ?? 12;
			$oProfessor        = $prof_nome->nome ?? '...';

		}

		// get lista de professores
		$meusProfessores = $obMeusProfessores->getMeusProfessores('id_user="'. $codigoUser .'"');

		$listarMeusProfessores = '';

		foreach( $meusProfessores as $key=>$professores ) {

			$nomeDoProfessor = $obProfessor->getProfessor( $professores->id_proff );

			$selecione = ( $oProfessor == $professores->id )? 'selected': '';

			$listarMeusProfessores .= '<option value="'. $professores->id .'" '. $selecione .'>
																	 '. 	$nomeDoProfessor->nome .'
																 </option>';
		}



		// Periodo de duracao
		$duracao = $periodo;

		switch ($periodo) {
			case 'i':
				$periodo = 'Indisponivel';
				break;
			case 't':
				$periodo = 'Trimestral';
				break;
			case 's':
				$periodo = 'Semestral';
				break;
			case 'a':
				$periodo = 'Anual';
				break;
			default:
				$periodo = 'Error...';
				break;
		}

		// Estados da cadeira
		$statusCade = $estadoCade;
		switch ($estadoCade) {
			case 'p':
				$estadoCade = 'Por fazer';
				break;
			case 'f':
				$estadoCade = 'A fazer';
				break;
			case 'r':
				$estadoCade = 'Em recurso';
				break;
			case 'e':
				$estadoCade = 'Em exame';
				break;
			case 'a':
					$estadoCade = 'A repetir';
					break;
			case 't':
					$estadoCade = 'Terminada';
					break;
			default:
				$estadoCade = 'Error...';
				break;
		}

		// Verifica a foto da cadeira, caso nao seta uma padrao
		$fotoCadeira = $fotoCadeira ?? 'mfkb-o-cara.jpeg';

		$getCategoriaCad = '';

		// get notas
		$asMinhasNotas = '';
	}

	// Verifica se ha notas
	if (strlen( $asMinhasNotas ) > 0 ) {
		$asMinhasNotas = '<div id="see-mys-grades">

											</div>';
	} else {
		$asMinhasNotas = '<div id="see-mys-grades">
											  <p>As notas encontram-se indisponiveis!</p>
											</div>';
	}

	// filtros
	$b_nomeCade = filter_input(INPUT_GET , 'buscarPor', FILTER_SANITIZE_STRING);
	$b_tipoCade = filter_input(INPUT_GET , 'tipoCad', FILTER_SANITIZE_STRING);

	// condicoes SQL
	$condicoes = [
		strlen( $b_nomeCade )? 'titulo LIKE "%'.$b_nomeCade.'%"': null,
		strlen( $b_tipoCade )? 'tipo = "'.$b_tipoCade.'"': null,
		strlen( $b_nomeCade )? 'descricao LIKE "'.$b_nomeCade.'"': null
	];

	// remove posicoes vazias
	$condicoes = array_filter( $condicoes );

	// clausula where
	$where = implode(' OR ', $condicoes);

	// quantidade de cadeiras
	$qtdeCadeiras = $obCadeiras->getQuantidadeCadeiras($where);

	// listar tipo de cadeiras
	$tipoCadeiras = $obTipoCadeiras->getTiposCad(null, 'tipo DESC');

	//Exibe mensagens de aviso
	include __DIR__.'/includes/avisos.php';

	//Carrega a interface padrao
	include __DIR__."/includes/header.php";
	include __DIR__."/includes/cadeiras.php";
	include __DIR__."/includes/footer.php";
	include __DIR__.'/includes/centralAjuda.php';
