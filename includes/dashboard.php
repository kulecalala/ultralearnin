<!DOCTYPE html>
<html lang="pt" dir="ltr">
  <head>
    <meta charset="utf-8"/>
    <link rel="shortcut icon" href="/../imagens/logo/ultralerning.png" type="image/x-icon"/>
    <title>Dashboard - Ultralearning</title>
    <link rel="stylesheet" href="/../css/dashboard.css"/>
  </head>
  <body>
    <div id="container">

      <!--menu lateral-->
      <nav>

        <div id="go-home"> Ultralearning </div>

        <ul>
          <li> <a href="#"> Dashboard </a> </li>
          <li> <a href="#"> Horario </a> </li>
          <li> <a href="/importante.php"> Agenda </a> </li>
          <li> <a href="#"> ... </a> </li>
          <li> <a href="#"> ... </a> </li>
          <li> <a href="#"> ... </a> </li>
          <li> <a href="#"> ... </a> </li>
          <li> <a href="#"> ... </a> </li>
          <li> <a href="#"> ... </a> </li>
          <li> <a href="#"> ... </a> </li>
          <li> <a href="#"> ... </a> </li>
          <li> <a href="#"> ... </a> </li>
          <li> <a href="#"> ... </a> </li>
          <li> <a href="#"> ... </a> </li>
          <li> <a href="#"> ... </a> </li>
          <li> <a href="#"> ... </a> </li>
          <li> <a href="#"> Registo de Actividade </a> </li>
          <li> <a href="/home.php"> Sair do dashboad </a> </li>
        </ul>
      </nav>

      <!--topo da pagina-->
      <header>

        <div id="dashboard">
          Dashboard
        </div>

        <div id="dados-utilizador">

          <div id="utilizador-foto">
            <!--Foto de peril-->
            <img src="\users\<?=$showPhotoP?>" alt="Foto de perfil" id="globalUserfotoDePerfil"/>
          </div>
          <div id="utilizador-name">
            <?=$_SESSION['userName']?>
          </div>

        </div>
      </header>

      <!--Conteudo da pagina-->
      <section>

      </section>

    </div>
  </body>
</html>
