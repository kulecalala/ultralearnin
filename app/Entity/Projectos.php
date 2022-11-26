<?php

  namespace App\Entity;

  use \App\Db\DataBase;

  use \PDO;
  use \PDOStatement;

  class Projectos {
    public $id;
    public $titulo;
    public $descricao;
    public $codigo_desenvolvimento;
    public $sobre;
    public $imagem;
    public $iniciado_em;
    public $terminado_em;
    public $utilizador;
    public $categoria;
    public $percentagem;
    public $estado;
    public $publico;

    public function cadastrar() {

      $this->$codigo_desenvolvimento = null;
      $this->iniciado_em = date('Y-m-d H:i:s');
      $this->imagem  = null;
      $this->publico = 'n';

      $obDataBase = new DataBase('projectos');

      $this->id = $obDataBase->insert(
        [
          'titulo'                 => $this->titulo,
          'descricao'              => $this->descricao,
          'codigo_desenvolvimento' => $this->codigo_desenvolvimento,
          'sobre'                  => $this->sobre,
          'imagem'                 => $this->imagem,
          'iniciado_em'            => $this->iniciado_em,
          'terminado_em'           => $this->terminado_em,
          'utilizador'             => $this->utilizador,
          'categoria'              => $this->categoria,
          'percentagem'            => $this->percentagem,
          'estado'                 => $this->estado,
          'publico'                => $this->publico
        ]
      );

      return true;
    }

    public function actualizar() {
      return (new DataBase('projectos'))->update('id = '. $this->id .' AND utilizador = '. $this->utilizador, [
        'titulo'                 => $this->titulo,
        'descricao'              => $this->descricao,
        'codigo_desenvolvimento' => $this->codigo_desenvolvimento,
        'sobre'                  => $this->sobre,
        'imagem'                 => $this->imagem,
        'iniciado_em'            => $this->iniciado_em,
        'terminado_em'           => $this->terminado_em,
        'categoria'              => $this->categoria,
        'percentagem'            => $this->percentagem,
        'estado'                 => $this->estado,
        'publico'                => $this->publico
      ]);
    }

    public function excluir() {
      return (new DataBase('projectos'))->delete('id = '. $this->id .' AND utilizador = '. $this->utilizador);
    }

    public static function getProjectos( $where = null, $order = null, $limit = null ) {
      return (new DataBase('projectos'))->select($where, $order, $limit)->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    public static function getQuantidadeProjectos($where = null) {
      return (new DataBase('projectos'))->select($where, null, null, 'COUNT(*) as qtde')->fetchObject()->qtde;
    }

    public static function getProjecto($id) {
      return (new DataBase('projectos'))->select('id = '. $id)->fetchObject(self::class);
    }
  }
