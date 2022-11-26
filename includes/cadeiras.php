<?php

  // armazena dados da cadeira selecionada
  $verMinhaCadeira = '';

  // Armazena a lista de cadeiras
  $listaDeCadeiras = '';

  // listar tipo de cadeiras
  foreach ($tipoCadeiras as $key => $tipos) {

    // marcar tipo
    $selecionar = '';

    // verifica se e igual
    if ( $tipos->id == $b_tipoCade ) {
      // marca
      $selecionar = 'selected';
    }

    // formata a lista
    $listaDeCadeiras .= '<option value="'.$tipos->id.'" '.$selecionar.'>
                           '. $tipos->tipo .'
                         </option>';
  }

  // armazena o resultado
  $listarResultados = '';

  // verifica busca
  if ( $b_nomeCade != '' || $b_tipoCade != '' ) {

    // get cadeiras
  	$resultadosBusca = $obCadeiras->getCadeiras($where, 'titulo DESC', '8');

    // get resultados
    foreach($resultadosBusca as $key => $cadeiras ) {

      // get dados
      $idCa = $cadeiras->id;
      $nome = $cadeiras->titulo ?? 'Indisponível';
      $desc = $cadeiras->descricao ?? 'Indisponível';
      $tipo = $cadeiras->tipo;

      // get tipo
      $getTipoName = $obTipoCadeiras->getTipoCad( $tipo );

      // tipo nome
      $tipo = $getTipoName->tipo ?? '...';

      // tipo
      $esta = '';

      //
      $addNewCad = '';

      if ( true ) {
        $addNewCad = '<form name="" method="post" action="">
                        <input type="text" name="cadeira" value="'.$idCa.'" hidden/>

                        <button type="submit" name="AddCadeiras">
                          Adicionar
                        </button>
                      </form>';
      }

      // formata lista
      $listarResultados .= '<tr>
                              <td class="td">'. $nome .'</td>
                              <td class="td" id="td-desc">'. $desc .'</td>
                              <td class="td">'. $tipo .'</td>
                              <td class="td"">
                                '. $addNewCad .'
                              </td>
                            </tr>';
    }

    // A resultados da busca
    if ( strlen($listarResultados) > 0 ) {

      // formata lista de resultados
      $listarResultados = '<div class="resultados-da-busca-cad">
                              <table border="1" collspacing="2" width="100%">
                                <tr align="center">
                                  <td width="25%">Nome</td>
                                  <td width="50%">Decrição</td>
                                  <td width="15%">Tipo</td>
                                  <td width="10%">Add/Rem</td>
                                </tr>

                                '.$listarResultados.'
                              </table>
                            </div>';
    }

  }

  // Armazena dados de busca ou not
  $carragarDadosCadMy = '';

  // A resultados da busca
  if ( strlen($listarResultados) > 0 ) {
    // set dados
    $carragarDadosCadMy = $listarResultados;
  } else {

    // verifica se alguma busca foi efectuada
    if ( $b_nomeCade != '' || $b_tipoCade != '' ) {
      $carragarDadosCadMy = '<h2> Resultados da busca </h2>
                             <p>Sem resultados para a busca efectuada!</p>';
    } else {
      $carragarDadosCadMy = '<h2> Gestor de Cadeiras </h2>
                             <p>Se você acha que a educação é cara. Experimente a ignorancia!</p>';
    }

  }

  // visualizar cadeira
  if ( $controlDeAcesso ) {
    $verMinhaCadeira = '<div id="cad-titulo">'. $nomeCadeira .'</div>
                          <div id="cad-imagem">
                            <img src="/../imagens/cadeiras/'.$fotoCadeira.'"/>
                          </div>

                          <div class="cad-sub-titulo"> Informação geral </div>

                          <div class="cad-dados">
                            <div class="cad-name"> Cadeira:  </div>
                            <div class="cad-conteudo-alinhar">
                              '. $nomeCadeira .'
                            </div>
                          </div>

                          <div class="cad-dados">
                            <div class="cad-name"> Categoria:  </div>
                            <div class="cad-conteudo-alinhar">
                              '. $categoriaCadeira .'
                            </div>
                          </div>

                          <div class="cad-dados">
                            <div class="cad-name"> Descrição: </div>
                            <div class="cad-conteudo">'. $descricaoCadeira .'</div>
                          </div>
                          <!-- Fim informacao geral-->

                          <!-- Informacao particular -->
                          <div class="cad-sub-titulo"> Meus dados </div>

                            <div class="cad-dados">
                              <div class="cad-estados"> Inc. em: '. $dataInicio .'</div>
                              <div class="cad-estados"> Fin. em: '. $dataFinalizar .'</div>
                              <div class="cad-estados"> Tipo: '. $periodo .'</div>
                              <div class="cad-estados"> Estado: '. $estadoCade .'</div>
                            </div>

                            <div class="cad-dados">
                              <div class="title-notas"> Notas de provas e avaliações </div>

                              <!--Carrega as notas-->
                              '. $asMinhasNotas .'

                              <div class="btn-add-notas">
                                <button type="button" name="button" onclick="showModal(\'editar-conteudo-notas\')">
                                  Adicionar nova nota
                                </button>
                              </div>
                            </div>

                            <div class="cad-dados">
                              <div class="cad-name"> Professor:  </div>
                              <div class="cad-conteudo-alinhar">
                                '. $oProfessor .'
                              </div>
                            </div>

                            <div class="cad-dados">
                              <div class="cad-name"> Descrição:  </div>
                              <div class="cad-conteudo">
                                <textarea name="name" placeHolder="Faça aqui as suas anotações!" onclick="showModal(\'editar-conteudo-cade\')">'. $sobreCadeira .'</textarea>
                              </div>

                              <button id="btn-editar-cad" type="button" onclick="showModal(\'editar-conteudo-cade\')">
                                Editar
                              </button>
                            </div>';

  }

  // tela de bloqueio
  $telaDeBloqueio = '<div class="tela-bloqueio-cadeiras">
                       <div id="topo">
                         <form name="" method="get" action="">

                           <div id="buscar">
                             <input type="text" name="buscarPor" value="'. $b_nomeCade .'" placeholder="Busque por uma determinda cadeira, temos mais de '.($qtdeCadeiras - 3).' cadastradas!"/>
                           </div>
                           <div id="filtro">
                             <label for=""> Filtrar: </label>

                             <select name="tipoCad" size="1">
                               <option value=""> Tipo </tipo>
                               '. $listaDeCadeiras .'
                             </select>
                           </div>

                           <button type="submit">
                             Procurar
                           </button>
                         </form>
                       </div>

                       <div id="resultados-cadeiras">
                         '. $carragarDadosCadMy .'
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
    $showInfo = $verMinhaCadeira;
  }

  // verifica se a cadeiras
  if ( strlen($todasMinhasCad) == 0) {
    $todasMinhasCad = '<div class="semCadeiras">
                         <p>Sem cadeiras</p>
                       </div>';
  }

?>
<main>
  <aside id="menu-lateral">
    <div id="m-titulo">
      Cadeiras
    </div>

    <ul>
      <?=$todasMinhasCad?>
    </ul>
  </aside>

  <section id="visualizar-c">
    <!--Editar conteudos-->
    <div class="editar-conteudo-cade" id="editar-conteudo-cade">

      <div class="titlo-da-opcao">
        Editar dados da cadeira
        <span onclick="hiddenModal('editar-conteudo-cade')"> &times; </span>
      </div>

      <form class="" action="" method="post">
        <div class="caixa-de-conteudos">
          <div class="descricao"> Periodo de Duração: </div>
          <div class="conteudos">
            <select name="periodo" size="1" required>
              <option value=""> Selecione o periodo de duração! </option>
              <option value="i" <?=($duracao == 'i')? 'selected': '';?>> Indisponivel </option>

              <option value="t" <?=($duracao == 't')? 'selected': '';?>> Trimestral </option>

              <option value="s" <?=($duracao == 's')? 'selected': '';?>> Semestral </option>

              <option value="a" <?=($duracao == 'a')? 'selected': '';?>> Anual </option>
            </select>

            <input type="text" name="idMinhaCad" value="<?=$idMinhaCad?>" hidden/>
          </div>

          <div class="descricao"> Data de inicio: </div>
          <div class="conteudos">
            <input type="date" name="dataInicio" value="<?=$dataInicio?>"  required/>
          </div>

          <div class="descricao"> Data de termino: </div>
          <div class="conteudos">
            <input type="date" name="dataTermino" value="<?=$dataFinalizar?>"  required/>
          </div>

          <div class="descricao"> Pontos necessarios: </div>
          <div class="conteudos">
            <input type="number" name="pontosNecessarios" value="<?=$pontosNecessarios?>" min="0" max="20" placeholder="Preencha este campo com valores numericos!" required/>
          </div>

          <div class="descricao"> O professor: </div>
          <div class="conteudos">
            <select name="oProfessor" size="1" required>
              <option value=""> Selecione o professor da cadeira! </option>
              <!-- Lista de professores -->
              <?=$listarMeusProfessores?>
            </select>
          </div>

          <div class="descricao"> Observações: </div>
          <div class="conteudos" id="conteudos">
            <textarea name="observacoes" placeHolder="Escreva aqui as suas observações sobre a cadeira e o professor (Opcional)!"><?=$sobreCadeira?></textarea>
          </div>

          <div class="descricao" id="descricao"> O estado: </div>
          <div class="conteudos">
            <select name="estadoDaCadeira" size="1">
              <option value=""> Selecione o estado da cadeira!</option>
              <option value="p" <?=($statusCade == 'p')? 'selected': '';?>> Por fazer</option>

              <option value="f" <?=($statusCade == 'f')? 'selected': '';?>> A fazer </option>

              <option value="r" <?=($statusCade == 'r')? 'selected': '';?>> Em recurso </option>

              <option value="e" <?=($statusCade == 'e')? 'selected': '';?>> Em exame especial </option>

              <option value="t" <?=($statusCade == 't')? 'selected': '';?>> Finalizada com sucesso </option>

              <option value="a" <?=($statusCade == 'a')? 'selected': '';?>> A repetir </option>
            </select>
          </div>
        </div>

        <div class="buttoes-de-controle">
          <input type="submit" name="actualizar" value="Actualizar" id="update"/>
          <input type="reset" name="restaurar" value="Restaurar" id="restaurar"/>
          <input type="submit" name="eliminar" value="Eliminar" id="delete"/>
        </div>
      </form>

    </div> <!-- Fim editar conteudos-->

    <!--Editar notas-->
    <div class="editar-conteudo-notas" id="editar-conteudo-notas">
      <span onclick="hiddenModal('editar-conteudo-notas')"> &times; </span>

      <div class="caixa-de-conteudos">
        As minhas notas
      </div>

    </div> <!-- Fim editar notas-->

    <!--Carrega informacoes necessarias -->
    <?=$showInfo?>

    <!-- Fim informacoes particulares -->
  </section>


</main>
