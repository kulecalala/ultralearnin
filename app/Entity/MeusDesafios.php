<?php

  namespace App\Entity;

  use \App\Db\DataBase;

  use \PDO;
  use \PDOStatement;

  class MeusDesafios {
    public $id;
    public $id_user;
    public $id_desa_exerc;
    public $solucao;
    public $pego_em;
    public $categoria;
    public $tentativas;
    public $estado;

    public function cadastrar() {
      $data = date('Y-m-d');

      $this->date = $data;
      $this->estado = 'p';

      $obDataBase = new DataBase('desafios_exercicios_aceites');

      $this->id = $obDataBase->insert(
        [
          'id_user'       => $this->id_user,
          'id_desa_exerc' => $this->id_desa_exerc,
          'solucao'       => $this->solucao,
          'pego_em'       => $this->pego_em,
          'categoria'     => $this->categoria,
          'tentativas'    => $this->tentativas,
          'estado'        => $this->estado
        ]
      );

      return true;
    }

    public function actualizar( ) {
      return (new DataBase('desafios_exercicios_aceites'))->update('id = '. $this->id,
      [
        'id_user'       => $this->id_user,
        'id_desa_exerc' => $this->id_desa_exerc,
        'solucao'       => $this->solucao,
        'pego_em'       => $this->pego_em,
        'categoria'     => $this->categoria,
        'tentativas'    => $this->tentativas,
        'estado'        => $this->estado
      ]);
    }

    public function excluir() {
      return (new DataBase('desafios_exercicios_aceites'))->delete('id = ', $this->id);
    }

    public static function getDesafiosAceites( $where = null, $order = null, $limit = null ) {
      return (new DataBase('desafios_exercicios_aceites'))->select($where, $order, $limit)->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    public function getQuantidadeDesafiosAceites( $where ) {
      return (new DataBase('desafios_exercicios_aceites'))->select($where, null, null, 'COUNT(*) as qtde')
                                                          ->fetchObject()
                                                          ->qtde;
    }

    public static function getDesafioAceite( $id ) {
      return (new DataBase('desafios_exercicios_aceites'))->select('id = '. $id )->fetchObject(self::class);
    }

  }
