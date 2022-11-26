 <?php
  // lista de desafios
  $desafiosAceites = '';

  // Lista de exercicios
  $exerciciosAceites = '';

  // Lista de exercicios gerais
  $listaDeExercicios = '';

  // Lista de desafios gerais
  $listaDeDesafios = '';

  // lista de exercicios aceites
  $listarExerciciosAceites = '';

  // ver desafio especifico
  $verDesafioEspecifico = '';

  // Resultado das buscas
  $verResultadoDeBuscas = '';

  // Verifica se algum desafio especifico foi selecionado
  if ( isset( $_GET['desafioCod'] ) ) { // true

    // busca o desafio
    $obDados = $obDesafio->getDesafio( $_GET['desafioCod'] );

    $idDesafio = $obDados->id ?? '';
    $titulo    = $obDados->titulo ?? '';
    $desafio   = $obDados->desafio ?? '';
    $sobre     = $obDados->sobre ?? '';
    $autor     = $obDados->adicionada_por ?? '';
    $autorID   = $obDados->adicionada_por ?? '';
    $data      = substr($obDados->data_inicio, 0, 10) ?? '';
    $nivel     = $obDados->nivel ?? '';
    $categoria = $obDados->categoria ?? '';

    // selecionar categoria
    $selecionarCat1 = ($categoria == 'd')? 'selected': '';
    $selecionarCat2 = ($categoria == 'e')? 'selected': '';

    // get autor do desafio
    $nomeAutor = $obUtilizador->getUser( $autor );

    // nome do utilizador
    $autor = ( strlen( ( $nomeAutor->username ) > 50) )? substr($nomeAutor->username, 0, 50) : $nomeAutor->username;

    // Autor
    $autor = '<a href="#" title="Ver perfil">'. $autor .'</a>'?? 'indisponivel';

    // get as minhas cadeiras
    $obCadList = $obCadeiras->getCadeiras();
    $cadeirasDesafio = '';

    foreach ($obCadList as $key=>$value) {

      // Nome da cadeira
      $cadName = $value->titulo;

      //Seleciona cadeira
      $selecionar = ( $sobre == $value->id )? 'selected': '';

      $cadeirasDesafio .= '<option value="'. $value->id .'" '. $selecionar .'>
                             '. $cadName .'
                           </option>';
    }

    // nivel de dificuldade select
    $nivelD1 = ($nivel == 'b')? 'selected': '';
    $nivelD2 = ($nivel == 'i')? 'selected': '';
    $nivelD3 = ($nivel == 'm')? 'selected': '';
    $nivelD4 = ($nivel == 'd')? 'selected': '';
    $nivelD5 = ($nivel == 'h')? 'selected': '';

    // controls opcoes
    $botoesDoFormulario = '';
    $activarEdicao = '';

    // Vefifica Autor
    if ( $autorID == $codigoUser ) {
      $botoesDoFormulario = '<input type="submit" name="btn-Actualizar" value="Actualizar" id="actualizar"/>
                             <input type="reset" name="btn-restaurar" value="Restaurar" id="restaurar"/>
                             <input type="submit" name="btn-apagar" value="Apagar" id="apagar"/>';

    } else {
      $botoesDoFormulario = '<p>Este exercicio só pode ser editado pelo autor!</p>';
      $activarEdicao = 'disabled';
    }

    // a resultados
    if ( (strlen( $titulo ) > 0) || (strlen($desafio) > 0) ) {
     $carregarLista = '<div id="ver-mais-detalhes">
                           <form name="" method="post" action="">
                             <div id="topo">
                               <input type="text" name="titulo" value="'. $titulo .'" placeHolder="Coloque aqui ao titulo do desafio!" required '.$activarEdicao.'/>

                               <input type="text" name="idDesafio" value="'. $idDesafio .'" required hidden/>
                             </div>
                             <a href="/desafios.php">
                               <div id="voltar">Voltar</div>
                             </a>

                             <div id="descricao">
                               <textarea name="desafioText" placeHolder="Escreva a aqui o desafio/exercicio que prentendes lançar!" required '.$activarEdicao.'>'. $desafio .'</textarea>
                             </div>

                             <div id="detalhes">
                               <div class="caixinhas">
                                 <div class="tituloMFKB">
                                   Criado em:
                                 </div>
                                 <div class="conteudo">
                                   <input type="date" name="dataCriacao" value="'. $data .'" required disabled/>
                                   <input type="date" name="dataCriacao" value="'. $data .'" required hidden/>
                                 </div>
                               </div>

                               <div class="caixinhas">
                                 <div class="tituloMFKB">
                                   Sobre:
                                 </div>
                                 <div class="conteudo">
                                   <select name="desafioSobre" size="1" required '.$activarEdicao.'>
                                     <option value=""> Este objectivo esta relacionado a: </option>
                                     '. $cadeirasDesafio .'
                                   </select>
                                 </div>
                               </div>

                               <div class="caixinhas">
                                 <div class="tituloMFKB">
                                   Nivel:
                                 </div>
                                 <div class="conteudo" id="range">
                                   <select name="nivelDificuldade" size="1" required '. $activarEdicao .'>
                                     <option value=""> Nivel de dificuldade </option>

                                     <option value="b" '. $nivelD1 .'>
                                       Iniciante
                                     </option>

                                     <option value="i" '. $nivelD2 .'>
                                       Básico
                                     </option>

                                     <option value="m" '. $nivelD3 .'>
                                       Básico/Intermediário
                                     </option>

                                     <option value="d" '. $nivelD4 .'>
                                       Difícil
                                     </option>

                                     <option value="h" '. $nivelD5 .'>
                                        Muito Difícil
                                     </option>
                                   </select>
                                 </div>
                               </div>

                               <div class="caixinhas">
                                 <div class="tituloMFKB">
                                   Categoria:
                                 </div>
                                 <div class="conteudo">
                                   <select name="categoriaDes" size="1" required '. $activarEdicao .'>
                                     <option value=""> Selecione a categoria!</option>

                                     <option value="d" '. $selecionarCat1 .'>
                                       Desafio
                                     </option>

                                     <option value="e" '. $selecionarCat2 .'>
                                       Exercicio
                                     </option>
                                   </select>
                                 </div>
                               </div>

                               <div class="caixinhas" id="authors">
                                 <div class="tituloMFKBAC">
                                   Autor/a:
                                 </div>
                                 <div id="autor">
                                   '. $autor .'
                                 </div>
                               </div>
                             </div>

                             <div id="controls">
                               '. $botoesDoFormulario .'
                             </div>
                           </form>
                         </div>';

      // get solucao do desafio
      $whereSolucao = 'id_user = "'. $codigoUser .'" AND id_desa_exerc = "'. $idDesafio .'"';
      $getSolucao = $obMeusDesafio->getDesafiosAceites( $whereSolucao, null, '1');

      $idPrimario     = '';
      $idDesafioExerc = $idDesafio;
      $desafioSolucao = '';
      $pego_em        = '';
      $tentativas     = '0';
      $estado         = '';

      $controlerBtnAdd = '';

      /*echo '<pre>';
      print_r( $getSolucao );
      echo '</pre>'; exit;*/

      // obet resultado
      foreach ( $getSolucao as $key => $solucao ) {

        $idPrimario     = $solucao->id;
        $desafioSolucao = $solucao->solucao ?? '';
        $pego_em        = $solucao->pego_em ?? '';
        $tentativas     = $solucao->tentativas ?? '';
        $estado         = $solucao->estado ?? '';

        $controlerBtnAdd = 'title="função desactivada, desafio/exercicio aceite" disabled';
      }

      // data da solucao
      $dataSolucao = strlen(($pego_em) > 0)? $pego_em: date('Y-m-d');

      // estado da solucao
      $estadoSol1 = ($estado == 'p')? 'selected': '';
      $estadoSol2 = ($estado == 'a')? 'selected': '';
      $estadoSol3 = ($estado == 'r')? 'selected': '';

      $carregarLista .= '<h3> Envie a sua solução aqui... </h3>
                         <div id="ver-mais-detalhes" style="border-bottom: 60px solid white;">
                           <form name="" method="post" action="">

                             <input type="text" name="idPrimario" value="'. $idPrimario .'" hidden/>

                             <input type="text" name="idExercicio" value="'. $idDesafioExerc .'" hidden/>

                             <textarea name="solucaoDesafio" id="solucao" placeHolder="Coloque aqui a sua solução para o desafio/exercicio. Ou escreva aqui como é que foi a experiencia de tal actividade!">'. $desafioSolucao .'</textarea>

                             <div id="detalhes">
                               <div class="caixinhas">
                                 <div class="tituloMFKB">
                                   Last Update:
                                 </div>
                                 <div class="conteudo">
                                   <input type="date" name="dataCriacao" value="'. $dataSolucao .'" disabled/>
                                   <input type="date" name="dataCriacao" value="'. $dataSolucao .'" hidden/>
                                 </div>
                               </div>

                               <div class="caixinhas">
                                 <div class="tituloMFKB">
                                   Tentativas:
                                 </div>
                                 <div class="conteudo">
                                   <input type="number" name="tentativasS" min="0" value="'. $tentativas  .'" disabled/>
                                   <input type="number" name="tentativasS" min="0" value="'. $tentativas  .'" hidden/>
                                 </div>
                               </div>

                               <div class="caixinhas">
                                 <div class="tituloMFKB">
                                   Categoria:
                                 </div>
                                 <div class="conteudo" id="range">
                                   <select name="categoriaS" size="1" required disabled>
                                     <option value=""> Categoria do desafio </option>

                                     <option value="d" '. $selecionarCat1 .'>
                                       Desafio
                                     </option>

                                     <option value="e" '. $selecionarCat2 .'>
                                       Exercicio
                                     </option>
                                   </select>

                                   <select name="categoriaS" size="1" hidden>
                                     <option value=""> Categoria do desafio </option>

                                     <option value="d" '. $selecionarCat1 .'>
                                       Desafio
                                     </option>

                                     <option value="e" '. $selecionarCat2 .'>
                                       Exercicio
                                     </option>
                                   </select>
                                 </div>
                               </div>

                               <div class="caixinhas">
                                 <div class="tituloMFKB">
                                   Estado:
                                 </div>
                                 <div class="conteudo">
                                   <select name="estadoDesafio" size="1">
                                     <option value="">
                                       Estado do desafio!
                                     </option>

                                     <option value="p" '. $estadoSol1 .'>
                                       Por resolver
                                     </option>

                                     <option value="a" '. $estadoSol2 .'>
                                       A resolver
                                     </option>

                                     <option value="r" '. $estadoSol3 .'>
                                       Resolvido
                                     </option>

                                   </select>
                                 </div>
                               </div>

                               <div class="caixinhas" id="authors">
                                 <div class="tituloMFKBAC">
                                   Autor/a:
                                 </div>
                                 <div id="autor">
                                   '. substr($globalUserName, 0, 50) .'
                                 </div>
                               </div>
                             </div>

                             <div id="controls">
                                <input type="submit" name="btn-enviar-solucao" value="Enviar" id="actualizar"/>

                                <input type="reset" name="btn-restaurar" value="Restaurar" id="restaurar"/>

                                <input type="submit" name="btn-resolver-depois" value="Adicionar a lista" id="apagar" '. $controlerBtnAdd .'/>
                             </div>
                           </form>
                         </div>';


    } else {
      $carregarLista = '<div id="ver-mais-detalhes">
                                 <div id="sms-objectivo-not-found">
                                   <p>O objectivo solicitado não foi localizado, por favor, tente novamente.</p> &nbsp;
                                   <p><a href="/queroAprender.php"> Voltar! </a></p>
                                 </div>
                               </div>';
    }

  } else { // false

    // verifica se alguma busca foi feita
    if ( isset($b_frase, $b_filtro) ) { // caso ten

      foreach ( $obTodosExercDesaf as $key => $results ) {

        $desafioId = $results->id;
        $descricao = (strlen($results->desafio) > 280)? substr($results->desafio, 0, 280).'...': $results->desafio;

        $verResultadoDeBuscas .= '<div class="list-items-d-o">
                                    <div class="descricao">'. $descricao .'</div>
                                    <a href="?desafioCod='. $desafioId .'">
                                      <div class="buttom"> Ver mais </div>
                                    </a>
                                  </div>';


      }

      if ( strlen( $verResultadoDeBuscas ) ) {
        $carregarLista .= '<h3> Resultado para a busca </h3>
                           <div class="listar-tarefas">
                             '. $verResultadoDeBuscas .'
                           </div>';
      } else {
        $carregarLista .= '<h3> Resultado para a busca </h3>
                           <div class="listar-tarefas">
                             <div class="sms-objectivos">
                               Sem resultados!
                             </div>
                           </div>';
      }

    } else { // Caso nenhuma busca tenha sido feita

      foreach ( $obExerciciosAceites as $key=>$dados ) {

        // GET DESAFIOS
        $obExercicio = $obDesafio->getDesafio( $dados->id_desa_exerc );

        $desafioId = $obExercicio->id;
        $descricao = (strlen($obExercicio->desafio) > 280)? substr($obExercicio->desafio, 0, 280).'...': $obExercicio->desafio;

        // get execicio
        $listarExerciciosAceites .= '<div class="list-items-d-o">
                                       <div class="descricao">'. $descricao .'</div>
                                       <a href="?desafioCod='. $desafioId .'">
                                         <div class="buttom"> Ver mais </div>
                                       </a>
                                     </div>';

      }

      if ( strlen($listarExerciciosAceites ) != 0 ) {
        $carregarLista .= '<h3>
                             Exercicios aceites
                             <a href="#"> Resolvidos </a>
                           </h3>
                           <div class="listar-tarefas">
                             '. $listarExerciciosAceites  .'
                           </div>';
      } else {
        $carregarLista .= '<h3> Exercicios aceites </h3>
                           <div class="listar-tarefas">
                             <div class="sms-objectivos">
                               A lista encontra-se vazia!
                             </div>
                           </div>';

      }

      // lista de desafios aceites
      $listarDesafiosAceites = '';

      // get desafios
      foreach ( $obDesafiosAceites as $key=>$dados ) {

        // GET DESAFIOS
        $obExercicio = $obDesafio->getDesafio( $dados->id_desa_exerc );

        $desafioId = $obExercicio->id;
        $descricao = (strlen($obExercicio->desafio) > 280)? substr($obExercicio->desafio, 0, 280).'...': $obExercicio->desafio;

        // get execicio
        $listarDesafiosAceites .= '<div class="list-items-d-o">
                                     <div class="descricao">'. $descricao .'</div>
                                       <a href="?desafioCod='. $desafioId .'">
                                       <div class="buttom"> Ver mais </div>
                                     </a>
                                   </div>';
      }

      if ( strlen( $listarDesafiosAceites ) != 0 ) {
        $carregarLista .= '<h3>
                             Desafios Aceites
                             <a href="#"> Resolvidos </a>
                           </h3>
                           <div class="listar-tarefas">
                             '. $listarDesafiosAceites  .'
                           </div>';
      } else {
        $carregarLista .= '<h3> Desafios Aceites </h3>
                           <div class="listar-tarefas">
                             <div class="sms-objectivos">
                               A lista encontra-se vazia!
                             </div>
                           </div>';

      }

      // Armazena lista de mais exercicios
      $getListaDeExercicios = '';

      // get lista de exercicios
      foreach( $obListaExercicios as $key => $exercicios ) {

        $descricao = (strlen($exercicios->desafio) > 285)? substr($exercicios->desafio, 0, 285): $exercicios->desafio;
        $desafioId = $exercicios->id;

        $getListaDeExercicios .= '<div class="list-items-d-o">
                                    <div class="descricao">'. $descricao .'</div>
                                    <a href="?desafioCod='. $desafioId .'">
                                      <div class="buttom"> Ver mais </div>
                                    </a>
                                  </div>';
      }

      if ( strlen( $getListaDeExercicios ) != 0 ) {
        $carregarLista .= '<h3> Mais exercicios
                             <a href="#"> Ver Todos os ('. $getQuantidadeExercicios .') </a>
                           </h3>
                           <div class="listar-tarefas">
                             '. $getListaDeExercicios .'
                           </div>';
      } else {
        $carregarLista .= '<h3> Mais exercicios </h3>
                           <div class="listar-tarefas">
                             <div class="sms-objectivos">
                               A lista encontra-se vazia!
                             </div>
                           </div>';

      }

      // Armazena os exercicios
      $getListaDeDesafios = '';

      // get lista de desafios
      foreach ( $obListaDesafios as $key => $desafios ) {

        $descricao = (strlen($desafios->desafio) > 285)? substr($desafios->desafio, 0, 285): $desafios->desafio;
        $desafioId = $desafios->id;

        $getListaDeDesafios .= '<div class="list-items-d-o">
                                    <div class="descricao">'. $descricao .'</div>
                                    <a href="?desafioCod='. $desafioId .'">
                                      <div class="buttom"> Ver mais </div>
                                    </a>
                                  </div>';
      }

      if ( strlen( $getListaDeDesafios ) != 0 ) {
        $carregarLista .= '<h3> Mais desafios
                             <a href="#"> Ver Todos os ('. $getQuantidadeDesafios .') </a>
                           </h3>
                           <div class="listar-tarefas">
                             '. $getListaDeDesafios .'
                           </div>';
      } else {
        $carregarLista .= '<h3> Mais desafios </h3>
                           <div class="listar-tarefas">
                             <div class="sms-objectivos">
                               A lista encontra-se vazia!
                             </div>
                           </div>';

      }

    }

  }

?>
<main id="objectivos-e-desafios">
  <div class="topo-pesquisar">
    <div id="titulo-top"> Desafios </div>
    <div id="formulario">
      <form class="" action="" method="method">
        <input type="text" name="pesquisar_por" value="<?=$b_frase?>" placeholder="Pesquise aqui por exercicios ou desafios!"/>

        <label for="filtro">Filtrar por: </label>
        <select class="" size="1" name="filtrar_por">
          <option value=""> Selecione o filtro </option>

          <option value="d" <?=($b_filtro == 'd')? 'selected': '';?>> Desafios </option>

          <option value="e" <?=($b_filtro == 'e')? 'selected': '';?>> Exercícios </option>

          <option value="p" <?=($b_filtro == 'p')? 'selected': '';?>> Por resolver </option>

          <option value="a" <?=($b_filtro == 'a')? 'selected': '';?>> A resolver </option>

          <option value="r" <?=($b_filtro == 'r')? 'selected': '';?>> Resolvidos </option>
        </select>

        <button type="submit" name="btn-buscar">Buscar</button>
      </form>
    </div>
  </div>

  <div id="sub-menu">
    <ul>
      <a href="#">
        <li> Exericios </li>
      </a>

      <a href="#">
        <li> Desafios </li>
      </a>

      <a href="#">
        <li> Exercicios aceites </li>
      </a>

      <a href="#">
        <li> Desafios Aceites </li>
      </a>

      <a href="#">
        <li> Exercicios Resolvidos </li>
      </a>

      <a href="#">
        <li> Desafios Cumpridos </li>
      </a>

      <a href="#">
        <li> Ranking </li>
      </a>
    </ul>
  </div>

  <div class="corpo-view-dados">
    <?=$carregarLista?>
  </div>
</main>
