<?php

  namespace App\Entity;

  use \App\Db\DataBase;

  use \PDO;
  use \PDOStatement;

  class Horario {
    public $id;
    public $user;

    public function cadastrar(){

      $obDataBase = new DataBase('horario');

      $this->id = $obDataBase->insert(
        [
          'user' => $this->user
        ]
      );

      return true;
    }

    public function actualizar() {

    }

    public function excluir() {
      return (new DataBase('horario'))->delete('id = '. $this->id);
    }

    public static function getHorarios( $where = null, $order = null, $limit = null  ) {
      return (new DataBase('horario'))->select($where, $order, $limit)->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    public static function getHorario($id) {
      return (new DataBase('horario'))->select('user = '. $id)->fetchObject(self::class);
    }
  }
