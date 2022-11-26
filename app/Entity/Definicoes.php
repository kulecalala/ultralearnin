<?php
  namespace App\Entity;

  use \App\Db\DataBase;

  use \PDO;
  use \PDOStatement;

  class Definicoes {
    public $id;
    public $id_user;
    public $definicao;
    public $fonte;
    public $tipo_ficheiro;
    public $sobre;
    public $actualizado_em;

    public function cadastrar() {
      $data = date('Y-m-d H:i:s');
      $this->actualizado_em = $data;

      $obDatabase = new DataBase('definicoes');

      $this->id = $obDatabase->insert(
        [
          'id_user'        => $this->id_user,
          'definicao'      => $this->definicao,
          'fonte'          => $this->fonte,
          'tipo_ficheiro'  => $this->tipo_ficheiro,
          'sobre'          => $this->sobre,
          'actualizado_em' => $this->actualizado_em
        ]
      );

      return true;

    }

    public function actualizar() {
      return (new DataBase('definicoes'))->update('id = '. $this->id,
      [
        'id_user'        => $this->id_user,
        'definicao'      => $this->definicao,
        'fonte'          => $this->fonte,
        'tipo_ficheiro'  => $this->tipo_ficheiro,
        'sobre'          => $this->sobre,
        'actualizado_em' => $this->actualizado_em
      ]);
    }

    public function excluir() {
      return (new DataBase('definicoes'))->delete('id = '. $this->id);
    }

    public static function getDefinicoes( $where = null, $order = null, $limit = null ) {
      return (new DataBase('definicoes'))->select($where, $order, $limit )->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    public function getQuantidadeDefinoces( $where = null ) {
      return (new DataBase('definicoes'))->select($where, null, null, 'COUNT(*) as qtde')->fetchObject()->qtde;
    }

    public static function getDefinicao( $id ) {
      return (new DataBase('definicoes'))->select('id = '. $id)->fetchObject(self::class);
    }

  }
