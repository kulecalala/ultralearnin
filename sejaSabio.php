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

	// Dicas lidas
	use \App\Entity\DicasRiquezasLidas;
  use \App\Entity\DicasRiquezasReacoes;
  use \App\Entity\DicasRiquezaComentarios;

	// Instancia um objecto da class
	$obDicasLidas  = new DicasRiquezasLidas();
	$obDicaReacoes = new DicasRiquezasReacoes();
  $obDicaComents = new DicasRiquezaComentarios();

	// Salvar denuncia
	if ( isset( $_POST['btn-denunciar'] ) ) {

		if ( isset($_POST['idDica']) ) {

			// set dados
			$obDenuncias->descricao = 'A dica de sabedoria viola as regras da plataforma!';
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
	$qtdeDicasLidasByMe = $obDicasLidas->getQuantidadeLidas( $whereQtdeLidas );

	// Actualizar dica de sabedoria
	if ( isset( $_POST['btn-actualizar'] ) ) {

		if ( isset( $_POST['dica'], $_POST['origem'], $_POST['idDica'] ) ) {

			// set dados necessarios
			$obDicas->id             = $_POST['idDica'];
			$obDicas->dica           = filter_var($_POST['dica'], FILTER_SANITIZE_STRING);
			$obDicas->id_user        = $codigoUser;
			$obDicas->origem         = filter_var($_POST['origem'], FILTER_SANITIZE_STRING);
			$obDicas->actualizado_em = date('Y-m-d H:i:s');

			// Actualizar dica
			if ( $obDicas->actualizar() ) { //true
				// Tudo ok
				$mensagem = 'A sua dica de sabedoria foi actualizada com sucesso!';
			} else { // False
				// erro
				$mensagem = 'Não foi possivel actualizar a sua dica de sabedoria, tente novamente!';
			}

		}

	}

	// Apagar dica de sabedoria
	if ( isset( $_POST['btn-apagar'] ) ) {
		if ( $_POST['idDica'] ) {
			$obDicas->id = $_POST['idDica'];

			if ( $obDicas->excluir() ) {
				$mensagem = 'A dica de sabedoria foi apagada com sucesso!';
			} else {
				$mensagem = 'Não foi possivel apagar esta dica de sabedoria!';
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

			// set dados
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
						$mensagem = '';
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

	// Busca
	$busca = filter_input(INPUT_GET, 'fraseSabio', FILTER_SANITIZE_STRING);

	// Condicoes SQL
	$condicoes = [
		strlen( $busca ) ? 'dica LIKE "%'. str_replace(' ', '%', $busca). '%"' : null,
		strlen( $busca ) ? 'origem LIKE "%'. str_replace(' ', '%', $busca) .'%"' : null
	];

	// Remove posicoes vazias
	$condicoes = array_filter($condicoes);

	// Clausula where
	$where = implode(' OR ', $condicoes);

	// Quantidade de dicas de sabedoria
	$quantidadeDicas = $obDicas::getQuantidadeDiscas( $where );

	// Paginacao
	$obPagination = new Pagination( $quantidadeDicas, $_GET['pagina'] ?? 1, 25 );

	$dicasS = $obDicas->getDicas($where, "actualizado_em DESC", $obPagination->getLimit() );

	//Exibe mensagens de aviso
	include __DIR__.'/includes/avisos.php';

	//Carrega a interface padrao
	include __DIR__."/includes/header.php";
	include __DIR__."/includes/sejaSabio.php";
	include __DIR__."/includes/footer.php";
	include __DIR__.'/includes/centralAjuda.php';
