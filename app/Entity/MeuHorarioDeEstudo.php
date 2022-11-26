<?php
  namespace App\Entity;

  use \App\Db\DataBase;

  use \PDO;
  use \PDOStatement;

  class MeuHorarioDeEstudo {
    public $id;
    public $dia;
    public $tempo;
    public $cadeira;

    public function cadastrar() {
      $obDataBase = new DataBase('meuHorarioDeEstudo');

      $this->id = $obDataBase->insert(
        [
          'dia'     => $this->dia,
          'tempo'   => $this->tempo,
          'cadeira' => $this->cadeira
        ]
      );

      return true;
    }

    public function actualizar() {

    }

    public function excluir() {
      return (new DataBase('meuHorarioDeEstudo'))->delete('id = '. $this->id);
    }

    public static function getHorariosDeEstudos( $where = null, $order = null, $limit = null ) {
      return (new DataBase('meuHorarioDeEstudo'))->select($where, $order, $limit)->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    public static function getHorarioDeEstudo( $id ) {
      return (new DataBase('meuHorarioDeEstudo'))->select('id = '. $id)->fetchObject(self::class);
    }

  }
