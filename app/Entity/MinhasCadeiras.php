<?php
  namespace App\Entity;

  use \App\Db\DataBase;

  use \PDO;
  use \PDOStatement;

  class MinhasCadeiras {
    public $id;
    public $cadeira;
    public $periodo;
    public $professor;
    public $observacoes;
    public $pontosNecessarios;
    public $user;
    public $criadaEm;
    public $terminadaEm;
    public $estados;

    public function cadastrar() {
      $data = date('Y-m-d');
      $this->criadaEm    = $data;
      $this->terminadaEm = null;
      $this->periodo     = 'i';
      $this->estados     = 'p';

      $obDataBase = new DataBase('minhasCadeiras');

      $this->id = $obDataBase->insert(
        [
          'cadeira'           => $this->cadeira,
          'periodo'           => $this->periodo,
          'professor'         => $this->professor,
          'observacoes'       => $this->observacoes,
          'pontosNecessarios' => $this->pontosNecessarios,
          'user'              => $this->user,
          'criadaEm'          => $this->criadaEm,
          'terminadaEm'       => $this->terminadaEm,
          'estados'           => $this->estados
        ]
      );

      return true;
    }

    public function actualizar( ) {
      return (new DataBase('minhasCadeiras'))->update('id = '. $this->id, [
        'cadeira'           => $this->cadeira,
        'periodo'           => $this->periodo,
        'professor'         => $this->professor,
        'observacoes'       => $this->observacoes,
        'pontosNecessarios' => $this->pontosNecessarios,
        'user'              => $this->user,
        'criadaEm'          => $this->criadaEm,
        'terminadaEm'       => $this->terminadaEm,
        'estados'           => $this->estados
      ]);
    }

    public function excluir() {
      return (new DataBase('minhasCadeiras'))->delete('id = '. $this->id);
    }

    public static function getMinhasCadeiras( $where = null, $order = null, $limit = null ) {
      return (new DataBase('minhasCadeiras'))->select($where, $order, $limit)->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    public static function getQuantidadeMinhasCad( $where = null ) {
      return (new DataBase('minhasCadeiras'))->select($where,  null, null, 'COUNT(*) as qtde')->fetchObject()->qtde;
    }

    public static function getMinhaCadeira( $id ) {
      return (new DataBase('minhasCadeiras'))->select('id = '. $id)->fetchObject(self::class);
    }

  }
