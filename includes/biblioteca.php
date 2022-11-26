<main id="home-page">
  <?php
    include __DIR__.'/pagina-em-construcao.php';
  ?>
  <div id="topo-menu">
    acesso rapido da biblioteca
  </div>

  <aside id="menu-lateral">
    <div id="m-titulo">
      Menu
    </div>

    <ul>
      <a href="biblioteca.php?ref=seeAllFiles">
        <li>Todos os ficheiros</li>
      </a>

      <a href="biblioteca.php?ref=seeImages">
        <li>Imagens</li>
      </a>

      <a href="biblioteca.php?ref=seeMyLibre">
        <li>Livros</li>
      </a>

      <a href="biblioteca.php?ref=seeAllVideo">
        <li>Vidoes</li>
      </a>

      <a href="biblioteca.php?ref=addNewFile">
        <li>Adicionar novo</li>
      </a>
    </ul>
  </aside>

  <section id="my-files">
    <?php
      $rotas = [
                'seeAllFiles' => 'includes/biblioteca/allfiles.php',
                'seeImages'   => 'includes/biblioteca/imagens.php',
                'seeMyLibre'  => 'includes/biblioteca/livros.php',
                'seeAllVideo' => 'includes/biblioteca/videos.php',
                'addNewFile'  => 'includes/biblioteca/adicionar.php'
               ];

      //Verifica se  codigo de alguma pagina foi enviado
      if ( !empty($_GET['ref']) ) {

        //Pega o codigo da pagina
        $pageCodigo = $_GET['ref'];

        //Pega a localizacao da pagina
        $openFile = $rotas[$pageCodigo];

        //Verifica se o ficheiro existe
        if ( file_exists($openFile) ) {
          //Inclui o arquico a pagina
          include($openFile);
        } else {
          //Caso a pagina nao exite redirecione
          header('location: biblioteca.php?status=UnlocationFile');
          exit; //Termina axecucao
        }

      } else { //Caso nenhum codigo tenha sido enviado
        //Pega a localizacao do arquivo
        $openFile = $rotas['seeAllFiles'];

        //Verifica se o arquivo existe
        if ( file_exists($openFile) ) {
          //Inclui o arquivo a pagina
          include($openFile);
        }else{
          //Caso a pagina nao exista
          header('location: biblioteca.php?status=UnlocationFile');
          exit; //Termina execucao
        }

      }

     ?>
  </section>
</main>
