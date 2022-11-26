<?php

  namespace App\Entity;

  use \App\Db\DataBase;

  use PDO;
  use PDOStatement;

  class Cadeiras {
    public $id;
    public $titulo;
    public $descricao;
    public $tipo;
    public $id_user;
    public $foto;

    public function cadastrar() {
      $obDatabase = new DataBase('cadeiras');

      $this->id = $obDatabase->insert([
        'titulo'    => $this->titulo,
        'descricao' => $this->descricao,
        'tipo'      => $this->tipo,
        'id_user'   => $this->id_user,
        'foto'      => $this->foto
      ]);

      return true;
    }

    public function actualizar() {
      return (new DataBase('cadeiras'))->update('id ='. $this->id, [
        'titulo'    => $this->titulo,
        'descricao' => $this->descricao,
        'tipo'      => $this->tipo,
        'id_user'   => $this->id_user,
        'foto'      => $this->foto
      ]);
    }

    public function excluir() {
      return (new DataBase('cadeiras'))->delete('id = '. $this->id);
    }

    public static function getCadeiras($where = null, $order = null, $limit = null) {
      return (new DataBase('cadeiras'))->select($where, $order, $limit)
                                       ->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    public static function getQuantidadeCadeiras( $where = null ) {
      return (new DataBase('cadeiras'))->select($where, null, null, 'COUNT(*) as qtde')->fetchObject()->qtde;
    }

    public static function getCadeira($id){
      return (new DataBase('cadeiras'))->select('id = '. $id)
                                       ->fetchObject(self::class);
    }

  }
