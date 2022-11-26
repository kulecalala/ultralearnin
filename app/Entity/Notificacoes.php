<?php
  namespace App\Entity;

  use \App\Db\DataBase;

  use \PDO;
  use \PDOStatement;

  class Notificacoes {
    public $id;
    public $user_id;
    public $breve_descricao;
    public $caminho;
    public $gerada_em;
    public $estado;

    public function cadastrar(){
      $data = date('Y-m-d H:i:s');
      $this->gerada_em = $data;
      $this->estado    = 'n';

      $obDataBase = new DataBase('notificacoes');

      $this->id = $obDataBase->insert(
        [
          'user_id'         => $this->user_id,
          'breve_descricao' => $this->breve_descricao,
          'caminho'         => $this->caminho,
          'gerada_em'       => $this->gerada_em,
          'estado'          => $this->estado
        ]
      );

      return true;
    }

    public function actualizar() {
      return (new DataBase('notificacoes'))->update('id = '. $this->id, [
        'user_id'         => $this->user_id,
        'breve_descricao' => $this->breve_descricao,
        'caminho'         => $this->caminho,
        'gerada_em'       => $this->gerada_em
      ]);
    }

    public function excluir() {
      return (new DataBase('notificacoes'))->delete('id = '. $this->id);
    }

    public static function getNotificacoes($where = null, $order = null, $limit = null ) {
      return (new DataBase('notificacoes'))->select($where, $order, $limit)
                                           ->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    public static function getQuantidadeNotificacoes ($where = null) {
      return (new DataBase('notificacoes'))->select($where, null, null, 'COUNT(*) as qtde')
                                           ->fetchObject()
                                           ->qtde;
    }

    public static function getNotificacao ( $id ) {
      return (new DataBase('notificacoes'))->select('id = '. $id)
                                           ->fetchObject(self::class);
    }

  }
