<?php

  namespace App\Entity;

  use \App\Db\DataBase;

  use \PDO;
  use \PDOStatement;

  class MeusCursos {
    public $id;
    public $user;
    public $curso_id;
    public $iniciado_em;
    public $terminado_em;
    public $estado;

    public function cadastrar() {
      $this->iniciado_em  = null;
      $this->terminado_em = null;
      $this->estado       = 'p';

      $obDataBase = new DataBase('meus_curso');

      $this->id = $obDataBase->insert(
        [
          'user'          => $this->user,
          'curso_id'      => $this->curso_id,
          'iniciado_em'   => $this->iniciado_em,
          'terminado_em'  => $this->terminado_em,
          'estado'        => $this->estado
        ]
      );

      return true;

    }

    public function actualizar() {

    }

    public function excluir( ) {
      return (new DataBase('meus_curso'))->delete('id = '. $this->id);
    }

    public static function getMeusCursos( $where = null, $order = null, $limit = null ) {
      return (new DataBase('meus_curso'))->select($where, $order, $limit)->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    public static function getMeuCurso( $id ) {
      return (new DataBase('meus_curso'))->select('id = '. $id)->fecthObject(self::class);
    }

  }
