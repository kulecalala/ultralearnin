<?php

  session_start();
  require __DIR__.'/../vendor/autoload.php';

  // Verifica login existente
  if( isset($_SESSION['userId'], $_SESSION['userName'], $_SESSION['userStatus']) ) {
    header('Location: /');
  }


  include __DIR__.'/../includes/inicio.php';
