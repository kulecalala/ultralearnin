<?php

  namespace App\Entity;

  use \App\Db\DataBase;

  use \PDO;
  use \PDOStatement;

  class BoasPraticasProgramacao {
    public $id;
    public $boaPratica;
    public $tecnologia;
    public $categoria;
    public $criada_por;
    public $criada_em;

    /**
     * Metodo responsavel por Adicionar as novas boas praticas de programação
     * @return true
     */
    public function cadastrar() {
      $data = date('Y-m-d H:i:s');

      $this->criada_em = $data;
      $this->gosto     = 0;
      $this->naogosto  = 0;


      $obDataBase = new DataBase('boasPraticasProgramacao');

      $this->id = $obDataBase->insert(
        [
          'boaPratica' => $this->boaPratica,
          'tecnologia' => $this->tecnologia,
          'categoria'  => $this->categoria,
          'criada_por' => $this->criada_por,
          'criada_em'  => $this->criada_em
        ]
      );

      return true;
    }

    /**
     * Metodo responsavel por actualizar as boas praticas
     * @return true;
     */
    public function actualizar() {
      return (new DataBase('boasPraticasProgramacao'))->update('id = '. $this->id, [
        'boaPratica' => $this->boaPratica,
        'tecnologia' => $this->tecnologia,
        'categoria'  => $this->categoria,
        'criada_por' => $this->criada_por,
        'criada_em'  => $this->criada_em
      ]);

    }

    /**
     * Metodo reponsavel por excluir as boas praticas
     * @return true;
     */
    public function excluir(){
      return (new DataBase('boasPraticasProgramacao'))->delete('id = '. $this->id);
    }

    /**
     * Metodo responval por buscar todas as boas praticas
     * @return array
     */
    public static function getBoasPraticas($where = null, $order = null, $limit = null ) {
      return (new DataBase('boasPraticasProgramacao'))->select($where, $order, $limit)->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    /**
     * metodo responsavel por obeter a quantidade de dicas de ti
     *
     */
    public static function getQuandidadeBoasPraticas ( $where = null ) {
      return (new DataBase('boasPraticasProgramacao'))->select($where, null, null, 'COUNT(*) as qtde')->fetchObject()->qtde;
    }

    /**
     * Metodo responsabel por buscar uma boa pratica
     * @return array
     */
    public static function getBoaPratica( $id ) {
      return (new DataBase('boasPraticasProgramacao'))->select('id = '. $id)
                                                     ->fetchObject(self::class);
    }

  }
