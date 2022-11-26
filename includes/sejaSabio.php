<?php
  $dicasDeSabedoria = '';

  // Adicionar comentario
  $adicionarComentario = false;

  // Controler ver todos as dicas
  $verTodasDicas = true;

  // Busca efectuada
  $tituloBusca = '';

  // Editar dica de sabedoria
  if ( isset( $_GET['dicaDeSabedoriaIdEdit'] ) ) {

    // Controler ver todas dicas
    $verTodasDicas = false;

    // Controler editar dica
    $editarDica = false;

    // dados da dica
    $id     = '';
    $dica   = '';
    $origem = '';

    // get dica
    $where = 'id = "'. $_GET['dicaDeSabedoriaIdEdit'] .'" AND id_user = "'. $codigoUser .'"';
    $dicaDeS = $obDicas->getDicas( $where, null, '1' );

    foreach ($dicaDeS as $key => $edit ) {

      // Controler editar dica
      $editarDica = true;

      // set dados
      $id     = $edit->id;
      $dica   = $edit->dica? $edit->dica: '';
      $origem = strlen($edit->origem)? $edit->origem:'Indisponivel';
      $data   = $edit->actualizado_em;
    }

    // Editar dica
    if ( $editarDica ) {

      $dicasDeSabedoria = '<div id="editar-dica-s">
                             <form name="" method="post" action="">
                               <h4>
                                 Editar dica sabedoria
                                 <a href="/sejaSabio.php">
                                   Voltar
                                 </a>
                               </h4>

                               <textarea name="dica" id="dica">'. $dica .'</textarea>

                               <input type="text" name="origem" value="'.$origem.'" id="origem"/>

                               <input type="text" name="idDica" value="'. $id .'" hidden/>

                               <div id="btn-control">
                                 <input type="submit" name="btn-actualizar" value="Actualizar" id="update"/>

                                 <input type="submit" name="btn-restaurar" value="Restaurar" id="reset"/>

                                 <input type="submit" name="btn-apagar" value="Apagar" id="apagar"/>
                               </div>
                             </form>
                           </div>';

    } else {

      $dicasDeSabedoria = '<div id="not-found-dica">
                            <a href="/sejaSabio.php">
                              Go To List
                            </a>

                            <p>A dica solicitada nao exite!</p>

                           </div>';

    }

  }

  if ( strlen( $busca ) ) {
    $tituloBusca = '<h3>
                      Resultado(s) da busca
                      <a href="/sejaSabio.php">Ver todas</a>
                    </h3>';
  }

  // add comentario
  if ( isset($_GET['comentDicaRiqueza']) ) {

    // Controler ver todos as dicas
    $verTodasDicas = false;

    // procura pela dica de ti
    $sabedoria = $obDicas->getDica( $_GET['comentDicaRiqueza'] );

    // di da dica de sabedoria
    $idDica = $sabedoria->id;

    // clausula de busca dos comentarios
    $whereComents = 'id_dica = "'. $_GET['comentDicaRiqueza'] .'"';

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

                                <input type="text" name="idDica" value="'. $_GET['comentDicaRiqueza'] .'" hidden/>

                                <input type="submit" value="Comentar" name="addComent"/>
                              </form>

                              <div id="listar-comentarios">
                                '. $listaComentarios .'
                              </div>
                            </div>';

    // a dica ja foi lida
    $whereDicaLida = 'id_dica = "'. $idDica .'" AND id_user = "'. $codigoUser .'"';
    $getLida = $obDicasLidas->getLidas( $whereDicaLida );

    // status lida
    $foiLida = '<div class="marcar-dica-nao-lida" title="Não lida"></div>';

    // lista lida
    foreach ($getLida as $key => $value) {
      // altera estado de dica lida
      $foiLida = '<div class="marcar-dica-lida" title="Lida"></div>';
    }

    // get Coments
    $whereComent = 'id_dica = "'. $idDica .'"';
    $coments = $obDicaComents->getQuantidadeComentarios( $whereComent );

    if ( $coments == 0 ) {
      $coments = 'Comentar';
    } else if ( $coments == 1 ) {
      $coments .= ' Comentario';
    } else {
      $coments .= ' Comentarios';
    }

    // get fixe and gato
    $like = $obDicaReacoes->getQtdeReacoes('id_dica = "'. $sabedoria->id .'"  AND reacoes = "l"');

    // verifica a qtde
    if ( $like == 0 ) {
      $like = 'Fixe';
    } else {
      $like .= ' Fixe';
    }

    // get gato
    $unlike = $obDicaReacoes->getQtdeReacoes('id_dica = "'. $sabedoria->id .'" AND reacoes = "u"');

    // verifica qtde gato
    if ( $unlike == 0 ) {
      $unlike = 'Gato';
    } else {
      $unlike .= ' Gato';
    }

    // get fonte
    $fonte = ($sabedoria->origem != "") ? substr($sabedoria->origem, 0, 220) : 'Indisponivel';

    // get nome do autor
    $userName = $obUtilizador->getUser( $sabedoria->id_user );

    // armazena o caminho da foto de perfil
    $userFoto = '../imagens/logo/icon2.jpeg';

    // link para editar a dica
    $editarDica = '';

    // verifica autor da publicacao
    if ( $codigoUser == $sabedoria->id_user ) {
      $editarDica = '<a href="?dicaDeSabedoriaIdEdit='. $idDica .'">
                       Editar
                     </a>';
    }

    $dicasDeSabedoria .= '<div class="dicas-de-sabedoria">
                            <div class="dica-topo">
                              <img src="'. $userFoto .'" class="foto"/>
                              <div class="conteiner-dados-user">
                                <div class="nome">
                                  '. $userName->username .'
                                  <a href="/sejaSabio.php"> Voltar </a> &nbsp;  '. $editarDica .'
                                </div>
                                <div class="fonte">
                                  Fonte: '. $fonte .'
                                </div>
                              </div>
                            </div>

                            <div class="dica-s">
                              '. $sabedoria->dica .'
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
                                <a href="?comentDicaRiqueza='. $idDica .'">
                                  <button>'. $coments .'</button>
                                </a>
                              </div>

                              <div class="denunciar">
                                <form name="" method="post" action="">
                                  <input type="text" name="idDica" value="'. $idDica .'" hidden/>
                                  <button type="submit" name="btn-denunciar"> Denunciar </button>
                                </form>
                              </div>

                              <div class="share" hidden>
                                <button> Share </button>
                              </div>

                              <div class="data">
                                <button>
                                Última actualização: '. $sabedoria->actualizado_em .' </button>
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

  // Ver todas as dicas de sabedoria
  if ( $verTodasDicas ) {

    foreach( $dicasS as $key=>$sabedoria ) {

      $idDica = $sabedoria->id;

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

      // get Coments
      $whereComent = 'id_dica = "'. $idDica .'"';
      $coments = $obDicaComents->getQuantidadeComentarios( $whereComent );

      if ( $coments == 0 ) {
        $coments = 'Comentar';
      } else if ( $coments == 1 ) {
        $coments .= ' Comentario';
      } else {
        $coments .= ' Comentarios';
      }

      // get fixe and gato
      $like = $obDicaReacoes->getQtdeReacoes('id_dica = "'. $sabedoria->id .'"  AND reacoes = "l"');

      if ( $like == 0 ) {
        $like = 'Fixe';
      } else {
        $like .= ' Fixe';
      }

      $unlike = $obDicaReacoes->getQtdeReacoes('id_dica = "'. $sabedoria->id .'" AND reacoes = "u"');

      if ( $unlike == 0 ) {
        $unlike = 'Gato';
      } else {
        $unlike .= ' Gato';
      }

      // fonte da dica
      $fonte = ($sabedoria->origem != "") ? substr($sabedoria->origem, 0, 220) : 'Indisponivel';

      // get user
      $userName = $obUtilizador->getUser( $sabedoria->id_user );

      // user foto
      $userFoto = '../imagens/logo/icon2.jpeg';

      // link para editar a dica
      $editarDica = '';

      if ( $codigoUser == $sabedoria->id_user ) {
        $editarDica = '<a href="?dicaDeSabedoriaIdEdit='. $idDica .'"> Editar </a>';
      }

      $dicasDeSabedoria .= '<div class="dicas-de-sabedoria">
                              <div class="dica-topo">
                                <img src="'. $userFoto .'" class="foto"/>
                                <div class="conteiner-dados-user">
                                  <div class="nome">
                                    '. $userName->username .'
                                    '. $editarDica .'
                                  </div>
                                  <div class="fonte">
                                    Fonte: '. $fonte .'
                                  </div>
                                </div>
                              </div>

                              <div class="dica-s">
                                '. $sabedoria->dica .'
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
                                  <a href="?comentDicaRiqueza='. $idDica .'">
                                    <button>'. $coments .'</button>
                                  </a>
                                </div>

                                <div class="denunciar">
                                  <form name="" method="post" action="">
                                    <input type="text" name="idDica" value="'. $idDica .'" hidden/>
                                    <button type="submit" name="btn-denunciar"> Denunciar </button>
                                  </form>
                                </div>

                                <div class="share" hidden>
                                  <button> Share </button>
                                </div>

                                <div class="data">
                                  <button>
                                  Última actualização: '. $sabedoria->actualizado_em .' </button>
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

  }

  // Gets
  unset( $_GET['pagina'] );

  $gets = http_build_query( $_GET );

  // Paginacao
  $paginacao = '';
  $paginas = $obPagination->getPages();

  foreach( $paginas as $key=>$pagina ) {
    $class = $pagina['actual'] ? 'p-actual' : 'o-paginas';

    $paginacao .= '<a href="?pagina='.$pagina['pagina'].'&'.$gets.'">
                     <button type="button" class="'.$class.'">
                       '. $pagina['pagina'] .'
                     </button>
                   </a>';
  }


?>
<main id="seja-sabio">
  <section id="seja-sabio-lista">
    <div id="topo-sabio">
      <a href="/sejaSabio.php">
      <div id="tituloMFKB">
        Seja sábio
      </div></a>

      <form name="" method="get" id="form-seja-sabio">
        <input type="text" name="fraseSabio" placeHolder="Pesquise por alguma dica, entre <?=$quantidadeDicas?> dicas de sabedoria!" class="buscar-sabio" value="<?=$busca?>"/>

        <input type="submit" value="Buscar" class="btn-buscar"/>
      </form>
    </div>

    <div id="lista-style">

     <div id="lidas-nao-de-dicas" title="">
       Lidas: <?=$qtdeDicasLidasByMe.' / '.$quantidadeDicas;?>
     </div>

      <!-- Titulo caso alguma busca seja efectuada -->
      <?=$tituloBusca?>

      <!--A lista com as dicas de sabedoria-->
      <?=$dicasDeSabedoria?>
    </div>
  </section>

  <section id="numero-paginas-sabio">
    <?=$paginacao?>
  </section>
</main>
