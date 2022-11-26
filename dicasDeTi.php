<?php
	session_start();
	require __DIR__.'/vendor/autoload.php';

	//Controle de acesso
	use \App\Config\AcessoControl;
	use \App\Db\Pagination;

	//set dados user
	$statusOn = new AcessoControl($_SESSION['userId'], $_SESSION['userLog']);

	//Avisos
	$mensagem = '';

	//Configuracao do formulario de acesso rapido
	include __DIR__.'/includes/add_config.php';
	include __DIR__.'/includes/add.php';

	// usa a class
	use \App\Entity\DicasDeTiLidas;
	use \App\Entity\DicasDeTiReacoes;
	use \App\Entity\DicasDeTiComentarios;

	// Instancia um objecto da class
	$obDicasLidas  = new DicasDeTiLidas();
	$obDicaReacoes = new DicasDeTiReacoes();
  $obDicaComents = new DicasDeTiComentarios();

	// Actualizar dica de ti
	if ( isset( $_POST['btn-actualizar-dica'] ) ) {

		// verifica se os dados foram enviados
		if ( isset($_POST['idDica'], $_POST['categoriaDica'], $_POST['tecnologiaDica'], $_POST['dica']) ) {

			// set dados
			$obBoaPratica->id         = $_POST['idDica'];
	    $obBoaPratica->boaPratica = filter_var($_POST['dica'], FILTER_SANITIZE_STRING);
	    $obBoaPratica->tecnologia  = $_POST['tecnologiaDica'];
	    $obBoaPratica->categoria   = $_POST['categoriaDica'];
	    $obBoaPratica->criada_por  = $codigoUser;
	    $obBoaPratica->criada_em   = date('Y-m-d H:i:s');

			if ( $obBoaPratica->actualizar() ) {
				// tudo ok
				$mensagem = 'A dica de T.I foi actualizada com sucesso!';
			} else {
				// reportar erro
				$mensagem = 'Não foi possivel actualizar a dica de T.I, tente novamente';
			}

		}

	}

	// Apagar dica de ti
	if ( isset( $_POST['btn-apagar-dica'] ) ) {

		// verifica se os dados foram enviados
		if ( isset($_POST['idDica']) ) {

			// set dados
			$obBoaPratica->id = $_POST['idDica'];

			if ( $obBoaPratica->excluir() ) {
				// tudo ok
				$mensagem = 'A dica de T.I foi apagada com sucesso!';
			} else {
				// reportar erro
				$mensagem = 'Não foi possivel apagar a dica de T.I, tente novamente!';
			}

		}

	}

	// Apagar comentario
  if ( isset( $_POST['Apagar-comentario'] ) ) {

    // dados necessarios
    if ( isset( $_POST['idComentario'] ) ) {
      $obDicaComents->id = $_POST['idComentario'];

      if ( $obDicaComents->excluir() ) {
        // tudo ok
				$mensagem = 'O seu comentario a esta publicação foi apagado com sucesso!';
      } else {
        // reportar erro
				$mensagem = 'Não foi possivel apagar o seu comentario nesta publicação!';
      }

    }

  }

	// Adiconar comentarios
	if ( isset($_POST['addComent']) ) {

		if ( isset( $_POST['comentario'],$_POST['idDica'] ) ) {

			// set dados
			$obDicaComents->comentario = filter_var($_POST['comentario'], FILTER_SANITIZE_STRING);
			$obDicaComents->id_user = $codigoUser;
			$obDicaComents->id_dica = $_POST['idDica'];

			// inserir comentario
			if ( $obDicaComents->cadastrar() ) {
				// tudo ok
			} else {
				$mensagem = 'Não foi foi possivel adicionar o seu comentario!';
				// reportar erro
			}

		}

	}

	// Adicionar/remover fixe/gato
	if ( isset($_POST['addReacao']) ) {

		// verfica dados necessarios
		if ( isset($_POST['idDica'], $_POST['reacao']) ) {
	    $obDicaReacoes->id_user  = $codigoUser;
	    $obDicaReacoes->id_dica  = $_POST['idDica'];
	    $obDicaReacoes->reacoes  = $_POST['reacao'];

			$where = 'id_user = "'. $codigoUser .'" AND id_dica = "'. $_POST['idDica'] .'"';
			$findReacao = $obDicaReacoes->getReacoes($where, null, '1');

			// ID da reacao
			$idReacao = '';

			// Qual foi a reacao
			$aReacao  = '';

			// Variavel controler
			$controler = false;

			// Set os resultados
			foreach ( $findReacao as $key => $dados ) {

				// set dados
				$idReacao  = $dados->id;
				$aReacao   = $dados->reacoes;
				$controler = true;

			}

			// Verifica se a reacao do user foi localizada
			if ( $controler == true ) { // true
				// Excluir

				// set id
				$obDicaReacoes->id = $idReacao;

				// A reacao existe
				if ( $aReacao == $_POST['reacao'] ) { // true

					// Excluir
					if ( $obDicaReacoes->excluir() ) {
						// tudo Ok
					} else {
						// reportar erro
						$mensagem = 'Não foi possivel remover a sua reação!';
					}

				} else { // false

					// Actalizar
					if ( $obDicaReacoes->actualizar() ) {
						// tudo ok
					} else {
						// reportar erro
						$mensagem = 'Erro ao actualizar a sua reação a publicação!';
					}

				}

			} else { // false
				// Cadastrar

				// cadastrar
				if ( $obDicaReacoes->cadastrar() ) {
					// tudo ok
				} else {
					// reportar erro
					$mensagem = 'Não foi possivel adicionar reação!';
				}

			}

		}

	}

	// Salvar denuncia
	if ( isset( $_POST['btn-denunciar'] ) ) {

		if ( isset($_POST['idDica']) ) {

			// set dados
			$obDenuncias->descricao = 'A dica de T.I viola as regras da plataforma, foi marcada para revisão por usuario do sistema!';
			$obDenuncias->id_user   = $codigoUser;
			$obDenuncias->id_sobre  = $_POST['idDica'];

			// cadastrar
			if ( $obDenuncias->cadastrar() ) {
				// tudo ok
				$mensagem = 'A sua denuncia foi efectuada com sucesso!';
			} else {
				// erro
				$mensagem = 'Erro ao denunciar a dica de sabedoria!';
			}

		}

	}

	// marcar dica como lida
	if ( isset( $_POST['lerDica'] ) ) {

		if ( isset( $_POST['idDica'] ) ) {

			$where = 'id_dica = "'. $_POST['idDica'] .'" AND id_user = "'. $codigoUser .'"';
			$lidas = $obDicasLidas->getLidas( $where );

			$jaFoiLida = false;
			$id_lida = '';

			foreach ($lidas as $key => $value ) {

				$id_lida = $value->id;

				$jaFoiLida = true;
			}

			// id dica
			$obDicasLidas->id      = $id_lida;
			$obDicasLidas->id_dica = $_POST['idDica'];
			$obDicasLidas->id_user = $codigoUser;

			if ( $jaFoiLida ) {

				// remover como lida
				if ( $obDicasLidas->excluir() ) {
					// tudo ok
					$mensagem = 'Removida da lista de dicas lidas!';
				} else {
					// erro
					$mensagem = 'Erro ao remover da lista de dicas lidas!';
				}

			} else {

				// cadastrar como lida
				if ( $obDicasLidas->cadastrar() ) {
					// tudo ok
					$mensagem = 'Adicionada a lista de dicas lidas!';
				} else {
					// erro
					$mensagem = 'Erro ao adicionar a lista de dicas lidas!';
				}

			}
		}


	}

	// get quantidaDeDicas lidas
	$whereQtdeLidas = 'id_user = "'. $codigoUser .'"';

	// get quantidade de dicas lidas
	$qtdeDicasLidasByMe = $obDicasLidas->getQuantidadeLidas( $whereQtdeLidas );

	// set dados necessarios a busca
	$b_frase  = filter_input(INPUT_GET, 'fraseDica', FILTER_SANITIZE_STRING);
	$b_filtro = filter_input(INPUT_GET, 'filtrarDica', FILTER_SANITIZE_STRING);
	$b_catego = filter_input(INPUT_GET, 'filtrarDicaCategoria', FILTER_SANITIZE_STRING);

	// Condicoes SQL
	$condicoes = [
		strlen( $b_frase )? 'boaPratica LIKE "%'. $b_frase .'%"': null,
		strlen( $b_filtro )? 'tecnologia = "'. $b_frase .'"': null,
		strlen( $b_catego )? 'categoria = "'. $b_catego .'"': null
	];

	//Boas praticas de programacao
  $getBoasPraticas = $obCategoriaB->getCategorias( null,'titulo DESC');

  // lista de boas praticas
  $listarBoasPraticasTi = '';

	// remove posicoes vazias
	$condicoes = array_filter($condicoes);

	// Clausula where
	$where = implode(' OR ', $condicoes);

	// ob dicas de ti
	$dicasDeTi = $obBoaPratica->getBoasPraticas();

	// quantidade de dicas de ti
	$quantidadeDeDicas = $obBoaPratica->getQuandidadeBoasPraticas( $where );

	// Paginacao
	$obPagination = new Pagination($quantidadeDeDicas, $_GET['pagina']?? 1, 25);

	// Dicas de t.i
	$dicasDeTI = $obBoaPratica->getBoasPraticas( $where, 'criada_em DESC', $obPagination->getLimit() );

	//get Tecnologia
  $getTecnologias = $obTecnologia->getTecnologias(null,'titulo ASC','');

	//Exibe mensagens de aviso
	include __DIR__.'/includes/avisos.php';

	//Carrega a interface padrao
	include __DIR__."/includes/header.php";
	include __DIR__."/includes/dicasDeTi.php";
	include __DIR__."/includes/footer.php";
	include __DIR__.'/includes/centralAjuda.php';
