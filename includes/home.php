<main id="home-page">
  <!--Conteudo lateral esquerdo-->
  <aside id="esquerda">
    <div class="titulo">Cadeiras</div>

    <ul>
      <?=$asMinhasCadeidas;?>
    </ul>
  </aside>

  <!--Conteudo principal-->
  <section id="home">

    <!--Acesso rapido-->
    <div id="acessar-paginas">
      <div class="titulos">
        Acesso rápido

        <div class="ver-mais" id="ver-mais">
          <a href="/sejaSabio.php"> Dicas de sabedoria!? </a>
        </div>
      </div>

      <ul>
        <a href="/dicasDeTi.php" title="Dicas sobre TI">
          <li> Dicas T.I </li>
        </a>

        <a href="/artigos.php" title="Crie um artigo e partilhe o seu conhecimento">
          <li> Criar artigos </li>
        </a>

        <a href="/dict.php" title="Diciónario">
          <li> Diciónario </li>
        </a>

        <a href="saibaMais.php" title="Definições de quem partilha o conhecimento!">
          <li> Saiba mais </li>
        </a>

        <a href="/trabalhosAcad.php" title="As minhas pesquisas acadêmicas">
          <li> Trabalhos </li>
        </a>

        <a href="/sites.php" title="Listas de locais na web quem podem lhe interessar">
          <li> Sites </li>
        </a>

        <a href="#">
          <li>Rank</li>
        </a>

        <a href="/moreUsers.php" title="Outros usuarios">
          <li id="btn-users-u"> Ultra Users </li>
        </a>

      </ul>

    </div> <!-- Fim Acesso rapido-->

    <!-- O que vou aprender hoje -->
    <div id="o-que-vou-aprender">
      <div class="titulos">
        O que você vai aprender hoje?

        <div class="ver-mais">
          <a href="/queroAprender.php"> Ver todos </a>
        </div>
      </div>

      <!-- Carregar conteudo -->
      <?=$oQueAprenderLista?>

    </div> <!-- Fim O que vou aprender hoje -->

    <!-- Projecto em desenvolvimento -->
    <div id="projecto-em-desenvolvimento">

      <!-- Carregar projecto dados do projecto -->
      <?=$meuProjecto?>

    </div> <!-- Fim projecto em desenvolvimento -->

    <!-- Objectivos da semana -->
    <div id="objectivos-da-semana">
      <div class="titulos">
        Objectivos da semana!

        <div class="ver-mais">
          <a href="/objectivos.php"> Ver todos </a>
        </div>

      </div>

      <!-- Carregar objectivos da semana -->
      <?=$objectivosDaSemana?>

    </div> <!-- Fim objectivos da semana -->

    <!-- Desafios propostos -->
    <div id="desafios-propostos">
      <div class="titulos">
        Desafios propostos!

        <div class="ver-mais">
          <a href="/desafios.php"> Ver todos </a>
        </div>

      </div>

      <!-- Carregar desafios -->
      <?=$desafiosLista?>

    </div> <!-- Fim desafios propostos -->

    <!-- Trabalhos academicos -->
    <div id="trabalhos-academicos">
      <div class="titulos"> Trabalhos academicos! </div>

      <!-- Carregar trabalhos acedemicos -->
      <?=$minhasPesquisas?>
    </div> <!-- Fim trabalhos academicos -->

    <!-- Exercicios por resolver -->
    <div id="exercicios-por-resolver">
      <div class="titulos">
        Exercícios por resolver!

        <div class="ver-mais">
          <a href="/desafios.php"> Ver todos </a>
        </div>

      </div>

      <!-- Carregar lista de exercicios -->
      <?=$exerciciosLista?>

    </div> <!-- Fim exercicios por resolver -->

    <!-- Colaboradores -->
    <div id="aqueles-que-partilham">
      <div class="titulos">
        Quem partilha o seu conhecimento conosco.

        <div class="ver-mais">
          <a href="/parceiros.php"> Ver todos </a>
        </div>
      </div>

      <ul>
        <!-- Lista dos criadores de artigos -->
        <?=$quemPartilhaConhecimento?>
      </ul>

    </div>
    <!-- Fim colaboradores -->

    <!-- Pareceiros -->
    <div id="nossos-parceiros">
      <div class="titulos">
        Parceiros, aqueles que contribuem para existirmos!

        <div class="ver-mais">
          <a href="/parceiros.php"> Ver todos </a>
        </div>
      </div>

      <ul>
        <!-- Lista de quem contribui para a nossa existencia  -->
        <?=$quemContribuiParaNossaExistencia?>
      </ul>

    </div>
    <!-- Fim Parceiros -->
  </section>

  <!--Conteudo lateral direito-->
  <aside id="direita">
    <!--Calendario-->
    <div class="titulo">Agenda</div>

    <div id="calendario">
      color
    </div>

    <!--Lista de novos contuedos-->
    <div class="titulo">O que é novo?</div>

    <div id="novos-conteudos">
      <?=$listaConteudo?>
    </div>

  </aside>

</main>
