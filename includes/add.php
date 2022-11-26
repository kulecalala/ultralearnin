<?php

  // Actualizar cadeiras no horarios de estudos
  if ( isset( $_POST['btn-actualizar-cad'] ) ) {

    // Verifica dados necessarios
    if ( $_POST['diaDaSemana'] != '' && $_POST['cadeira'] != '' && $_POST['codTempo'] != '' ) { // true

      $obHoraDeEstu->dia     = $_POST['diaDaSemana'];
      $obHoraDeEstu->tempo   = $_POST['codTempo'];
      $obHoraDeEstu->cadeira = $_POST['cadeira'];

      if ( $obHoraDeEstu->cadastrar() ) {

        // tudo ok!
        $mensagem = 'A cadeira foi adicionada ao horario de estudos com sucesso!';

      } else {
        $mensagem = 'Erro ao selecionar cadeira de estudos para o horario escolhido, por favor, tente novamento!';
      }

    } else { // False
      $mensagem = 'Dados necessarios para adicionar disciplina ao horario em falta, por favor, preencha todos os campos!';
    }

  } // Fim actualizar horario de estudos


  // Criar novo tempo de estudos
  if ( isset( $_POST['criarNovoTempo'] ) ) {
    // Verifica dados necessarios
    if ( $_POST['codigoTempo'] != '' && $_POST['numeroTempo'] != '' && $_POST['horaInicio'] != '' && $_POST['horaSaida'] != '' ) {

      // Validar hora de entrada e saida
      if ( $_POST['horaSaida'] > $_POST['horaInicio'] ) {

        // set dados
        $obTempos->horario     = $_POST['codigoTempo'];
        $obTempos->numeroTempo = $_POST['numeroTempo'];
        $obTempos->entrada     = $_POST['horaInicio'];
        $obTempos->saida       = $_POST['horaSaida'];

        // Gerar novo horario de estudos
        if ( $obTempos->cadastrar() ) { // True
          // tudo ok
          $mensagem = 'O seu novo horario de estudos foi criado com sucesso!';
        } else { // False
          $mensagem = 'Ocorreu um erro ao criar um novo horario de estudos, por favor, tente novamente!';
        }

      } else {
        $mensagem = 'Horario de inicio e termino de estudos é invalido, por favor, os verifique!';
      }


    } else {
      $mensagem = 'Dados necessarios a criação de um novo horario de estudos em falta. Por favor, preenha todos os campos!';
    }


  }

  // Criar horario de estudos
  if ( isset( $_POST['criarHorario'] ) ) {
    // codigo do utilizador
    $obHorario->user = $codigoUser;

    if( $obHorario->cadastrar() ) {
      $mensagem = 'Ops! O seu horario de estudos foi criado com sucesso!';
    } else {//False
      $mensagem = 'Ops! Ocorreu um erro ao criar horario de estudos!';
    }

  }

  //Salvar professores
  if( isset($_POST['addProfessor']) ) {

    //Verifica dados necessarios
    if( $_POST['descricaoProf'] != '' && $_POST['nomeProf'] != '' ){

      //set Dados
      $obProfessor->nome           = $_POST['nomeProf'];
      $obProfessor->descricao      = $_POST['descricaoProf'];
      $obProfessor->adicionado_por = $codigoUser;

      //Verifica estado
      if ( $obProfessor->cadastrar() ) { //true
        // tudo ok
        $mensagem = 'O novo professor foi salvo com sucesso!';
      } else { //False
        $mensagem = 'Ops! Ocorreu um erro ao adicionar um novo professor!';
      }

    }
  }

  //Salvar negocios
  if ( isset( $_POST['addNegocios'] )) {

    //verifica dados necessarios
    if ( $_POST['tituloV'] != '' && $_POST['descricaoN'] != '' && $_POST['iniciaEmN'] != '' && $_POST['quemPodeVerN'] != '' ) {

      //set dados
      $obNegocios->titulo         = $_POST['tituloV'];
      $obNegocios->descricao      = $_POST['descricaoN'];
      $obNegocios->requisitos     = $_POST['requisitosN'] ?? null;
      $obNegocios->email          = $_POST['emailN'] ?? null;
      $obNegocios->number         = $_POST['numberN'] ?? null;
      $obNegocios->data_inicio    = $_POST['iniciaEmN'];
      $obNegocios->data_termino   = $_POST['terminaEmN'] ?? null;
      $obNegocios->adicionado_por = $codigoUser;
      $obNegocios->quem_pode_ver  = $_POST['quemPodeVerN'];
      $obNegocios->imagem         = $_POST['imagemN'] ?? null;

      //Verifica estado
      if ( $obNegocios->cadastrar() ) { //True
        // tudo ok
        $mensagem = 'A sua oportunidade de negocios foi salva com sucesso!';
      } else { //False
        $mensagem = 'Ops! Ocorreu um erro ao criar nova oportunidade de negócios/emprego!';
      }

    }

  }

  //Salvar cursos
  if ( isset($_POST['AddCurso']) ) {

    //Verifica dados necessarios
    if( isset($_POST['tituloC'], $_POST['descricaoC'], $_POST['criadoPorC'], $_POST['professorC'], $_POST['dataC'], $_POST['cadeiraC'], $_POST['tecnologiaC']) ) {

      $titulo = filter_var($_POST['tituloC'], FILTER_SANITIZE_STRING);
      $descri = filter_var($_POST['descricaoC'], FILTER_SANITIZE_STRING);
      $qtdeAulas = filter_var($_POST['qtdeVideoC'], FILTER_SANITIZE_STRING);
      $dataC = filter_var($_POST['dataC'], FILTER_SANITIZE_STRING);


      //set dados
      $obCursos->titulo         = $titulo;
      $obCursos->descricao      = $descri;
      $obCursos->qtde           = $qtdeAulas;
      $obCursos->fonte          = $_POST['criadoPorC'];
      $obCursos->tecnologia     = $_POST['tecnologiaC'];
      $obCursos->professor      = $_POST['professorC'];
      $obCursos->data_criacao   = $dataC;
      $obCursos->cadeira        = $_POST['cadeiraC'];
      $obCursos->adicionado_por = $codigoUser;

      $newName = '';

      //Verifica se o logo do curso foi enviado
      if( isset($_FILES['imagemC']['name']) ) {

        //armazenar em
        $directorio = __DIR__.'/../imagens/logo/cursos/';

        //extensao
        $extensao = strtolower( substr($_FILES['imagemC']['name'], -4));

        //Extensoes permitidas
        if($extensao == '.png' || $extensao == '.jpg' || $extensao == '.gif') {

          //criar novo nome
          $newName = md5( time().$codigoUser ).$extensao;

          //carregar a imagem no web app
          move_uploaded_file($_FILES['imagemC']['tmp_name'], $directorio.$newName);

          $mensagem = 'Ok!';

        } else {
          $mensagem = 'Ops! A imagem do curso não foi carregada, quando editares o curso, exprimente carregar imagens nos seguintes formatos: [png, jpg, gif]';
        }

      }

      // set nome da foto do curso
      $obCursos->logo  = $newName ?? null;

      //Verifica estado
      if( $obCursos->cadastrar() ) { //true
        // tudo ok

        // clausula where
        $where = 'adicionado_por = "'.$codigoUser.'"';

        // pega o ultima curso inserido por min
        $getLastCourse = $obCursos->getCursos($where, 'data_criacao DESC', '1');

        // id do curso inserido
        $temaId = '';

        // get dados do curso
        foreach ($getLastCourse as $key => $curso) {
          //
          $temaId = $curso->id;
        }

        // verifica ultima curso inserido
        if ($temaId != '') {
          // dados novidades
          $obNovidades->id_user   = $codigoUser;
          $obNovidades->id_tema   = $temaId;
          $obNovidades->tema      = 'Curso';
          $obNovidades->descricao = '<h6>'.$titulo.'</h6> - '. $descri;
          $obNovidades->link      = 'cursos.php';
          $obNovidades->local     = 'c';

          // cadastra novidade
          if ($obNovidades->cadastrar()) {
            // tudo ok
          } else {
            // reportar erro
          }

        }


        $mensagem .= ' O seu novo curso foi salvo com sucesso!';
      } else { //false
        $mensagem .= ' Ops! Ocorreu um erro ao salvar o novo curso!';
      }

    }

  }

  //Salvar a fazer cursos
  if ( isset($_POST['AddNewCourse']) ) {

    // Verifica dados necessarios
    if ( $_POST['fazerCurso'] != '  ' ) {
      // set dados necessarios
      $obMeusCursos->user     = $codigoUser;
      $obMeusCursos->curso_id = $_POST['fazerCurso'];

      // Cadastrar novo curso
      if ( $obMeusCursos->cadastrar() ) { // True
        // tudo ok
        $mensagem = '';
      } else { // False
        // reportar erro
        $mensagem = 'Ops! Não foi possivel adicionar o novo curso, por favor, tente novamete!';
      }
    }
  }

  //Salvar Definicoes
  if( isset($_POST['addDefinicoes']) ) {

    //Verificar dados necessarios
    if( isset($_POST['definicao'], $_POST['cadeiras'], $_POST['ficheiro']) ) {

      $definicao = filter_var($_POST['definicao'], FILTER_SANITIZE_STRING);
      $fonte = filter_var($_POST['fonte'], FILTER_SANITIZE_STRING);

      //Set dados
      $obDefinicoes->id_user       = $codigoUser;
      $obDefinicoes->definicao     = $definicao;
      $obDefinicoes->fonte         = $fonte;
      $obDefinicoes->tipo_ficheiro = $_POST['ficheiro'];
      $obDefinicoes->sobre         = $_POST['cadeiras'];

      //Salvar Definicao
      if( $obDefinicoes->cadastrar() ) {  //True
        // tudo ok
        $mensagem = 'A sua definição foi salva com sucesso!';
      } else { //false
        $mensagem = 'Ops! Ocorreu um erro ao adicionar a definição!';
      }

     }

    }

    //Salvar palavra e significado //dicionario
    if ( isset($_POST['addDicionario']) ) {

      //Virifica dados necessarios
      if( isset($_POST['palavra'], $_POST['significado'], $_POST['tipo'], $_POST['cadeira'], $_POST['tecnoDict']) ) {

        // purificar
        $palavra     = filter_Var($_POST['palavra'] , FILTER_SANITIZE_STRING);
        $significado = filter_Var($_POST['significado'] , FILTER_SANITIZE_STRING);
        $fonte       = filter_Var($_POST['fonte'], FILTER_SANITIZE_STRING);

        $tipo = in_array($_POST['tipo'], ['t', 'g', 'i'])? $_POST['tipo']: 'i';

        //Set dados
        $obDicionario->termo         = $palavra;
        $obDicionario->definicao     = $significado;
        $obDicionario->user          = $codigoUser;
        $obDicionario->fonte         = $fonte ?? null;
        $obDicionario->tipo          = $tipo;
        $obDicionario->relacionado_a = $_POST['cadeira'];
        $obDicionario->tecnologia    = $_POST['tecnoDict'];

        //Salvar termo
        if( $obDicionario->cadastrar() ) { //True

          // tudo ok!
          $mensagem = 'Nova palavra foi carregada com sucesso!';

        } else { //False
          $mensagem = 'Ops! Ocorreu um erro ao adicionar a nova palavra ao diciónario!';
        }

      }

    }

    //Salvar boas praticas de programacao
    if ( isset($_POST['addBoaPratica']) ) {

      //Verifica dados necessarios
      if( $_POST['boaPratica'] != '' && $_POST['sobreTecnologia'] != '' && $_POST['categoiaPratica'] != '' ) {

        //set os Dados
        $obBoaPratica->boaPratica = $_POST['boaPratica'];
        $obBoaPratica->tecnologia = $_POST['sobreTecnologia'];
        $obBoaPratica->categoria  = $_POST['categoiaPratica'];
        $obBoaPratica->criada_por = $codigoUser;

        //Verifica se foi salva
        if ( $obBoaPratica->cadastrar() ) {
          // Tudo ok
          $mensagem = 'A nova dica de T.I salva com sucesso!';
        } else {
          // reportar erro
          $mensagem = 'Ops! Ocorreu um erro ao criar a nova dica  de T.I!';
        }

      }

    }

    //Salvar imagem
    if ( isset($_POST['addImagens']) ) {

      //Verifica dados necessarios
      if ( $_POST['tituloI'] != '' && $_POST['descricaoI'] != '' && $_POST['sobreI'] != '' ) {

        //Novo nome da imagem
        $newName = '';

        //armazenar em
        $directorio = __DIR__.'/../biblioteca/imagens/';

        //Verifica se a imagem foi recebida
        if( isset($_FILES['imagemUp']['name']) ) {

          //extensao
          $extensao = strtolower( substr($_FILES['imagemUp']['name'], -4));

          //Extensoes permitidas
          if( $extensao == '.png' || $extensao == '.jpg' || $extensao == '.gif' ) {

            //criar novo nome
            $newName = md5( time().$codigoUser ).$extensao;

            //carregar a imagem no web app
            if( move_uploaded_file($_FILES['imagemUp']['tmp_name'], $directorio.$newName) ) {

              //get dados
              $obImagem->titulo     = $_POST['tituloI'];
              $obImagem->descricao  = $_POST['descricaoI'];
              $obImagem->imagem     = $newName;
              $obImagem->sobre      = $_POST['sobreI'];
              $obImagem->criada_por = $codigoUser;

              //Verifica estado
              if ( $obImagem->cadastrar() ) { //True
                // tudo ok
                $mensagem = 'A nova imagem salva com sucesso!';
              } else { //False
                $mensagem = 'Ops! Ocorreu um erro ao salvar a nova imagem!';
              }

            } else {
              $mensagem = 'Ops! Não foi possível fazer o upload da imagem!';
            }

          } else {
            $mensagem = 'Ops! A formato do arquivo invalido, tente estes: [.png, .jpg, .gif]';
          }

        }

      }

    }

    //Salvar Livros
    if ( isset($_POST['addLivros']) ) {

      //verifica dados necessario
      if ( $_POST['descricaoL'] != '' && $_POST['sobreL'] != '' && $_POST['numeroP'] != '' && $_POST['autorL'] != '' ) { //true

        //Nome do livro
        $nome = $_POST['tituloL'];

        //Nome do arquivo
        $fileName = null;

        if ( isset($_FILES['carregarLivro']['name']) ) {

          //Verifica o arquito
          if( is_uploaded_file($_FILES['carregarLivro']['tmp_name']) ){

            //numero de caracteres
            $caracteres = strlen($_FILES['carregarLivro']['name'])-4;

            //get nome sem a extensao
            $nome = substr($_FILES['carregarLivro']['name'], 0, $caracteres);

            //set nome, caso nao pre-definido
            $nome = $_POST['tituloL'] != '' ? $_POST['tituloL'] : $nome;

            //get extensao
            $extensao = strtolower( substr($_FILES['carregarLivro']['name'], -4) );

            //Verifica a extensao do arquivo
            if( $_FILES['carregarLivro']['type'] == "application/pdf" ) {

              //nome do ficheiro
              $fileName = md5( time().$codigoUser ).$extensao;

              //Salvar em
              $directorio = __DIR__.'/../biblioteca/livros/';

              //carregar arquivo no servidor
              if( move_uploaded_file($_FILES['carregarLivro']['tmp_name'], $directorio.$fileName) ) {//true
                // tudo ok
                $mensagem = 'Tudo ok! ';
              } else { //Erro ao carregar arquivos no servidor
                $mensagem = 'Ops! Por problemas técnicos não foi possivel fazer o upload do livro. Carrege o [.PDF] depois nas definições!';
              }

            } else {
              $mensagem = 'Ops! Só é possível carregar arquivos em: [.PDF]. Carrege o [.PDF] depois nas definições!';
            }

          }

        }

        //set dados
        $obLivros->titulo     = $nome;
        $obLivros->descricao  = $_POST['descricaoL'];
        $obLivros->cadeiras   = $_POST['sobreL'];
        $obLivros->paginas    = $_POST['numeroP'];
        $obLivros->autores    = $_POST['autorL'];
        $obLivros->criado_por = $codigoUser;
        $obLivros->file_name  = $fileName;

        //salva os dados no DB
        if ( $obLivros->cadastrar() ) { //true

          //tudo ok
          $mensagem .= ' O livro foi adicionada a nossa biblioteca publica com sucesso!';

        } else { //Erro ao salvar no db
          $mensagem .= ' Não foi possível salvar os dados do livro, por favor, tente novamente!';
        }

      }

    }

    //Salvar desafio
    if ( isset($_POST['addDesafioE']) ) {

      //Verifica dados necessario
      if( isset($_POST['tituloD'], $_POST['descricaoD'], $_POST['cadeiraD'], $_POST['categoriaD'], $_POST['nivelDificuldade']) ) {

        $titulo = filter_var($_POST['tituloD'], FILTER_SANITIZE_STRING);
        $descri = filter_var($_POST['descricaoD'], FILTER_SANITIZE_STRING);

        //set dados
        $obDesafio->titulo         = $titulo;
        $obDesafio->desafio        = $descri;
        $obDesafio->sobre          = $_POST['cadeiraD'];
        $obDesafio->adicionada_por = $codigoUser;
        $obDesafio->nivel          = $_POST['nivelDificuldade'];
        $obDesafio->categoria      = $_POST['categoriaD'];

        //cadastrar desafio
        if ( $obDesafio->cadastrar() ) { //true

          // get categoria extensa
          $cat = ($_POST['categoriaD'] == 'd')? 'desafio': 'exercicio';

          // id do curso inserido
          $temaId = '';

          //
          $where = 'adicionada_por = "'.$codigoUser.'"';

          //
          $getLastDesafio = $obDesafio->getDesafios($where, 'data_inicio DESC', 1);

          // get dados do curso
          foreach ($getLastDesafio as $key => $desafio) {
            //
            $temaId = $desafio->id;
          }

          // verifica ultima curso inserido
          if ($temaId != '') {
            // dados novidades
            $obNovidades->id_user   = $codigoUser;
            $obNovidades->id_tema   = $temaId;
            $obNovidades->tema      = $cat;
            $obNovidades->descricao = '<h6>'. $titulo .'</h6> - '. $descri;
            $obNovidades->link      = 'desafios.php';
            $obNovidades->local     = 'd';

            // cadastra novidade
            if ($obNovidades->cadastrar()) {
              // tudo ok
            } else {
              // reportar erro
            }

          }


          //
          $mensagem = 'Novo '. $cat .' foi lançado, seja o primeiro a resolve-lo!';


        } else { //False
          $mensagem = 'Ops! Ocorreu um erro ao criar o novo '. $cat .'!';
        }

      }

    }

    //Objectivos
    if ( isset( $_POST['addObjectivos']) ) {

      //Verifica dados necessarios
      if ( $_POST['tituloOb'] != '' && $_POST['descricaoOb'] != '' && $_POST['dataInO'] != '' && $_POST['dateExO'] != '' && $_POST['sobreO'] != '' && $_POST['percentagemO'] != '' && $_POST['categoriaO'] != '' ) {

        //set dados
        $obObjectivos->titulo        = $_POST['tituloOb'];
        $obObjectivos->descricao     = $_POST['descricaoOb'];
        $obObjectivos->data_inicio   = $_POST['dataInO'];
        $obObjectivos->data_validade = $_POST['dateExO'];
        $obObjectivos->sobre         = $_POST['sobreO'];
        $obObjectivos->percentagem   = $_POST['percentagemO'];
        $obObjectivos->utilizador    = $codigoUser;
        $obObjectivos->categoria     = $_POST['categoriaO'];
        $obObjectivos->estado        = $_POST['estadoOb'];

        //Verifica estados
        if ( $obObjectivos->cadastrar() ) { // true

          $descricao = 'Um novo objectivo acabou de ser criado com sucesso!';

          $obNotificacoes->user_id         = $codigoUser;
          $obNotificacoes->breve_descricao = $descricao;
          $obNotificacoes->caminho         = '/objectivos.php';

          if ( $obNotificacoes->cadastrar() ) {
            // tudo ok!
            $memsagem = 'O objectivo foi adicionado a lista de objectivos com sucesso!';
          } else {
            // reportar o erro
            $mensagem = 'Não foi possivel gerar uma notificação!';
          }

        } else {//false
          $mensagem = 'Ops! Ocorreu um erro ao criar o seu novo objectivo!';
        }
      }

    }

    //quero aprender
    if ( isset($_POST['addOqueAprender']) ) {

      //Verificar dados necessarios
      if ( $_POST['queroAprender'] != '' && $_POST['weyWordA'] != '' && $_POST['tecnologiaA'] != '' && $_POST['aprenderA'] != '' && $_POST['cadeiraA'] != '' ) {

        $obAprender->descricao    = $_POST['queroAprender'];
        $obAprender->key_word     = $_POST['weyWordA'];
        $obAprender->tecnologia   = $_POST['tecnologiaA'];
        $obAprender->lancado_em   = $_POST['aprenderA'];
        $obAprender->sobre        = $_POST['cadeiraA'];
        $obAprender->criada_por   = $codigoUser;

        //Verifica o estado
        if( $obAprender->cadastrar() ) { //True
          // tudo ok
          $mensagem = 'Novo tema sobre o que aprender foi criado com sucesso!';
        } else { //False
          $mensagem = 'Ops! Ocorreu um erro ao criar tema sobre o que aprender!';
        }

      }

    }

    //Salvar ideias e projectos
    if ( isset($_POST['AddProjectos']) ) {

      //verifica dados necessarios
      if( isset($_POST['nomeP'], $_POST['descricaoP'], $_POST['sobreP'], $_POST['categoriaP'], $_POST['percentagemP'], $_POST['estadoP'])  ) {

        //
        $titulo = filter_var($_POST['nomeP'], FILTER_SANITIZE_STRING);
        $descricao = filter_var($_POST['descricaoP'], FILTER_SANITIZE_STRING);

        //set dados
        $obProjectos->titulo       = $titulo;
        $obProjectos->descricao    = $descricao;
        $obProjectos->sobre        = $_POST['sobreP'];
        $obProjectos->utilizador   = $codigoUser;
        $obProjectos->categoria    = $_POST['categoriaP'];
        $obProjectos->percentagem  = $_POST['percentagemP'];
        $obProjectos->estado       = $_POST['estadoP'];

        //verifica o estado
        if ( $obProjectos->cadastrar() ) { //True
          // tudo ok
          $mensagem = 'Um novo projecto foi criado com sucesso!';
        } else { //False
          $mensagem = 'Ops! Ocorreu um erro ao criar um novo projecto!';
        }
      }

    }

    //Pesquisar por
    if ( isset( $_POST['addPesquisarPor']) ) {

      //Verificar dados
      if ( $_POST['tituloPes'] != '' && $_POST['descricaoPes'] != '' && $_POST['cadeiraPes'] != '' && $_POST['categoriaPes'] != '' ) {

        //set dados
        $obMateria->titulo           = $_POST['tituloPes'];
        $obMateria->descricao        = $_POST['descricaoPes'];
        $obMateria->sobre            = $_POST['cadeiraPes'];
        $obMateria->desenvolvida_por = $codigoUser;
        $obMateria->categoria        = $_POST['categoriaPes'];

        if( $obMateria->cadastrar() ) { //true
          // tudo ok
          $mensagem = 'Um novo trabalho de investigação ciêntifica foi criado com sucesso!';
        } else { //False
          $mensagem = 'Ops! Ocorreu um erro ao criar o trabalho de investigação ciêntifica, tente novamente!';
        }

      }

    }


    //Salvar dicas de riquiza/sabedoria
    if ( isset($_POST['addDicasSabias']) ) {

      //Verificar dados necessarios
      if ( $_POST['dicaRiqueza'] != '' ) {

        //Set dados
        $obDicas->id_user = $codigoUser;
        $obDicas->dica    = $_POST['dicaRiqueza'];
        $obDicas->origem  = $_POST['origemDica'] ?? null;

        //verifica se a dica foi salva
        if( $obDicas->cadastrar() ) { //true

          $descricao = 'A sua dica de sabedoria foi salva com sucesso!';

          $obNotificacoes->user_id         = $codigoUser;
          $obNotificacoes->breve_descricao = $descricao;
          $obNotificacoes->caminho         = '/sejaSabio.php';

          if ( $obNotificacoes->cadastrar() ) {
            // tudo ok
            $mensagem = 'A sua dica de sabedoria/riqueza foi criada com sucesso!';
          } else {
            // reportar o erro
            $mensagem = 'Ops! Ocorreu um erro ao gerar notificação!';
          }

        } else { //false
          $mensagem = 'Ops! Ocorreu um erro ao criar novo nova dica de riqueza/sabedoria!';
        }

      }

    }

    //Salvar sites
    if ( isset($_POST['addSites']) ) {

      //Verifica se os dados foram enviados
      if ( $_POST['nome'] != '' && $_POST['linkWeb'] != '' && $_POST['descricao'] != '' && $_POST['cadeira'] > 0 ) {

        //Set dados
        $obSites->user          = 1;
        $obSites->titulo        = $_POST['nome'];
        $obSites->link          = $_POST['linkWeb'];
        $obSites->descricao     = $_POST['descricao'];
        $obSites->imagem        = '';
        $obSites->relacionado_a = $_POST['cadeira'];

        //Salvar site
        if ( $obSites->cadastrar() ) { //true

          $descricao = 'Acabaste de adicionar um novo site a nossa lista, podes visita-lo a qualquer momento!';

          $obNotificacoes->user_id         = $codigoUser;
          $obNotificacoes->breve_descricao = $descricao;
          $obNotificacoes->caminho         = '/sites.php';

          if ( $obNotificacoes->cadastrar() ) {
            // tudo ok!
            $mensagem = 'O novo site foi salvo com sucesso!';
          } else {
            // reportar o erro
            $mensagem = 'Ops! Ocorreu um erro ao gerar notificação!';
          }

        } else { //False
          $mensagem = 'Ops! Ocorreu um erro ao criar novo site!';
        }

      }

    }


    // Cursos
    $getCursos = $obCursos::getCursos(null, "titulo DESC");

    // Armazena a lista de cursos
    $listarCursos = '';

    // formata a lista de cursos
    foreach ( $getCursos as $cursos ) {
      $listarCursos .= '<option value="'. $cursos->id .'">
                         '. $cursos->titulo .'
                       </option>';
    } // Fim cursos

    // get Meus cursos
    $getMeusCursos = $obMeusCursos::getMeusCursos("user='". $codigoUser ."' AND estado = 'p'");

    // armazena a lista com os cursos
    $todosMeusCursos = '';

    // formata a lista com os cursos
    foreach ( $getMeusCursos as $cursos ) {

      $curso = $obCursos->getCurso( $cursos->curso_id );

      $status = '';

      if ( $cursos->estado == 'p' ) {
        $status = 'Por fazer';
      } else if ( $cursos->estado == 'a' ) {
        $status = 'A fazer';
      } else {
        $status = 'Feito';
      }

      $todosMeusCursos .= '<li>
                             <a href="?id='. $cursos->id .'">

                               <span title="'. $status .'">'. $cursos->estado .'</span>
                               - '. $curso->titulo .'
                             </a>
                           </li>';

    }

    // armazena a lista de notificacoes
    $listarNotificacoes = '';

    // clausula where notificaoes
    $whereNotificacoes = 'user_id="'. $codigoUser .'"';

    // Obtem as notificacoes especificas de um utilizador
    $getNotificacoes = $obNotificacoes->getNotificacoes($whereNotificacoes, 'gerada_em DESC', 7);

    $qtdeNotificacoesPorVer = $obNotificacoes->getQuantidadeNotificacoes($whereNotificacoes);

    // Formata a lista de notificacoes
    foreach( $getNotificacoes as $key=>$notificacoes ) {

      // set notificacoes
      $listarNotificacoes .= '<div class="as-minhas-notificacoes">
                                <a href="'. $notificacoes->caminho .'">
                                  '. $notificacoes->breve_descricao .' <small>Aos
                                  '. $notificacoes->gerada_em .'</small>
                                </a>
                              </div>';
    }

    // verifica se ha notificacoes
    if ( strlen($listarNotificacoes) == 0 ) {
      $listarNotificacoes = '<p>Sem notificações!</p>';
    }
