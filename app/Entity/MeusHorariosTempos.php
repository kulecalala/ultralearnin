<?php
  namespace App\Entity;

  use \App\Db\DataBase;

  use \PDO;
  use \PDOStatement;

  class MeusHorariosTempos {
    public $id;
    public $horario;
    public $numeroTempo;
    public $entrada;
    public $saida;

    public function cadastrar() {
      $obDataBase = new DataBase('meuHorarioTempos');

      $this->id = $obDataBase->insert(
        [
          'horario'     => $this->horario,
          'numeroTempo' => $this->numeroTempo,
          'entrada'     => $this->entrada,
          'saida'       => $this->saida
        ]
      );

      return true;
    }

    public function actualizar() {

    }

    public function excluir() {
      return (new DataBase('meuHorarioTempos'))->delete('id = '. $this->id );
    }

    public static function getTempos( $where = null, $order = null, $limit = null ) {
      return (new DataBase('meuHorarioTempos'))->select($where, $order, $limit)->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    public static function getTempo( $id ) {
      return (new DataBase('meuHorarioTempos'))->select('id = '. $id)->fecthObject(self::class);
    }


  }
