<?php

  namespace App\Entity;

  use \App\Db\DataBase;

  use \PDO;
  use \PDOStatement;

  class Imagens {
    public $id;
    public $titulo;
    public $descricao;
    public $criada_por;
    public $criada_em;
    public $sobre;

    public function cadastrar() {
      $this->criada_em = date('Y-m-d H:i:s');

      $obDataBase = new DataBase('imagem');

      $this->id = $obDataBase->insert(
        [
          'titulo'     => $this->titulo,
          'descricao'  => $this->descricao,
          'criada_por' => $this->criada_por,
          'criada_em'  => $this->criada_em,
          'sobre'      => $this->sobre,
          'imagem'     => $this->imagem
        ]
      );

      return true;
    }
  }
