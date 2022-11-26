<?php

  namespace App\Entity;

  use \App\Db\DataBase;

  use \PDO;
  use \PDOStatement;

  class CategoriaObjectivos {
    public $id;
    public $titulo;
    public $decricao;
    public $criada_em;
    public $adicionada_por;

    public function cadastrar() {
      $data = date('Y-m-d H:i:s');
      $this->criada_em = $data;

      $obDataBase = new DataBase('categoriaObjectivos');

      $this->id = $obDataBase->insert(
        [
          'titulo'         => $this->titulo,
          'descricao'      => $this->descricao,
          'criada_em'      => $this->criada_em,
          'adicionada_por' => $this->adicionada_por
        ]
      );

      return true;
    }

    public function actualizar( ) {

    }

    public function excluir( ) {
      return (new DataBase('categoriaObjectivos'))->delete('id = '. $this->id);
    }

    public static function getCategorias($where = null, $order = null, $limit = null ){
      return (new DataBase('categoriaObjectivos'))->select($where = null, $order = null, $limit )->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    public static function getCategoria( $id ) {
      return (new DataBase('categoriaObjectivos'))->select('id = '. $id)->fetchObject(self::class);
    }
  }
