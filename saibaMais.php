<?php
	session_start();
	require __DIR__.'/vendor/autoload.php';

	//Controle de acesso
	use \App\Config\AcessoControl;
	use \App\Db\Pagination;

	//set dados user
	$statusOn = new AcessoControl($_SESSION['userId'], $_SESSION['userLog']);

	//Configuracao do formulario de acesso rapido
	include __DIR__.'/includes/add_config.php';
	include __DIR__.'/includes/add.php';

	//Avisos
	$mensagem = '';
	
	// Dicas lidas
	use \App\Entity\SaibaMaisLidas;
  use \App\Entity\DefinicoesReacoes;
  use \App\Entity\DefinicoesComentarios;

	// Instancia um objecto da class
	$obDicasLidas  = new SaibaMaisLidas();
	$obDicaReacoes = new DefinicoesReacoes();
  $obDicaComents = new DefinicoesComentarios();

	// Apagar definicao
	if ( isset($_POST['btn-apagar']) ) {

		// verifica dados necessarios
	  if ( isset($_POST['idDica']) ) {

			// set id
			$obDefinicoes->id = $_POST['idDica'];

			// apaga a definicao
			if ( $obDefinicoes->excluir() ) {
				// tudo ok
				$mensagem = 'A sua definição foi apagada com sucesso!';
			} else {
				// reportar erro
				$mensagem = 'Não foi possivel apagar a definição, por favor, tente novamente!';
			}

		}

	}

	// Actualizar definição
	if ( isset($_POST['btn-actualizar']) ) {

		// verifica dados necessarios
		if ( isset( $_POST['idDica'], $_POST['disciplinaDica'], $_POST['dica'], $_POST['ficheiro'] ) ) {

			// SET DADOS
			$obDefinicoes->sobre     = $_POST['disciplinaDica'];
			$obDefinicoes->id        = $_POST['idDica'];
			$obDefinicoes->fonte     = filter_var($_POST['origem'],  FILTER_SANITIZE_STRING)?? null;
			$obDefinicoes->tipo_ficheiro = $_POST['ficheiro'];
			$obDefinicoes->definicao = filter_Var($_POST['dica'],  FILTER_SANITIZE_STRING);
			$obDefinicoes->id_user   = $codigoUser;
			$obDefinicoes->actualizado_em = date('Y-m-d H:i:s');

			// actualizar a definicao
			if ( $obDefinicoes->actualizar() ) {
				// tudo ok
				$mensagem = 'A sua definição foi actualizada com sucesso!';
			} else {
				// reportar erro
				$mensagem = 'Não foi possivel actualizar a definição, por favor, tente novamente!';
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

	// Salvar denuncia
	if ( isset( $_POST['btn-denunciar'] ) ) {

		if ( isset($_POST['idDica']) ) {

			// set dados
			$obDenuncias->descricao = 'A presente Definição viola as regras da plataforma!';
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
					$mensagem = 'Removida da lista de definições lidas!';
				} else {
					// erro
					$mensagem = 'Erro ao remover da lista de definições lidas!';
				}

			} else {

				// cadastrar como lida
				if ( $obDicasLidas->cadastrar() ) {
					// tudo ok
					$mensagem = 'Adicionada a lista de definições lidas!';
				} else {
					// erro
					$mensagem = 'Erro ao adicionar a lista de definições lidas!';
				}

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

	// set dados para realizar busca
	$b_frase  = filter_input(INPUT_GET, 'pesquisar_por', FILTER_SANITIZE_STRING);
	$b_filtro = filter_input(INPUT_GET, 'filtrar_por', FILTER_SANITIZE_STRING);

	// condicoes SQL
	$condicoes = [
		strlen($b_frase)? 'definicao LIKE "%'. $b_frase .'%"': null,
		strlen($b_frase)? 'fonte LIKE "%'. $b_frase .'%"': null,
		strlen($b_filtro)? 'sobre = "'. $b_filtro .'"': null
	];

	// remove posicoes vazias
	$condicoes = array_filter( $condicoes );

	// Clausula where
	$where = implode(' OR ', $condicoes);

	// get quantidade de conhecimento
	$quantidadeDefinicoes = $obDefinicoes->getQuantidadeDefinoces( $where );

	// paginacao
	$paginacao = new Pagination($quantidadeDefinicoes, $_GET['pagina'] ?? 1, 25);

	// get mais conhecimento
	$definicoes = $obDefinicoes->getDefinicoes($where, 'actualizado_em DESC', $paginacao->getLimit());

	// quantidade definicoes lidas
	$qtdeDicasLidasByMe = $obDicasLidas->getQuantidadeLidas('id_user = "'. $codigoUser .'"');

	//Exibe mensagens de aviso
	include __DIR__.'/includes/avisos.php';

	//Carrega a interface padrao
	include __DIR__."/includes/header.php";
	include __DIR__."/includes/saibaMais.php";
	include __DIR__."/includes/footer.php";
	include __DIR__.'/includes/centralAjuda.php';
