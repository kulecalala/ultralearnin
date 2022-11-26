<?php

  // Habilidades a serem aprendidas
  $aAprenderLista = '';

  // get lista de habilidades aprendidas
  $habilidadesAprendidas = '';

  // get lista de coisas por aprender
  $habilidadesPorAprender = '';

  // get quero aprender busca
  $buscasQueroAprender = '';

  // get lista de habilidades aprendidas
  $habilidadesAprendidas = '';

  // get lista de hablidades a serem revisadas
  $habilidadesEmRev = '';

  // dados da hablidade
  $tituloHab   = '';
  $descriHab   = '';
  $criadaEmHab = '';
  $percentagemHab = '';
  $estadosDaHab = '';

  // dados da hablidade
  $idHabilidad = '';
  $tituloHab   = '';
  $descriHab   = '';
  $criadaEmHab = '';
  $tecnologiaHab = '';
  $sobreHab = '';
  $percentagemHab = '';
  $estadosDaHab = '';

  // estados da habilidade select
  $estadoHabSelct1 = '';
  $estadoHabSelct2 = '';
  $estadoHabSelct3 = '';
  $estadoHabSelct4 = '';


  // lista de tecnologias
  $listarTecnologias = '';

  // Verifica se uma habilidade foi aprendida
  if ( isset($idHabilidadeS) ) { // true

    foreach ( $todoOqueQueroAprender as $key => $dados ) {
      $idHabilidad    = $dados->id;
      $tituloHab      = $dados->key_word;
      $descriHab      = $dados->descricao;
      $criadaEmHab    = $dados->lancado_em;
      $tecnologiaHab  = $dados->tecnologia;
      $sobreHab       = $dados->sobre;
      $percentagemHab = $dados->percentagem;
      $estadosDaHab   = $dados->estado;
    }

    // verifica e set o estado das habilidades
    $estadoHabSelct1 = ( $estadosDaHab == 'p' )? 'selected': '';
    $estadoHabSelct2 = ( $estadosDaHab == 'a' )? 'selected': '';
    $estadoHabSelct3 = ( $estadosDaHab == 'f' )? 'selected': '';
    $estadoHabSelct4 = ( $estadosDaHab == 'r' )? 'selected': '';

    // get as minhas cadeiras
    $obMinhasCadList = $obMinhasCad->getMinhasCadeiras();
    $listarCadeirasObj = '';

    foreach ($obMinhasCadList as $key=>$value) {

      // Nome da cadeira
      $nomeCadeira = $obCadeiras->getCadeira( $value->cadeira );
      $cadName = $nomeCadeira->titulo;

      //Seleciona cadeira
      $selecionar = ( $sobreHab == $value->id )? 'selected': '';

      $listarCadeirasHab .= '<option value="'. $value->id .'" '. $selecionar .'>
                               '. $cadName .'
                             </option>';
    }

    // get lista de tecnologias
    $tecnoList = $obTecnologia->getTecnologias();

    foreach ( $tecnoList as $key => $dados) {

      $selecionar = ( $dados->id == $tecnologiaHab )? 'selected': '';

      $listarTecnologias .= '<option value="'. $dados->id.'" '.$selecionar.'>
                               '. $dados->titulo .'
                             </option>';
    }

    // Formatar mais detalhes da habilidade a aprender
    $formatarAprender = '<div id="ver-mais-detalhes">
                         <form name="" method="post" action="">
                           <div id="topo">
                             <input type="text" name="titulo" value="'. $tituloHab .'" placeHolder="Coloque aqui as palavras chaves da habilidade!" required/>

                             <input type="text" name="idHab" value="'. $idHabilidad .'" required hidden/>
                           </div>
                           <a href="/queroAprender.php">
                             <div id="voltar">Voltar</div>
                           </a>

                           <div id="descricao">
                             <textarea name="descricao" placeHolder="Escreva a aqui o máximo de detalhes possiveis sobre a habilidade!" required>'. $descriHab .'</textarea>
                           </div>

                           <div id="detalhes">
                             <div class="caixinhas">
                               <div class="tituloMFKB">
                                 Criado em:
                               </div>
                               <div class="conteudo">
                                 <input type="date" name="dataCriacao" value="'. $criadaEmHab .'" required disabled/>
                                 <input type="date" name="dataCriacao" value="'. $criadaEmHab .'" required hidden/>
                               </div>
                             </div>

                             <div class="caixinhas">
                               <div class="tituloMFKB">
                                 Tecnologia:
                               </div>
                               <div class="conteudo">
                                 <select name="tecnologia" size="1" required>
                                   <option value=""> Qual a tecnologia principal! </option>
                                   '. $listarTecnologias .'
                                 </select>
                               </div>
                             </div>

                             <div class="caixinhas">
                               <div class="tituloMFKB">
                                 Sobre:
                               </div>
                               <div class="conteudo">
                                 <select name="sobreHab" size="1" required>
                                   <option value=""> Este objectivo esta relacionado a: </option>
                                   '. $listarCadeirasHab .'
                                 </select>
                               </div>
                             </div>

                             <div class="caixinhas">
                               <div class="tituloMFKB">
                                 Nivel em %:
                               </div>
                               <div class="conteudo" id="range">
                                <input type="range" name="percentagemHab" min="0" max="100" value="'. $percentagemHab .'" title="'. $percentagemHab .'% alcançados" required/>
                               </div>
                             </div>

                             <div class="caixinhas">
                               <div class="tituloMFKB">
                                 Estado:
                               </div>
                               <div class="conteudo">
                                 <select name="estadoHab" size="1" required>
                                   <option value=""> Selecione o estado do objectivo!</option>

                                   <option value="p" '. $estadoHabSelct1 .'>
                                     Por aprender
                                   </option>

                                   <option value="a" '. $estadoHabSelct2 .'>
                                     A aprender
                                   </option>

                                   <option value="f" '. $estadoHabSelct3 .'>
                                     Aprendida
                                   </option>

                                   <option value="r" '. $estadoHabSelct4 .'>
                                     A revisar conceitos
                                   </option>
                                 </select>
                               </div>
                             </div>
                           </div>

                           <div id="controls">
                              <input type="submit" name="btn-Actualizar" value="Actualizar" id="actualizar"/>

                              <input type="reset" name="btn-restaurar" value="Restaurar" id="restaurar"/>

                              <input type="submit" name="btn-apagar" value="Apagar" id="apagar"/>
                           </div>
                         </form>
                       </div>';

    // caso nao tenha resultados
    $resultados = $tituloHab.$descriHab;

    if ( strlen($resultados) == 0 ) {
      $formatarAprender = '<div id="ver-mais-detalhes">
                             <div id="sms-objectivo-not-found">
                               <p>O objectivo solicitado não foi localizado, por favor, tente novamente.</p> &nbsp;
                               <p><a href="/queroAprender.php"> Voltar! </a></p>
                             </div>
                           </div>';
    }

  } else { // false

    // verifica se alguma busca foi efecuada
    if ( (strlen($b_filtro) != 0) || (strlen($b_frase) != 0) ) { // true
      // formatacao de busca

      foreach( $todoOqueQueroAprender as $key=>$dados ) {
        $descricao = $dados->descricao;
        $descricao = (strlen($descricao) > 285)? substr($descricao, 0, 285).'...' : $descricao;

        $buscasQueroAprender .= '<div class="list-items-d-o">
                                   <div class="descricao">'. $descricao .'</div>
                                   <a href="?queroAprenderCod='. $dados->id .'">
                                     <div class="buttom"> Ver mais </div>
                                   </a>
                                 </div>';
      }

      // verifica se a resultados para as buscas
      if ( strlen($buscasQueroAprender) != 0 ) {

        $formatarAprender = '<h3>Resultado das buscas
                               <a href="/queroAprender.php"> Voltar </a>
                             </h3>
                              <div class="listar-tarefas">
                                '. $buscasQueroAprender .'
                              </div>';
      } else {
        $formatarAprender = '<h3>Resultado das buscas</h3>
                             <div class="listar-tarefas">
                               <div class="sms-objectivos">
      													 Sem resultados para esta busca!
      		                     </div>
                             </div>';
      }


    } else { // false
      // Carregar formatacao padrao

      // Habilidades a aprender
      foreach ($obAAprender as $key=>$dados ) {

        $descricao = $dados->descricao;
        $descricao = (strlen($descricao) > 285)? substr($descricao, 0, 285).'...' : $descricao;

        $aAprenderLista .= '<div class="list-items-d-o">
                              <div class="descricao">'. $descricao .'</div>
                              <a href="?queroAprenderCod='. $dados->id .'">
                                <div class="buttom"> Ver mais </div>
                              </a>
                            </div>';
      }

      // Habilidades por aprender
      foreach ( $obPorAprender as $key=>$dados  ) {
        $descricao = $dados->descricao;
        $descricao = (strlen($descricao) > 285)? substr($descricao, 0, 285).'...' : $descricao;

        $habilidadesPorAprender .= '<div class="list-items-d-o">
                                      <div class="descricao">'. $descricao .'</div>
                                      <a href="?queroAprenderCod='. $dados->id .'">
                                        <div class="buttom"> Ver mais </div>
                                      </a>
                                    </div>';
      } // fim


      // Lista de habilidades aprendidas
      foreach ( $obAprendidasHab as $key=>$dados ) {

        $descricao = $dados->descricao;
        $descricao = (strlen($descricao) > 285)? substr($descricao, 0, 285).'...' : $descricao;

        $habilidadesAprendidas .= '<div class="list-items-d-o">
                                     <div class="descricao">
                                       '. $descricao .'
                                     </div>
                                     <a href="?queroAprenderCod='. $dados->id .'">
                                       <div class="buttom"> Ver mais </div>
                                     </a>
                                   </div>';
      }

      // habilidades em revisao
      foreach ($obHabilidadesARev as $key=>$dados ) {
        $descricao = $dados->descricao;
        $descricao = (strlen($descricao) > 285)? substr($descricao, 0, 285).'...' : $descricao;

        $habilidadesEmRev .= '<div class="list-items-d-o">
                              <div class="descricao">'. $descricao .'</div>
                              <a href="?queroAprenderCod='. $dados->id .'">
                                <div class="buttom"> Ver mais </div>
                              </a>
                            </div>';
      }

      // Lista de habilidades a aprender
      if ( strlen( $aAprenderLista ) != 0 ) {
        $formatarAprender .= '<h3> Habilidades a aprender</h3>
                              <div class="listar-tarefas">
                                '. $aAprenderLista .'
                              </div>';
      } else {
        $formatarAprender .= '<h3> Habilidades a aprender </h3>
                              <div class="listar-tarefas">
                                <div class="sms-objectivos">
                                  A lista encontra-se vazia!
                                </div>
                              </div>';
      } // fim

      // Lista de habilidades por aprender
      if ( strlen( $habilidadesPorAprender ) != 0 ) {
        $formatarAprender .= '<h3> Habilidades por aprender </h3>
                              <div class="listar-tarefas">
                                '. $habilidadesPorAprender .'
                              </div>';
      } else {
        $formatarAprender .= '<h3> Habilidades por aprender </h3>
                              <div class="listar-tarefas">
                                <div class="sms-objectivos">
                                  A lista encontra-se vazia!
                                </div>
                              </div>';
      }

      // Habilidades aprendidas
      if ( strlen( $habilidadesAprendidas ) != 0 ) {
        $formatarAprender .= '<h3> Habilidades aprendidas </h3>
                              <div class="listar-tarefas">
                                '. $habilidadesAprendidas .'
                              </div>';

      } else {
        $formatarAprender .= '<h3> Habilidades aprendidas </h3>
                              <div class="listar-tarefas">
                                <div class="sms-objectivos">
                                  A lista encontra-se vazia!
                                </div>
                              </div>';
      }

      // habilidades em revisao
      if ( strlen($habilidadesEmRev) != 0 ) {
        $formatarAprender .= '<h3> Habilidades em revisão </h3>
                              <div class="listar-tarefas">
                                '. $habilidadesEmRev .'
                              </div>';
      }

    }

  }

?>
<main id="objectivos-e-desafios">
  <div class="topo-pesquisar">
    <div id="titulo-top">Learning</div>
    <div id="formulario">
      <form class="" action="" method="method">
        <input type="text" name="pesquisar_por" value="<?=$b_frase?>" placeholder="Pesquise ma sua lista, o que é que você deseja aprender!"/>

        <label for="filtro">Filtrar por: </label>
        <select class="" size="1" name="filtrar_por">
          <option value=""> Selecione o filtro </option>
          <option value="p" <?=($b_filtro == 'p')? 'selected': '';?>>
            Por aprender
          </option>
          <option value="a" <?=($b_filtro == 'a')? 'selected': '';?>>
            A aprender
          </option>
          <option value="f" <?=($b_filtro == 'f')? 'selected': '';?>>
            Habilidade aprendida
          </option>
          <option value="r" <?=($b_filtro == 'r')? 'selected': '';?>>
            A revisar conceitos
          </option>
        </select>

        <button type="submit" name="btn-buscar">Buscar</button>
      </form>
    </div>
  </div>

  <div class="corpo-view-dados">
    <?=$formatarAprender?>
  </div>
</main>
