<?php

  namespace App\Entity;

  use \App\Db\DataBase;

  use \PDO;
  use \PDOStatement;

  class Denuncias {
    public $id;
    public $descricao;
    public $id_user;
    public $id_sobre;
    public $enviada_em;

    public function cadastrar() {
      $data = date('Y-m-d H:i:s');
      $this->enviada_em = $data;

      $obDataBase = new DataBase('Denuncias');

      $this->id = $obDataBase->insert([
        'descricao'  => $this->descricao,
        'id_user'    => $this->id_user,
        'id_sobre'   => $this->id_sobre,
        'enviada_em' => $this->enviada_em
      ]);

      return true;
    }

    public function actualizar() {
      return (new DataBase('Denuncias'))->update('id = '. $this->id,
      [
        'descricao'  => $this->descricao,
        'id_user'    => $this->id_user,
        'id_sobre'   => $this->id_sobre,
        'enviada_em' => $this->enviada_em
      ]);
    }

    public function excluir() {
      return (new DataBase('Denuncias'))->delete('id = '. $this->id);
    }

    public static function getDenuncias( $where = null, $order = null, $limit = null ) {
      return (new DataBase('Denuncias'))->select($where, $order, $limit)->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    public static function getQuantidadeDenuncias( $where = null ) {
      return (new DataBase('Denuncias'))->select( $where, null, null, 'COUNT(*) as qtde')->fetchObject()->qtde;
    }

    public static function getDenuncia( $id ) {
      return (new Database('Denuncias'))->select($where)->fetchObject(self::class);
    }

  }
