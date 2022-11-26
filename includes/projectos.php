<?php
  //
  $listarProjectos = '';

  //
  foreach ($getProjectos as $kay => $projecto) {

    // foto
    $foto = $projecto->imagem;

    // diretoria da foto do projecto
    $directorio = '/../perfil/projectos/imagens/';

    // get foto
    if ( $foto != '') {
      $foto = $directorio.$foto;
    } else {
      $foto = $directorio.'default.png';
    }

    // titulo
    $titulo = $projecto->titulo ?? 'Titulo indisponível';

    // repositoria github
    $github = $projecto->repositorio ?? '#';

    // descricao
    $descricao = $projecto->descricao ?? 'Descrição indisponível';

    //
    $dataCriacao = $projecto->iniciado_em ?? 'Sem data de publicação';

    //
    $ultimaActualizao = $projecto->terminado_em ?? 'Sem última actualização';

    //
    $sobreMinhaCad = $obMinhasCad->getMinhaCadeira($projecto->sobre);

    //
    $sobre = $obCadeiras->getCadeira($sobreMinhaCad->cadeira);

    //
    $sobre = $sobre->titulo ?? 'Cadeira indisponível';

    //
    $categoria = $projecto->categoria ?? 'Categoria indisponível';

    //
    if ($categoria == 'i') {
      $categoria = 'Ideias';
    } else if ($categoria == 'p') {
      $categoria = 'Projectos';
    } else {
      $categoria = 'Negócios';
    }

    //
    $categoria = $categoria ?? 'Categoria indisponível';

    //
    $percentagem = 'Sem dados de progresso';

    //
    $visibilidade = $projecto->publico;

    //
    if ($visibilidade == 'n') {
      $visibilidade = 'Apenas eu';
    } else {
      $visibilidade = 'Todos UltraLearners';
    }

    //
    $visibilidade = $visibilidade ?? 'Visibilidade Indisponível';

    //
    $artigo = $projecto->codigo_desenvolvimento;

    //
    $artigo = (strlen($artigo) != 0)? '<a href="#">Ver artigo</a>':'<a href="#">Criar artigo</a>';

    //
    $estado = $projecto->estado;

    //
    if ($estado == 'p') {
      $estado = 'Por desenvolver';
    } else if ($estado == 'a') {
      $estado = 'A desenvolver';
    } else if ($estado == 'f') {
      $estado = 'Desenvolvido';
    } else {
      $estado = 'Em actualização';
    }

    //
    $estado = $estado ?? 'Estado indisponível';


    // Armazena
    $listarProjectos .= '<div class="projecto">
                           <div class="foto">
                             <img src="'.$foto.'" alt="Foto ilustrativa do projecto"/>
                           </div>

                           <div class="titulo" title="Nome">
                             '.$titulo.'
                             <a href="'.$github.'" title="Repositório">
                               GitHub
                             </a>
                           </div>

                           <div class="detalhes" title="Descrição">
                             '.$descricao.'
                           </div>

                           <div class="adicionais">
                             <div class="items" title="Data de publicação">
                               '.$dataCriacao.'
                             </div>

                             <div class="items" title="Última actualização">
                               '.$ultimaActualizao.'
                             </div>

                             <div class="items" title="Cadeira: '.$sobre.'">
                               '.substr($sobre, 0, 24).'
                             </div>

                             <div class="items" id="items" title="Categoria">
                               '.$categoria.'
                             </div>
                           </div>

                           <div class="adicionais" id="adicionais">
                             <div class="items" title="Barra de progresso">
                               '.$percentagem.'
                             </div>

                             <div class="items" title="Quem pode ver">
                               '.$visibilidade.'
                             </div>

                             <div class="items" title="Ver/escrever artigo">
                               '.$artigo.'
                             </div>

                             <div class="items" id="items" title="Estado actual">
                               '.$estado.'
                             </div>
                           </div>

                           <div class="btns-controls">
                           </div>
                         </div>';
  }

  //
  if ($listarProjectos == '') {
    // Armazena
    $listarProjectos = 'ola mundo';
  }
?>
<main>
  <section id="projectos">
    <header>
      <h2> Projectos</h2>
      <form name="" method="get" action="">
        <input type="text" name="" value="" placeholder="Pesquise por um determindo projecto aqui!"/>

        <div id="filtros">
          <label for="">Filtar por</label>

          <select class="" name="">
            <option value=""> Cadeiras </option>

            <?=$todasMinhasCadOption?>
          </select>

          <select class="" name="">
            <option value="">Categoria</option>
            <option value="i">Ideia</option>
            <option value="p">Projecto</option>
            <option value="n">Negócio</option>
          </select>

          <select class="" name="">
            <option value="">Estado</option>
            <option value="p">Por desenvolver</option>
            <option value="a">A desenvolver</option>
            <option value="f">Feito</option>
            <option value="u">Em actualização</option>
          </select>

          <select class="" name="">
            <option value="">Público</option>
            <option value="n">Os meus</option>
            <option value="y">Todos</option>
          </select>
        </div>

        <input type="submit" name="btn-procurar" id="btn-procurar" value="Find"/>
      </form>
    </header>

    <section id="lista-projectos">
      <?=$listarProjectos?>
    </section>

    <section id="numero-de-paginas">

    </section>
  </section>
</main>
