<?php

  namespace App\Entity;

  use \App\Db\DataBase;

  use \PDO;
  use \PDOStatement;

  class Novidades {
    public $id;
    public $id_user;
    public $id_tema;
    public $tema;
    public $descricao;
    public $link;
    public $data;

    public function cadastrar() {
      $data = date('Y-m-d H:i:s');
      $this->data = $data;

      $obDataBase = new DataBase('novidades');

      $this->id = $obDataBase->insert(
        [
          'id_user'   => $this->id_user,
          'id_tema'   => $this->id_tema,
          'tema'      => $this->tema,
          'descricao' => $this->descricao,
          'link'      => $this->link,
          'data'      => $this->data,
          'local'     => $this->local
        ]
      );

      return true;

    }

    public function actualizar() {
      return (new DataBase('novidades'))->update('id = '. $this->id .' AND id_user = '. $this->id_user, [
        'id_tema'   => $this->id_tema,
        'tema'      => $this->tema,
        'descricao' => $this->descricao,
        'link'      => $this->link,
        'data'      => $this->data,
        'local'     => $this->local
      ]);
    }

    public function excluir() {
      return (new DataBase('novidades'))->delete('id = '. $this->id .' AND id_user = '. $this->id_user);
    }

    public static function getNovidades($where = null, $order = null, $limit = null) {
      return (new DataBase('novidades'))->select($where, $order, $limit)->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    public static function getQuantidadeNovidades( $where = null) {
      return (new DataBase('novidades'))->select($where, null, null, 'COUNT(*) as qtde')->fetchObject()->qtde;
    }

    public static function getNovidade($id) {
      return (new DataBase('novidades'))->select('id = '. $this->id)->fetchObject(self::class);
    }

  }
