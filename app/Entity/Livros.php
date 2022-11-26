<?php

  namespace App\Entity;

  use \App\Db\DataBase;

  use \PDO;
  use \PDOStatement;

  class Livros {
    public $id;
    public $titulo;
    public $descricao;
    public $cadeiras;
    public $paginas;
    public $autores;
    public $criado_por;
    public $criado_em;
    public $file_name;

    public function cadastrar() {
      $this->criado_em = date('Y-m-d H:i:s');

      $obDataBase = new DataBase('livros');

      $this->id = $obDataBase->insert(
        [
          'titulo'     => $this->titulo,
          'descricao'  => $this->descricao,
          'cadeiras'   => $this->cadeiras,
          'paginas'    => $this->paginas,
          'autores'    => $this->autores,
          'criado_por' => $this->criado_por,
          'criado_em'  => $this->criado_em,
          'file_name'  => $this->file_name
        ]
      );

      return true;
    }

    public function actualizar() {

    }

    public function excluir() {
      return (new DataBase('livros'))->delete('id = '. $this->id);
    }

    public static function getLivros($where = null, $order = null, $limit = null ) {
      return (new DataBase('livros'))->select($where, $order, $limit)->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    public static function getLivro($id) {
      return (new DataBase('livros'))->select('id = '. $id)->fetchObject(self::class);
    }

  }
