<?php

  namespace App\Entity;

  use \App\Db\DataBase;

  use \PDO;
  use \PDOStatement;

  class DicasRiqueza {
    public $id;
    public $dica;
    public $id_user;
    public $origem;
    public $actualizado_em;

    public function cadastrar() {
      $data = date('Y-m-d H:i:s');
      $this->actualizado_em = $data;

      $obDataBase = new DataBase('dicas_riquezas');

      $this->id = $obDataBase->insert(
        [
          'dica'           => $this->dica,
          'id_user'        => $this->id_user,
          'origem'         => $this->origem,
          'actualizado_em' => $this->actualizado_em
        ]
      );

      return true;
    }

    public function actualizar() {
      return (new DataBase('dicas_riquezas'))->update('id = '. $this->id, [
        'dica'           => $this->dica,
        'id_user'        => $this->id_user,
        'origem'         => $this->origem,
        'actualizado_em' => $this->actualizado_em
      ]);
    }

    public function excluir() {
      return (new Database('dicas_riquezas'))->delete('id = '. $this->id);
    }

    public static function getDicas($where = null, $order = null, $limit = null ) {
      return (new DataBase('dicas_riquezas'))->select($where, $order, $limit)->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    public static function getQuantidadeDiscas( $where = null ) {
      return (new Database('dicas_riquezas'))->select($where, null, null, 'COUNT(*) as qtd')
                                             ->fetchObject()
                                             ->qtd;
    }

    public static function getDica($id) {
      return (new DataBase('dicas_riquezas'))->select('id = '. $id)->fetchObject(self::class);
    }
  }
