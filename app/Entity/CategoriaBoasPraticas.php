<?php

  namespace App\Entity;

  use App\Db\DataBase;

  use \PDO;
  use \PDOStatement;

  class CategoriaBoasPraticas {
    public $id;
    public $titulo;
    public $descricao;
    public $adicionada_por;
    public $criada_em;

    /**
     * Metodo responsal por inserir nova categoria de boa pratica
     * @return true;
     */
    public function cadastrar() {
      $data = date('Y-m-d H:i:s');

      $this->criada_em = $data;

      $obCategoria = new DataBase('categoriaBoasPraticas');

      $this->id = $obCategoria->insert(
        [
          'titulo'         => $this->titulo,
          'descricao'      => $this->descricao,
          'adicionada_por' => $this->adicionada_por,
          'criada_em'      => $this->criada_em
        ]
      );
    }

    /*
     *
     */
    public function actualizar() {
      return (new DataBase('categoriaBoasPraticas'))->update('id = '. $this->id, [
        'titulo'         => $this->titulo,
        'descricao'      => $this->descricao,
        'adicionada_por' => $this->adicionada_por,
        'criada_em'      => $this->criada_em
      ]);
    }

    /**
     * Metodo responsavel por apagar a boa pratica de programacao
     * @return true
     */
    public function excluir() {
      return (new DataBase('categoriaBoasPraticas'))->delete('id = '. $this->id);
    }

    /**
     * Metodo responsavel por buscar as boas praticas de programacao
     */
    public static function getCategorias($where = null, $order = null, $limit = null) {
      return (new DataBase('categoriaBoasPraticas'))->select($where, $order, $limit)->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    public static function getQuantidadeDeCategorias( $where = null ) {
      return (new DataBase('categoriaBoasPraticas'))->select($where, null, null, 'COUNT(*) as qtde')->fetchObject()->qtde;
    }

    /**
     * Metodo responsavel por buscar boa pratica de programacao
     * @return array
     */
    public static function getCategoria( $id ) {
      return (new DataBase('categoriaBoasPraticas'))->select('id = '. $id)->fetchObject(self::class);
    }
  }
