<?php
  namespace App\Entity;

  use \App\Db\DataBase;

  use \PDO;
  use \PDOStatement;

  class Negocios {
    public $id;
    public $titulo;
    public $descricao;
    public $requisitos;
    public $email;
    public $number;
    public $data_criacao;
    public $data_inicio;
    public $data_termino;
    public $adicionado_por;
    public $quem_pode_ver;
    public $imagem;

    public function cadastrar() {
      $data = date('Y-m-d H:i:s');
      $this->data_criacao = $data;

      $obDataBase = new DataBase('negocios');

      $this->id = $obDataBase->insert(
        [
          'titulo'         => $this->titulo,
          'descricao'      => $this->descricao,
          'requisitos'     => $this->requisitos,
          'email'          => $this->email,
          'number'         => $this->number,
          'data_criacao'   => $this->data_criacao,
          'data_inicio'    => $this->data_inicio,
          'data_termino'   => $this->data_termino,
          'adicionado_por' => $this->adicionado_por,
          'quem_pode_ver'  => $this->quem_pode_ver,
          'imagem'         => $this->imagem
        ]
      );

      return true;
    }


    public function actualizar() {

    }

    public function excluir() {
      return (new DataBase('negocios'))->delete('id = '. $this->id );
    }

    public static function getNegocios($where = null, $order = null, $limit = null ) {
      return (new DataBase('negocios'))->select($where, $order, $limit)->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    public static function getNegocio( $id ) {
      return (new DataBase('negocios'))->select('id = '. $id)->fetchObject(self::class);
    }


  }
