<?php

  // Mensagens de erro/avisos
  if ( isset($_GET['smsAvisos']) && $mensagem == '' ) {
    $mensagem = 'Olá <strong>'. $globalUserName .'</strong>, é bom ter-te novamente aqui, pronto/a para mais uma experiência de ultraprendizado?';
  }

  //Verifica se ha mensagem a ser exibida
  if( $mensagem != '' ){
    // forma a mensagem a ser exibida
    $mensagem = '<div id="notificacoes">'. $mensagem .'</div>';
  }
