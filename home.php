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

	//Conteudos novos
	$listaConteudo = '';

	// get novidades
	$getNovidades = $obNovidades->getNovidades(null, 'data DESC');

	foreach ( $getNovidades as $keys => $news ) {

		//
		$titulo = $news->tema;

		//
		$descricao = substr($news->descricao, 0, 100).' ...';

		//
		$_getName = '';

		if ($news->local == 'a') {
			// Artigos
			$_getName = '';
		} else if ($news->local == 'b') {
			// biblioteca
			$_getName = '';
		} else if ($news->local == 'c') {
			// cursos
			$_getName = 'id=';
		} else if ($news->local == 'd') {
			// desafios
			$_getName = 'desafioCod=';
		} else if ($news->local == 'j') {
			// Jogos
			$_getName = '';
		} else if ($news->local == 'm') {
			// Market place
			$_getName = '';
		} else if ($news->local == 'n') {
			// Bissnes
			$_getName = '';
		} else {
			// projecto
			$_getName = '';
		}

		// link para acessar conteudo
		$link = $news->link .'?'. $_getName.$news->id_tema;

		//
		$directorioTec = '/imagens/tecnologias/';

		//
		$fotoTec = '';

		if ( false ) {
			//
			$fotoTec = $directorioTec.$fotoTec;
		} else {
			//
			$fotoTec = $directorioTec.'default.jpg';
		}

		// formata lista de conteudos
		$listaConteudo .= '<a href="/'.$link.'">
												<div class="conteudos">
													<div class="foto">
														<img src="'.$fotoTec.'" alt=""/>
													</div>

													<div class="dados">
														<label>'.$titulo.'</label>
														<div>
														  '.$descricao.'
													  </div>
													</div>
												</div>
											 </a>';
	}

	//
	if ( $listaConteudo == '' ) {
		// set aviso
		$listaConteudo = '<div id="sem-novidades">
		                    Sem conteudo
											</div>';
	}

	// Carregar as minhas cadeiras
	$getMinhasCad = $obMinhasCad->getMinhasCadeiras("user = '". $codigoUser ."' AND estados='f'");
	$asMinhasCadeidas = '';

	foreach ( $getMinhasCad as $cadeiras ) {

		$resultado = $obCadeiras->getCadeira( $cadeiras->cadeira );

		$asMinhasCadeidas .= '<a href="/cadeiras.php?id='. $resultado->id .'">
														<li>'. $resultado->titulo .'</li>
													</a>';
	}

	if ( $asMinhasCadeidas == '' ) {
		$asMinhasCadeidas = "<div class='semCadeiras'>
													 <p>Olá, de momento não há cadeiras!</p>
													 <p>O que é que falta para começares os teus estudos, <strong>".  $globalUserName ."</strong>?</p>
													 <p><a href='/cadeiras.php'>Clique em mim!</a></p>
												 </div>";
	} // Fim minhas cadeiras

	// O que vou aprender hoje
	$oQueAprender = $obAprender->getResultados('estado="a" OR estado="p" AND criada_por = "'. $codigoUser .'"', 'lancado_em DESC', '5');

	// armazena a lista de conhecimento a ser adequirido
	$oQueAprenderLista = '';

	// get dados
	foreach ($oQueAprender as $dados ) {

		// descricao do conhecimento a ser adequirido
		$descricao = $dados->descricao ?? 'Sem informações adicionais!';

		// set lista de conhecimento
		$oQueAprenderLista .= '
			<div class="caixinhas-home">
				<div class="capa-conteudo">
					'. $descricao .'
				</div>

				<a href="/queroAprender.php?queroAprenderCod='. $dados->id .'">
					<div class="sub-titulo" title="Clique em mim">
						Ver mais
					</div>
				</a>
			</div>';
	}

	// verifica o que aprender
	if ( $oQueAprenderLista == "" ) {
		$oQueAprenderLista = '
				<div class="conteudo-indisponivel">
					<p>	Por hoje, ainda não há qualquer conteudo para ser aprendido! </p>
				</div>';
	}// Fim o que vou aprender

	// get projecto
	$projecto = $obProjectos->getProjectos('utilizador="'. $codigoUser .'" AND estado="a"', 'iniciado_em ASC', '1');

	// Armazena os dados do projecto
	$meuProjecto = '';

	// get dados do projecto
	foreach ( $projecto as $dados ) {

		// get nome do projecto
		$nome = substr($dados->titulo, 0, 50) ?? 'Projectos';

		// get imagens do projecto
		$imagem = ( $dados->imagem != "")? "/perfil/projectos/imagens/$dados->imagem": "../imagens/tecnologias/default.jpeg";

		// descricao do projecto
		$descricao =  $dados->descricao;

		// categoria do projecto
		$categoria = ($dados->categoria == "i")? "Ideia" : "Projecto";

		// get dados da cadeira
		$cadeira = $obCadeiras->getCadeira($dados->sobre);

		// get dados minhas cadeiras
		$sobreMinhaC = $obMinhasCad->getMinhaCadeira($dados->sobre);

		// get dados gerias da cadeira
		$cadeira = $obCadeiras->getCadeira($sobreMinhaC->cadeira);

		// set nome da cadeira
		$sobre = substr($cadeira->titulo, 0, 31) ?? 'Cadeira Indisponível';

		// Data de inicio
		$dataInicio = $dados->iniciado_em ?? 'Indisponível';

		// armazena o estado
		$estado = '';

		// set estado do projecto
		switch ( $dados->estado ) {
			case 'p':
				$estado = 'Por desenvolver';
				break;
			case 'a':
				$estado = 'A desenvolver';
				break;
			case 'f':
				$estado = 'Desenvolvido';
				break;
			default:
				$estado = 'Indisponivel';
				break;
		}

		// link do repositorio no github
		$link = $dados->repositorio ?? "#";

		// get projecto
		$meuProjecto = '<div class="titulos" align="center">
											'. $nome .'

											<div class="ver-mais">
							          <a href="'. $link .'"> GitHub </a>
							        </div>

										</div>

										<div id="foto-projecto">
											<img src="'. $imagem .'" alt="Foto ilustrativa do projecto '. $nome .'"/>
										</div>

										<div id="descricao-projecto">
											'. $descricao .'
										</div>

										<div id="mais-projecto">
											<div id="grafico" titulo="Gráfico de adamento do projecto">
												grafico
											</div>

											<div class="mais-dados" title="Iniciado em">
												'. $dataInicio .'
											</div>

											<div class="mais-dados" title="Categoria">
												'. $categoria .'
											</div>

											<div class="mais-dados" titlo="Cadeira">
												'. $sobre .'
											</div>

											<div class="mais-dados" title="Estado">
												'. $estado .'
											</div>

										</div>

										<button type="button" name="button">
											<a href="#">Mais detalhes</a>
										</button>';
	}

	if ( $meuProjecto == "" ) {
		$meuProjecto = '
				<div class="titulos" align="center"> Projectos </div>

				<div class="conteudo-indisponivel">
					<p>	Nenhum projecto em desenvolvimento!	</p>
				</div>';
	}	// Fim carregar projecto

	// carregar objectivos da semena
	$objectivosSe = $obObjectivos->getObjectivos('estado="c" AND utilizador="'. $codigoUser .'"', 'data_inicio DESC', '5');

	$objectivosDaSemana = '';

	foreach ( $objectivosSe as $dados ) {

		$descricao = $dados->descricao ?? 'Sem informações adicionais!';

		$objectivosDaSemana .= '
				<div class="caixinhas-home">
					<div class="capa-conteudo">
						'. $descricao .'
					</div>

					<a href="#">
						<div class="sub-titulo" title="Clique em mim">
							Ver mais
						</div>
					</a>
				</div>';
	}

	if ( $objectivosDaSemana == "" ) {
		$objectivosDaSemana = '
				<div class="conteudo-indisponivel">
					<p>	Sem objectivos para esta semana, crie alguns!	</p>
				</div>';
	}// Fim objectivos da semana

	if ( $objectivosDaSemana == "" ) {
		$objectivosDaSemana = '
				<div class="conteudo-indisponivel">
					<p>	Sem objectivos para esta semana, crie alguns!	</p>
				</div>';
	}// Fim desafios propostos

	// Desafios propostos
	$desafiosPropostos = $obDesafio->getDesafios('categoria="d"', 'data_inicio DESC', '5');

	$desafiosLista = '';

	foreach ( $desafiosPropostos as $dados ) {

		$descricao = $dados->desafio ?? 'Sem informações adicionais!';;

		$desafiosLista .= '
				<div class="caixinhas-home">
					<div class="capa-conteudo">
						'. $descricao .'
					</div>

					<a href="/desafios.php?desafioCod='. $dados->id .'">
						<div class="sub-titulo" title="Clique em mim">
							Ver mais
						</div>
					</a>
				</div>';
	}

	if ( $desafiosLista == "" ) {
		$desafiosLista = '
				<div class="conteudo-indisponivel">
					<p>	Não foram localizados desafios propostos, crie alguns!	</p>
				</div>';
	}// Fim desafios propostos

	// Carregar exercicios
	$exercicios = $obDesafio->getDesafios('categoria="e"', 'data_inicio DESC', '5');

	$exerciciosLista = '';

	foreach ( $exercicios as $value ) {

		$descricao = $value->desafio ?? 'Sem informações adicionais!';

		$exerciciosLista .= '
				<div class="caixinhas-home">
					<div class="capa-conteudo">
						'. $descricao .'
					</div>

					<a href="\desafios.php?desafioCod='. $value->id .'">
						<div class="sub-titulo" title="Clique em mim">
							Ver mais
						</div>
					</a>
				</div>';
	}

	if ( $exerciciosLista == "" ) {
		$exerciciosLista = '
				<div class="conteudo-indisponivel">
					<p>	Não foram localizados exercicios por resolver, crie alguns!	</p>
				</div>';
	}// Fim lista de exercicios

	// Trabalhos academicos
	$trabalhos = $obMateria->getMaterias('desenvolvida_por = "'. $codigoUser .'" AND estado = "p"', 'iniciado_em DESC', '3');

	$minhasPesquisas = '';

	foreach ($trabalhos as $value ) {

		$titulo = (strlen($value->titulo) > 90)? substr($value->titulo, 0, 90) : $value->titulo;
		$titulo = $titulo ?? "...";

		// get dados minhas cadeiras
		$sobreMinhaC = $obMinhasCad->getMinhaCadeira($value->sobre);

		// get dados gerias da cadeira
		$cadeira = $obCadeiras->getCadeira($sobreMinhaC->cadeira);

		// set nome da cadeira
		$cadeira = substr($cadeira->titulo, 0, 28) ?? 'Cadeira Indisponível';

		// get professor
		$professor = $obMeusProfessores->getMeuProfessor($sobreMinhaC->professor);

		// get dados do professor
		$dadosProfessor = $obProfessor->getProfessor($professor->id_proff);

		// set nome do professor
		$professor = substr($dadosProfessor->nome, 0, 28) ?? 'Nome indisponivel';

		// get categoria
		$cat = $obCatMateria->getCategoria( $value->categoria );

		// verifica categoria
		$categoria = $cat->titulo ?? 'Sem categoria';

		// Descricao do trabalho
		$descricao = $value->descricao;

		// verifica descricao
		$descricao = $descricao ?? 'Sem descrição';

		$minhasPesquisas .= '<div class="conteiner-trabalho">
														<div class="sub-titulo">'. $titulo .'</div>

														<div class="designacao">
															<div class="dados" title="Cadeira">
															  '. $cadeira .'
															</div>

															<div class="dados" title="Professor">
															  '. $professor .'
															</div>

															<div class="dados" title="Categoria">
															  '. $categoria .'
															</div>
														</div>

														<div class="descricao">
															'. $descricao .'
														</div>

														<div class="outros-dados">
															<a href="#">Mais detalhes</a>
														</div>
													</div>';
	}

	if ( $minhasPesquisas == "" ) {
		$minhasPesquisas = '<div class="conteudo-indisponivel" id="conteudo-indisponivel">
													<p>Olá '.  $globalUserName .'!<br/>
													De momento não esta a realizar nenhuma pesquisa academica<br/>
													quer de caracter pessoal ou institucional.<br/>
													Inicie já, realize algumas pesquisas e cresça ainda mais intelectualmente!	</p>
												</div>';
	} else {
		$minhasPesquisas .= '
		<button type="button" name="button">
			<a href="/trabalhosAcad.php"> Mais trabalhos academicos </a>
		</button>';
	} // Fim lista de trabalhos acedimicos

	// Quem partilha o seu conhecimento
	$quemPartilha  = '';

	$quemPartilhaConhecimento = "";

	if ( $quemPartilhaConhecimento == "" ) {
		$quemPartilhaConhecimento = '
				<div class="conteudo-indisponivel" id="sms-parceiros">
					<p> De momento não há pessoas partilhando o seu conhecimento! <br/>
					Seja o primeiro, clicando em <a href="/artigos.php">criar um artigo</a>! </p>
				</div>';
	}// Fim quem partilha o seu conhecimento

	// Quem contribui para a nossa existencia
	$quemContribui = '';

	$quemContribuiParaNossaExistencia = '';



	if ( $quemContribuiParaNossaExistencia == "" ) {
		$quemContribuiParaNossaExistencia = '
				<div class="conteudo-indisponivel" id="sms-parceiros">
					<p> De momentos a ultralearning não tem parceiros! <br/>
					Deseja ser nosso parceiro? <br/>
					Caso sim, saiba mais clicando aqui, <a href="/serParceiro.php">Quero ser vosso parceiro</a>! </p>
				</div>';
	}// Fim quem contribui para a nossa existencia

	//Exibe mensagens de aviso
	include __DIR__.'/includes/avisos.php';

	//Carrega a interface padrao
	include __DIR__."/includes/header.php";
	include __DIR__."/includes/home.php";
	include __DIR__.'/includes/centralAjuda.php';
