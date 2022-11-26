<?php

  namespace App\Entity;

  use \App\Db\DataBase;

  use \PDO;
  use \PDOStatement;

  class DefinicoesReacoes {
    public $id;
    public $id_user;
    public $id_dica;
    public $reacoes;

    public function cadastrar() {
      $obDataBase = new DataBase('definicoes_reacoes');

      $this->id = $obDataBase->insert(
        [
          'id_user' => $this->id_user,
          'id_dica' => $this->id_dica,
          'reacoes' => $this->reacoes
        ]
      );

      return true;
    }

    public function actualizar() {
      return (new DataBase('definicoes_reacoes'))->update('id = '. $this->id,
      [
        'id_user' => $this->id_user,
        'id_dica' => $this->id_dica,
        'reacoes' => $this->reacoes
      ]);
    }

    public function excluir( ) {
      return (new DataBase('definicoes_reacoes'))->delete('id = '. $this->id);
    }

    public static function getReacoes($where = null, $order = null, $limit = null ) {
      return (new DataBase('definicoes_reacoes'))->select($where, $order, $limit)->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    public static function getQtdeReacoes( $where = null ) {
      return (new DataBase('definicoes_reacoes'))->select($where, null, null, 'COUNT(*) as qtde')->fetchObject()
                               ->qtde;
    }

    public static function getReacao( $id ) {
      return (new DataBase('definicoes_reacoes'))->select($id)
                                                    ->fetchObject(self::class);
    }

  }
