<?php
  namespace App\Entity;

  use \App\Db\DataBase;

  use \PDO;
  use \PDOStatement;

  class Materias {
    public $id;
    public $titulo;
    public $descricao;
    public $codigo_materia_ref;
    public $sobre;
    public $iniciado_em;
    public $terminado_em;
    public $desenvolvida_por;
    public $quem_pode_ver;
    public $categoria;
    public $estado;

    public function cadastrar() {
      $data = date('Y-m-d');

      $this->codigo_materia_ref = null;
      $this->iniciado_em         = $data;
      $this->terminado_em       = null;
      $this->quem_pode_ver      = 'e';
      $this->estado             = 'p';

      $obDataBase = new DataBase('materias');

      $this->id = $obDataBase->insert(
        [
          'titulo'             => $this->titulo,
          'descricao'          => $this->descricao,
          'codigo_materia_ref' => $this->codigo_materia_ref,
          'sobre'              => $this->sobre,
          'iniciado_em'        => $this->iniciado_em,
          'terminado_em'       => $this->terminado_em,
          'desenvolvida_por'   => $this->desenvolvida_por,
          'quem_pode_ver'      => $this->quem_pode_ver,
          'categoria'          => $this->categoria,
          'estado'             => $this->estado
        ]
      );

      return true;

    }

    public function actualizar() {

    }

    public function excluir() {
      return (new DataBase('materias'))->delete('id = '. $this->id);
    }

    public static function getMaterias( $where = null, $order = null, $limit = null ) {
      return (new DataBase('materias'))->select($where, $order, $limit)->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    public static function getMateria($id) {
      return (new DataBase('materias'))->select('id = '. $this->id)->fetchObject(self::class);
    }
  }
