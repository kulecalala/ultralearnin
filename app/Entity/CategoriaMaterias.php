<?php
  namespace App\Entity;

  use \App\Db\DataBase;

  use \PDO;
  use \PDOStatement;

  class CategoriaMaterias {
    public $id;
    public $titulo;
    public $descricao;
    public $adicionada_por;
    public $actualizada_em;

    public function cadastrar() {

      $obDataBase = new DataBase('categoria_materia');

      $this->id = $obDataBase->insert(
        [
          'titulo'         => $this->titulo,
          'descricao'      => $this->descricao,
          'adicionada_por' => $this->adicionada_por,
          'actualizada_em' => $this->actualizada_em
        ]
      );

      return true;
    }

    public function actualizar() {
      return (new DataBase('categoria_materia'))->update('id = '. $this->id, [
        'titulo'         => $this->titulo,
        'descricao'      => $this->descricao,
        'adicionada_por' => $this->adicionada_por,
        'actualizada_em' => $this->actualizada_em
      ]);
    }

    public function excluir() {
      return (new DataBase('categoria_materia'))->delete('id='. $this->id);
    }

    public static function getCategorias($where = null, $order = null, $limit = null ) {
      return (new DataBase('categoria_materia'))->select($where, $order, $limit)->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    public static function getQuantidadeDeMaterias($where =  null) {
      return (new DataBase('categoria_materia'))->select($where, null, null, 'COUNT(*) as qtde')->fetchObject()->qtde;
    }

    public static function getCategoria($id) {
      return (new DataBase('categoria_materia'))->select('id='. $id)->fetchObject(self::class);
    }
  }
