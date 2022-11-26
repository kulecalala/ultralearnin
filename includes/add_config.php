<?php
  $codigoUser       = $_SESSION['userId'];
  $globalUserName   = $_SESSION['userName'];
  $globalUserPath   = $_SESSION['userPath'];
  $globalFotoPerfil = $_SESSION['fotoPerfil'];
  $_SESSION['userStatus'];
  $_SESSION['userLog'];

  // set foto de pefil
  $photo = strlen($globalFotoPerfil)? $globalFotoPerfil: '';

  // nome da pasta do utilizador
  $caminho = strlen($globalUserPath)? $globalUserPath: '';

  // armazena o caminho ate o ficheiro
  $showPhotoP = '';

  // verifica dados necessarios
  if ( $photo != '' && $caminho != '' ) {
    // monta caminho
    $showPhotoP = $caminho.'\\foto\\'.$photo;
  } else {
    // set foto default
    $showPhotoP = 'defaultProfilePhoto.png';
  }

  //Tabelas a serem usadas
  use \App\Entity\Cadeiras;
  use \App\Entity\Definicoes;
  use \App\Entity\Dicionario;
  use \App\Entity\Sites;
  use \App\Entity\DicasRiqueza;
  use \App\Entity\Denuncias;
  use \App\Entity\BoasPraticasProgramacao;
  use \App\Entity\CategoriaBoasPraticas;
  use \App\Entity\Desafios;
  use \App\Entity\MeusDesafios;
  use \App\Entity\Professores;
  use \App\Entity\Materias;
  use \App\Entity\CategoriaMaterias;
  use \App\Entity\Cursos;
  use \App\Entity\Negocios;
  use \App\Entity\Projectos;
  use \App\Entity\Objectivos;
  use \App\Entity\CategoriaObjectivos;
  use \App\Entity\OqueAprender;
  use \App\Entity\Tecnologias;
  use \App\Entity\Imagens;
  use \App\Entity\Livros;
  use \App\Entity\MinhasCadeiras;
  use \App\Entity\Horario;
  use \App\Entity\MeusHorariosTempos;
  use \App\Entity\MeuHorarioDeEstudo;
  use \App\Entity\MeusCursos;
  use \App\Entity\Users;
  use \App\Entity\UsersMore;
  use \App\Entity\ToDoList;
  use \App\Entity\MeusProfessores;
  use \App\Entity\Notificacoes;
  use \App\Entity\TipoDeFicheiros;
  use \App\Entity\Novidades;

  //Incitancia novos objectos
  $obDefinicoes  = new Definicoes();
  $obCadeiras    = new Cadeiras();
  $obDicionario  = new Dicionario();
  $obSites       = new Sites();
  $obDicas 			 = new DicasRiqueza();
  $obDenuncias   = new Denuncias();
  $obBoaPratica  = new BoasPraticasProgramacao();
  $obCategoriaB  = new CategoriaBoasPraticas();
  $obDesafio     = new Desafios();
  $obMeusDesafio = new MeusDesafios();
  $obProfessor   = new Professores();
  $obMateria     = new Materias();
  $obCatMateria  = new CategoriaMaterias();
  $obCursos      = new Cursos();
  $obNegocios    = new Negocios();
  $obProjectos   = new Projectos();
  $obObjectivos  = new Objectivos();
  $obCObjectivos = new CategoriaObjectivos();
  $obAprender    = new OqueAprender();
  $obTecnologia  = new Tecnologias();
  $obImagem      = new Imagens();
  $obLivros      = new Livros();
  $obMinhasCad   = new MinhasCadeiras();
  $obHorario     = new Horario();
  $obToDoList    = new ToDoList();
  $obTempos      = new MeusHorariosTempos();
  $obHoraDeEstu  = new MeuHorarioDeEstudo();
  $obMeusCursos  = new MeusCursos();
  $obUtilizador  = new Users();
  $obUserMoreData    = new UsersMore();
  $obMeusProfessores = new MeusProfessores();
  $obNotificacoes    = new Notificacoes();
  $obTipoDeFicheiros = new TipoDeFicheiros();
  $obNovidades       = new Novidades();

    // Apagar tarefa
    if ( isset($_POST['deletarTarefa']) ) {

      if ( isset($_POST['idTarefa']) && is_numeric($_POST['idTarefa']) ) {

        // set id
        $id = $_POST['idTarefa'];

        // get dados
        $obToDoList->id      = $id;
        $obToDoList->id_user = $codigoUser;

        // Apagar tarefa
        if ( $obToDoList->excluir() ) {
          // Tudo ok
          $mensagem = 'A sua tarefa foi apagada com sucesso!';
        } else {
          // Reportar erro
          $mensagem = 'Ops! Ocorreu um erro ao apagar a tarefa!';
        }

      }

    }

    // Marcar a tarefa como feita
    if ( isset($_POST['marcarFeita']) ) {

      if (isset($_POST['idTarefa'], $_POST['descricao'], $_POST['titulo'], $_POST['sobreTarefa'], $_POST['dataC']) && is_numeric($_POST['idTarefa'])) {

        // set dados
        $id        = $_POST['idTarefa'];
        $titulo    = filter_var($_POST['titulo'], FILTER_SANITIZE_STRING);
        $descricao = filter_var($_POST['descricao'], FILTER_SANITIZE_STRING);
        $sobre     = filter_var($_POST['sobreTarefa'], FILTER_SANITIZE_STRING);
        $dataC     = filter_var($_POST['dataC'], FILTER_SANITIZE_STRING);

        // get dados
        $obToDoList->id        = $id;
        $obToDoList->id_user   = $codigoUser;
        $obToDoList->titulo    = $titulo;
        $obToDoList->descricao = $descricao;
        $obToDoList->sobre     = $sobre;
        $obToDoList->estado    = 'f';
        $obToDoList->data      = $dataC;
        $obToDoList->feitaEm   = date('Y-m-d H:i:m');
        $obToDoList->renovar   = $_POST['renovar'];

        // marcar tarefa como feita
        if ( $obToDoList->actualizar() ) {
          // tudo ok
          $mensagem = 'Ok, a sua tarefa foi realizada com sucesso!';
        } else {
          // reportar erro
          $mensagem = 'Ops! Ocorreu um erro ao marcar a tarefa como feita!';
        }



      }

    }

    // adicionar tarefas do dia
    if ( isset($_POST['addTarefasToDo']) ) {

      if ( isset($_POST['tema'], $_POST['descricao'], $_POST['cadeira']) ) {

        // get dados
        $titulo = filter_var($_POST['tema'], FILTER_SANITIZE_STRING);
        $descri = filter_var($_POST['descricao'], FILTER_SANITIZE_STRING);
        $sobreT = filter_var($_POST['cadeira'], FILTER_SANITIZE_STRING);

        // set dados
        $obToDoList->id_user   = $codigoUser;
        $obToDoList->titulo    = $titulo;
        $obToDoList->descricao = (strlen($descri) > 2535)? substr($descri, 0, 2535): $descri;
        $obToDoList->sobre     = $sobreT;

        // Registar tarefa
        if ( $obToDoList->cadastrar() ) {
          // tudo ok
          $mensagem = 'A sua tarefa foi salva com sucesso!';
        } else {
          // reportar erro
          $mensagem = 'Ops! Não foi possivel registar a sua tarefa, tente novamente!';
        }

      }

    }

  // Armazena a lista de Tarefas
  $toDoListUser = '';

  //
  $whereToDoList = 'id_user = "'.$codigoUser.'" AND estado = "p"';

  // qtde de tarefas por fazer
  $qtdeTarefasPorFazerMy = $obToDoList->getQuantidadeTarefas($whereToDoList);

  //
  $getTarefasUser = $obToDoList->getTarefas($whereToDoList, 'data ASC', '4');

  //
  $qtdeMyToDo = $obToDoList->getQuantidadeTarefas($whereToDoList);

  // conta o numero de tarefas
  $countTarefas = 1;

  //
  foreach ($getTarefasUser as $key => $tarefa) {

    $marcarFirst = '';

    $marcarLast = '';

    if ( $countTarefas == 1 ) {
      $marcarFirst = 'id="primeiraTarefa"';
    }

    if ( $countTarefas == $qtdeMyToDo ) {
      $marcarLast = 'id="ultimaTarefa"';
    }

    $countTarefas++;

    //
    $idTarefa  = $tarefa->id;
    $titulo    = $tarefa->titulo ?? 'Indisponível';
    $titulo2    = (strlen($titulo) > 50)? substr($titulo, 0, 50): $titulo;
    $descricao = $tarefa->descricao ?? 'Sem descrição';
    $descricao2 = (strlen($descricao) > 255)? substr($descricao, 0, 255).' ...': $descricao;
    $sobreId   = $tarefa->sobre;
    $dataCri   = $tarefa->data;
    $estadoR   = $tarefa->renovar;

    //Formata a lista de Tarefas
    $toDoListUser .= '<div class="tarefas-info" '.$marcarFirst.' '.$marcarLast.'>
                        <div class="titulo">
                          '. $titulo2 .'
                          <a href="/gestorDeTarefas.php?detalhesTarefa='.$idTarefa.'" title="Detalhes">
                            ...
                          </a>
                        </div>
                        <div class="descricao">'. $descricao2 .'</div>
                        <div class="btns">
                          <form name="" method="post" action="">

                            <input type="text" name="idTarefa" value="'.$idTarefa.'" hidden/>

                            <input type="text" name="renovar" value="'.$estadoR.'" hidden/>

                            <input type="text" name="titulo" value="'.$titulo.'" hidden/>

                            <input type="text" name="descricao" value="'.$descricao.'" hidden/>

                            <input type="text" name="sobreTarefa" value="'.$sobreId.'" hidden/>

                            <input type="text" name="dataC" value="'.$dataCri.'" hidden/>

                            <input type="submit" name="marcarFeita" value="Feita" id="marcarFeita"/>

                            <input type="submit" name="deletarTarefa" value="Delete" id="deletarTarefa"/>
                          </form>
                        </div>
                      </div>';
  }

  //
  if ($toDoListUser == '') {
    $toDoListUser = '<div class="avisos">
                       <p>Todas as suas tarefas foram cumpridas.</p>
                       <p>Adicione algumas!</p>
                     </div>';
  }

  // where tarefas
  $tarefasUser = 'id_user = "'.$codigoUser.'"';

  // get tarefas
  $tarefasUserToDo = $obToDoList->getTarefas($tarefasUser);

  // get tarefas
  foreach ($tarefasUserToDo as $key => $tarefa) {

    // set data de hoje
    $dataActual = date('Y-m-d');

    // verifica se tarefa pode ser renovada
    if ( $tarefa->renovar == 'y' ) {

      if ( $tarefa->feitaEm != '' && substr($tarefa->feitaEm, 0, 10) != $dataActual ) {

        // set dados
        $obToDoList->id        = $tarefa->id;
        $obToDoList->id_user   = $codigoUser;
        $obToDoList->titulo    = $tarefa->titulo;
        $obToDoList->descricao = $tarefa->descricao;
        $obToDoList->sobre     = $tarefa->sobre;
        $obToDoList->data      = date('Y-m-d H:i:s');
        $obToDoList->feitaEm   = null;
        $obToDoList->renovar   = 'y';
        $obToDoList->estado    = 'p';

        // actualiza a terafa
        if ( $obToDoList->actualizar() ) {
          // tudo ok
        } else {
          // reportar erro
        }

      }

    }

  }


  // Armazena o tipo de ficheiros
  $listarTipoDeFicheiros = '';

  // get tipo de ficheiros
  $getTipoDeFicheiros = $obTipoDeFicheiros->getFicheiros(null, 'tipo ASC');

  // set lista
  foreach ( $getTipoDeFicheiros as $key => $tipos ) {

    // set lista
    $listarTipoDeFicheiros .= '<option value="'. $tipos->id .'">
                                 '. $tipos->tipo .'
                               </option>';

  }



  // As cadeiras do estudante
  $getTodasCadeiras = $obMinhasCad::getMinhasCadeiras("user = '". $codigoUser ."'");

  // Armazena a lista com as cadeiras
  $todasMinhasCad = '';
  $todasMinhasCadOption = '';

  // Formata a lista de cadeiras
  foreach ( $getTodasCadeiras as $cadeiras ) {

    //
    $resultado = $obCadeiras->getCadeira( $cadeiras->cadeira );

    // cadeiras link
    $todasMinhasCad .= '<a href="/cadeiras.php?id='. $resultado->id .'">
                          <li>'. $resultado->titulo .'</li>
                        </a>';

    // cadeiras option
    $todasMinhasCadOption .= '<option value="'.$cadeiras->id.'">
                               '.$resultado->titulo.'
                             </option>';
  } // Fim get cadeiras

  // Lista de todos os professores
  $todosOsMeusProfesfores = '';

  // get professores
  $getMeusProfessores = $obMeusProfessores->getMeusProfessores('id_user ="'. $codigoUser .'"');

  // formata a lista de professores
  foreach ( $getMeusProfessores as $proffs ) {

    $nome = $obProfessor->getProfessor( $proffs->id_proff );
    $todosOsMeusProfesfores .= '<option value="'. $proffs->id .'">
                                  '. $nome->nome .'
                                </option>';
  }

  // verifica se a professores
  if ( strlen( $todosOsMeusProfesfores ) == 0 ) {
    $todosOsMeusProfesfores = '<option value="">
                                 A lista de professores encontra-se vazia!
                               </option>';
  }// FIm professores



  //Armazena sites
  $listaDeSites = '';

  //get lista de sites
  foreach( Sites::getSites() as $sites ) {
    $listaDeSites .= '<option value="'. $sites->id .'">
                        '. $sites->titulo .'
                      </option>';
  } //

  //Verifica se ha sites
  if( $listaDeSites == '' ) {
    $listaDeSites = '<option value="">
                      A lista de sites encontra-se vazia!
                     </option>';
  }

  //get Lista de cadeiras
  $cadeiras = Cadeiras::getCadeiras("titulo <> 'null'", 'titulo DESC');

  //Armazena a lista de cadeiras
  $resultadosCadeiras = '';
  $listarCadeiras     = '';

  //Pega todas as cadeiras a serem feitas
  foreach( $cadeiras as $cadeira ) {
    $resultadosCadeiras .= '<a href="/cadeiras.php?id='. $cadeira->id .'">
                              <li>'. $cadeira->titulo .'</li>
                            </a>';
  }

  if ( strlen($resultadosCadeiras) == 0 ) {
     $resultadosCadeiras = '<li>
                              A lista encontra-se vazia
                            </li>';
  }

  //Lista de cadeiras
  $cadeiras = Cadeiras::getCadeiras(null, 'titulo DESC');

  //Pega todas as cadeiras a serem feitas
  foreach( $cadeiras as $cadeira ) {
    $listarCadeiras .= '<option value="'. $cadeira->id  .'">
                          '. $cadeira->titulo .'
                        </option>';
  }

  // verifica se a cadeiras
  if( $listarCadeiras == '' ) {
    $listarCadeiras = '<option value="">
                        A lista de encontra-se vazia!
                       </option>';
  } // Fim cadeiras

  //Horario de estudos
  $horario = '';      //
  $nTempo  = 0;       // numero de tempos
  $tempos  = '';      // tempos
  $codHorario = null; // id horarios

  // Armazena o formulario para criar novo horario
  $novoHorarioForm = '';

  //Boas praticas de programacao
  $getBoasPraticas = $obCategoriaB->getCategorias(null, 'titulo DESC');

  // lista de boas praticas
  $listarBoasPraticas = '';

  //Get boas praticas
  foreach( $getBoasPraticas as $dados ) {
    $listarBoasPraticas .= '<option value="'. $dados->id .'">
                              '. $dados->titulo .'
                            </option>';
  }

  //Verifica se a dicas de programacao
  if( $listarBoasPraticas == '' ) {
    $listarBoasPraticas = '<option value="">
                            A lista de encontra-se vazia!
                           </option>';
  }


  // get professores
  $getProfessores = Professores::getProfessores(null, 'nome ASC');

  // armazena a lista de professfores
  $listarProfessores = '';

  //Buscar de professorres
  foreach( $getProfessores as $resultados ) {
    $listarProfessores .= '<option value="'. $resultados->id .'">
                            '. $resultados->nome .'
                          </option>';
  }

  //Verfica professores
  if ( $listarProfessores == ''  ) {
    $listarProfessores = '<option value="" selected>
                            Sem resultados!
                          </option>';
  }

  //get categoria de materias
  $getCatMaterias = CategoriaMaterias::getCategorias('', 'titulo ASC', '');

  // armazena a lista de materias
  $listarCatMaterias = '';

  // formata a lista de materias
  foreach ($getCatMaterias as $resultados) {
    $listarCatMaterias .= '<option value="'. $resultados->id .'">
                             '. $resultados->titulo .'
                           </option>';
  }

  // Verifica se a materias
  if ( $listarCatMaterias == '' ) {
    $listarCatMaterias .= '<option value="" selected>
                             Sem resultados para a categoria de materias!
                           </option>';
  }

  //get categoria de objectivos
  $getCategorias = CategoriaObjectivos::getCategorias(null, 'titulo ASC', '');

  // Armazena a lista da categoria de objectivos
  $listarCObjectivos = '';

  // Formata a lista
  foreach( $getCategorias as $objetivos ) {
    $listarCObjectivos .= '<option value="'. $objetivos->id  .'">
                             '. $objetivos->titulo .'
                           </option>';
  }

  // Verifica se ha itens na lista
  if( $listarCObjectivos == '') {
    $listarCObjectivos = '<option value="">
                            a lista encontra-se vazia!
                          </option>';
  }

  //get Tecnologia
  $getTecnologias = $obTecnologia->getTecnologias(null,'titulo ASC','');

  // armazena a lista de tecnologias
  $listarTecnologias = '';

  // Formata a lista
  foreach ( $getTecnologias as $tecnologias ) {
    $listarTecnologias .= '<option value="'. $tecnologias->id .'">
                             '. $tecnologias->titulo .'
                           </option>';
  }

  // verifica se a tecnologias na lista
  if ( $listarTecnologias == '' ) {
    $listarTecnologias = '<option value="" selected>
                            A lista encontra-se vazia!
                          </option>';
  }  // Fim Tecnologias
