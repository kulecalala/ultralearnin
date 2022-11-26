<?php
  // Armazena a lista de mais conhecimento
  $listaSaibaMais = '';

  // Adicionar comentario
  $adicionarComentario = '';

  // Busca efectuada
  $tituloBusca = '';

  // oculutar lidas/nao
  $ocultarLidas = 'hidden';


  // controlador
  $verTodasDefinicoes = true;

  //Lista de cadeiras
  $cadeiras = $obCadeiras::getCadeiras(null, 'titulo DESC');

  // armazer lista de cadeiras
  $listarCadeiras = '';

  // Editar definicao
  if ( !isset( $_GET['definicaoIdEdit'] ) ) {

    //Pega todas as cadeiras a serem feitas
    foreach( $cadeiras as $cadeira ) {

      // marcar cadeira
      $selecionar = '';

      // selecionar
      if ( $b_filtro == $cadeira->id ) {
        $selecionar = 'selected';
      }

      $listarCadeiras .= '<option value="'.$cadeira->id.'" '. $selecionar .'>
                            '. $cadeira->titulo .'
                          </option>';
    }
  }

  // Editar definicao
  if ( isset( $_GET['definicaoIdEdit'] ) ) {

    // controlador
    $verTodasDefinicoes = false;

    // clausula where
    $where = 'id_user="'.$codigoUser.'" AND id="'.$_GET['definicaoIdEdit'].'"';

    // get definicao
    $buscarDefinicao = $obDefinicoes->getDefinicoes($where, null, '1');

    // set editar definicao
    foreach ($buscarDefinicao as $key => $def ) {

      // set dados
      $idDef     = $def->id;
      $definicao = $def->definicao;
      $fonte     = $def->fonte ?? 'Indisponivel';

      //Pega todas as cadeiras a serem feitas
      foreach( $cadeiras as $cadeira ) {

        // marcar cadeira
        $selecionar = '';

        // selecionar
        if ( $def->sobre == $cadeira->id ) {
          $selecionar = 'selected';
        }

        $listarCadeiras .= '<option value="'.$cadeira->id.'" '. $selecionar .'>
                              '. $cadeira->titulo .'
                            </option>';
      }

      // Armazena o tipo de ficheiros
      $listarTipoDeFicheiros = '';

      // set lista
      foreach ( $getTipoDeFicheiros as $key => $tipos ) {

        // marcar tipo de ficheiro
        $selecionar = '';

        // selecionar
        if ( $def->tipo_ficheiro == $tipos->id ) {
          $selecionar = 'selected';
        }

        // set lista
        $listarTipoDeFicheiros .= '<option value="'. $tipos->id .'" '.$selecionar.'>
                                     '. $tipos->tipo .'
                                   </option>';

      }

      $listaSaibaMais = '<div id="editar-dica-s" style="height: 530px;">
                            <form name="" method="post" action="">
                              <h4>
                                Editar Definição
                                <a href="/saibaMais.php">
                                  Voltar
                                </a>
                              </h4>

                              <textarea name="dica" id="dica">'. $definicao .'</textarea>

                              <select name="ficheiro" size="1" class="selectOptionEditar" required>
                                <option value="">
                                  Selecione o tipo de ficheiro!
                                </option>

                                '. $listarTipoDeFicheiros .'
                              </select>

                              <input type="text" name="origem" value="'. $fonte .'" id="origem" placeholder="Coloque aqui a fonte da definição! (Opcional)"/>

                              <select name="disciplinaDica" size="1" class="selectOptionEditar" required>
                                <option value="">
                                  Selecione a cadeira referente!
                                </option>

                                '. $listarCadeiras .'
                              </select>

                              <input type="text" name="idDica" value="'. $idDef .'" hidden/>

                              <div id="btn-control">
                                <input type="submit" name="btn-actualizar" value="Actualizar" id="update"/>

                                <input type="submit" name="btn-restaurar" value="Restaurar" id="reset"/>

                                <input type="submit" name="btn-apagar" value="Apagar" id="apagar"/>
                              </div>
                            </form>
                          </div>';
    }

  }

  // realizar buscas
  if ( isset($b_frase) || isset($b_filtro) ) {
    // Busca efectuada
    $tituloBusca = '<h3>
                      Resultado(s) da busca
                      <a href="/saibaMais.php">Ver todas</a>
                    </h3>';

    // ocultar lidas nao lidas
    $ocultarLidas = 'hidden';
  }

  // Comentar e ver comentarios
  if ( isset($_GET['comentSaibaMais']) ) {

    // controlador
    $verTodasDefinicoes = false;

    // get definicao
    $def = $obDefinicoes->getDefinicao( $_GET['comentSaibaMais'] );

    // id da definicao
    $idDica = $def->id;

    // get tipo de ficheiros
    $getTipoDeFicheiro = $obTipoDeFicheiros->getFicheiro( $def->tipo_ficheiro );

    // clausula de busca dos comentarios
    $whereComents = 'id_dica = "'. $idDica .'"';

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

                                <input type="text" name="idDica" value="'. $idDica .'" hidden/>

                                <input type="submit" value="Comentar" name="addComent"/>
                              </form>

                              <div id="listar-comentarios">
                                '. $listaComentarios .'
                              </div>
                            </div>';

    // armazena a cadeira
    $cadeirasDef = '';

    // get cadeira
    $disciplina = $obCadeiras->getCadeira( $def->sobre );

    // armazenar a cadeira
    $cadeirasDef = $disciplina->titulo;

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
    $like = $obDicaReacoes->getQtdeReacoes('id_dica = "'. $def->id .'"  AND reacoes = "l"');

    // verifica a qtde
    if ( $like == 0 ) {
      $like = 'Fixe';
    } else {
      $like .= ' Fixe';
    }

    // get gato
    $unlike = $obDicaReacoes->getQtdeReacoes('id_dica = "'. $def->id .'" AND reacoes = "u"');

    // verifica qtde gato
    if ( $unlike == 0 ) {
      $unlike = 'Gato';
    } else {
      $unlike .= ' Gato';
    }

    // get user
    $userName = $obUtilizador->getUser( $def->id_user );

    // user foto
    $userFoto = '../imagens/logo/icon2.jpeg';

    // fonte da definicao
    $fonte = strlen($def->fonte)? substr($def->fonte, 0, 255): 'Indisponivel';

    // link para editar a dica
    $editarDica = '';

    // verifica o autor
    if ( $codigoUser == $def->id_user ) {
      $editarDica = '<a href="?definicaoIdEdit='. $idDica .'"> Editar </a>';
    }

    // armazena a definicao selecionada
    $listaSaibaMais = '<div class="dicas-de-sabedoria">
                             <div class="dica-topo">
                               <img src="'. $userFoto .'" class="foto"/>
                               <div class="conteiner-dados-user">
                                 <div class="nome">
                                   '. $userName->username .'
                                   <a href="/saibaMais.php"> Voltar </a> &nbsp;
                                   '. $editarDica .'
                                 </div>
                                 <div class="fonte">
                                   Fonte: '. $getTipoDeFicheiro->tipo .' - '. $fonte .'
                                 </div>
                               </div>
                             </div>

                             <div class="dica-s">
                               '. $def->definicao .'
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
                                 <a href="?comentSaibaMais='. $idDica .'">
                                   <button>'. $coments .'</button>
                                 </a>
                               </div>

                               <div class="denunciar">
                                 <form name="" method="post" action="">
                                   <input type="text" name="idDica" value="'. $idDica .'" hidden/>
                                   <button type="submit" name="btn-denunciar"> Denunciar </button>
                                 </form>
                               </div>

                               <div class="share" title="Cadeira/Disciplina">
                                 <button>'. $cadeirasDef .'</button>
                               </div>

                               <div class="data">
                                 <button>
                                 Última actualização: '. $def->actualizado_em .' </button>
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


  // ver todas as defincoes
  if ( $verTodasDefinicoes ) { // true

    // realizar buscas
    if ( !isset($b_frase) || !isset($b_filtro) ) {
      // ocultar lidas nao lidas
      $ocultarLidas = '';
    }

    // get definicoes
    foreach ($definicoes as $key => $def) {
      // id da definicao
      $idDica = $def->id;

      // armazena a cadeira
      $cadeirasDef = '';

      // get cadeira
      $disciplina = $obCadeiras->getCadeira( $def->sobre );

      // armazenar a cadeira
      $cadeirasDef = $disciplina->titulo;

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
      $like = $obDicaReacoes->getQtdeReacoes('id_dica = "'. $def->id .'"  AND reacoes = "l"');

      // verifica a qtde
      if ( $like == 0 ) {
        $like = 'Fixe';
      } else {
        $like .= ' Fixe';
      }

      // get gato
      $unlike = $obDicaReacoes->getQtdeReacoes('id_dica = "'. $def->id .'" AND reacoes = "u"');

      // verifica qtde gato
      if ( $unlike == 0 ) {
        $unlike = 'Gato';
      } else {
        $unlike .= ' Gato';
      }

      // get user
      $userName = $obUtilizador->getUser( $def->id_user );

      // user foto
      $userFoto = '../imagens/logo/icon2.jpeg';

      // fonte da definicao
      $fonte = strlen($def->fonte)? substr($def->fonte, 0, 255): 'Indisponivel';

      // link para editar a dica
      $editarDica = '';

      // verifica o autor
      if ( $codigoUser == $def->id_user ) {
        $editarDica = '<a href="?definicaoIdEdit='. $idDica .'"> Editar </a>';
      }

      // get tipo de ficheiros
      $getTipoDeFicheiro = $obTipoDeFicheiros->getFicheiro( $def->tipo_ficheiro );

      // formata lista
      $listaSaibaMais .= '<div class="dicas-de-sabedoria">
                               <div class="dica-topo">
                                 <img src="'. $userFoto .'" class="foto"/>
                                 <div class="conteiner-dados-user">
                                   <div class="nome">
                                     '. $userName->username .'
                                     '. $editarDica .'
                                   </div>
                                   <div class="fonte">
                                     Fonte: '. $getTipoDeFicheiro->tipo .' - '. $fonte .'
                                   </div>
                                 </div>
                               </div>

                               <div class="dica-s">
                                 '. $def->definicao .'
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
                                   <a href="?comentSaibaMais='. $idDica .'">
                                     <button>'. $coments .'</button>
                                   </a>
                                 </div>

                                 <div class="denunciar">
                                   <form name="" method="post" action="">
                                     <input type="text" name="idDica" value="'. $idDica .'" hidden/>
                                     <button type="submit" name="btn-denunciar"> Denunciar </button>
                                   </form>
                                 </div>

                                 <div class="share" title="Cadeira/Disciplina">
                                   <button>'. $cadeirasDef .'</button>
                                 </div>

                                 <div class="data">
                                   <button>
                                   Última actualização: '. $def->actualizado_em .' </button>
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

  if ( strlen($listaSaibaMais) == 0 ) {
    $listaSaibaMais = '<div id="not-found-dica">
                         <a href="/saibaMais.php">
                           Go To List
                         </a>

                         <p>A dica solicitada nao exite!</p>

                       </div>';
  }

  //
  unset($_GET['pagina']);

  $gets = http_build_query( $_GET );

  // Armazena o numero de paginas
  $paginas = '';

  // Get numero de paginas
  $paginar = $paginacao->getPages();

  // formatar pagina
  foreach ($paginar as $key => $page ) {

    $class = $page['actual']? 'p-actual': 'o-paginas';

    $paginas .= '<a href="?pagina='. $page['pagina'] .'&'. $gets .'">
                   <button type="button" class="'. $class .'">
                     '. $page['pagina'] .'
                   </button>
                 </a>';
  }

?>
<main id="seja-sabio">
  <section id="seja-sabio-lista">
    <div id="topo-sabio">
      <a href="/saibaMais.php">
      <div id="tituloMFKB">
        Saiba +
      </div></a>

      <form name="" method="get" id="form-seja-sabio">
        <input type="text" name="pesquisar_por" placeHolder="Faça uma busca, temos mais de <?=($quantidadeDefinicoes-3)?> definições para si!" class="buscar-sabio" id="buscar-definicoes" value="<?=$b_frase?>"/>

        <div id="def-filtrar">
          <label for="cadeirasDefinicoes" id="label-def"> Filtrar: </label>
          <select name="filtrar_por" size="1" id="filtro-def">
            <option value=""> Selecione a cadeira! </option>

            <?=$listarCadeiras?>
          </select>
        </div>

        <input type="submit" value="Buscar" class="btn-buscar"/>
      </form>
    </div>

    <div id="lista-style">

     <div id="lidas-nao-de-dicas" title="" <?=$ocultarLidas?>>
       Lidas: <?=$qtdeDicasLidasByMe.' / '.$quantidadeDefinicoes;?>
     </div>

      <!-- Titulo caso alguma busca seja efectuada -->
      <?=$tituloBusca?>

      <!--A lista com as definicoes-->
      <?=$listaSaibaMais?>
    </div>
  </section>

  <section id="numero-paginas-sabio">
    <?=$paginas?>
  </section>
</main>
