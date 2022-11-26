<?php

  //Inicia sessao
  session_start();

  session_destroy();

  //Redireciona para a pagina de login
  header('location: /home');
