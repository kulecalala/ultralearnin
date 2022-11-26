<?php

  namespace App\Entity;

  use \App\Db\DataBase;

  use \PDO;
  use \PDOStatement;

  class TipoCadeiras {
    public $id;
    public $tipo;
    public $descricao;
    public $criada_por;
    public $em;

    public function cadastrar(){
      $obTipoCadeiras = new DataBase('tipo_de_cadeira');

      $this->id = $obTipoCadeiras->insert(
        [
          'tipo'       => $this->tipo,
          'descricao'  => $this->descricao,
          'criada_por' => $this->criada_por,
          'em'         => $this->em
        ]
      );

      return true;
    }

    public function actualizar() {
      return (new DataBase('tipo_de_cadeira'))->update('id ='. $this->id, [
        'tipo'       => $this->tipo,
        'descricao'  => $this->descricao,
        'criada_por' => $criada_por,
        'em'         => $this->em
      ]);

    }

    public function excluir() {
      return (new DataBase('tipo_de_cadeira'))->delete('id = '. $this->id);
    }

    public static function getTiposCad($where = null, $order = null, $limit = null ) {
      return (new DataBase('tipo_de_cadeira'))->select($where, $order, $limit)
                                            ->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    public static function getTipoCad($id) {
      return (new DataBase('tipo_de_cadeira'))->select('id = '. $id)
                                              ->fetchObject(self::class);
    }

  }
