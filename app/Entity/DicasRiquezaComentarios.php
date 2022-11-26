<?php

  namespace App\Entity;

  use \App\Db\DataBase;

  use \PDO;
  use \PDOStatement;

  class DicasRiquezaComentarios {
    public $id;
    public $id_user;
    public $id_dica;
    public $comentario;
    public $data;

    public function cadastrar() {
      $data = date('Y/m/d H:i:s');
      $this->data = $data;

      $obDataBase = new DataBase('dicas_riquezas_comentarios');

      $this->id = $obDataBase->insert(
        [
          'id_user'    => $this->id_user,
          'id_dica'    => $this->id_dica,
          'comentario' => $this->comentario,
          'data'       => $this->data
        ]
      );

      return true;
    }

    public function actualizar() {
      return (new DataBase('dicas_riquezas_comentarios'))->update('id = '. $this->id, [
        'id_user'    => $this->id_user,
        'id_dica'    => $this->id_dica,
        'comentario' => $this->comentario,
        'data'       => $this->data
      ]);
    }

    public function excluir() {
      return (new DataBase('dicas_riquezas_comentarios'))->delete('id = '. $this->id);
    }

    public static function getDicaComentarios($where = null, $order = null, $limit = null) {
      return (new DataBase('dicas_riquezas_comentarios'))->select($where, $order, $limit)->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    public function getQuantidadeComentarios($where = null) {
      return (new DataBase('dicas_riquezas_comentarios'))->select($where, null, null, 'COUNT(*) as qtde')->fetchObject()->qtde;
    }

    public static function getDicaComentario($id) {
      return (new Database('dicas_riquezas_comentarios'))->select('id = '. $id)
                                                     ->fetchObject(self::class);
    }

  }
