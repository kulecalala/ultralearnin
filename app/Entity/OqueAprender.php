<?php

  namespace App\Entity;

  use \App\Db\DataBase;

  use \PDO;
  use \PDOStatement;

  class OqueAprender {
    public $id;
    public $descricao;
    public $key_word;
    public $tecnologia;
    public $lancado_em;
    public $sobre;
    public $percentagem;
    public $criada_por;
    public $estado;

    public function cadastrar() {

      $this->percentagem = 0;
      $this->estado = 'p';

      $obDataBase = new DataBase('o_que_aprender');

      $this->id = $obDataBase->insert(
        [
          'descricao'              => $this->descricao,
          'key_word'               => $this->key_word,
          'tecnologia'             => $this->tecnologia,
          'lancado_em'             => $this->lancado_em,
          'sobre'                  => $this->sobre,
          'percentagem'            => $this->percentagem,
          'criada_por'             => $this->criada_por,
          'estado'                 => $this->estado
        ]
      );

      return true;
    }

    public function actualizar() {
      return (new DataBase('o_que_aprender'))->update('id = '. $this->id,
      [
        'descricao'              => $this->descricao,
        'key_word'               => $this->key_word,
        'tecnologia'             => $this->tecnologia,
        'lancado_em'             => $this->lancado_em,
        'sobre'                  => $this->sobre,
        'percentagem'            => $this->percentagem,
        'criada_por'             => $this->criada_por,
        'estado'                 => $this->estado
      ]);
    }

    public function excluir() {
      return (new DataBase('o_que_aprender'))->delete('id = '. $this->id);
    }

    public static function getResultados( $where = null, $order = null, $limit = null) {
      return (new DataBase('o_que_aprender'))->select($where, $order, $limit)->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    public static function getResultado( $id ) {
      return (new DataBase('o_que_aprender'))->select('id = '. $id)->fetchObject(self::class);
    }
  }
