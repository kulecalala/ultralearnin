<?php

  namespace App\Entity;

  use \App\Db\DataBase;

  use \PDO;
  use \PDOStatement;

  class Professores {
    public $id;
    public $nome;
    public $descricao;
    public $adicionado_por;

    public function cadastrar(){
      $obProfessor = new DataBase('professores');

      $this->id = $obProfessor->insert(
        [
          'nome'           => $this->nome,
          'descricao'      => $this->descricao,
          'adicionado_por' => $this->adicionado_por
        ]
      );

      return true;
    }

    public function actualizar() {
      return (new DataBase('professores'))->update('id = '. $this->id, [
        'nome'           => $this->nome,
        'descricao'      => $this->descricao,
        'adicionado_por' => $this->adicionado_por
      ]);
    }

    public function excluir() {
      return (new DataBase('professores'))->delete('id = '. $this->id);
    }

    public static function getProfessores($where = null, $order = null, $limit = null) {
      return (new DataBase('professores'))->select($where, $order, $limit)->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    public static function getQuantidadeProff( $where = null ) {
      return (new DataBase('professores'))->select($where, null, null, 'COUNT(*) as qtde')->fetchObject()->qtde;
    }

    public static function getProfessor($id) {
      return (new DataBase('professores'))->select('id = '. $id)->fetchObject(self::class);
    }

  }
