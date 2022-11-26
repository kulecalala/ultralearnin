<?php

  namespace App\Entity;

  use \App\Db\DataBase;

  use \PDO;
  use \PDOStatement;

  class Tecnologias {
    public $id;
    public $titulo;
    public $descricao;
    public $criada_por;
    public $imagem;
    public $criada_em;

    public function cadastrar() {
      $this->criada_em = date('Y-m-d H:i:s');

      $obDataBase = new DataBase('tecnologia');

      $this->id = $obDataaBase->insert(
        [
          'titulo'     => $this->titulo,
          'descricao'  => $this->descricao,
          'criada_por' => $this->criada_por,
          'imagem'     => $this->imagem,
          'criada_em'  => $this->criada_em
        ]
      );

      return true;

    }

    public function actualizar() {
      return (new DataBase('tecnologia'))->update('id = '. $this->id,
      [
        'titulo'     => $this->titulo,
        'descricao'  => $this->descricao,
        'criada_por' => $this->criada_por,
        'imagem'     => $this->imagem,
        'criada_em'  => $this->criada_em
      ]);
    }

    public function excluir() {
      return (new DataBase('tecnologia'))->delete('id = '. $this->id);
    }

    public static function getTecnologias($where = null, $order = null, $limit = null ) {
      return (new DataBase('tecnologia'))->select($where, $order, $limit)->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    public static function getQuantidadeDeTecnologias( $where = null ) {
      return (new DataBase('tecnologia'))->select($where, null, null, 'COUNT(*) as qtde')->fetchObject()->qtde;
    }

    public static function getTecnologia($id) {
      return (new DataBase('tecnologia'))->select('id = '. $id)->fetchObject(self::class);
    }
  }
