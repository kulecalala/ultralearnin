<?php

  $carregarListas = "";

  // Lista de resultados das buscas
  $listaDeResultadosBusca = "";

  if ( !empty($b_frase) 	|| !empty($b_filtro) ) {

    foreach( $obObjectivoEspecifico as $key=>$dados ) {

      $descricao = $dados->descricao;
  		$descricao = (strlen($descricao) > 285)? substr($descricao, 0, 285).'...' : $descricao;

  		$codObj = $dados->id;

  		$listaDeResultadosBusca .= '<div class="list-items-d-o">
      															<div class="descricao">'. $descricao .'</div>
      															<a href="?objectivosCod='. $codObj .'">
      																<div class="buttom"> Ver mais </div>
      															</a>
      														</div>';
    }

  }
/*
  echo '<pre>';
  print_r( $listaDeResultadosBusca );
  echo '</pre>'; exit;*/

  // Resultados das buscas
  if ( $listaDeResultadosBusca != "" ) {
    $carregarListas = '<h3>
                         Resultados da busca de objectivos
                         <a href="/objectivos.php"> Voltar </a>
                       </h3>

                       <div class="listar-tarefas">
                         '. $listaDeResultadosBusca .'
                       </div>';
  } else {

    // Objectivos da semana
    if ( isset( $objectivosDaSemana ) ) {
      $carregarListas .= '<h3>Objectivos da semana</h3>
                          <div class="listar-tarefas">
                            '.$objectivosDaSemana .'
                          </div>';
    }

    if ( isset($objectivosDeCurtoPrazo) ) {
      $carregarListas .= '<h3>Objectivos de curto prazo</h3>
                          <div class="listar-tarefas">
                            '.$objectivosDeCurtoPrazo.'
                          </div>';
    }

    if ( isset($objectivosDeMedioPrazo) ) {
      $carregarListas .= '<h3>Objectivos de médio prazo</h3>
                          <div class="listar-tarefas">
                            '.$objectivosDeMedioPrazo.'
                          </div>';
    }

    if ( isset($objectivosDeLongoPrazo) ) {
      $carregarListas .= '<h3>Objectivos de longo prazo</h3>
                          <div class="listar-tarefas">
                            '.$objectivosDeLongoPrazo.'
                          </div>';
    }

  }

  // obter objectivo especifico
  $tituloObj = '';
  $descriObj = '';
  $criadoObj = '';
  $validoObj = '';
  $sobreObj  = '';
  $percenObj = '';
  $categoObj = '';
  $estadoObj = '';

  $ocultarBlock = 'visible';

  foreach( $obObjectivoEspecifico as $key=>$dados ) {
    $tituloObj = $dados->titulo;
    $descriObj = $dados->descricao;
    $criadoObj = $dados->data_inicio;
    $validoObj = $dados->data_validade;
    $sobreObj  = $dados->sobre;
    $percenObj = $dados->percentagem;
    $categoObj = $dados->categoria;
    $estadoObj = $dados->estado;

    $ocultarBlock = 'hidden';
  }

  $selectEstadoObj1 = '';
  $selectEstadoObj2 = '';
  $selectEstadoObj3 = '';
  $selectEstadoObj4 = '';
  $selectEstadoObj5 = '';
  switch ($estadoObj) {
    case 'n':
      $selectEstadoObj1 = 'selected';
      break;
    case 'c':
      $selectEstadoObj2 = 'selected';
      break;
    case 'm':
      $selectEstadoObj3 = 'selected';
      break;
    case 'l':
      $selectEstadoObj4 = 'selected';
      break;
    case 'a':
      $selectEstadoObj5 = 'selected';
      break;
  }

  $estadosDoObjectivo = '<option value="n" '. $selectEstadoObj1 .'>
                           Não alcançado
                         </option>

                         <option value="c" '. $selectEstadoObj2 .'>
                           Curto prazo
                         </option>

                         <option value="m" '. $selectEstadoObj3 .'>
                           Médio prazo
                         </option>

                         <option value="l" '. $selectEstadoObj4 .'>
                           Longo prazo
                         </option>

                         <option value="a" '. $selectEstadoObj5 .'>
                           Alcançado
                         </option>';

  // Categoria
	$obCategoriaMaterias = $obCObjectivos->getCategorias();
	$categoriaMaterias = '';

	foreach ( $obCategoriaMaterias as $key=>$dados ) {

    $selecionar = ( $categoObj == $dados->id )? 'selected': '';

		$categoriaMaterias .= '<option value="'. $dados->id .'" '. $selecionar .'>
														 '. $dados->titulo .'
													 </option>';
	}

  // forma a lista das minhas cadeiras
  $obMinhasCadList = $obMinhasCad->getMinhasCadeiras();
  $listarCadeirasObj = '';

  foreach ($obMinhasCadList as $key=>$value) {

    // Nome da cadeira
    $nomeCadeira = $obCadeiras->getCadeira( $value->cadeira );
    $cadName = $nomeCadeira->titulo;

    //Seleciona cadeira
    $selecionar = ( $sobreObj == $value->id )? 'selected': '';

    $listarCadeirasObj .= '<option value="'. $value->id .'" '. $selecionar .'>
                            '. $cadName .'
                           </option>';
  }

  // Ver mais detalhes sobre determinado objectivos
  if ( isset( $_GET['objectivosCod'] ) ) {
    $carregarListas = '<div id="ver-mais-detalhes">
                         <form name="" method="post" action="">
                           <div id="topo">
                             <input type="text" name="tituloObj" value="'. $tituloObj .'" placeHolder="Coloque aqui o titulo do objectivo!" required/>

                             <input type="text" name="idObjectivosCod" value="'. $objEspecifico .'" required hidden/>
                           </div>
                           <a href="/objectivos.php">
                             <div id="voltar">Voltar</div>
                           </a>

                           <div id="descricao">
                             <textarea name="descircaoObj" placeHolder="Escreva a aqui o máximo de detalhes possiveis sobre o objectivo!" required>'. $descriObj .'</textarea>
                           </div>

                           <div id="detalhes">
                             <div class="caixinhas">
                               <div class="tituloMFKB">
                                 Criado em:
                               </div>
                               <div class="conteudo">
                                 <input type="date" name="dataCriacaoObj" value="'. $criadoObj .'" required disabled/>

                                 <input type="date" name="dataCriacaoObj" value="'. $criadoObj .'" required hidden/>
                               </div>
                             </div>

                             <div class="caixinhas">
                               <div class="tituloMFKB">
                                 Alcançar em:
                               </div>
                               <div class="conteudo">
                                 <input type="date" name="alcancarEmObj" value="'. $validoObj .'" required/>
                               </div>
                             </div>

                             <div class="caixinhas">
                               <div class="tituloMFKB">
                                 Sobre:..
                               </div>
                               <div class="conteudo">
                                 <select name="objSobre" size="1" required>
                                   <option value=""> Este objectivo esta relacionado a: </option>
                                   '. $listarCadeirasObj .'
                                 </select>
                               </div>
                             </div>

                             <div class="caixinhas">
                               <div class="tituloMFKB">
                                 Categoria:
                               </div>
                               <div class="conteudo">
                                 <select name="categoriaObj" size="1" required>
                                   <option value=""> Selecione a categoria! </option>
                                   '. $categoriaMaterias .'
                                 </select>
                               </div>
                             </div>

                             <div class="caixinhas">
                               <div class="tituloMFKB">
                                 Nivel em %:
                               </div>
                               <div class="conteudo" id="range">
                                <input type="range" name="percentagemObj" min="0" max="100" value="'. $percenObj .'" title="'.$percenObj.'% alcançados" required/>
                               </div>
                             </div>

                             <div class="caixinhas">
                               <div class="tituloMFKB">
                                 Estado:
                               </div>
                               <div class="conteudo">
                                 <select name="estadoObj" size="1" required>
                                   <option value=""> Selecione o estado do objectivo!</option>

                                   '. $estadosDoObjectivo .'

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
  }

  // verifica resultados
  $resultadoObEspecifico = $tituloObj.$descriObj;

  if ( strlen( $resultadoObEspecifico ) == 0 ) {

    $carregarListas = '<div id="ver-mais-detalhes">
                         <div id="sms-objectivo-not-found">
                           <p>O objectivo solicitado não foi localizado, por   favor, tente novamente.</p> &nbsp;
                           <p><a href="/objectivos.php"> Voltar! </a></p>
                         </div>
                       </div>';
  }
?>

<main id="objectivos-e-desafios">
  <div class="topo-pesquisar">
    <div id="titulo-top">Objectivos</div>
    <div id="formulario">
      <form class="" action="" method="method">
        <input type="text" name="pesquisar_por" value="<?=$b_frase?>" placeholder="Pesquise por um objectivo, insira um titulo ou um descrição!"/>

        <label for="filtro">Filtrar por: </label>
        <select class="" size="1" name="filtrar_por">
          <option value=""> Selecione o filtro </option>
          <option value="c" <?=($b_filtro == 'c')? 'selected': '';?>>
            Curto prazo
          </option>

          <option value="m" <?=($b_filtro == 'm')? 'selected': '';?>>
            Médio prazo
          </option>

          <option value="l" <?=($b_filtro == 'l')? 'selected': '';?>>
            Longo prazo
          </option>

          <option value="a" <?=($b_filtro == 'a')? 'selected': '';?>>
            Objectivo alcançado
          </option>

          <option value="n"  <?=($b_filtro == 'n')? 'selected': '';?>>
            Objectivo não alcançado
          </option>
        </select>

        <button type="submit" name="btn-buscar">Buscar</button>
      </form>
    </div>
  </div>

  <div class="corpo-view-dados">
    <?=$carregarListas?>
  </div>
</main>
