<?php

  // quantidade a exibir
  $qtdeBusca = ($qtdeWords-3);

  // Armazena termos
  $visualizarTermos = '';

  // Carregar lista de termos
	$listaTermos = '';

  //Lista de cadeiras
  $cadeiras = $obCadeiras::getCadeiras(null, 'titulo DESC');

  // armazer lista de cadeiras
  $listarCadeiras = '';

  //Pega todas as cadeiras a serem feitas
  foreach( $cadeiras as $cadeira ) {

    // marcar cadeira
    $selecionar = '';

    // selecionar
    if ( $b_cadeir == $cadeira->id ) {
      $selecionar = 'selected';
    }

    $listarCadeiras .= '<option value="'.$cadeira->id.'" '. $selecionar .'>
                          '. $cadeira->titulo .'
                        </option>';
  }

  // Purificar id
  $id = filter_var( $_GET['findNexo'] ?? null, FILTER_SANITIZE_STRING ) ?? '';

  // Verifica se id de termo foi passado
  if ( isset( $_GET['findNexo'] ) ) {

    // clausula where
    $where = 'id = "'. $id .'"';

    // get significado
    $resultados = $obDicionario->getDefinicoes( $where, null, '1' );

    foreach ($resultados as $key => $dict) {

      // id dp termo
      $idDict = $dict->id;

      // id tecnologia
      $tecnoId = $dict->tecnologia;

      $getTecnoDict = $obTecnologia->getTecnologia( $tecnoId );

      // nome da tecnologia
      $tecnoName = $getTecnoDict->titulo;

      // get palavra
      $palavra = $dict->termo ?? 'Indisponivel';

      // get traducao da palavra
      $definicao = $dict->definicao ?? 'Segnificado encontra-se indisponivel';

      // data de actualização
      $lastUpdate = $dict->actualizado_em;

      // id da cadeira
      $about = $dict->relacionado_a;

      // get nome da cadeira
      $nome = $obCadeiras->getCadeira( $about );

      // get nome cadeira
      $sobre = $nome->titulo;

      // get tipo de dicionario
      $dicionario = $dict->tipo;

      // armaze editar dict type
      $dictType = $dicionario;

      // verifica o tipo
      if ( $dicionario == 't' ) {
        $dicionario = 'Técnico';
      } else if ( $dicionario == 'g' ) {
        $dicionario = 'Geral';
      } else {
        $dicionario = 'Indisponível';
      }

      // get fonte
      $fontesDict = $dict->fonte ?? 'Não esta disponível!';
      $fontesDictEdit = $dict->fonte ?? null;

      // get id autor
      $idAutor = $dict->user;

      // get dados autor
      $autorDados = $obUtilizador->getUser( $idAutor );

      // get nome do autor
      $autorDict = $autorDados->username;

      // tbn editar
      $editar = '';

      // armazena o tipo de dict a selecionar
      $selectDict1 = '';
      $selectDict2 = '';
      $selectDict3 = '';

      // armazena a lista de cadeiras
      $editListCad = '';

      // armazena a lista de tecnologias
      $tecnoListDict = '';

      // verifica autorizacao
      if ( $dict->user == $codigoUser ) {

        // Formata a lista
        foreach ( $getTecnologias as $tecnologias ) {

          // marcar cadeira
          $selecionar = '';

          // selecionar
          if ( $tecnoId == $tecnologias->id ) {
            $selecionar = 'selected';
          }

          // formata lista de tecnologia
          $tecnoListDict .= '<option value="'.$tecnologias->id.'" '.$selecionar.'>
                               '. $tecnologias->titulo .'
                             </option>';
        }

        // verifica o tipo
        if ( $dictType == 't' ) {
          $selectDict3 = 'selected';
        } else if ( $dictType == 'g' ) {
          $selectDict2 = 'selected';
        } else {
          $selectDict1 = 'selected';
        }

        //Pega todas as cadeiras a serem feitas
        foreach( $cadeiras as $cadeira ) {

          // marcar cadeira
          $selecionar = '';

          // selecionar
          if ( $about == $cadeira->id ) {
            $selecionar = 'selected';
          }

          $editListCad .= '<option value="'.$cadeira->id.'" '. $selecionar .'>
                             '. $cadeira->titulo .'
                           </option>';
        }

        // configura a opcao de edicao
        $editar = '<div class="caixinhas">
                     <button title="Editar" onclick="showModal(\'editar-termo-dict\')">
                       Editar
                     </button>
                   </div>';
      }

      // set dados da palavra
      $visualizarTermos = '<section id="visualizar-termos-dict">
                             <h2>
                               '. $palavra .'
                               <span title="Mais informações" onclick="showModal(\'informacoes-adicionais-dict\')">
                                 I
                               </span>
                             </h2>
                             <div class="informacoes-adicionais-dict" id="informacoes-adicionais-dict">

                              <div id="mais-sobre-dict-traducao">
                                <p>Sobre</p>
                                <span onclick="hiddenModal(\'informacoes-adicionais-dict\')"> &times; </span>
                              </div>

                              <div id="caixa-de-info-dict">
                                <p><strong>Autor</strong>: '. $autorDict .'</p>
                                <p><strong>Fonte</strong>: '. $fontesDict .'</p>
                              </div>

                             </div>

                             <div id="dict-termo-detalhes">
                               <p>'. $definicao .'</p>
                             </div>

                             <div id="mais-info">
                               <div class="caixinhas">
                                 <a href="#">
                                   <button title="Faça uma denuncia">
                                     Denunciar
                                   </button>
                                 </a>
                               </div>

                               <div class="caixinhas">
                                 <a href="#">
                                   <button title="Faça uma sugestão">
                                     Sugerir
                                   </button>
                                 </a>
                               </div>

                               <div class="caixinhas">
                                 <button title="Tipo de Tecnólogia">
                                   '.$tecnoName.'
                                 </button>
                               </div>

                               <div class="caixinhas">
                                 <button title="A cadeira">
                                   '. $sobre .'
                                 </button>
                               </div>

                               <div class="caixinhas">
                                 <button title="Tipo de Dicionário">
                                   '. $dicionario .'
                                 </button>
                               </div>

                               '. $editar .'

                               <div class="caixinhas">
                                 <button title="Actualizado pela ultima vez em">
                                   '. $lastUpdate .'
                                 </button>
                               </div>

                               <div class="caixinhas">
                                 <a href="/dict.php">
                                   <button title="Restaurar página">
                                     Padrão
                                   </button>
                                 </a>
                               </div>
                             </div>

                             <div class="editar-termo-dict" id="editar-termo-dict">
                               <div id="dados-termo-a-editar">
                                 <form name="" method="post" action="">
                                   <h3>
                                     Editar
                                     <span onclick="hiddenModal(\'editar-termo-dict\')">&times;</span>
                                   </h3>

                                   <input type="number" name="idDict" value="'.$idDict.'" hidden/>

                                   <input type="text" name="termoDict" value="'.$palavra.'" placeholder="Palavra, sigla, frase ou termo"/>

                                   <textarea name="descricaDict" placeholder="Descrição">'.$definicao.'</textarea>

                                   <input type="text" name="fonteDict" value="'.$fontesDictEdit.'" placeholder="Origem"/>

                                   <select name="tipoDict" size="1" class="editar-dictionary">
                                     <option value=""> Tipo de dicionário </option>

                                     <option value="i" '.$selectDict1.'>
                                       Indisponível
                                     </option>

                                     <option value="g" '.$selectDict2.'>
                                       Geral
                                     </option>

                                     <option value="t" '.$selectDict3.'>
                                       Técnico
                                     </option>
                                   </select>

                                   <select name="cadeiraDict" size="1" class="editar-dictionary">
                                     <option value=""> Relacionado a </option>
                                     '. $editListCad .'
                                   </select>

                                   <select name="tecnologiaDict" size="1" class="editar-dictionary">
                                     <option value=""> Tecnólogia </option>
                                     '.$tecnoListDict.'
                                   </select>

                                   <div id="dict-denuncias-sugestoes">
                                     <p>Denuncias e sugestoes</p>
                                   </div>

                                   <div id="btns-control-update-dict">
                                     <input type="submit" name="UpdateDict" value="Actualizar" id="UpdateDict"/>

                                     <input type="reset" name="resetDict" value="Restaurar" id="resetDict"/>

                                     <input type="submit" name="deleteDict" value="Apagar" id="deleteDict"/>
                                   </div>
                                 </form>
                               </div>
                             </div>
                           </section>';
    }

  }

  // Gets
  unset( $_GET['findNexo'], $_GET['editarDict'] );

  $gets = http_build_query( $_GET );

  // formatar lista de termos
  foreach ($getTermos as $key => $termos ) {

    $listaTermos .= '<a href="?findNexo='. $termos->id .'&'. $gets .'">
                       <li>'. $termos->termo .'</li>
                     </a>';
  }

  // verifica conteudo na lista
  if ( strlen($listaTermos) == 0) {
    $listaTermos = '<div id="sms-termos-indisponiveis">
                      <p>A lista termos encontra-se vazia!</p>
                      <p>OU</p>
                      <p>Sem resultados disponíveis para a busca efectuada!</p>

                      <a href="/dict.php">
                        Clique em mim para actualizar!
                      </a>
                    </div>';
  }

  // verifica termo selecionado
  if ( strlen( $visualizarTermos ) == 0 && ($id == '') ) {
    $visualizarTermos = '<section id="visualizar-termos-dict">
                           <h2>Ultra-Dicionário</h2>

                           <div id="mais-info"></div>

                           <p>O <strong>Ultra-Dicionário</strong>, é um dicionario online com foco principal na informatica, cujo objectivo principal é a partilha de conhecimento da area de T.I...</p>

                           <p>Faça uma busca, selecione uma palavra, uma sigla ou uma frase e veja o seu significado no <strong>Ultra-Dicionário</strong>, temos mais de ('. $qtdeBusca .') termos, siglas e frases para si, com termos, palavras novas sendo adicionadas quase todos os dias, pelos administradores da plataforma <strong>UltraLearning</strong> e pelos seus úsuarios (colaboradores)!</p>

                           <p><strong>OBS:</strong> Caso note alguma irregularidade, nalguma palavra/termo, frase ou sigla e nos seus respectivos segnificados, denuncie ou faça uma sugestão para ajudar os administradores e os colaboradores da plataforma a melhorem os seus conteudos, tornando as informações por nós partilhadas melhores e mais claras. Ajundando assim, todos aqueles que partilham o seu conhecimento e quem consulta as mesmas informações possa crescer de forma intelectual. Seja um colaborador, compartilhe conosco os seus conhecimentos, e torne o nosso dicionário e a nossa plataforma ainda mais rica.</p>

                           <p><strong>Aviso</strong>: Antes de adicionar um termo especifico, palavra, frase ou sigla, ao nosso dicionário, faça uma para verificar se não há um termo identico ou semelhante na plataforma, para evitar a repetição de informações. A inserção constante de informações repetidas esta sugeita a suspenção, ou, o bloqueio permanente da plataforma.</p>


                           <a href="/dict.php">
                             Clique em mim e actualize!
                           </a>
                         </section>';
  }

  // alguma palavra selecionada
  if ( strlen( $visualizarTermos ) == 0 && ($id != '') ) {
    $visualizarTermos = '<section id="visualizar-termos-dict">
                           <h2> Indisponível </h2>

                           <hr/>

                           <p>A palavra/termo, frase ou sigla solicitada encontra-se indisponível. Por favor, se não a encontrares aqui, após as suas pesquisas, adicione-a ao nosso dicionário!</p>

                           <a href="/dict.php">
                             Clique em mim, e actualize!
                           </a>
                         </section>';
  }

?>
<main id="home-page">
  <div id="topo-menu">
    <a href="/dict.php">
      <div id="dect-titulo">
        Ultra-Dicionário
      </div>
    </a>

    <div id="find-words">
      <form name="" action="" method="get">
        <input type="text" name="buscar_por" value="<?=$b_frases?>" placeholder="Faça uma busca, temos + de <?=$qtdeBusca?> termos, siglas e frases para si!"/>

        <div id="filtar-por">
          <label for="filtrar_por">Filtrar por:</label>
          <select name="filtrar_por" size="1">
            <option value=""> Dicionário! </option>

            <option value="g" <?=($b_filtro == 'g')? 'selected': ''?> >
              Geral
            </option>

            <option value="t" <?=($b_filtro == 't')? 'selected': ''?> >
              Técnico
            </option>

            <option value="i" <?=($b_filtro == 'i')? 'selected': ''?> >
              Indisponível
            </option>
          </select>

          <select size="1" name="cadeiras">
            <option value=""> Cadeiras </option>

            <!--Lista de cadeiras-->
            <?=$listarCadeiras?>
          </select>
        </div>

        <button type="submit">
          Find
        </button>
      </form>
    </div>
  </div>

  <aside id="menu-lateral">
    <div id="m-titulo">
      Palavras & frases
    </div>

    <ul>
      <?=$listaTermos;?>
    </ul>
  </aside>

  <section id="my-files">
    <?=$visualizarTermos?>
  </section>
</main>
