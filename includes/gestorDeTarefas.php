<?php
  // control de acesso
  $controlDeAcesso = false;

  // Controla resultados
  $tarefaExiste = false;

  // armazena a tarefa selecionada
  $verMinhaTarefa = '';

  // armazena o titulo e id da tarefa
  $tarefasToDoList = '';

  // formata a lista de tarefas
  foreach ($getMyToDoList as $key => $tarefas) {

    $idToDo = $tarefas->id;
    $titulo = $tarefas->titulo ?? 'Sem titulo';

    // estado da terefa
    $statustarefa = '';

    if ( $tarefas->estado == 'f' ) {
      // estado da terefa
      $statustarefa = '<div class="reconfigStatusToDo" id="tarefaFeita"></div>';
    } else if ( $tarefas->estado == 'p' ) {
      // estado da terefa
      $statustarefa = '<div class="reconfigStatusToDo" id="tarefaPorFazer"></div>';
    } else {
      // estado da terefa
      $statustarefa = '<div class="reconfigStatusToDo"></div>';
    }

    // code...
    $tarefasToDoList .= '<a href="?detalhesTarefa='.$idToDo.'">
                           <li>'.$statustarefa.' '. $titulo .'</li>
                         </a>';
  }

  // Armazena a tarefa
  $carragarTarefas = '';

  // Armazenam dados da tarefa
  $id          = '';
  $titulo      = '';
  $descricao   = '';
  $sobreId     = '';
  $sobreTitulo = '';
  $dataCriacao = '';
  $dataFeita   = '';
  $estado      = '';
  $estadoNome  = '';

  // Verifica a selecao de tarefa
  if (isset($_GET['detalhesTarefa']) && is_numeric($_GET['detalhesTarefa'])) {

    // set id tarefa
    $idTarefa = $_GET['detalhesTarefa'];

    $whereT = 'id = "'.$idTarefa.'" AND id_user = "'.$codigoUser.'"';

    //
    $getTarefa = $obToDoList->getTarefas($whereT, null, '1');

    // Carrega o resultado da tarefa selecionada
    foreach ($getTarefa as $key => $tarefa) {

      // Controla resultados
      $tarefaExiste = true;

      // Armazenam dados da tarefa
      $id          = $tarefa->id;
      $titulo      = $tarefa->titulo;
      $descricao   = $tarefa->descricao;
      $sobreId     = $tarefa->sobre;
      $dataCriacao = $tarefa->data;
      $dataFeita   = $tarefa->feitaEm;
      $repetir     = $tarefa->renovar;
      $estado      = $tarefa->estado;

      $minhaCadeira = $obMinhasCad->getMinhaCadeira($sobreId);

      $cadDados = $obCadeiras->getCadeira($minhaCadeira->cadeira);

      $cadeiraName = $cadDados->titulo;

      $todasMinhasCadOption = '';

      // Formata a lista de cadeiras
      foreach ( $getTodasCadeiras as $cadeiras ) {

        // selecionar cadeira
        $selecionar = '';

        // verifica id
        if ( $sobreId == $cadeiras->id ) {
          $selecionar = 'selected';
        }

        //
        $resultado = $obCadeiras->getCadeira( $cadeiras->cadeira );

        // cadeiras option
        $todasMinhasCadOption .= '<option value="'.$cadeiras->id.'" '.$selecionar.'>
                                   '.$resultado->titulo.'
                                 </option>';
      } // Fim get cadeiras

      // marcar repetir tarefa
      $repetirYes = '';
      $repetirNo  = '';

      // verifica a opcao de renovacao
      if ($repetir == 'y') {
        $repetirYes = 'checked';
      } else {
        $repetirNo  = 'checked';

      }

      // btn tarefa feita
      $btnTarefaFeita = '';

      // marcar estado
      $estadoFeita = '';
      $estadoFazer = '';
      $estadoIndis = '';

      // destaca feita
      $statusTarefaFeita = '';

      // verificar estado
      if ($estado == 'f') {
        $estadoFeita = 'selected';

        $statusTarefaFeita = '<div id="statusToDoFeita" title="Tarefa feita"></div>';

      } else if ($estado == 'p') {
        $estadoFazer = 'selected';

        // set btn marcar feita
        $btnTarefaFeita = '<form name="" method="post" action="">
                             <input type="text" name="idTarefa" value="'.$id.'" hidden/>

                             <input type="text" name="dataCricao" value="'.$dataCriacao.'" hidden/>

                             <input type="text" name="titulo" value="'.$titulo.'" hidden/>

                             <input type="text" name="descricao" value="'.$descricao.'" hidden/>

                             <input type="text" name="renovar" value="'.$repetir.'" hidden>

                             <input type="text" name="cadeira" value="'.$sobreId.'" hidden/>

                             <input type="text" name="estado" value="'.$estado.'" hidden/>

                             <button type="submit" name="btn-tFeita" title="Clique em mim, para marcar tarefa feita">
                               Marcar Como Feita
                             </button>
                           </form>';

        // set estado da tarefa
        $statusTarefaFeita = '<div id="statusToDoFazer" title="Tarefa por fazer"></div>';

      } else {
        $estadoIndis = 'selected';

        // set btn marcar como feita
        $btnTarefaFeita = '<form name="" method="post" action="">
                             <input type="text" name="idTarefa" value="'.$id.'" hidden/>

                             <input type="text" name="dataCricao" value="'.$dataCriacao.'" hidden/>

                             <input type="text" name="titulo" value="'.$titulo.'" hidden/>

                             <input type="text" name="descricao" value="'.$descricao.'" hidden/>

                             <input type="text" name="renovar" value="'.$repetir.'" hidden>

                             <input type="text" name="cadeira" value="'.$sobreId.'" hidden/>

                             <input type="text" name="estado" value="'.$estado.'" hidden/>

                             <button type="submit" name="btn-tFeita" title="Clique em mim, para marcar tarefa feita">
                               Marcar Como Feita
                             </button>
                           </form>';

        $statusTarefaFeita = '<div id="statusToDoIndisp" title="Estado Indisponível"></div>';
      }

    }

    // verifica se a tarefa existe
    if ( $tarefaExiste ) {
      // control de acesso
      $controlDeAcesso = true;

      // controla da update
      $ocultarFeita = '';

      $estadoRefazerTarefa = '';

      // data actualizacao !isset
      if ( $dataFeita == '' ) {
        $ocultarFeita = 'hidden';

        $estadoRefazerTarefa = '<option value="p" '.$estadoFazer.'>
                                  Por fazer
                                </option>';
      }

      // Carrega detalhes da tarefa
      $verMinhaTarefa = '<div id="detalhes-tarefa">
                            <h2>
                              '.$titulo.'
                              '.$statusTarefaFeita.'
                            </h2>
                            <p>'.$descricao.'</p>


                           <div id="btns-controls">
                             <button>
                               Sobre: '.$cadeiraName.'
                             </button>

                             <button>
                               Criada: '.$dataCriacao.'
                             </button>

                             <button '.$ocultarFeita.'>
                               Update: '.$dataFeita.'
                             </button>

                             <button '.$ocultarFeita.'>
                               Tempo de corrido:
                             </button>

                             '.$btnTarefaFeita.'

                             <button onclick="showModal(\'editar-tarefa\')">
                               Editar
                             </button>
                           </div>

                           <div class="editar-tarefa" id="editar-tarefa">
                             <form name="" method="post" action="">
                               <div id="dados-da-tarefa">

                                 <h2>
                                   Editar tarefa
                                   <span onclick="hiddenModal(\'editar-tarefa\')">&times;</span>
                                 </h2>

                                 <input type="text" name="idTarefa" value="'.$id.'" hidden/>

                                 <input type="text" name="dataCricao" value="'.$dataCriacao.'" hidden/>

                                 <input type="text" name="actualizada" value="'.$dataFeita.'" hidden/>

                                 <input type="text" name="titulo" value="'.$titulo.'" placeholder="Titulo da tarefa" required/>

                                 <textarea name="descricao" placeholder="Descrição da tarefa" required>'.$descricao.'</textarea>

                                 <div id="renovar-tarefa">
                                   <label for="repetir">Desaja que a tarefa seja repetida diariamente?</label>
                                   <div class="repetir">
                                     Sim <input type="radio" name="repetir" value="y" class="renovar-tarefa" '.$repetirYes.' required/>
                                   </div>

                                   <div id="separar"></div>

                                   <div class="repetir">
                                     Não <input type="radio" name="repetir" value="n" class="renovar-tarefa" '.$repetirNo.' rquired/>
                                   </div>
                                 </div>

                                 <select name="cadeira" size="1" required>
                                   <option value="">Selecione a cadeira</option>
                                   '.$todasMinhasCadOption.'
                                 </select>

                                 <select name="estado" size="1" required>
                                   <option value="">Estado da tarefa</option>

                                   '.$estadoRefazerTarefa.'

                                   <option value="f" '.$estadoFeita.'>
                                     Feita
                                   </option>
                                 </select>

                                 <div id="btns-control">
                                   <button type="submit" name="btn-update" id="btn-update">
                                     Actualizar
                                   </button>

                                   <button type="reset" name="btn-reset" id="btn-reset">
                                     Restaurar
                                   </button>

                                   <button type="submit" name="btn-delete" id="btn-delete">
                                     Delete
                                   </button>

                                 </div>
                               </div>
                             </form>
                           </div>
                         </div>';

    }

  }

  // visualizar tarefa
  if ( $controlDeAcesso ) {
    // set tarefa
    $carragarTarefas = '<div class="tela-bloqueio-cadeiras">
                          <div id="topo">
                            <form name="" method="get" action="">

                              <div id="buscar">
                                <input type="text" name="buscar" value="'. $b_titulo .'" placeholder="Faça uma busca pelas, tens '.($qtdeTarefas).' tarefas registadas!"/>
                              </div>
                              <div id="filtro">
                                <label for=""> Filtrar: </label>

                                <select name="tipo" size="1">
                                  <option value=""> Tarefas </tipo>
                                  <option value="f"> Feitas </option>
                                  <option value="i"> Indisponível </option>
                                  <option value="p"> Por fazer </option>
                                </select>
                              </div>

                              <button type="submit">
                                Procurar
                              </button>
                            </form>
                          </div>

                          '. $verMinhaTarefa .'
                        </div>';
  } else {

    // verifica se algum busca foi feita
    if ( ($b_titulo != '' || $b_estado != '') && ($tarefasToDoList == '') ) {
      $carragarTarefas = '<h2> Resultados da busca </h2>
                          <p>Sem resultados para a busca efectuada!</p>';
    } else {

      if ( $tarefaExiste == false && isset($_GET['detalhesTarefa']) ) {
        $carragarTarefas = '<h2> Aviso </h2>
                            <p>
                              A tarefa solicita foi apagada ou não existe!
                            </p>';
      } else {
        $carragarTarefas = '<h2> Gestor de tarefas </h2>
                            <p>O <strong>Ultra-Gest</strong>!</p>';

      }

    }

  }

  // tela de bloqueio
  $telaDeBloqueio = '<div class="tela-bloqueio-cadeiras">
                       <div id="topo">
                         <form name="" method="get" action="">

                           <div id="buscar">
                             <input type="text" name="buscar" value="'. $b_titulo .'" placeholder="Faça uma busca pelas, tens '.($qtdeTarefas).' tarefas registadas!"/>
                           </div>
                           <div id="filtro">
                             <label for=""> Filtrar: </label>

                             <select name="tipo" size="1">
                               <option value=""> Tarefas </tipo>

                               <option value="f">
                                 Feitas
                               </option>

                               <option value="i">
                                 Indisponível
                               </option>

                               <option value="p">
                                 Por fazer
                               </option>
                             </select>
                           </div>

                           <button type="submit">
                             Procurar
                           </button>
                         </form>
                       </div>

                       <div id="resultados-cadeiras">
                         '. $carragarTarefas .'
                       </div>

                     </div>';

  // armazena informacoes necessarias
  $showInfo = '';

  // control de acesso - mostrar info
  if ( $controlDeAcesso == false ) {
    // carrega informacoes da tela de bloqueio
    $showInfo = $telaDeBloqueio;
  } else {
    // carrega informacoes da cadeira
    $showInfo = $carragarTarefas;
  }

  // Verifica se ha tarefas
  if ( strlen($tarefasToDoList) == 0 ) {
    $tarefasToDoList = '<div class="semCadeiras">
                          <p>Sem tarefas</p>
                        </div>';
  }

?>
<main>
  <aside id="menu-lateral">
    <div id="m-titulo">
      As minhas tarefas
    </div>

    <ul>
      <?=$tarefasToDoList?>
    </ul>
  </aside>

  <section id="visualizar-c">
    <?=$showInfo?>
  </section>

</main>
