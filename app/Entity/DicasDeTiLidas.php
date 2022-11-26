<?php

  namespace App\Entity;

  use \App\Db\DataBase;

  use \PDO;
  use \PDOStatement;

  class DicasDeTiLidas {
    public $id;
    public $id_user;
    public $id_dica;

    public function cadastrar() {

      $obDataBase = new DataBase('boasPraricasLidas');

      $this->id = $obDataBase->insert(
        [
          'id_user' => $this->id_user,
          'id_dica' => $this->id_dica
        ]
      );

      return true;

    }

    public function actualizar() {
      return (new DataBase('boasPraricasLidas'))->actualizar('id = '. $this->id,
      [
        'id_user' => $this->id_user,
        'id_dica' => $this->id_dica
      ]);
    }

    public function excluir() {
      return (new DataBase('boasPraricasLidas'))->delete('id_user = '. $this->id_user .' AND id = '. $this->id);
    }

    public static function getLidas( $where = null, $order = null, $limit = null ) {
      return (new DataBase('boasPraricasLidas'))->select($where, $order, $limit)->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    public static function getQuantidadeLidas( $where = null ) {
      return (new DataBase('boasPraricasLidas'))->select( $where, null, null, 'COUNT(*) as qtde' )->fetchObject()->qtde;
    }

    public static function getLida( $id ) {
      return (new DataBase('boasPraricasLidas'))->select('id = '. $id)
                                                  ->fetchObject(self::class);
    }


  }
