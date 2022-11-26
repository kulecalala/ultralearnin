<?php

  session_start();
  require __DIR__.'/../vendor/autoload.php';

  // Verifica login existente
  if( isset($_SESSION['userId'], $_SESSION['userName'], $_SESSION['userStatus']) ) {
    header('Location: /../home.php');
  }

  // tabela de utilizadores
  use \App\Entity\Users;
  use \App\Entity\UsersMore;

  //Instancia users
  $obUser = new Users();
  $obMoreData = new UsersMore();

  $mensagem  = '';

  $email = $_COOKIE['user'] ?? null;;
  $senha = $_COOKIE['pass'] ?? null;;
  $check = $_COOKIE['check'] ?? null;

  //Verifica btn iniciar
  if ( isset($_POST['iniciarSeccao']) ) {

    //Verifica dados de login
    if ( ($_POST['email'] != '') && ( $_POST['senha'] != '') ) { //True

      $email = $_POST['email'];
      $senha = $_POST['senha'];

      //verifica/valida email
      if ( true ) {

        //Dados user
        $obUser->useremail    = $email;
        $obUser->userpassword = md5($senha);

        //buscar user
        $utilizador = $obUser->getUsers('useremail = \''. $obUser->useremail .'\' AND userpassword = \''. $obUser->userpassword .'\' AND userstatus =\'a\'', '', '1' );

        //buscar dados
        foreach ($utilizador as $resultados) {

          // set as variaveis globais
          $_SESSION['userId']     = $resultados->id;
          $_SESSION['userName']   = $resultados->username;
          $_SESSION['userPath']   = $resultados->path;
          $_SESSION['userStatus'] = $resultados->userstatus;

          // obtem mais informacos sobre user
          $maisInfo = $obMoreData->getData( $_SESSION['userId'] );

          // get foto
          $_SESSION['fotoPerfil'] = $maisInfo->foto;

          // status login true
          $_SESSION['userLog']  = true;

          if (isset($_POST['remenber'])) {
            setcookie('user', $email, time()+60*60*24*7*365 );
            setcookie('pass', $senha, time()+60*60*24*7*365);
            setcookie('check', 'checked', time()+60*60*24*7*365);
          } else {
            setcookie('user', $email, 60*60*24*7*365 );
            setcookie('pass', $senha, 60*60*24*7*365);
            setcookie('check', 'checked', time()+60*60*24*7*365);
          }

          //sms de boas vindas

          //pagina home
          header('location: ../?smsAvisos=bem-vindo');
        }

        //Usario não localizado
        $mensagem = '<fieldset id="avisos"> <legend>Aviso</legend>
                       Por favor, forneça dados de login correctos!
                     </fieldset>';

      } else {
        $mensagem = '<fieldset id="avisos"> <legend>Aviso</legend>
                       Todos os campos devem ser preenchidos!
                     </fieldset>';
      }

    } else { //False
      $mensagem = '<fieldset id="avisos"> <legend>Aviso</legend>
                     Todos os campos devem ser preenchidos!
                   </fieldset>';
    }

  }

  //
  include __DIR__.'/../includes/login.php';
