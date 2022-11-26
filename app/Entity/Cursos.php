<?php

  namespace App\Entity;

  use \App\Db\DataBase;

  use \PDO;
  use \PDOStatement;

  class Cursos {
    public $id;
    public $titulo;
    public $descricao;
    public $cadeira;
    public $professor;
    public $fonte;
    public $tecnologia;
    public $data;
    public $data_criacao;
    public $qtde;
    public $adicionado_por;
    public $logo;

    public function cadastrar() {
      $data = date('Y-m-d');
      $this->data = $data;

      $obDataBase = new DataBase('cursos');

      $this->id = $obDataBase->insert(
        [
          'titulo'         => $this->titulo,
          'descricao'      => $this->descricao,
          'cadeira'        => $this->cadeira,
          'professor'      => $this->professor,
          'fonte'          => $this->fonte,
          'tecnologia'     => $this->tecnologia,
          'data'           => $this->data,
          'data_criacao'   => $this->data_criacao,
          'qtde'           => $this->qtde,
          'adicionado_por' => $this->adicionado_por,
          'logo'           => $this->logo
        ]
      );

      return true;
    }

    public function actualizar() {
      return (new DataBase('cursos'))->update('id = '. $this->id .' AND adicionado_por = '. $this->adicionado_por, [
        'titulo'         => $this->titulo,
        'descricao'      => $this->descricao,
        'cadeira'        => $this->cadeira,
        'professor'      => $this->professor,
        'fonte'          => $this->fonte,
        'tecnologia'     => $this->tecnologia,
        'data'           => $this->data,
        'data_criacao'   => $this->data_criacao,
        'qtde'           => $this->qtde,
        'logo'           => $this->logo
      ]);
    }

    public function excluir() {
      return (new DataBase('cursos'))->delete('id = '. $this->id);
    }

    public static function getCursos($where = null, $order = null, $limit = null ) {
      return (new Database('cursos'))->select($where, $order, $limit)->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    public static function getCurso($id) {
      return (new DataBase('cursos'))->select('id ='. $id)->fetchObject(self::class);
    }

  }
