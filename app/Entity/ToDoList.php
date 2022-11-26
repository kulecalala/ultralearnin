<?php

  namespace App\Entity;

  use \App\Db\DataBase;

  use \PDO;
  use \PDOStatement;

  class ToDoList {
    public $id;
    public $id_user;
    public $titulo;
    public $descricao;
    public $sobre;
    public $data;
    public $feitaEm;
    public $renovar;
    public $estado;

    public function cadastrar() {
      $data = date('Y-m-d H:i:s');

      $this->data    = $data;
      $this->feitaEm = null;
      $this->renovar = 'n';
      $this->estado  = 'p';

      $obDataBase = new DataBase('to_do_list');

      $this->id = $obDataBase->insert(
        [
          'id_user'   => $this->id_user,
          'titulo'    => $this->titulo,
          'descricao' => $this->descricao,
          'sobre'     => $this->sobre,
          'data'      => $this->data,
          'feitaEm'   => $this->feitaEm,
          'renovar'   => $this->renovar,
          'estado'    => $this->estado
        ]
      );

      return true;
    }

    public function actualizar() {
      return (new DataBase('to_do_list'))->update('id = '. $this->id .' AND id_user = '. $this->id_user, [
        'titulo'    => $this->titulo,
        'descricao' => $this->descricao,
        'sobre'     => $this->sobre,
        'data'      => $this->data,
        'feitaEm'   => $this->feitaEm,
        'renovar'   => $this->renovar,
        'estado'    => $this->estado
      ]);
    }

    public function excluir() {
      return (new DataBase('to_do_list'))->delete('id = '. $this->id .' AND id_user = '. $this->id_user);
    }

    public static function getTarefas($where = null, $order = null, $limit = null) {
      return (new DataBase('to_do_list'))->select($where, $order, $limit)->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    public static function getQuantidadeTarefas($where = null) {
      return (new DataBase('to_do_list'))->select($where, null, null, 'COUNT(*) as qtde')->fetchObject()->qtde;
    }

    public static function getTarefa($id) {
      return (new DataBase('to_do_list'))->select('id = '. $id)->fetchObject(self::class);
    }



  }
