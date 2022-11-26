<?php

  namespace App\Config;

  use \App\Entity\Users;

  class AcessoControl {
    public $id_user = null;
    public $online = null;
    public $status = null;

    public function __construct( $id = null, $on = null ) {
      $this->controleAcesso( $id, $on );
    }

    /**
     * Metodo responsavel pelo controle de acesso
     */
    public function controleAcesso( $id = null, $on = null ){
      //dados user
      $this->id_user = $id;
      $this->online  = $on;

      //Verifica os dados
      if( $this->id_user != '' && $this->online == true ) {



      } else {
        header('location: /logout');
      }
    }
  }
