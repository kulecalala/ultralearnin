<?php

  namespace App\Entity;

  use \App\Db\DataBase;

  use \PDO;
  use \PDOStatement;

  class Dicionario {
    public $id;
    public $termo;
    public $definicao;
    public $user;
    public $fonte;
    public $tipo;
    public $relacionado_a;
    public $tecnologia;
    public $actualizado_em;

    public function cadastrar() {
      $data = date('Y-m-d');
      $this->actualizado_em = $data;

      $obDatabase = new DataBase('dicionario');

      $this->id = $obDatabase->insert(
        [
          'termo'          => $this->termo,
          'definicao'      => $this->definicao,
          'user'           => $this->user,
          'fonte'          => $this->fonte,
          'tipo'           => $this->tipo,
          'relacionado_a'  => $this->relacionado_a,
          'tecnologia'     => $this->tecnologia,
          'actualizado_em' => $this->actualizado_em
        ]
      );

      return true;

    }

    public function actualizar( ) {
      return (new DataBase('dicionario'))->update('id = '. $this->id .' AND user = '. $this->user,
        [
          'termo'          => $this->termo,
          'definicao'      => $this->definicao,
          'fonte'          => $this->fonte,
          'tipo'           => $this->tipo,
          'relacionado_a'  => $this->relacionado_a,
          'tecnologia'     => $this->tecnologia,
          'actualizado_em' => $this->actualizado_em
        ]
      );
    }

    public function excluir() {
      return (new Database('dicionario') )->delete('id = '. $this->id .' AND user = '. $this->user);
    }

    public static function getDefinicoes($where = null, $order = null, $limit = null ) {
      return (new DataBase('dicionario'))->select($where, $order, $limit)->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    public static function getQuantidadeWords( $where = null ) {
      return (new DataBase('dicionario'))->select($where, null, null, 'COUNT(*) as qtde')->fetchObject()->qtde;
    }

    public static function getDefinicao($id) {
      return (new DataBase('dicionario'))->select('id = '. $id)->fetchObject(self::class);
    }
  }
