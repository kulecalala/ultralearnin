<?php
  //
  $dicasDeTIList = '';

  // Controla a visualizacao das dicas
  $mostrarTudo = true;

  // editar dica ti
  if ( isset($_GET['dicaDeTecnolIdEdit']) ) {

    // Controla a visualizacao das dicas
    $mostrarTudo = false;

    // control de acesso
    $contolDeAcessoDicaTI = true;

    // clausula where de busca da dica
    $whereBuscaDica = 'id = "'. $_GET['dicaDeTecnolIdEdit'] .'" AND criada_por = "'. $codigoUser .'"';

    // realiza a busca da dica
    $EditarDica = $obBoaPratica->getBoasPraticas( $whereBuscaDica, null, '1' );

    foreach ($EditarDica as $key => $dica) {
      // control de acesso
      $contolDeAcessoDicaTI = false;

      // get lista de tecnologias
      $obTecnologiasList = $obTecnologia->getTecnologias(null, 'titulo DESC');

      // lista de tecnologias
      $tecnologiasList = '';

      // gerar lista de tecnologias
      foreach ($obTecnologiasList as $key => $value ) {

        // seleciona a dica
        $selecionar = '';

        // verifica se o id e igual
        if ( $dica->tecnologia == $value->id ) {
          // seleciona a dica
          $selecionar = 'selected';
        }

        // formar lista
        $tecnologiasList .= '<option value="'. $value->id .'" '.$selecionar.'>
                               '. $value->titulo .'
                             </option>';
      }

      // get Lista de categorias
      $obCategoriasList = $obCategoriaB->getCategorias(null, 'titulo DESC');

      // lista de categorias
      $categoriasList = '';

      // gerar lista de categorias
      foreach ($obCategoriasList as $key => $value) {

        // seleciona a dica
        $selecionar = '';

        // verifica se o id e igual
        if ( $dica->categoria == $value->id ) {
          // seleciona a dica
          $selecionar = 'selected';
        }

        // formar lista
        $categoriasList .= '<option value="'. $value->id .'" '.$selecionar.'>
                              '. $value->titulo .'
                            </option>';
      }

      // get dica de ti
      $dicasDeTIList = '<div id="editar-dica-s" id="editar-dica-s-ti">
                          <form name="" method="post" action="">
                            <h4> Editar dica de T.I
                              <a href="/dicasDeTi.php">
                               Voltar
                              </a>
                            </h4>

                            <textarea name="dica" id="dica" min="20" required>'. $dica->boaPratica .'</textarea>

                            <select name="tecnologiaDica" size="1" class="selectOptionEditar" required>
                              <option value="">
                                Selecione a tecnologia referente!
                              </option>

                              '. $tecnologiasList .'
                            </select>

                            <select name="categoriaDica" size="1" class="selectOptionEditar" required>
                              <option value="">
                                Selecione a categoria da dica!
                              </option>

                              '. $categoriasList .'
                            </select>

                            <input type="text" name="idDica" value="'. $_GET['dicaDeTecnolIdEdit'] .'" required hidden/>

                            <div id="btn-control">
                              <input type="submit" name="btn-actualizar-dica" value="Actualizar" id="update"/>

                              <input type="submit" name="btn-restaurar" value="Restaurar" id="reset"/>

                              <input type="submit" name="btn-apagar-dica" value="Apagar" id="apagar"/>
                            </div>
                          </form>
                        </div>';

    }

    // a dica foi localizada e valida
    if ( $contolDeAcessoDicaTI ) { // true
      // get dica de ti
      $dicasDeTIList  = '<div id="not-found-dica">
                           <a href="/dicasDeTi.php"> Go To List </a>

                           <p>A dica solicitada nao exite!</p>
                         </div>';
    }

  }

  // Comentar uma publicacao
  if ( isset( $_GET['comentDicaDeTecno'] ) ) {

    // control de acesso
    $contolDeAcessoDicaTI = false;

    // realiza a busca da dica
    $dicas = $obBoaPratica->getBoaPratica( $_GET['comentDicaDeTecno'] );

    // Controla a visualizacao das dicas
    $mostrarTudo = false;

    // set o id da dica
    $idDica = $dicas->id;

    // set outros dados
    $like = 'Fixe';
    $unlike = 'Gato';
    $comentar = '';
    $tecnologia = 'Tecnologia: ';
    $categoria = 'Categoria: ';

    // get Coments
    $whereComent = 'id_dica = "'. $idDica .'"';
    $comentar = $obDicaComents->getQuantidadeComentarios( $whereComent );

    if ( $comentar == 0 ) {
      $comentar = 'Comentar';
    } else if ( $comentar == 1 ) {
      $comentar .= ' Comentario';
    } else {
      $comentar .= ' Comentarios';
    }

    // Clausula where
    $whereComents = 'id_dica = "'. $_GET['comentDicaDeTecno'] .'"';

    // get comentarios
    $comentsDica = $obDicaComents->getDicaComentarios( $whereComents, 'data DESC' );

    // Armazena os comentarios
    $listaComentarios = '';

    // get comentarios
    foreach ($comentsDica as $key => $comentario) {

      $userFoto = '../imagens/logo/icon2.jpeg';

      $dadosAutor = $obUtilizador->getUser( $comentario->id_user );
      $comentAutorName = $dadosAutor->username;

      // BTN editar comentario
      $deleteCometario = '';

      // verifica autor do comentario
      if ( $comentario->id_user == $codigoUser ) {
        $deleteCometario = '<form name="" method="post" action="">

                              <input type="text" name="idComentario" value="'. $comentario->id .'" hidden/>

                              <input type="submit" name="Apagar-comentario" id="btn-delete" value="Apagar"/>
                            </form>';
      }

      $listaComentarios .= '<div class="comentario">
                              <div class="coment-dados-user">
                                <img src="'. $userFoto .'" alt="foto de perfil do autor do comentario!"/>

                                <div class="users">

                                  <div class="name">
                                    '. $comentAutorName .'
                                  </div>

                                  '. $deleteCometario .'

                                  <div class="data">
                                    Aos: '. $comentario->data .'
                                  </div>
                                </div>

                                <div class="comentario-user">
                                  '. $comentario->comentario .'
                                </div>
                              </div>
                            </div>';
    }

    // verifica se ha algum comentario
    if ( strlen($listaComentarios) == 0 ) {
      $listaComentarios = '<p>'. $globalUserName .', seja a primeira pessoa a comentar!</p>';
    }

    // Formulario para comentar e lista de comentarios
    $adicionarComentario = '<div id="add-comentario">
                              <form name="" method="post" action="">
                                <textarea name="comentario" placeHolder="Escreva aqui o seu comentario!" required></textarea>

                                <input type="text" name="idDica" value="'. $_GET['comentDicaDeTecno'] .'" hidden/>

                                <input type="submit" value="Comentar" name="addComent"/>
                              </form>

                              <div id="listar-comentarios">
                                '. $listaComentarios .'
                              </div>
                            </div>';

    // get fixe and gato
    $like = $obDicaReacoes->getQtdeReacoes('id_dica = "'. $dicas->id .'"  AND reacoes = "l"', null, '1');

    if ( $like == 0 ) {
      $like = 'Fixe';
    } else if ( $like >= 1 ) {
      $like .= ' Fixe';
    }

    $unlike = $obDicaReacoes->getQtdeReacoes('id_dica = "'. $dicas->id .'" AND reacoes = "u"', null, '1');

    if ( $unlike == 0 ) {
      $unlike = 'Gato';
    } else if ( $unlike >= 1 ) {
      $unlike .= ' Gato';
    }

    // get categoria
    $getCagorias = $obCategoriaB->getCategoria( $dicas->categoria );

    // set categoria
    $categoria = $getCagorias->titulo ?? 'Indisponivel';

    // get tecnologia
    $getTecnologia = $obTecnologia->getTecnologia( $dicas->tecnologia );

    // set tecnologia
    $tecnologia = $getTecnologia->titulo ?? 'Indisponivel';

    // a dica ja foi lida
    $whereDicaLida = 'id_dica = "'. $idDica .'" AND id_user = "'. $codigoUser .'"';
    $getLida = $obDicasLidas->getLidas( $whereDicaLida, null, '1' );

    // status lida
    $foiLida = '<div class="marcar-dica-nao-lida" title="Não lida"></div>';

    // lista lida
    foreach ($getLida as $key => $value) {
      // code...
      $foiLida = '<div class="marcar-dica-lida" title="Lida"></div>';
    }

    $userName = $obUtilizador->getUser( $dicas->criada_por );

    $userFoto = '../imagens/logo/icon2.jpeg';

    // link para editar a dica
    $editarDica = '';

    if ( $codigoUser == $dicas->criada_por ) {
      $editarDica = '<a href="?dicaDeTecnolIdEdit='. $idDica .'"> Editar </a>';
    }

    // get dica de ti
    $dicasDeTIList = '<div class="dicas-de-sabedoria">
                            <div class="dica-topo">
                              <img src="'. $userFoto .'" class="foto"/>
                              <div class="conteiner-dados-user">
                                <div class="nome">
                                  '. $userName->username .'
                                  '. $editarDica .'
                                </div>
                                <div class="fonte">
                                  Actualizado em: '. $dicas->criada_em .'
                                </div>
                              </div>
                            </div>

                            <div class="dica-s">
                              '. $dicas->boaPratica .'
                            </div>

                            <div class="roda-peS">
                              <div class="reacoes">
                                <form method="post" action="">
                                  <input type="text" name="idDica" value="'. $idDica .'" hidden/>

                                  <input type="text" name="reacao" value="l" hidden/>

                                  <button type="submit" name="addReacao">
                                    '. $like .'
                                  </button>
                                </form>
                              </div>

                              <div class="reacoes">
                              <form method="post" action="">
                                <input type="text" name="idDica" value="'. $idDica .'" hidden/>

                                <input type="text" name="reacao" value="u" hidden/>

                                <button type="submit" name="addReacao">
                                  '. $unlike .'
                                </button>
                              </form>
                              </div>

                              <div class="comentarios">
                                <a href="?comentDicaDeTecno='. $idDica .'">
                                  <button>'. $comentar .'</button>
                                </a>
                              </div>

                              <div class="more-info">
                                <button title="Tecnologia">
                                  '. $tecnologia .'
                                </button>
                              </div>

                              <div class="more-info">
                                <button title="Categoria">
                                  '. $categoria .'
                                </button>
                              </div>

                              <div class="denunciar" title="Ao denunciar, os gestores da plataforma irão rever a publicação">
                                <form name="" method="post" action="">
                                  <input type="text" name="idDica" value="'. $idDica .'" hidden/>
                                  <button type="submit" name="btn-denunciar"> Denunciar </button>
                                </form>
                              </div>

                              <div class="share" hidden>
                                <button> Share </button>
                              </div>

                              <div class="lida">
                                <form name="" method="post" action="">
                                  <input type="text" name="idDica" value="'. $idDica .'" hidden/>
                                  <button type="submit" name="lerDica"> Lida '. $foiLida .' </button>
                                </form>
                              </div>

                            </div>

                            '. $adicionarComentario .'
                          </div>';

  }

  // Mostrar todas as dicas de ti ou dica especifica
  if ( $mostrarTudo ) {

    foreach ( $dicasDeTI as $key => $dicas ) {
      $idDica = $dicas->id;

      $like = 'Fixe';
      $unlike = 'Gato';
      $comentar = 'Comentar';
      $tecnologia = 'Tecnologia: ';
      $categoria = 'Categoria: ';

      // get Coments
      $whereComent = 'id_dica = "'. $idDica .'"';
      $comentar = $obDicaComents->getQuantidadeComentarios( $whereComent );

      if ( $comentar == 0 ) {
        $comentar = 'Comentar';
      } else if ( $comentar == 1 ) {
        $comentar .= ' Comentario';
      } else {
        $comentar .= ' Comentarios';
      }

      // get fixe and gato
      $like = $obDicaReacoes->getQtdeReacoes('id_dica = "'. $dicas->id .'"  AND reacoes = "l"', null, '1');

      if ( $like == 0 ) {
        $like = 'Fixe';
      } else if ( $like >= 1 ) {
        $like .= ' Fixe';
      }

      $unlike = $obDicaReacoes->getQtdeReacoes('id_dica = "'. $dicas->id .'" AND reacoes = "u"', null, '1');

      if ( $unlike == 0 ) {
        $unlike = 'Gato';
      } else if ( $unlike >= 1 ) {
        $unlike .= ' Gato';
      }

      // get categoria
      $getCagorias = $obCategoriaB->getCategoria( $dicas->categoria );

      // set categoria
      $categoria = $getCagorias->titulo ?? 'Indisponivel';

      // get tecnologia
      $getTecnologia = $obTecnologia->getTecnologia( $dicas->tecnologia );

      // set tecnologia
      $tecnologia = $getTecnologia->titulo ?? 'Indisponivel';

      // a dica ja foi lida
      $whereDicaLida = 'id_dica = "'. $idDica .'" AND id_user = "'. $codigoUser .'"';
      $getLida = $obDicasLidas->getLidas( $whereDicaLida, null, '1' );

      // status lida
      $foiLida = '<div class="marcar-dica-nao-lida" title="Não lida"></div>';

      // lista lida
      foreach ($getLida as $key => $value) {
        // code...
        $foiLida = '<div class="marcar-dica-lida" title="Lida"></div>';
      }

      $userName = $obUtilizador->getUser( $dicas->criada_por );

      $userFoto = '../imagens/logo/icon2.jpeg';

      // link para editar a dica
      $editarDica = '';

      if ( $codigoUser == $dicas->criada_por ) {
        $editarDica = '<a href="?dicaDeTecnolIdEdit='. $idDica .'"> Editar </a>';
      }

      //
      $dicasDeTIList .= '<div class="dicas-de-sabedoria">
                              <div class="dica-topo">
                                <img src="'. $userFoto .'" class="foto"/>
                                <div class="conteiner-dados-user">
                                  <div class="nome">
                                    '. $userName->username .'
                                    '. $editarDica .'
                                  </div>
                                  <div class="fonte">
                                    Actualizado em: '. $dicas->criada_em .'
                                  </div>
                                </div>
                              </div>

                              <div class="dica-s">
                                '. $dicas->boaPratica .'
                              </div>

                              <div class="roda-peS">
                                <div class="reacoes">
                                  <form method="post" action="">
                                    <input type="text" name="idDica" value="'. $idDica .'" hidden/>

                                    <input type="text" name="reacao" value="l" hidden/>

                                    <button type="submit" name="addReacao">
                                      '. $like .'
                                    </button>
                                  </form>
                                </div>

                                <div class="reacoes">
                                <form method="post" action="">
                                  <input type="text" name="idDica" value="'. $idDica .'" hidden/>

                                  <input type="text" name="reacao" value="u" hidden/>

                                  <button type="submit" name="addReacao">
                                    '. $unlike .'
                                  </button>
                                </form>
                                </div>

                                <div class="comentarios">
                                  <a href="?comentDicaDeTecno='. $idDica .'">
                                    <button>'. $comentar .'</button>
                                  </a>
                                </div>

                                <div class="more-info">
                                  <button title="Tecnologia">
                                    '. $tecnologia .'
                                  </button>
                                </div>

                                <div class="more-info">
                                  <button title="Categoria">
                                    '. $categoria .'
                                  </button>
                                </div>

                                <div class="denunciar" title="Ao denunciar, os gestores da plataforma irão rever a publicação">
                                  <form name="" method="post" action="">
                                    <input type="text" name="idDica" value="'. $idDica .'" hidden/>
                                    <button type="submit" name="btn-denunciar"> Denunciar </button>
                                  </form>
                                </div>

                                <div class="share" hidden>
                                  <button> Share </button>
                                </div>

                                <div class="lida">
                                  <form name="" method="post" action="">
                                    <input type="text" name="idDica" value="'. $idDica .'" hidden/>
                                    <button type="submit" name="lerDica"> Lida '. $foiLida .' </button>
                                  </form>
                                </div>

                              </div>
                            </div>';
    }

  }

  // Gets
  unset( $_GET['pagina'] );

  $gets = http_build_query( $_GET );

  // Paginacao
  $paginacao = '';

  $paginas = $obPagination->getPages();

  foreach ( $paginas as $key => $pagina ) {
    $class = $pagina['actual'] ? 'p-actual' : 'o-paginas';

    $paginacao .= '<a href="?pagina='.$pagina['pagina'].'&'.$gets.'">
                     <button type="button" class="'.$class.'">
                       '. $pagina['pagina'] .'
                     </button>
                   </a>';
  }

  //Get boas praticas
  foreach( $getBoasPraticas as $dados ) {

    // marcar como select
    $selecionar = '';

    // get id
    $getId = $_GET['filtrarDicaCategoria'] ?? '';

    // verifica igualdade de ID
    if ( $getId == $dados->id ) {
      $selecionar = 'selected';
    }

    $listarBoasPraticasTi .= '<option value="'. $dados->id .'" '.$selecionar.'>
                              '. $dados->titulo .'
                            </option>';
  }

  //Verifica se a dicas de programacao
  if( $listarBoasPraticasTi == '' ) {
    $listarBoasPraticasTi = '<option value="">
                            A lista de encontra-se vazia!
                           </option>';
  }

  // Formata a lista de tecnologias
  foreach ( $getTecnologias as $tecnologias ) {

    // marcar como select
    $selecionar = '';

    // get id
    $getId = $_GET['filtrarDica'] ?? '';

    // verifica igualdade de ID
    if ( $getId == $tecnologias->id ) {
      $selecionar = 'selected';
    }

    $listarTecnologias .= '<option value="'. $tecnologias->id .'" '.$selecionar.'>
                             '. $tecnologias->titulo .'
                           </option>';
  }

  // verifica se a tecnologias na lista
  if ( $listarTecnologias == '' ) {
    $listarTecnologias = '<option value="" selected>
                            A lista encontra-se vazia!
                          </option>';
  }  // Fim Tecnologias

  // titulo busca
  $tituloBusca = '';

  // verifica se alguma busca foi efectuada
  if ( isset($_GET['filtrarDica']) || isset($_GET['filtrarDicaCategoria']) ) {
    $tituloBusca = '<h3>
                      Resultado(s) da busca
                      <a href="/dicasDeTi.php">Ver todas</a>
                    </h3>';
  }

?>
<main id="seja-sabio">
  <section id="seja-sabio-lista">
    <div id="topo-sabio">
      <div id="tituloMFKB">
        Dicas De T.I
      </div>

      <form name="" method="get" id="form-seja-sabio">
        <input type="text" name="fraseDica" placeHolder="Faça uma busca, temos +<?=($quantidadeDeDicas-5)?> dicas de T.I para si!" class="buscar-sabio" id="buscar-ti" value="<?=$b_frase?>"/>

        <div class="filtros">
          <label for="filtro">Tecnologia:</label>
          <select class="" name="filtrarDica" size="1">
            <option value="">Selecione o filtro</option>

            <!--Lista de tecnologias-->
            <?=$listarTecnologias;?>
          </select>
        </div>

        <div class="filtros" id="filtros">
          <label for="filtro">Categoria:</label>
          <select class="" name="filtrarDicaCategoria" size="1">
            <option value="">Selecione o filtro</option>

            <!--Lista de boas praticas-->
            <?=$listarBoasPraticasTi;?>
          </select>
        </div>

        <input type="submit" value="Buscar" class="btn-buscar" id="btn-ti-busca"/>
      </form>
    </div>

    <div id="lista-style">
      <div id="lidas-nao-de-dicas" title="" <?=($tituloBusca != '')? 'hidden': ''?>>
        Lidas: <?=$qtdeDicasLidasByMe.' / '.$quantidadeDeDicas?>
      </div>

      <?=$tituloBusca?>


      <div id="lista-sabio">
        <?=$dicasDeTIList?>
      </div>
    </div>
  </section>

  <section id="numero-paginas-sabio">
    <?=$paginacao?>
  </section>
</main>
