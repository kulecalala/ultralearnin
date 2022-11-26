<?php

  namespace App\Entity;

  use \App\Db\DataBase;

  use \PDO;
  use \PDOStatement;

  class Desafios {
    public $id;
    public $titulo;
    public $desafio;
    public $sobre;
    public $adicionada_por;
    public $data_inicio;
    public $nivel;
    public $categoria;

    /**
     *
     */
    public function cadastrar() {
      $data = date('Y-m-d H:i:s');
      $this->data_inicio = $data;

      $obDataBase = new DataBase('desafios');

      $this->id = $obDataBase->insert(
        [
          'titulo'         => $this->titulo,
          'desafio'        => $this->desafio,
          'sobre'          => $this->sobre,
          'adicionada_por' => $this->adicionada_por,
          'data_inicio'    => $this->data_inicio,
          'nivel'          => $this->nivel,
          'categoria'      => $this->categoria
        ]
      );

      return true;
    }

    /**
     *
     */
    public function actualizar() {
      return (new DataBase('desafios'))->update('id = '. $this->id,
      [
        'titulo'         => $this->titulo,
        'desafio'        => $this->desafio,
        'sobre'          => $this->sobre,
        'adicionada_por' => $this->adicionada_por,
        'data_inicio'    => $this->data_inicio,
        'nivel'          => $this->nivel,
        'categoria'      => $this->categoria
      ] );
    }

    /**
     *
     */
    public function excluir() {
      return (new DataBase('desafios'))->delete('id = '. $this->id);
    }

    /**
     *
     */
    public static function getDesafios( $where = null, $order = null, $limit = null ) {
      return (new DataBase('desafios'))->select($where, $order, $limit)->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    public function getQuantidadeDesafios( $where = null ) {
      return (new DataBase('desafios'))->select($where, null, null, 'COUNT(*) as qtde')
                                       ->fetchObject()
                                       ->qtde;
    }

    /**
     *
     */
    public static function getDesafio($id) {
      return (new DataBase('desafios'))->select('id = '. $id)->fetchObject(self::class);
    }

  }
