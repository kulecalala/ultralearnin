<?php

  namespace App\Entity;

  use \App\Db\DataBase;

  use \PDO;
  use \PDOStatement;

  class Objectivos {
    public $id;
    public $titulo;
    public $descricao;
    public $data_inicio;
    public $data_validade;
    public $sobre;
    public $percentagem;
    public $utilizador;
    public $categoria;
    public $estado;

    public function cadastrar() {

      $obDataBase = new DataBase('objectivos');

      $this->id = $obDataBase->insert(
        [
          'titulo'        => $this->titulo,
          'descricao'     => $this->descricao,
          'data_inicio'   => $this->data_inicio,
          'data_validade' => $this->data_validade,
          'sobre'         => $this->sobre,
          'percentagem'   => $this->percentagem,
          'utilizador'    => $this->utilizador,
          'categoria'     => $this->categoria,
          'estado'        => $this->estado
        ]
      );

      return true;
    }

    public function actualizar() {
      return (new DataBase('objectivos'))->update('id = '. $this->id, [
        'titulo'        => $this->titulo,
        'descricao'     => $this->descricao,
        'data_inicio'   => $this->data_inicio,
        'data_validade' => $this->data_validade,
        'sobre'         => $this->sobre,
        'percentagem'   => $this->percentagem,
        'utilizador'    => $this->utilizador,
        'categoria'     => $this->categoria,
        'estado'        => $this->estado
      ]);

    }

    public function excluir() {
      return (new DataBase('objectivos'))->delete('id = '. $this->id);
    }

    public static function getObjectivos($where = null, $order = null, $limit = null ) {
      return (new DataBase('objectivos'))->select($where, $order, $limit)->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    public static function getObjectivo($id) {
      return (new DataBase('objectivos'))->select('id = '. $id)->fetchObject(self::class);
    }

  }
