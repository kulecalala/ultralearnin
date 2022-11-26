<?php

  namespace App\Entity;

  use \App\Db\DataBase;

  use \PDO;
  use \PDOStatement;

  class UsersMore {
    public $id;
    public $id_user;
    public $foto;
    public $sobre;
    public $nascido;

    public function cadastrar() {

      $obDataBase = new DataBase('usuarios_mais_dados');

      $this->id = $obDatabase->insert([
        'id_user' => $this->id_user,
        'foto'    => $this->foto,
        'sobre'   => $this->sobre,
        'nascido' => $this->nascido
      ]);

      return true;
    }

    public function actualizar() {
      return (new DataBase('usuarios_mais_dados'))->update('id = '. $this->id,
      [
        'id_user' => $this->id_user,
        'foto'    => $this->foto,
        'sobre'   => $this->sobre,
        'nascido' => $this->nascido
      ]);
    }

    public function excluir() {
      return (new DataBase('usuarios_mais_dados'))->delete('id = '. $this->id);
    }

    public static function getAllData ( $where = null, $order = null, $limit = null ) {
      return (new DataBase('usuarios_mais_dados'))->select($where, $order, $limit)->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    public static function getQuantidadeDados( $where = null ) {
      return (new DataBase('usuarios_mais_dados'))->select($where, null, null, 'COUNT(*) as qtde')->fetchObject()->qtde;
    }

    public static function getData ( $id ) {
      return (new DataBase('usuarios_mais_dados'))->select($id)->fetchObject(self::class);
    }

  }
