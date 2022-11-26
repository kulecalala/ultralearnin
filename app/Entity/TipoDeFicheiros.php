<?php

  namespace App\Entity;

  use \App\Db\DataBase;

  use \PDO;
  use \PDOStatement;

  class TipoDeFicheiros {
    public $id;
    public $id_user;
    public $tipo;
    public $descricao;
    public $data_insercao;

    public function cadastrar() {
      $data = date('Y-m-d');
      $this->$data_insercao = $data;

      $obDataBase = new DataBase('tipo_de_ficheiros');

      $this->id = $obDataBase->insert(
        [
          'id_user'       => $this->id_user,
          'tipo'          => $this->tipo,
          'descricao'     => $this->descricao,
          'data_insercao' => $this->data_insercao
        ]
      );
    }

    public function actualizar() {
      return (new DataBase('tipo_de_ficheiros'))->update('id = '. $this->id, [
        'id_user'       => $this->id_user,
        'tipo'          => $this->tipo,
        'descricao'     => $this->descricao,
        'data_insercao' => $this->data_insercao
      ]);
    }

    public function excluir() {
      return (new DataBase('tipo_de_ficheiros'))->delete('id = '. $this->id);
    }

    public static function getFicheiros( $where = null, $order = null, $limit = null ) {
      return (new DataBase('tipo_de_ficheiros'))->select($where, $order, $limit)->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    public static function getQuantidadeFicheiros( $where = null ) {
      return (new DataBase('tipo_de_ficheiros'))->select($where, null, null, 'COUNT(*) as qtde')->fetchObject()->qtde;
    }

    public static function getFicheiro( $id ) {
      return (new DataBase('tipo_de_ficheiros'))->select('id = '. $id)->fetchObject(self::class);
    }

  }
