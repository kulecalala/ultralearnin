 <?php
  // Lista de sites
  $resultados = '';

  // Editar site
  if ( isset($_GET['editarSiteCod']) && is_numeric($_GET['editarSiteCod']) ) {

    // set id site
    $idSite = $_GET['editarSiteCod'];

    // get lista de cadeiras
    $relacionado_a = $obCadeiras->getCadeiras(null, 'titulo ASC');

    // Armazena as cadeiras
    $todasCadeiras = '';

    // busca onde
    $where = 'id = "'. $idSite .'" AND user = "'. $codigoUser .'"';

    // get site
    $getSite = $obSites->getSites($where, null, '1');

    // controle de busca para edicao
    $controlResults = true;

    // get site
    foreach ($getSite as $key => $site ) {

      // controle de busca para edicao
      $controlResults = false;

      // array de cadeiras
      foreach ($relacionado_a as $key => $cadeira) {

        // selecione a cadeira do site
        $selecionar = '';

        // verifica qual a cadeira do site
        if ( $site->relacionado_a == $cadeira->id ) {
          $selecionar = 'selected';
        }

        // Formata lista de cadeiras
        $todasCadeiras .= '<option value="'.$cadeira->id.'" '.$selecionar.'>
                             '. $cadeira->titulo .'
                           </option>';
      }

      // armazena titulo do site
      $titulo  = '';
      $titulo2 = '';

      // ha titulo?
      if ( $site->titulo != '' ) {
        $titulo = $site->titulo;
      } else {
        $titulo2 = 'encontra-se indisponivel, adicione-o!';
      }

      // armazena o link do site
      $link  = '';
      $link2 = '';

      // ha link
      if ( $site->link != '' ) {
        $link = $site->link ;
      } else {
        $link2 = 'encontra-se indisponicel, adicione-o';
      }

      //
      $descricao = $site->descricao;

      $resultados = '<div id="form-editar-site">
                       <h3>
                         Editar Site
                         <a href="/sites.php">Cancelar</a>
                       </h3>

                       <form name="" method="post" acton="">
                        <div id="caixa-de-componentes">
                          <input type="text" name="" value="'.$titulo.'" placeholder="Nome do site '.$titulo2.'"/>

                          <input type="text" name="" value="'.$link.'" placeholder="Link do site '.$link2.'"/>

                          <textarea name="" placeholder="Escreva aqui informações adicionais sobre o site">'.$descricao.'</textarea>

                          <input type="file" name="" title="Selecione um ficheiro, do tipo [png, jpg]!" id="logo-site"/>
                          <label id="alternativo">O logo do site é opcional!</label>

                          <select name="" size="1">
                            <option value="">
                              Este site a relacionado a
                            </option>

                            '.$todasCadeiras.'
                          </select>
                        </div>

                        <div id="btns">
                          <input type="submit" name="btn-actualizar" value="Actualizar" id="btn-actualizar"/>

                          <input type="reset" name="btn-restaurar" value="Restaurar" id="btn-restaurar"/>

                          <input type="submit" name="btn-apagar" value="Apagar" id="btn-apagar"/>
                        </div>
                       </form>
                     </div>';


    }

    // controle de resultados
    if ( $controlResults ) {
      $resultados = '<div class="aviso-sites">
                       <p>
                         O site seleciona para edição, encontra-se indisponivel ou não exite! <br/>
                         <a href="/sites.php">
                           Carregue a lista geral clicando aqui!
                         </a>
                       </p>
                     </div>';
    }

  } else {

    // get sites
    foreach( $sitesList as $kes => $sites ) {
      // armazena o logo do site
      $imagens = ($sites->imagem != "")? $sites->imagem : 'default.jpeg';

      //
      $titulo = $sites->titulo ?? 'Nome indisponivel';

      // Armazena a descicao
      $descricao = $sites->descricao != ""? $sites->descricao: 'As informações adicionais sobre o site encontram-se indisponiveis!';

      // get utilizador dados
      $utilizador = $obUtilizador->getUser($sites->user);

      // user name
      $usename = $utilizador->username ?? 'O autor não foi localizado!';

      // get cadeira do site
      $relacionado_a = $obCadeiras->getCadeira($sites->relacionado_a);

      // armazena a cadeira
      $siteSobre = $relacionado_a->titulo ?? 'A cadeira encontra-se indisponivel';

      // Armazena opcao de edicao
      $editarSite = '';

      // Verifica autor
      if ( $sites->user == $codigoUser ) {
        $editarSite = '<a href="?editarSiteCod='. $sites->id .'" title="Edite clicando aqui!">
                         <div class="options" id="options">
                           <img src="/imagens/editar.jpeg"/>
                         </div>
                       </a>';
      }

      // armaze a lista de sites
      $resultados .= '<div class="dados-sites">
                        <div class="icon" title="Logo do site">
                          <img src="/imagens/sites/'.$imagens.'"/>
                        </div>

                        <div class="nome" title="Nome do site">
                          '. $titulo .'
                        </div>

                        <div class="relacionado_a" title="Relacionada a cadeira de!">
                          '. $siteSobre .'
                        </div>

                        <div class="conjunto" title="Visite clicando aqui!">
                          <a href="'. $sites->link .'" target="_blank">
                            <div class="options">
                              <img src="/imagens/mundo.jpeg"/>
                            </div>
                          </a>

                          '.$editarSite.'
                        </div>

                        <div class="descricao" title="Descrição do site!">
                          '. $descricao .'
                        </div>

                        <div class="mais-dados" title="Autor e data da última actualização!">
                          '. $usename .' | '. $sites->actualizado_em .'
                        </div>

                      </div>';
    }

    if ( $resultados == '' ) {
      $resultados = '<div class="aviso-sites">
                       <p>Sem resultados disponiveis para busca efectuada!</p>
                     </div>';
    }

  }

  // GETS
  unset( $_GET['pagina'] );

  $gets = http_build_query( $_GET );

  // Paginacao
  $paginacao = '';
  $paginas = $obPagination->getPages();

  foreach( $paginas as $key=>$pagina ) {
    $class = $pagina['actual'] ? 'p-actual' : 'o-paginas';

    $paginacao .= '<a href="?pagina='.$pagina['pagina'].'&'. $gets.'">
                     <button type="button" class="'. $class .'">
                       '. $pagina['pagina'] .'
                     </button>
                   </a>';
  }

  if ( $paginacao == '' ) {
    $paginacao = '<div class="aviso-sites">
                    Página única! &nbsp; <a href="/sites.php">Actualize clicando aqui!</a>
                  </div>';
  }

?>
<main>
  <div id="conteiner-sites">
    <div id="sites-buscar">
      <a href="/sites.php">
        <div id="title-sites-s">Sites</div>
      </a>

      <div id="form-busca-s">
        <form class="" method="get">
          <input type="text" name="site" id="dados-busca-text" placeHolder="A procura de algo? Faça uma busca, temos uma lista com <?=($quantidadeSites)?> sites!" value="<?=$_GET['site']??""?>" />
          <input type="submit" id="btn-buscar-site" value="Buscar"/>
        </form>
      </div>

    </div>

    <aside id="sugestoes-sites">
      <div class="title-sites">Sugestões</div>

      <div id="sugestoes-sites">

      </div>
    </aside>

    <section id="sites">
      <div id="lista-sites">
        <?=$resultados?>
      </div>
    </section>

    <section id="numero-paginas">
      <?=$paginacao?>
    </section>

  </div>
</main>
